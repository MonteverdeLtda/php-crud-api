<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class tIdentifiaction extends EntidadBase {
    private $id;
    private $name;
    private $code;
     
    public function __construct() {
        $table = TBL_T_IDENTIFICATIONS;
        parent::__construct($table);
    }
	
	public function login(){
		
	}
     
    public function getId() {
        return $this->id;
    }
 
    public function setId($id) {
        $this->id = $id;
    }
     
    public function getNombre() {
        return $this->name;
    }
 
    public function setNombre($name) {
        $this->name = $name;
    }
 
    public function getCodigo() {
        return $this->code;
    }
 
    public function setCodigo($code) { 
        $this->code = $code;
    }
 
    public function save(){
        $query="INSERT INTO " . TBL_T_IDENTIFICATIONS . " (id,nombre,apellido,email,password)
                VALUES(NULL,
                       '".$this->name."',
                       '".$this->code."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }
}