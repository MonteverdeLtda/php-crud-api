<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

//FUNCIONES PARA EL CONTROLADOR FRONTAL
 
function cargarControlador($controller){
    $controlador = ucwords($controller).'Controller';
	$folder_system = (folder_admin . '/controller/'.$controlador.'.php');
	$folder_modules = (folder_content . '/modules/'.ucwords($controller).'/'.$controlador.'.php');
	
	if(is_file($folder_system) && !is_file($folder_modules)){
		$strFileController = $folder_system;
	}
	else if(!is_file($folder_system) && is_file($folder_modules)){
		$strFileController = $folder_modules;
	}
	else if(is_file($folder_system) && is_file($folder_modules)){
		$strFileController = $folder_system;
	}
	else if(!is_file($folder_system) && !is_file($folder_modules)){
		exit("Error: Controlador no detectado.");
	}
	else {
		exit("Error: problema en el controlador.");
	}
	
	if(@file_exists($strFileController)){		
		require_once $strFileController;
		$controllerObj = new $controlador();
		return $controllerObj;
	}
}
 
function cargarAccion($controllerObj,$action){
    $accion=$action;
    $controllerObj->$accion();
}
 
function lanzarAccion($controllerObj){
    if(isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
        cargarAccion($controllerObj, $_GET["action"]);
    }else{
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}
function listar_directorios_ruta($ruta, $limit = 999999999999999){
	
	#$r->ruta = $ruta;
	$r = array();
	
	if (is_dir($ruta)) {
		if ($dh = opendir($ruta)) {
			while (($file = readdir($dh)) !== false) {
				 if (count($r) == $limit) { break; }
				if($file != ".." && $file != "." && $file != ""){
					$item = new stdClass();
					$item->ruta = $ruta . $file;
					$item->name = $file;
					$item->tree = array();
					#$item->type = filetype($ruta . $file);
					# $item->ruta = $ruta;
					
					if (is_dir($ruta . $file) && $file!="." && $file!=".." && $file != ""){
						$item->tree = listar_directorios_ruta($ruta . $file . "/", $limit);
					}
					
					$r[] = $item;
					
				}
				
			}
      closedir($dh); 
      } 
   } else {
	   # echo "<br>No es ruta valida";
   }
   return $r;
}
