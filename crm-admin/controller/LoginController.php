<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class LoginController extends ControladorBase {
	public $options;
	public $identification_type;
	public $identification_number;
	public $user;
	
    public function __construct() {
        parent::__construct();
		if(isset($_SESSION['user']) && get_called_class() != 'LoginController'){
			@header("Location: /");
			exit();
		}
		
		$this->options = new stdClass();
		$this->options->types_identifications = array();
        $types_identifications = new tIdentifiaction();
        $types_identifications = $types_identifications->getAll();
		if(count($types_identifications) > 0){
			$this->options->types_identifications = $types_identifications;
		}
		// htmlspecialchars
    }
	
    public function index(){
		$this->viewSystem(
			"login", array(
				"options" => $this->options,
				"title" => "Bienvenid@",
				"subtitle" => "",
				"description" => "Por favor ingrese sus datos para acceder al portal."
			)
		);
    }
	
    public function login(){
		if(
			isset($this->post)
			&& isset($this->post['identification_type']) && $this->post['identification_type'] != "" 
			&& isset($this->post['identification_number']) && $this->post['identification_number'] != ""
		){
			$this->identification_type = $this->post['identification_type'];
			$this->identification_number = $this->post['identification_number'];
			$searchUser = $this->searchUserLogin($this->identification_type, $this->identification_number);
			
			if($searchUser == true){
				$this->viewSystem(
					"password", array(
						"options" => $this->options,
						"title" => "Hola {$this->user->names}",
						"user" => $this->user,
						"subtitle" => "",
						"description" => "Por favor ingrese su contraseña para acceder."
					)
				);
			}else{
				$this->error('Upss', 'No hemos encontrado ninguna cuenta con estos datos.');
			}
		}else{
			$this->index();
		}
	}
	
    public function error($title = "Error", $message = ""){
		if($message == "" && isset($_GET['message']))
		{
			$message = base64_decode($_GET['message']);
		}
		$this->viewSystem(
			"loginError", array(
				"options" => $this->options,
				"title" => $title,
				"subtitle" => "",
				"description" => "Los datos estan incorrectos intenta nuevamente."
			)
		);
    }
	
	public function searchUserLogin($identification_type, $identification_number){
		$usuario = $this->user = new Usuario();
		
		if($identification_type != null && $identification_number != null){ $usuario->getByUsername("{$this->identification_type}:{$this->identification_number}"); };
		
		if($usuario->isUser()){ return true; } 
		else { return false; }
	}
}