<?php
require_once("includes/init.php");
require_once('classes/usuarios.class.php');

$smarty->assign('nombre_modulo', 'Usuarios');
$smarty->assign('modulo_core', true);


if(isset($_GET['do']) && $_GET['do'] == 'delete'){
	Misc::control('borrar');
	$res = $db->execute("DELETE FROM ". TABLE_PREFIX . "onas_Usuarios WHERE ID_Usuario = " . $db->qstr($_GET['id']));
	if ($res) {
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
	//EDITAR Y AGREGAR
	case 'form':
		$smarty->assign('activar_edicion', true);
		$smarty->assign('subtitulo_modulo', 'Alta y edici&oacute;n');
		$tipo = (isset($_GET['id'])) ? 'editar' : 'agregar';	
		//Misc::control($tipo);
		$misc = new Misc();
		$misc-> control($tipo);
		if (!empty($_POST)) {			
			if ($_POST['indice'] != '') {
				if(isset($_POST['password']) && trim($_POST['password']) != ''){
					$query = "UPDATE ". TABLE_PREFIX . "onas_Usuarios SET
							Nombre = ". Misc::post('nombre') .",
							Apellido = ". Misc::post('apellido') .",
							Pswrd = '".  md5($_POST['password']) ."',
							Username = ". Misc::post('username') ."
							WHERE ID_Usuario = ". Misc::post('indice'); 	
				}else{
					$query = "UPDATE ". TABLE_PREFIX . "onas_Usuarios SET
						Nombre = ". Misc::post('nombre') .",
						Apellido = ". Misc::post('apellido') .",
						Username = ". Misc::post('username') ."
						WHERE ID_Usuario = ". Misc::post('indice');
				}		
	
			}else{
				$query = "INSERT INTO ". TABLE_PREFIX . "onas_Usuarios (Nombre, Apellido, Pswrd, Username) VALUES (
						". Misc::post('nombre')  .", 
						". Misc::post('apellido')  .",
						'". md5($_POST['password'])."',
						". Misc::post('username') .")"; 									
			}				
		
			$res = $db->execute($query);
			
			if ((int)($_POST['indice']) > 0) {
				$last_id = $_POST['indice'];
			}else{
				$last_id = $db->Insert_ID();
			}
			//Usuarios::setPermisos($last_id, $_POST['permiso']);
			$usuarios = new Usuarios();
			$usuarios-> setPermisos($last_id, $_POST['permiso']);

			if($res){ 	
				$smarty->assign('mensaje', 'El proceso se ha completado con éxito.');
				$smarty->assign('mensaje_link' , Misc::getQuerystring(array('do' => '', 'id' => '')));
				$smarty->assign('mensaje_boton', 'Continuar');
			}else{
				$smarty->assign('mensaje', 'El proceso no se ha completado. Intente nuevamente.');
				$smarty->assign('mensaje_link' , 'javascript:history.go(-1);');
				$smarty->assign('mensaje_boton', 'Volver');
			} 
			$smarty->display('mensajes.tpl');
		}else{
			if(isset($_GET['id'])){
				$usuario = $db->getRow("SELECT * FROM " . TABLE_PREFIX . "onas_Usuarios WHERE ID_Usuario = ". $db->qstr($_GET['id']));
				$smarty->assign('usuario', $usuario);
				$user->getPermisos($smarty, $_GET['id'], false);
			}else{
				$user->getPermisos($smarty, NULL, false);
			} 
			
			$smarty->assign('form_body', 'core/usuarios_form.tpl');
			$smarty->display('form_base.tpl');
		}
			
		break;
	//VER
	case 'view':
		Misc::control('listar');
		
		$smarty->assign('subtitulo_modulo', 'Detalle');
				
		$usuario = $db->getRow("SELECT * FROM " . TABLE_PREFIX . "onas_Usuarios WHERE ID_Usuario = ". (int)($_GET['id']));
		$smarty->assign('usuario', $usuario);
		$user->getPermisos($smarty, $_GET['id'], true);
		
		$smarty->assign('form_body', 'core/usuarios_view.tpl');
		$smarty->display('form_base.tpl');
		break;
	//LISTAR
	default:
		Misc::control('listar');
		
		$smarty->assign('subtitulo_modulo', 'Listado');
		
		$consulta_listado = "SELECT * FROM " . TABLE_PREFIX . "onas_Usuarios";
		$columnas_listado = array('Username', 'Nombre', 'Apellido');
		$campos_listado = array('Username', 'Nombre', 'Apellido');
		$campos_busqueda = array('Username', 'Nombre', 'Apellido');
		$ordenar["grupo"] = false;
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
		
		
		Misc::obtenerListado($smarty, $pagina, $campo_busqueda, Misc::obtenerItemsXPagina(), $orderby, $ordertype, $columnas_listado, $campos_listado, $consulta_listado, 'ID_Usuario', $permisos, $export_data, $campos_busqueda, $ordenar);		
		$smarty->display('listado.tpl');
}


?>
