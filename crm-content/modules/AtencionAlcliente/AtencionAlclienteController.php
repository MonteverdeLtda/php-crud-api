<?php 

class AtencionAlclienteController extends ControladorBase {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		
	}
	
	public function create_pqrs_peticion(){
		$this->viewInTemplate(
			"create_pqrs_peticion", array(
				"title" => "Vista FrontPage",
				"template" => $this->template,
			)
		);
	}
}