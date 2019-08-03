<?php 

class AsistenciaJuridicaController extends ControladorBase {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
	}
	
	public function peticiones_pendientes(){
		$this->viewInTemplate(
			"consola_pqrs_peticiones", array(
				"title" => "Vista FrontPage",
				"template" => $this->template,
			)
		);
	}
	
	public function quejas_pendientes(){
		$this->viewInTemplate(
			"consola_pqrs_quejas", array(
				"title" => "Vista FrontPage",
				"template" => $this->template,
			)
		);
	}
	
}