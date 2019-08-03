<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */
 
// Activar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("CONTROLADOR_DEFECTO", "wellcome");
define("ACCION_DEFECTO", "index");

define("TEMA_DEFECTO", "default");
#define("MODULO_DEFECTO", "paginas");
#define("SECCION_DEFECTO", "principal");


//Más constantes de configuración
$thisFile = (__FILE__);
$thisFileDirname = dirname($thisFile);
define('folder_config_global', $thisFileDirname);
define('folder_admin', dirname($thisFileDirname . '../'));
define('folder_principal', (dirname(folder_admin . '../')));
define('folder_content', ((folder_principal . '/crm-content')));

function getPath() : string {
	$a = null;
	
	if (!isset($_SERVER['REQUEST_URI'])) {
		$_SERVER['REQUEST_URI'] = '/';
	}
	$a = $_SERVER['REQUEST_URI'];
	return $a;
}
define('current_path', getPath());

$protocol = @$_SERVER['HTTP_X_FORWARDED_PROTO'] ?: @$_SERVER['REQUEST_SCHEME'] ?: ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https" : "http");
$port = @intval($_SERVER['HTTP_X_FORWARDED_PORT']) ?: @intval($_SERVER["SERVER_PORT"]) ?: (($protocol === 'https') ? 443 : 80);
$host = @explode(":", $_SERVER['HTTP_HOST'])[0] ?: @$_SERVER['SERVER_NAME'] ?: @$_SERVER['SERVER_ADDR'];
$port = ($protocol === 'https' && $port === 443) || ($protocol === 'http' && $port === 80) ? '' : ':' . $port;
$path = @trim(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/openapi')), '/');
