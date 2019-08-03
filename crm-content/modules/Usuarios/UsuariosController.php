<?php 
class UsuariosController extends ControladorBase {
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		
	}
	
    public function mi_perfil(){
		$this->viewInTemplate(
			"mi_perfil", array(
				"title" => "mi_perfil",
				"template" => $this->template,
			)
		);
    }
}