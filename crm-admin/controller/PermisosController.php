<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class PermisosController extends ControladorBase {
    public function __construct() {
        parent::__construct();
    }
     
    public function index(){
        //Creamos el objeto permisos
        $permissions = new Permiso();
        //Conseguimos todos los usuarios
        $allpermissions = $permissions->getAll();
        //Cargamos la vista index y le pasamos valores
		
        $this->view(
			"permissions", array(
				"allpermissions" => $allpermissions,
				"title" => "Permisos de Usuarios",
				"subtitle" => "",
				"description" => "Estos son los perfiles o permisos de los usuarios"
			)
		);
    }
 
}
?>
