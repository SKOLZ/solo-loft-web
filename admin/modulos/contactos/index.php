<?php 
require_once("../../includes/init.php");
Misc::modulo_init();

/*
Si no esta seteada la variable $subtitulo_modulo se setea automaticamente (Alta y edicion, Detalles, Listado)
*/

/* VARIABLES DEL MODULO */

$nombre_modulo = 'Contactos';

$nombre_tabla = 'Contactos';

$primary_key = 'ID_Contacto';

$prefix_tpl = 'contactos';


$imagenes[] = NULL;
				
					
/* FIN VARIABLES DEL MODULO */
	

if($do == 'delete'){
	Misc::control('borrar');
	Misc::classicDelete($nombre_tabla, $primary_key, $_GET['id']);
}

switch($do) {
	case 'view':
		Misc::control('listar');
		$form = $db->getRow("SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y %H:%i:%s') AS F_Fecha_Formato FROM ". $nombre_tabla ." WHERE ". $primary_key ." = ". $id);
		$smarty->assign('form', $form); 
		break;


		
	//LISTAR
	default:
		Misc::control('listar');
		

		
		$consulta_listado = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y %H:%i:%s') AS F_Fecha_Formato FROM ". $nombre_tabla;
		$columnas_listado = array('Nombre','Email','Fecha');
		$campos_listado = array('Nombre','Email','F_Fecha_Formato');
		$campos_busqueda = array('Nombre','Email');
	
	
		$export_data['xls'] = true;
		
		
		$export_data['consulta_listado'] = "SELECT *,DATE_FORMAT(Fecha, '%d/%m/%Y %H:%i:%s') AS F_Fecha_Formato  FROM ". $nombre_tabla;
		$export_data['columnas_listado'] = array('Nombre','Telefono','Dirección','Asunto','Fecha','Email','Mensaje');
		$export_data['campos_listado'] = array('Nombre','Telefono','Direccion','Asunto','F_Fecha_Formato','Email','Mensaje'); 
	
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

