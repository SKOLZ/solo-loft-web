<?php

define('SITE_DESCRIPTION','');
define('SITE_KEYWORDS','');
define('REL_CANONICAL','');

require_once('includes/init.php');

$categorias = $db->getAll("SELECT pc.ID_Categoria, pc.Categoria, COUNT(pc.ID_Categoria) AS Total
							FROM Productos_Categorias pc
							LEFT JOIN Productos p ON pc.ID_Categoria = p.ID_Categoria
							WHERE pc.ID_Categoria NOT IN (1,2) AND pc.Online = 1 AND p.Online = 1
							GROUP BY pc.ID_Categoria, pc.Categoria ORDER BY Categoria");
$total_categorias = count($categorias);

$smarty->assign('categorias', $categorias);

$categorias_item = $db->getAll("SELECT * FROM Productos_Categorias WHERE Online = 1");
$smarty->assign('categorias_item', $categorias_item);

$complejos = $db->getOne("SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria = 1 ORDER BY ID_Producto");
if($complejos > 0){
	$smarty->assign('activar_complejo', true);
}

$ventas = $db->getOne("SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria_Departamento = 1 ORDER BY ID_Producto");
if($ventas > 0){
	$smarty->assign('activar_ventas', true);
}

$alquileres = $db->getOne("SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria_Departamento = 2 ORDER BY ID_Producto");
if($alquileres > 0){
	$smarty->assign('activar_alquileres', true);
}

$temporales = $db->getOne("SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria_Departamento = 3 ORDER BY ID_Producto");
if($temporales > 0){
	$smarty->assign('activar_temporales', true);
}

if(isset($_GET['id_categoria']) and $_GET['id_categoria'] != ''){
	$paginador = new Paginador($db, $smarty);
	$paginador->smarty_array = 'complejo';
	$paginador->nombre_unidades = 'propiedades';
	
	if($_GET['id_categoria'] == 'complejos'){
		$paginador->query = "SELECT * FROM Productos WHERE Online = 1 AND ID_Categoria = 1 ORDER BY ID_Producto";
		$paginador->query_count = "SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria = 1 ORDER BY ID_Producto";
		$smarty->assign('complejos_active', true);
	}elseif($_GET['id_categoria'] == 'ventas'){
		$paginador->query = "SELECT * FROM Productos WHERE Online = 1 AND ID_Categoria_Departamento = 1 ORDER BY ID_Producto";
		$paginador->query_count = "SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria = 2 AND ID_Categoria_Departamento = 2 ORDER BY ID_Producto";
		$smarty->assign('ventas_active', true);
	}elseif($_GET['id_categoria'] == 'alquileres'){
		$paginador->query = "SELECT * FROM Productos WHERE Online = 1 AND ID_Categoria_Departamento = 2 ORDER BY ID_Producto";
		$paginador->query_count = "SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria = 2 AND ID_Categoria_Departamento = 2 ORDER BY ID_Producto";
		$smarty->assign('alquileres_active', true);
	}elseif($_GET['id_categoria'] == 'temporales'){
		$paginador->query = "SELECT * FROM Productos WHERE Online = 1 AND ID_Categoria_Departamento = 3 ORDER BY ID_Producto";
		$paginador->query_count = "SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria = 2 AND ID_Categoria_Departamento = 3 ORDER BY ID_Producto";
		$smarty->assign('temporales_active', true);
	}else{
		$paginador->query = "SELECT * FROM Productos WHERE Online = 1 AND ID_Categoria = '".$_GET['id_categoria']."' ORDER BY ID_Producto";
		$paginador->query_count = "SELECT COUNT(*) FROM Productos WHERE Online = 1 AND ID_Categoria = '".$_GET['id_categoria']."' ORDER BY ID_Producto";
		
		//que categoria estas
		$que_categoria = $_GET['id_categoria'];
		$smarty->assign('categoria_activa', $que_categoria);
	}
}else{
	$paginador = new Paginador($db, $smarty);
	$paginador->smarty_array = 'complejo';
	$paginador->nombre_unidades = 'propiedades';
	
	// Realizo query con las propiedades de la categoria
	$paginador->query = "SELECT * FROM Productos WHERE Online = 1 ORDER BY ID_Producto";
	$paginador->query_count = "SELECT COUNT(*) FROM Productos WHERE Online = 1 ORDER BY ID_Producto";
}

$paginador->mostrar();

//Destacado
$destacados_home = "SELECT * FROM Productos WHERE Online = 1 AND Destacado = 1 LIMIT 1";
$destacados = $db->getAll($destacados_home);
$smarty->assign('destacados', $destacados);

$smarty->display('propiedades.tpl');

?>