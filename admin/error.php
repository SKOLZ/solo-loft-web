<?php
require_once("includes/init.php");

$smarty->assign('nombre_modulo', 'ERROR');
$smarty->assign('subtitulo_modulo', 'Error');	

$smarty->assign('mensaje', 'Su usuario no dispone de permisos para realizar esta operacion. <a href="#" onclick="history.back(-2);">Volver</a>');
$smarty->display('mensajes.tpl');


?>
