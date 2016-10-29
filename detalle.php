<?php

define('SITE_DESCRIPTION','');
define('SITE_KEYWORDS','');
define('REL_CANONICAL','');

require_once('includes/init.php');

$q_prod = "SELECT * FROM Productos WHERE Online = 1 AND ID_Producto = ".$_GET['id']."  ORDER BY Titulo";
$producto = $db->getRow($q_prod);

$producto['Titulo'] = htmlentities ($producto['Titulo']);
$producto['Encabezado'] = htmlentities ($producto['Encabezado']);
//$producto['Descripcion'] = htmlentities ($producto['Descripcion']);
$producto['Servicios_dto'] = htmlentities ($producto['Servicios_dto']);

$smarty->assign('producto', $producto);

$img_adicionales = $db->getAll("SELECT * FROM Productos_Imagenes_Adicionales WHERE ID_Producto = ". (int)($_GET['id']) ." ORDER BY Orden");
$smarty->assign('img_adicionales', $img_adicionales);

if($producto['ID_Categoria'] == 2){
	$departamentos_complejo = $db->getAll("SELECT * FROM Productos WHERE ID_Perteneciente = ".$producto['ID_Perteneciente']." ORDER BY Titulo");
	$smarty->assign('departamentos_complejo', $departamentos_complejo);
}

$smarty->display('detalle.tpl');

?>