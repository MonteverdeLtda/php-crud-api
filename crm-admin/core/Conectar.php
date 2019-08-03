<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */
require_once(folder_admin . '/config/database.php');

class Conectar {
    private $driver;
    private $host, $user, $pass, $database, $charset;
   
    public function __construct() {
        $this->driver = DB_driver;
        $this->host = DB_host;
        $this->user = DB_user;
        $this->pass = DB_pass;
        $this->database = DB_database;
        $this->charset = DB_charset;
    }
     
    public function conexion(){
         
        if($this->driver=="mysql" || $this->driver==null){
            $con=new mysqli($this->host, $this->user, $this->pass, $this->database);
            $con->query("SET NAMES '".$this->charset."'");
        }
         
        return $con;
    }
     
    public function startFluent(){
        require_once "FluentPDO/FluentPDO.php";
         
        if($this->driver=="mysql" || $this->driver==null){
            $pdo = new PDO($this->driver.":dbname=".$this->database, $this->user, $this->pass);
            $fpdo = new FluentPDO($pdo);
        }
         
        return $fpdo;
    }
}
?>
