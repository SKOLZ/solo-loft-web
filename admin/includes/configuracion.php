<?php
define('ERR_LOGIN_EMPTY', 'Deben ingresar un usuario y contrase�a');
define('ERR_LOGIN_INVALID', 'El usuario o la contrase�a son inv�lidos');
define('DEFAULT_ITEMS_X_PAGINA', 10);
define("PATH_PREFIX", "admin/");
define('TABLE_PREFIX', '');
define("FTP_TMP_PATH", "../../upload/ftp/");
	
$PATH_ONAS = (strpos($_SERVER['SCRIPT_NAME'], 'modulos/') === false) ? '' : '../../';

require_once($PATH_ONAS. "../includes/configuracion.php");

define("UNBRAND", false);

?>
