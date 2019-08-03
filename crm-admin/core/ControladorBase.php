<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

require_once(folder_admin . '/config/database.php');
require_once('api.php');
require_once(folder_admin . '/core/ui.php');

class ControladorBase {
	public $thisClassName;
	public $post;
	public $get;
	public $put;
	public $folders;
	public $protocol;
	public $host;
	public $port;
	public $path;
	public $request;
	public $apiCore;
	public $response;
	public $api;
	public $this_file;
	public $sections;
	public $status;
	public $enlace_actual;
	public $session;
	public $userData;
	public $modules;
	public $theme;
	public $template;
	public $vista_actual;
	public $datos;
	public $thisModule;
 
    public function __construct() {
        require_once 'EntidadBase.php';
        require_once 'ModeloBase.php';
        require_once 'MenuBase.php';
		$this->modules = $this->getModules();
		$this->post = $_POST;
		$this->get = $_GET;
		$this->userData = new stdClass();
		$this->sections = array();
		$this->enlace_actual = $_SERVER['REQUEST_URI'];
		
        //Incluir todos los modelos del sistema
        foreach(glob(folder_admin . "/model/*.php") as $file){ require_once $file; };
        //Incluir todos los modelos de los modulos
		$directorio = opendir(folder_content . "/modules"); //ruta actual
		while ($nombreModulo = readdir($directorio)) 
		{
			//verificamos si es o no un directorio
			if (is_dir(folder_content . "/modules/" . $nombreModulo))
			{
				# echo "{$nombreModulo}\n";
				foreach(glob(folder_content . "/modules/{$nombreModulo}/models/*.php") as $file){
					require_once $file;
				};
			}
		}
		
		$this->setServer();
		$this->folders = new stdClass();
		$this->folders->principal = folder_principal;
		$this->folders->admin = folder_admin;
		$this->theme = TEMA_DEFECTO;
		
		if(
			isset($_POST) && count($_POST) > 0
			&& isset($_GET['controller']) && $_GET['controller'] == 'Login' && isset($_GET['action']) && $_GET['action'] == 'password'
		){
			$this->view(
				strtolower($_GET['action']), array(
					"post" => $_POST,
					"title" => "Ingresa tu contraseña",
				)
			);
			exit(0);
		}
		
		$this->request = RequestFactory::fromGlobals();
		$this->apiCore = new Api(new Config([
			'driver' => DB_driver,
			'address' => DB_host,
			'port' => DB_port,
			'username' => DB_user,
			'password' => DB_pass,
			'database' => DB_database,
			'debug' => true,
			'openApiBase' => API_openApiBase,
			'controllers' => API_controllers,
			'middlewares' => API_middlewares,
			'dbAuth.mode' => API_dbAuth_mode,
			'dbAuth.usersTable' => API_dbAuth_usersTable,
			'dbAuth.usernameColumn' => API_dbAuth_usernameColumn,
			'dbAuth.passwordColumn' => API_dbAuth_passwordColumn,
			'dbAuth.returnedColumns' => API_dbAuth_returnedColumns,
			// 'xsrf.cookieName' => API_xsrf_cookieName,
			// 'xsrf.headerName' => API_xsrf_headerName
		]));
		$this->response = $this->apiCore->handle($this->request);
		
		$request_headers = getallheaders();
		
		
		if((
			isset($request_headers['X-CORE']) && $request_headers['X-CORE'] == 'api') 
			|| (isset($this->sections[0]) && $this->sections[0] == 'api') 
			|| (isset($this->sections[0]) && $this->sections[0] == 'openapi') 
			// || (isset($this->sections[0]) && $this->sections[0] == 'login') 
			// || (isset($this->sections[0]) && $this->sections[0] == 'logout') 
			|| (isset($this->sections[0]) && $this->sections[0] == 'records') 
			|| (isset($_GET['core']) && $_GET['core'] == 'api')
		){
			$this->api = ResponseUtils::output($this->response, true);
			echo ($this->api);
			exit(0);
		}else{
			$this->api = json_decode(ResponseUtils::output($this->response));
		}
		
		if(
			isset($this->api->code) 
		){
			if($this->api->code == 1011){
				$this->status = 'disconnect';
			} else if($this->api->code == 1012){
				$this->status = 'login_fail';
			} else {
				// Errores API no necesarios en back y front.
				if(
					$this->api->code != 1000
					&& $this->api->code != 1011
					&& $this->api->code != 1012
				){
					echo "Error API.<hr>";
					echo "{$this->api->code}: {$this->api->message}";
					exit();
				}
			}
		}else {
			$this->status = 'connected';
		}
		
		// Agregar el login si no esta `connected`
		if($this->status === 'disconnect'){
			if(!isset($this->get['controller']) || $this->get['controller'] != 'Login'){
				header("Location: /index.php?controller=Login");
			}
		} else if ($this->status === 'login_fail'){
			if(!isset($this->get['controller']) || $this->get['controller'] != 'Login'){
				header("Location: /index.php?controller=Login&action=error&message=".base64_encode($this->api->message));
			}
			
			echo "Fail Login";
			exit();
		}
		$this->session = isset($_SESSION) ? $this->validateSession() : null;
		if(!isset($this->session->id) || $this->session == null){
			$this->userData = $this->getProfileDefault();
		}else{
			$this->userData = $this->getLoadProfile($this->session->id);
		}
		
		# Crear Template
		require_once "TemplateBase.php";
		$themeFileBase = folder_content . "/themes/{$this->theme}/global/template.php";
		if($this->validateFileExist($themeFileBase) == true){
			require_once $themeFileBase;
			$template_name = "Template".ucwords(strtolower($this->theme));
			$template = new $template_name();
			$this->template = $template->getTemplate();
			
		}else{
			echo "Template no encontrado en el tema. {$themeFileBase}";
			exit();
		}
		
		
		$this->thisClassName = $this->getClassName();
		$this->thisModule = $this->getThisModule();
	}
	
