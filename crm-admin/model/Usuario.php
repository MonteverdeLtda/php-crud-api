<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class Usuario extends EntidadBase {
    public $id;
    public $username;
    public $identification_type;
    public $identification_number;
    public $names;
    public $surname;
    public $email;
    public $password;
    public $company_name;
    public $company_position;
    public $notes;
    public $registered;
    public $updated;
    public $last_connection;
     
    public function __construct() {
        $table = TBL_USERS;
        parent::__construct($table);
    }
	
	public function __toString(){
		return json_encode($this);
	}
	
	public function getThisAll(){
		return json_encode($this);
	}
	
	public function getId(){
		return ($this->id == null) ? 0 : (int) $this->id;
	}
	
	public function isUser(){
		if($this->getId() > 0){ return true; } else { return false; }
	}
	
	
	public function getByUsername($v1){
		 $usuario = $this->getBy('username', $v1);
		 if(isset($usuario[0]) && isset($usuario[0]->id) && (int) $usuario[0]->id > 0){
			 foreach($usuario[0] as $k => $v){
				 $this->{$k} = $v;
			 }
			 return true;
		 }else{
			 return false;
		 }
	}
	
	public function getByIdentification($v1, $v2){
		 $usuario = $this->getByDoubleColm('identification_type', $v1, 'identification_number', $v2);		 
		 if(isset($usuario[0]) && isset($usuario[0]->id) && (int) $usuario[0]->id > 0){
			 foreach($usuario[0] as $k => $v){
				 $this->{$k} = $v;
			 }
			 return true;
		 }else{
			 return false;
		 }
	}
	
}