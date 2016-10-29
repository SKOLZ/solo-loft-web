<?php

define('SITE_DESCRIPTION','');
define('SITE_KEYWORDS','');
define('REL_CANONICAL','');

require_once('includes/init.php');

$smarty->assign('PAGE_TITLE', '');
$smarty->assign('productos_activo',' class="activo"');

//Destacado
$destacados_home = "SELECT * FROM Productos WHERE Online = 1 AND Destacado = 1 ORDER BY ID_Producto LIMIT 1";
$destacados = $db->getAll($destacados_home);
$smarty->assign('destacados', $destacados);

if(isset($_GET['busqueda']) and $_GET['busqueda'] != ''){

	$smarty->assign('busqueda', $_GET['busqueda']);
	
	$paginador = new Paginador($db, $smarty);
	$paginador->smarty_array = 'complejo';
	$paginador->nombre_unidades = 'resultados';
	
	// Realizo query con las invitaciones de la categoria
	$paginador->query = "SELECT * FROM Productos  WHERE (Titulo LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') ." OR Descripcion LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Ubicacion LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Servicios LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Servicios_dto LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Otros_datos LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . ") AND Online = 1 ORDER BY ID_Producto";
	
	$paginador->query_count = "SELECT COUNT(*) FROM Productos  WHERE (Titulo LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Descripcion LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Ubicacion LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Servicios LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Servicios_dto LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . " OR Otros_datos LIKE  ". $db->qstr('%'. $_GET['busqueda'] .'%') . ") AND Online = 1 ORDER BY ID_Producto";
	// Muestro resultados y el titulo (nombre de la categoria)
	$paginador->mostrar();
	
	if($paginador->query_count > 0){
		$hayProductos = true;
		$smarty->assign('hayProductos', $hayProductos);
	}

}

$smarty->display('resultados.tpl');

?>