	public static function validateSession(){
		if(isset($_SESSION) && isset($_SESSION['user'])){
			return $_SESSION;
		} else {
			return null;
		}
	}
	
	public static function getClassName(){
		return str_replace(array(
			"controller",
			"Controller",
		), array(
			"",
			"",
		), get_called_class());
	}
	
	public static function getModules() : array {
		$Mydir = folder_content . '/modules/';
		$dirs = array();
		foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $dir) {
			$dir = str_replace($Mydir, '', $dir);
			$dirs[] = $dir;
		}
		return $dirs;
	}
	
	public function tableDebug($data){
		$keys = array();
		$values = array();
		$html = "<div class=\"container-debug table table-responsive\" style=\"width:100%\"><table class=\"table table-responsive\">";
		foreach($data as $k => $v){
			$html .= "<tr>";
			
			$html .= "<th>{$k}</th>";
			if(is_array($v) || is_object($v)){
				$html .= "<td>{$this->tableDebug($v)}</td>";
			}else{
				$html .= "<td>".($v)."</td>";
			}
			
			$html .= "</tr>";
		}
		$html .= "</table></div>";
		
		return $html;
	}
	
	function getLoadProfile($userid){
		$userid = (int) $userid;
		$user = new Usuario();
		$user->getId($userid);
		return $user;
	}
	
	function getProfileDefault(){
		$a = null;
		$a = new stdClass();
		$a->userID = 0;
		$a->username = 0;
		$a->userInfo = 0;
		return $a;
	}
	
	function getPath() : string {
		$a = null;
		
        if (!isset($_SERVER['PHP_SELF'])) {
            $_SERVER['PHP_SELF'] = '/';
        }
		$a = $_SERVER['PHP_SELF'];
		return $a;
	}
	
    function setServer()
    {
        $this->protocol = @$_SERVER['HTTP_X_FORWARDED_PROTO'] ?: @$_SERVER['REQUEST_SCHEME'] ?: ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https" : "http");
        $this->port = @intval($_SERVER['HTTP_X_FORWARDED_PORT']) ?: @intval($_SERVER["SERVER_PORT"]) ?: (($this->protocol === 'https') ? 443 : 80);
        $this->host = @explode(":", $_SERVER['HTTP_HOST'])[0] ?: @$_SERVER['SERVER_NAME'] ?: @$_SERVER['SERVER_ADDR'];
        $this->port = ($this->protocol === 'https' && $this->port === 443) || ($this->protocol === 'http' && $this->port === 80) ? '' : ':' . $this->port;
        $this->path = @trim(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/openapi')), '/');
        $this->this_file = substr($_SERVER['SCRIPT_NAME'],1);
		
		$this->path = $this->getPath();
		
		$sections = explode('/', $this->path);
		foreach($sections as $section){
			if($section != '' && $section != null && $section != $this->this_file){
				$this->sections[] = $section;
			}
		}
		
		return true;
    }
	
	public static function getSections() {
		$nombreModulo = str_replace(array(
			"controller",
			"Controller",
		), array(
			"",
			"",
		), get_called_class());
		
		$urlInfoModulo = folder_content . "/modules/{$nombreModulo}/{$nombreModulo}.json";
		if(ControladorBase::validateFileExist($urlInfoModulo)){
			$infoModulo = json_decode(@file_get_contents($urlInfoModulo));
		}else{
			$infoModulo = json_decode(json_encode(array(
				'name' => "Modulo {$nombreModulo}",
				"isActive" => false
			)));
		}
		
		return (!isset($infoModulo->sections)) ? array() : $infoModulo->sections;
		
		/*
		$nombreModulo = str_replace(array(
			"controller",
			"Controller",
		), array(
			"",
			"",
		), get_called_class());
		
		$urlInfoModulo = folder_content . "/modules/{$nombreModulo}/{$nombreModulo}.json";
		if(ControladorBase::validateFileExist($urlInfoModulo)){
			return json_decode(@file_get_contents($urlInfoModulo));
		}else{
			$r = json_decode(json_encode(array(
				'name' => "Modulo {$nombreModulo}",
				"isActive" => false
			)));
			return $r->
		}*/
		
	}
	
	public static function defaultInfoModule() {
		
	}
     
    //Plugins y funcionalidades
    public function viewSystem($vista,$datos){
		/*
		* Este método lo que hace es recibir los datos del controlador en forma de array
		* los recorre y crea una variable dinámica con el indice asociativo y le da el
		* valor que contiene dicha posición del array, luego carga los helpers para las
		* vistas y carga la vista que le llega como parámetro. En resumen un método para
		* renderizar vistas.
		*/
		foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor;
        }
        require_once folder_admin . '/core/AyudaVistas.php';
        $helper=new AyudaVistas();
		if(isset($vista)){
			$urlVista = folder_admin . '/view/'.$vista.'View.php';
			if(@file_exists($urlVista)){ require_once $urlVista; } 
			else { echo ("<br> Vista: {{$vista}} No encontrada. URL: {$urlVista}<br>"); };
		}
    }
	
    public function view($vista,$datos){
		foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor;
        }
        require_once folder_admin . '/core/AyudaVistas.php';
        $helper=new AyudaVistas();
		if(isset($vista)){
			$urlVista = folder_content . '/modules/' . $this->getClassName() . '/view/'.$vista.'View.php';
			if(@file_exists($urlVista)){ require_once $urlVista; } 
			else { echo ("<br> Vista: {{$vista}} No encontrada. URL: {$urlVista}<br>"); };
		}
    }
	
	public function viewInTemplate($vista,$datos){
		/*
		* Este método lo que hace es recibir los datos del controlador en forma de array
		* los recorre y crea una variable dinámica con el indice asociativo y le da el
		* valor que contiene dicha posición del array, luego carga los helpers para las
		* vistas y carga la vista que le llega como parámetro con los archivos conjuntos de la plantilla. En resumen un método para
		* renderizar vistas pero con el tema.
		*/
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor;
        }
		$this->vista_actual = $vista;
		$this->datos = $datos;
		echo "<!DOCTYPE html>\n";
		$this->templateToCode($this->template->baseCode);
    }
	
	public function viewSystemInTemplate($vista,$datos){
		/*
		* Este método lo que hace es recibir los datos del controlador en forma de array
		* los recorre y crea una variable dinámica con el indice asociativo y le da el
		* valor que contiene dicha posición del array, luego carga los helpers para las
		* vistas y carga la vista que le llega como parámetro con los archivos conjuntos de la plantilla. En resumen un método para
		* renderizar vistas pero con el tema.
		*/
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor;
        }
		$this->vista_actual = $vista;
		$this->datos = $datos;
		echo "<!DOCTYPE html>\n";
		$this->templateSystemToCode($this->template->baseCode);
    }
	
	public function templateToCode($codeTemplate){
		$vista = $this->vista_actual;
		$datos = $this->datos;
		foreach ($datos as $id_assoc => $valor) {
			${$id_assoc}=$valor;
		}
		require_once folder_admin . '/core/AyudaVistas.php';
		$helper=new AyudaVistas();
		if(is_array($codeTemplate)){
			foreach($codeTemplate as $i => $prms){
				if(isset($prms->name)){
					$clss = (isset($prms->class) && $prms->class != "") ? " class=\"{$prms->class}\"" : '';
					if(isset($prms->tag)){
						echo str_repeat("\t", ($i+1))."<{$prms->tag}{$clss}> \n";
					}
					echo str_repeat("\t", ($i+1))."<!-- // ↑ Inicio {$prms->name} --> \n";
					if(isset($prms->function)){
						if(method_exists($this->template, $prms->function)){
							$this->template->{$prms->function}();
						}else{
							echo str_repeat("\t", ($i+1))."function => {$prms->function}::Result - NO encontrada.\n";
						}
						if($prms->function === 'getBody'){
							if(isset($vista)){
								$urlVista = folder_content . '/modules/' . $this->getClassName() . '/view/'.$vista.'View.php';
								if(@file_exists($urlVista)){ require_once $urlVista; } 
								else { echo ("<br> Vista: {{$vista}} No encontrada.<br>"); };
							}
						}
					}
					if(isset($prms->includes) && is_array($prms->includes)){
						$this->templateToCode($prms->includes);
					}
					echo @str_repeat("\t", ($i+1))."<!-- // ↓ Fin {$prms->name} -->\n";
					if(isset($prms->tag)){
						echo @str_repeat("\t", ($i+1))."</{$prms->tag}>\n";
					}
				}
			}
		}
		
		#	return $html;
	}
	
	public function templateSystemToCode($codeTemplate){
		$vista = $this->vista_actual;
		$datos = $this->datos;
		foreach ($datos as $id_assoc => $valor) {
			${$id_assoc}=$valor;
		}
		require_once folder_admin . '/core/AyudaVistas.php';
		$helper=new AyudaVistas();
		if(is_array($codeTemplate)){
			foreach($codeTemplate as $i => $prms){
				if(isset($prms->name)){
					$clss = (isset($prms->class) && $prms->class != "") ? " class=\"{$prms->class}\"" : '';
					if(isset($prms->tag)){
						echo str_repeat("\t", ($i+1))."<{$prms->tag}{$clss}> \n";
					}
					echo str_repeat("\t", ($i+1))."<!-- // ↑ Inicio {$prms->name} --> \n";
					if(isset($prms->function)){
						if(method_exists($this->template, $prms->function)){
							$this->template->{$prms->function}();
						}else{
							echo str_repeat("\t", ($i+1))."function => {$prms->function}::Result - NO encontrada.\n";
						}
						if($prms->function === 'getBody'){
							if(isset($vista)){
								$urlVista = folder_admin . '/view/'.$vista.'View.php';
								if(@file_exists($urlVista)){ require_once $urlVista; } 
								else { echo ("<br> Vista: {{$vista}} No encontrada.<br>"); };
							}
						}
					}
					if(isset($prms->includes) && is_array($prms->includes)){
						$this->templateSystemToCode($prms->includes);
					}
					echo str_repeat("\t", ($i+1))."<!-- // ↓ Fin {$prms->name} -->\n";
					if(isset($prms->tag)){
						echo str_repeat("\t", ($i+1))."</{$prms->tag}>\n";
					}
				}
			}
		}
		
		#	return $html;
	}
	
    public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        header("Location:index.php?controller=".$controlador."&action=".$accion);
    }
     
    public function linkUrl($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        return ("index.php?controller=".$controlador."&action=".$accion);
    }
     
    public function json(){
        echo json_encode($this);
    }
    //Métodos para los controladores
	
	public function formLogout() : string {
		return "<form method=\"post\" action=\"/logout\"><button type=\"submit\">Cerar sesion</button></form>";
	}
	
	public static function validateFileExist($fileUrl) {
		return (!file_exists($fileUrl)) ? false : true;
	}
	
	public static function validateDirExist($dirUrl) {
		return (is_dir($dirUrl)) ? true : false;
	}
	
	/* FUNCIONES PARA LOS MODULOS */
	public static function getThisModule() {
		$nombreModulo = str_replace(array(
			"controller",
			"Controller",
		), array(
			"",
			"",
		), get_called_class());
		
		$urlInfoModulo = folder_content . "/modules/{$nombreModulo}/{$nombreModulo}.json";
		if(ControladorBase::validateFileExist($urlInfoModulo)){
			return json_decode(@file_get_contents($urlInfoModulo));
		}else{
			return json_decode(json_encode(array(
				'name' => "Modulo {$nombreModulo}",
				"isActive" => false,
			)));
		}
	}
}