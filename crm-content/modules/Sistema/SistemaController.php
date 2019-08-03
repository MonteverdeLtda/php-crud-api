<?php 
class SistemaController extends ControladorBase {	
    public function __construct() {
        parent::__construct();
    }
	
    public function index(){
		
    }
	
    public function table_debug(){
		$this->viewInTemplate(
			"debug", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function database_vue(){
		$this->viewInTemplate(
			"database_vue", array(
				"title" => "Administrador DB",
				"template" => $this->template,
			)
		);
    }
	
    public function api_readme(){
		$this->viewInTemplate(
			"api_readme", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function api_docs(){
		$this->viewInTemplate(
			"api_docs", array(
				"title" => "Documentacion API",
				"template" => $this->template,
			)
		);
    }
	
    public function users_list(){
        //Creamos el objeto usuario
        $usuario = new Usuario();
        //Conseguimos todos los usuarios
        $allusers=$usuario->getAll();
        //Cargamos la vista index y le pasamos valores
		
		$this->viewInTemplate(
			"users_list", array(
				"title" => "Todos los usuarios",
				"allusers"=>$allusers,
				"template" => $this->template,
			)
		);
    }
	
    public function modules_list(){
		$this->viewInTemplate(
			"modules_list", array(
				"title" => "Todos los modulos",
				"template" => $this->template,
			)
		);
    }
	
    public function users_add(){
		$this->viewInTemplate(
			"users_add", array(
				"title" => "Nuevo Usuario",
				"template" => $this->template,
			)
		);
    }
	
    public function theme_list(){
		$this->viewInTemplate(
			"theme_list", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function settings(){
		$this->viewInTemplate(
			"blank", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function privacy(){
		$this->viewInTemplate(
			"blank", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function ads(){
		$this->viewInTemplate(
			"blank", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function header_and_footer_scripts(){
		$this->viewInTemplate(
			"blank", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function modules_editor(){
		$this->viewInTemplate(
			"blank", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function modules_add(){
		$this->viewInTemplate(
			"blank", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function gallery(){
		$this->viewInTemplate(
			"gallery", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function gallery_add(){
		$this->viewInTemplate(
			"picture_create", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function picture(){
		$this->view(
			"picture", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
	
    public function picture_editor(){
		$this->viewInTemplate(
			"picture_editor", array(
				"title" => "Modo Debug",
				"template" => $this->template,
			)
		);
    }
}