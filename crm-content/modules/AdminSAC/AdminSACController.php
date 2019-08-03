<?php 

class AdminSACController extends ControladorBase {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		
	}
	public function types_pqrs(){
		$this->viewInTemplate(
			"types_pqrs", array(
				"title" => "Vista FrontPage",
				"template" => $this->template,
			)
		);
	}
	
	public function create_pqrs(){
		$this->viewInTemplate(
			"create_pqrs", array(
				"title" => "Vista FrontPage",
				"template" => $this->template,
			)
		);
	}
}