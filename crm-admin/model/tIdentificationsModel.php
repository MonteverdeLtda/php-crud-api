<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class tIdentifiactionsModel extends ModeloBase {
    private $table;
     
    public function __construct(){
        $this->table = TBL_T_IDENTIFICATIONS;
        parent::__construct($this->table);
    }
     
    //Metodos de consulta
    public function getUnPermiso(){
        $query = "SELECT * FROM " . TBL_T_IDENTIFICATIONS . " LIMIT 1";
        $usuario = $this->ejecutarSql($query);
        return ($usuario);
    }
}