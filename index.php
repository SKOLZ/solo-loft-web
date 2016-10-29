<?php
define('SITE_DESCRIPTION','');
define('SITE_KEYWORDS','');
define('REL_CANONICAL','');

require_once('includes/init.php');

$smarty->assign('home', true);

$slides = "SELECT * FROM Productos_Slide WHERE Online = 1 ORDER BY ID_Slide";
$slide = $db->getAll($slides);
$smarty->assign('slides', $slide);


$destacados_home = "SELECT * FROM Productos WHERE Online = 1 AND Home = 1 ORDER BY ID_Producto LIMIT 3";
$destacados = $db->getAll($destacados_home);
$smarty->assign('destacados', $destacados);


$smarty->display('home.tpl');

?>