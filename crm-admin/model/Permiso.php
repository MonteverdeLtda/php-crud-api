<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class Permiso extends EntidadBase {
    private $id;
    private $name;
    private $data;
     
    public function __construct() {
        $table = TBL_PERMISSIONS;
        parent::__construct($table);
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
 
    public function getData() {
        return $this->data;
    }
 
    public function setData($data) { 
        $this->data = $data;
    }
 
    public function save(){
        $query="INSERT INTO " . TBL_PERMISSIONS . " (id,nombre,apellido,email,password)
                VALUES(NULL,
                       '".$this->name."',
                       '".$this->data."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }
}