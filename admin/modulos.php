<?php

require_once("includes/init.php");
require_once('classes/modulos.class.php');

$smarty->assign('nombre_modulo', 'Módulos');
$smarty->assign('modulo_core', true);

$modulo = new Modulos();


if(isset($_GET['do']) && $_GET['do'] == 'delete'){
	Misc::control('borrar');

	if ($modulo->delete($_GET['id'])) {
		$smarty->assign('mensaje_notificacion_evento', 'El registro ha sido eliminado con exito');
	} else {
		$smarty->assign('mensaje_notificacion_evento', 'Ocurrio un error, el registro no pudo ser eliminado.<br /> 
					Compruebe que el modulo no sea predecesor de una jerarquia (padre),<br />
					recuerde que solo se pueden eliminar modulos sin descendencia.');
	}
	$_GET['do'] = NULL;
	unset($_GET['do']);
}



if (isset($_GET["do"])) {
	$do = $_GET['do'];
} else if (isset($_POST["do"])) {
	$do = $_POST["do"];
}else{
	$do = '';
}


switch($do) {
	case 'orden':
		Misc::control('listar');
		
		$smarty->assign('subtitulo_modulo', 'Orden');	
	
		
		if(!empty($_POST)){
			$modulo->procesarSecuenciaReajusteArbolModulos();
			$smarty->assign('CAMBIOS_GUARDADOS', true);
		}
		$smarty->assign('html_arbol_modulos', $modulo->getHTMLArbolModulos());
		$smarty->display('core/modulos_orden.tpl');
		break;

	//EDITAR Y AGREGAR
	case 'form':
		$smarty->assign('activar_edicion', true);
		$tipo = (isset($_GET['id'])) ? 'editar' : 'agregar';	
		Misc::control($tipo);

		
		$smarty->assign('subtitulo_modulo', 'Alta y edición');	
	
		if (!empty($_POST)) {
			if ($modulo->saveProfile($smarty, $_POST, $_POST['indice'])) {
				$smarty->assign('mensaje', 'El proceso se ha completado con éxito.');
				$smarty->assign('mensaje_link' , Misc::getQuerystring(array('do' => '', 'id' => '')));
				$smarty->assign('mensaje_boton', 'Continuar');

			} else {
				$smarty->assign('mensaje', 'El proceso no se ha completado. Intente nuevamente.');
				$smarty->assign('mensaje_link' , 'javascript:history.go(-1);');
				$smarty->assign('mensaje_boton', 'Volver');
			} 
			$smarty->display('mensajes.tpl');
		} else {
			$id = (isset($_GET['id']) && $_GET['id'] > 0) ? $_GET['id'] : null;
			$modulo->loadProfile($smarty, $id);
			
			$tipo = ($modulo->Tipo_Modulo > 0) ? $modulo->Tipo_Modulo : 1;
			$usuarios = Usuarios::getUsuarios($smarty, $tipo, $id);
			$smarty->assign('usuarios', $usuarios);
			$smarty->assign('form_body', 'core/modulos_form.tpl');
			$smarty->display('form_base.tpl');
		}
			
		break;
	//VER
	case 'view':
		Misc::control('listar');
		
		$smarty->assign('subtitulo_modulo', 'Detalle');
				
		$modulo->view($smarty, $_GET['id']);
		
		$tipo = ($modulo->Tipo_Modulo > 0) ? $modulo->Tipo_Modulo : 1;
		$usuarios = Usuarios::getUsuarios($smarty, $tipo, $_GET['id'], true);
		$smarty->assign('usuarios', $usuarios);
		
		$smarty->assign('form_body', 'core/modulos_view.tpl');
		$smarty->display('form_base.tpl');
		break;
	//LISTAR
	default:
		Misc::control('listar');
		
		$smarty->assign('subtitulo_modulo', 'Listado');
		
		$consulta_listado = 'SELECT * FROM ' . TABLE_PREFIX . 'onas_Modulos WHERE (Core <> 1 OR Core IS NULL)';
		$columnas_listado = array('Nombre');
		$campos_listado = array('Texto');
		$campos_busqueda = array('Texto');
		$ordenar["grupo"] = true;
		$ordenar["texto_grupo"] = "Reordenar menu";
		$ordenar["items"] = false;
		$ordenar["texto_items"] = "";
		
		$export_data = NULL;
		
		if(Misc::controlarPermisos('agregar')){ $permisos["agregar"] = true; }
		if(Misc::controlarPermisos('editar')){ $permisos["editar"] = true; }
		if(Misc::controlarPermisos('borrar')){ $permisos["borrar"] = true; }
		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
		$campo_busqueda = isset($_GET['campo_busqueda']) ? $_GET['campo_busqueda'] : '';
		$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : NULL;
		$ordertype = isset($_GET['ordertype']) ? $_GET['ordertype'] : NULL;
		
		
		
		Misc::obtenerListado($smarty, $pagina, $campo_busqueda, Misc::obtenerItemsXPagina(), $orderby, $ordertype, $columnas_listado, $campos_listado, $consulta_listado, 'ID_Modulo', $permisos, $export_data, $campos_busqueda, $ordenar);		
		$smarty->display('listado.tpl');
}


?>
