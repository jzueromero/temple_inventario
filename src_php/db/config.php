<?php

$mostrar_errores = 1;

if ($mostrar_errores == 1) {
	ini_set('display_errors', 'On');
 
	// Valor por defecto en PHP
	// Muestra todos los errores menos las notificaciones
	error_reporting(E_ALL ^ E_NOTICE);
 
	// Muestro todos los errores
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	error_reporting(E_ALL);
	error_reporting(-1);
 
	// Muestro todos los errores, incluso los estrictos
	error_reporting(E_ALL | E_STRICT);
 
	// No muestra ningún error
	error_reporting(0);
 
	// También se puede usar la función ini_set
	ini_set('error_reporting', E_ALL);
}

/*
define('DB_HOST', 'localhost:3306');
define('DB_NAME', 'kxdrzfsc_temple_inventario_01');
define('DB_USUARIO', 'kxdrzfsc_temple_user_root_mitienditasv');
define('DB_PASS', 'rTP?Spw_+S^v');
define('DB_CHARSET', 'utf8');
define('ZONE_TIME', "America/El_Salvador");
*/

define('DB_HOST', 'localhost');
define('DB_NAME', 'temple_inventario_07');
define('DB_USUARIO', 'root');
define('DB_PASS', 'rootmysql123');
define('DB_CHARSET', 'utf8mb4');
define('ZONE_TIME', "America/El_Salvador");


?>