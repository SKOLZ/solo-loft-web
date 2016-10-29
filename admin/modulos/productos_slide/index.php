<?php 
require_once("../../includes/init.php");
Misc::modulo_init();

/*
Si no esta seteada la variable $subtitulo_modulo se setea automaticamente (Alta y edicion, Detalles, Listado)
*/

/* VARIABLES DEL MODULO */

$nombre_modulo = 'Slide de Productos';

$nombre_tabla = 'Productos_Slide';

$primary_key = 'ID_Slide';

$prefix_tpl = 'productos_slide';

$imagenes[] = array(
					'nombre_imagen' => '{LAST_ID}_original',
					'nombre_campo_form' => 'imagen',
					'path' => '../../../upload/productos/slide',
					'dimensiones' => array(
											
												array('ancho' => 1663, 'alto' => 752, 'nombre' => '{LAST_ID}_th')																																	
											
									),
					'tipo_resize' => 'jcrop',
					'update_db' => array(
										'tabla_actualizar' => $nombre_tabla,
										'primary_key' => $primary_key,
										'primary_key_value' => '{LAST_ID}',
										'campo_actualizar' => 'Img_Ext'
									)
					);
					

					
				
					
/* FIN VARIABLES DEL MODULO */
	
if($do == 'ajax'){
	echo Misc::classicAjaxUpdate($nombre_tabla, 'Online', (int)($_GET["status"]), $primary_key , (int)($_GET["id"]));
	exit;
}

if($do == 'delete'){
	Misc::control('borrar');
	Misc::classicDelete($nombre_tabla, $primary_key, $_GET['id']);
}

switch($do) {
	case 'form': // automaticamente se crea $tipo_form y asigna $indice en smarty
		Misc::control($tipo_form);
		if (!empty($_POST)) {			
			if ((int)($_POST['indice']) > 0) {
				$query = "UPDATE $nombre_tabla SET 	
						
						Titulo_Amarillo = ". Misc::post('titulo_amarillo') .",					
						Online = ". Misc::post('online', 'int') ." 
						WHERE $primary_key = ". Misc::post('indice', 'int'); 						
			}else{
				$query = "INSERT INTO $nombre_tabla (Titulo_Amarillo,Online) VALUES (
						
						". Misc::post('titulo_amarillo') .",
						". Misc::post('online', 'int') .")";
			}
			$res = $db->execute($query);
			
			if ((int)($_POST['indice']) > 0) {
				$last_id = $_POST['indice'];
			}else{
				$last_id = $db->Insert_ID();
			}
			
			if($res){ 	
				Misc::uploadImagenes($imagenes);
				Misc::mensajeOK();
			}else{
				Misc::mensajeError();
			} 
		}else{
			if($id){
				$form = $db->getRow("SELECT * FROM ". $nombre_tabla ." WHERE ". $primary_key ." = ". $id);
				$smarty->assign('form', $form);
			} 
			
		}
		break;
		
	case 'jcrop':
		Misc::finalizarJCrop();
	break; 
	case 'view':
		Misc::control('listar');
		$form = $db->getRow("SELECT * FROM ". $nombre_tabla ." WHERE ". $primary_key ." = ". $id);
		$smarty->assign('form', $form); 
		break;
	case "orden":
		Misc::control('listar');

		$titulo = "Ordenar productos";
		$consulta_orden = "SELECT * FROM ". $nombre_tabla . " ORDER BY Orden";
		$campo_orden = "Orden";
		$campo_mostrar = "Link";

		break;
	//LISTAR
	default:
		Misc::control('listar');
		
		$consulta_listado = "SELECT * FROM ". $nombre_tabla;
		$columnas_listado = array('Titulo');
		$campos_listado = array('Titulo_Amarillo');
		$campos_busqueda = array('Titulo_Amarillo');
	
		$ajax_params["enabled"] = true;
		$ajax_params["nombre_columna"] = "Online/Offline";
		$ajax_params["nombre_campo"] = "Online";
		$export_data['xls'] = false;
		/* CAMBIAR SOLO SI EL EXCEL ES DIFERENTE AL LISTADO
		$export_data['consulta_listado'] = "SELECT * FROM ". $nombre_tabla;
		$export_data['columnas_listado'] = array('Nombre', 'Apellido');
		$export_data['campos_listado'] = array('Nombre', 'Apellido');
		*/
		$ordenar["grupo"] = false;
		$ordenar["texto_grupo"] = "Ordenar";
		$ordenar["items"] = false;
		$ordenar["texto_items"] = "";
		$ordenar["link_items"] = "";
		$ordenar["campo_items"] = "";
		
		
		
		$orderby = 'Orden';
		$ordertype = 'ASC';
		

	
}

Misc::modulo_end();
?>