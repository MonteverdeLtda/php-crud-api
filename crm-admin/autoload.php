<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 * El controlador frontal es donde se cargan todos los ficheros de la aplicación y por tanto la única pagína que visita el usuario realmente es esta.
 */

//Configuración global
require_once 'crm-admin/config/global.php';

//Base para los controladores
require_once 'crm-admin/core/ControladorBase.php';
 
//Funciones para el controlador frontal
require_once 'crm-admin/core/ControladorFrontal.func.php';
 
//Cargamos controladores y acciones
if(isset($_GET["controller"])){
    $controllerObj=cargarControlador($_GET["controller"]);
    lanzarAccion($controllerObj);
}else{
    $controllerObj=cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controllerObj);
}