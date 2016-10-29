<?php
$public = true;
require_once("includes/init.php");

if(isset($user) && $user->isLogged()){
	header('location: home.php');
	exit;
}
$title = "Titulo de la pagina";

if (isset($_POST['submit']) && $_POST['submit'] == 'Ingresar') {	
	if ($user->login($_POST['user'], $_POST['pass'])) {
		if(isset($_GET['r'])){
			header('location: '. base64_decode($_GET['r']));
		}else{
			header('location: home.php');
		}
		exit;
	} else {
		$smarty->assign('mensaje_error', $user->error);
	}
	
}

$smarty->display('index.tpl');

?>
