<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */


class EntidadBase {
    private $table;
    private $db;
    private $conectar;
 
    public function __construct($table) {
		require_once 'Conectar.php';
        $this->table=(string) $table;
        $this->conectar=new Conectar();
        $this->db=$this->conectar->conexion();
    }
     
    public function getConetar(){
        return $this->conectar;
    }
     
    public function db(){
        return $this->db;
    }
     
    public function getAll(){
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY id DESC");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
         
		 if(isset($resultSet)){
			 return $resultSet;
		 }else{
			 return array();
		 }
    }
     
    public function getById($id){
        $query=$this->db->query("SELECT * FROM $this->table WHERE id=$id");
 
        if($row = $query->fetch_object()) {
           $resultSet=$row;
        }
         
        return $resultSet;
    }
     
    public function getBy($column, $value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");
 
        while($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
		
		if(!isset($resultSet)){
			return array();
		}else{
			return $resultSet;
		}
    }
     
    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id=$id");
        return $query;
    }
     
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'");
        return $query;
    }
     
    public function get($key) { return $this->{$key}; }
 
    public function set($key, $id) { $this->{$key} = $id; }
 
    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
    public function getByDoubleColm($k1, $v1, $k2, $v2){
		$r = null;
        $query = $this->db->query("SELECT * FROM $this->table WHERE {$k1} IN ('{$v1}') AND {$k2} IN ('{$v2}')");
		
        while($row = $query->fetch_object()) { $resultSet[] = $row; }
		
		 if(!isset($resultSet)){
			 return array();
		 }else{
			 return $resultSet;
		 }
		 
    }
	
}
