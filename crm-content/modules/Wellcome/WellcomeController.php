<?php 

class WellcomeController extends ControladorBase {
	
    public function __construct() {
        parent::__construct();
    }
	
	
    public function index(){
		$this->viewInTemplate(
			"wellcome", array(
				"title" => "Vista FrontPage",
				"template" => $this->template,
			)
		);
    }
	
	
	/*
	public function getHead(){
		$file = folder_admin . "/themes/{$this->theme}/global/head.php";
		if($this->validateFileExist($file) == true){
			include_once $file;
		}
	}
	
	public function getSection(){
		$file = folder_admin . "/themes/{$this->theme}/includes/{$this->module_active}.php";
		if($this->validateFileExist($file) == true){
			require_once $file;
		}		
	}*/
	
	public function __toString(){
		if(isset($this->body)){
			return $this->body;
		}else{
			return json_encode($this);
		}
	}
}