<?php

session_start();
//session_destroy();

$PATH = (strpos($_SERVER['SCRIPT_NAME'], 'modulos/') === false) ? '' : '../../';

$PATH_INCLUDES = $PATH .'includes/';

require_once($PATH . 'includes/configuracion.php');
require_once($PATH . 'classes/misc.class.php');
require_once($PATH . 'classes/paginador.class.php');
require_once($PATH . 'classes/usuarios.class.php');
require_once($PATH . 'classes/menu.class.php');
require_once($PATH . 'classes/export.class.php');

// ADODB
require_once($PATH . '../classes/adodb5/adodb-exceptions.inc.php');
require_once($PATH . '../classes/adodb5/adodb.inc.php');
$db = ADONewConnection('mysqlt');
$db->Connect(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

require($PATH .'../classes/smarty/Smarty.class.php');
$smarty = new Smarty();

if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);

        return $value;
    }

    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}


$user = new Usuarios($db);

$smarty->assign('PATH', $PATH);

$smarty->assign('UNBRAND', UNBRAND);
foreach(get_defined_constants() as $nombre_constante => $valor_constante){
	if(substr($nombre_constante, 0, 4) == 'SITE' || substr($nombre_constante, 0, 4) == 'LANG'){
		$smarty->assign($nombre_constante, $valor_constante);
	};
};

if (isset($_GET['logout'])) {
	$user->logout();
	header("location: " . $PATH . "index.php");
	exit;
}

if (!isset($public) || !$public) {
	if (! $user->isLogged()) {
		header("location: " . $PATH . "index.php?r=". base64_encode($_SERVER['REQUEST_URI']));
		exit;
	}
	

	$smarty->assign('login_name', $user->Nombre . ' ' . $user->Apellido);
	foreach ($_SESSION['onas']['config'] as $key => $value) {
		$smarty->assign(strtoupper($key), $value);
	}
}

if(isset($_POST['itemxpagina']) && (int)($_POST['itemxpagina']) > 0){
	Misc::setearItemsXPagina((int)($_POST['itemxpagina']));
	header("location: ". $_SERVER['PHP_SELF'] . Misc::getQuerystring(NULL));
	exit;
}
		
$menu = new Menu();
$onas_usuario = (isset($_SESSION['onas']['usuario']['data']['ID_Usuario'])) ? $_SESSION['onas']['usuario']['data']['ID_Usuario'] : NULL ;


$menu->getMenu($db,$smarty, $onas_usuario);
									
?>
