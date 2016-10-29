<?php

// Para que strtolower funcione tambien sobre caracteres especiales
setlocale(LC_ALL, 'es_ES');

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);	 

/*ini_set('display_errors', 0);
ini_set('error_reporting', 0);*/
define('DB_SERVER', 'localhost');
define('DB_DATABASE', 'c10sololoft');
define('DB_USER', 'c10sololoft');
define('DB_PASS', 'zanzotti123');

define('MAIL_CONTACTO', 'sololoft@gmail.com, proyectos@giusa.com.ar');
define('MAIL_CONTACTO_NAME', 'CONSULTORA ROCA REAL ESTATE');

define('MULTILENGUAJE', false);
define('DEFAULT_LANG', 'es'); // Solo tiene efecto si MULTILENGUAJE = TRUE
	
define('PATH_PHPMAILER', 'classes/phpmailer/');	
define('SITE_PATH','http://www.solo-loft.com.ar/');
define('SITE_TITLE','');

/*************************************************************************/

?>
