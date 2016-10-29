<?php

// Inicio
session_start();
// Si es area privada verifico el login
if(isset($area_privada) && $area_privada == true){
	if(!isset($_SESSION['user_data']['id'])){
		header("location: index.php");
		exit;
	}
}

require('includes/configuracion.php');
require('classes/misc.class.php');
require('classes/paginador.class.php');

// ADODB
require_once('classes/adodb5/adodb-exceptions.inc.php');
require_once('classes/adodb5/adodb.inc.php');
$db = ADONewConnection('mysql');
$db->Connect(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

// Asigno Smarty
require('classes/smarty/Smarty.class.php');
$smarty = new Smarty();

	$smarty->assign('DEBUG', true);
	$smarty->clear_compiled_tpl();


if(MULTILENGUAJE){
	if(isset($_GET['lang'])){
		$_GET['lang'] = trim($_GET['lang']);
		if(file_exists('includes/lang/'. $_GET['lang'] .'.php')){
			$_SESSION['lang'] = $_GET['lang'];
			$lang = $_GET['lang'];
		}else{
			$codigo = $ip2c->get_country_code();
			$lang = misc::ipLang($codigo);
		}
	}else{
		if(isset($_SESSION['lang'])){
			if(file_exists('includes/lang/'. $_SESSION['lang'] .'.php')){
				$lang =  $_SESSION['lang'];
			}else{
				$codigo = $ip2c->get_country_code();
				$lang = misc::ipLang($codigo);
			}
		}else{
			$codigo = $ip2c->get_country_code();
			$_SESSION['lang'] = misc::ipLang($codigo);
			$lang = misc::ipLang($codigo);
		}
	}
	require('includes/lang/'. $lang .'.php');
	$smarty->assign('SITE_LANG', $lang);
	$smarty->assign('LANG_'. strtoupper($lang), ' activo');
}

foreach(get_defined_constants() as $nombre_constante => $valor_constante){
	if(substr($nombre_constante, 0, 4) == 'SITE' || substr($nombre_constante, 0, 4) == 'LANG'){
		$smarty->assign($nombre_constante, $valor_constante);
	};
};

/*$q_cat = "SELECT * FROM Productos_Categorias WHERE Online = 1 ORDER BY Categoria";
$categorias = $db->getAll($q_cat);
$smarty->assign('categorias', $categorias);

$q_nov = "SELECT * FROM Productos WHERE Online = 1 AND Novedades = 1 ORDER BY Titulo LIMIT 6";
$novedades = $db->getAll($q_nov);
$smarty->assign('novedades', $novedades);

$q_prod_nuevos = "SELECT * FROM Productos WHERE Online = 1 AND Nuevos = 1 ORDER BY Titulo LIMIT 3";
$productos_nuevos = $db->getAll($q_prod_nuevos);
$smarty->assign('productos_nuevos', $productos_nuevos);*/

?>
