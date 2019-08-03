<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class UsuariosModel extends ModeloBase {
    private $table;
     
    public function __construct(){
        $this->table = TBL_USERS;
        parent::__construct($this->table);
    }
     
    //Metodos de consulta
    public function getUnUsuario(){
        $query = "SELECT * FROM " . TBL_USERS . " LIMIT 1";
        $usuario = $this->ejecutarSql($query);
        return ($usuario);
    }
	/*
    public function getByTypeDocAndDoc($type_identification, $identification_number){
        $query = $this->db->query("SELECT * FROM $this->table WHERE type_identification IN ('{$type_identification}') AND identification_number IN ('{$identification_number}')");
		
		$resultSet = array();
		if(count($query->fetch_object()) > 0){
			
			while($row = $query->fetch_object()) {
			   $resultSet[]=$row;
			}
		}
			 
        return $resultSet;
    }*/
}
?>
