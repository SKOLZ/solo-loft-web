<?php 
require_once("../../includes/init.php");
Misc::modulo_init();

/*
Si no esta seteada la variable $subtitulo_modulo se setea automaticamente (Alta y edicion, Detalles, Listado)
*/

/* VARIABLES DEL MODULO */

$nombre_modulo = 'Newsletters';

$nombre_tabla = 'Registrados_Newsletter';

$primary_key = 'ID_Registro';

$prefix_tpl = 'newsletters';


$imagenes[] = NULL;
				
					
/* FIN VARIABLES DEL MODULO */
	

if($do == 'delete'){
	Misc::control('borrar');
	Misc::classicDelete($nombre_tabla, $primary_key, $_GET['id']);
}

switch($do) {
	case 'view':
		Misc::control('listar');
		$form = $db->getRow("SELECT *,DATE_FORMAT(Fecha, '%d/%m/%Y') AS F_Fecha_Formato FROM ". $nombre_tabla ." WHERE ". $primary_key ." = ". $id);
		$smarty->assign('form', $form); 
		break;


		
	//LISTAR
	default:
		Misc::control('listar');
		
		$consulta_listado = "SELECT *,DATE_FORMAT(Fecha, '%d/%m/%Y') AS F_Fecha_Formato FROM ". $nombre_tabla;
		$columnas_listado = array('Email','Fecha');
		$campos_listado = array('Email','F_Fecha_Formato');
		$campos_busqueda = array('Email');
	
	
		$export_data['xls'] = true;
		
		
		$export_data['consulta_listado'] = "SELECT *,DATE_FORMAT(Fecha, '%d/%m/%Y') AS F_Fecha_Formato FROM ". $nombre_tabla;
		$export_data['columnas_listado'] = array('Email','Fecha');
		$export_data['campos_listado'] = array('Email','F_Fecha_Formato'); 
	
		$permisos['editar'] = false;
		$permisos['agregar'] = false;
		
		$orderby = 'Fecha';
		$ordertype = 'DESC';
		
		$filtro_buscador[] = array(
								'label' => 'Fecha',
								'query_field' => 'Fecha',
								'type' => 'date'
								);
}

Misc::modulo_end();
?>

