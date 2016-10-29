<?php 
require_once("../../includes/init.php");
Misc::modulo_init();

/*
Si no esta seteada la variable $subtitulo_modulo se setea automaticamente (Alta y edicion, Detalles, Listado)
*/

/* VARIABLES DEL MODULO */

$nombre_modulo = 'Categorias Departamentos';

$nombre_tabla = 'Productos_Categorias_Departamentos';

$primary_key = 'ID_Categoria_Departamento';

$prefix_tpl = 'productos_categorias_dto';


$imagenes[] = NULL;
				
					
/* FIN VARIABLES DEL MODULO */
	
if($do == 'ajax'){
	echo Misc::classicAjaxUpdate($nombre_tabla, 'Online', (int)($_GET["status"]), $primary_key , (int)($_GET["id"]));
	exit;
}

if($do == 'delete'){

$catidad_facturas = $db->getAll("SELECT COUNT(ID_Categoria_Departamento) as Cant_Cat FROM Productos WHERE ID_Categoria_Departamento = ". $_GET['id']);

	if($catidad_facturas[0]['Cant_Cat'] == 0){
		Misc::control('borrar');
		Misc::classicDelete($nombre_tabla, $primary_key, $_GET['id']);
	}else{
		$smarty->assign('mensaje_notificacion_evento',' No se puede borrar la categoria porque tiene productos. Si desea Borrar la categoria y todos sus productos haga click <a href="?do=borrar_categoria
		&id_categoria='.$_GET['id'].'" >Aqui</a>.');
		$do = '';
	}
	
}

switch($do) {
	case 'form': // automaticamente se crea $tipo_form y asigna $indice en smarty
		Misc::control($tipo_form);
		if (!empty($_POST)) {			
			if ((int)($_POST['indice']) > 0) {
				$query = "UPDATE $nombre_tabla SET 								


						Categoria_Departamento = ". Misc::post('categoria') .",
						Online = ". Misc::post('online', 'int') ."
						WHERE $primary_key = ". Misc::post('indice', 'int'); 						
			}else{
				$query = "INSERT INTO $nombre_tabla (Categoria_Departamento,Online) VALUES (
						
						". Misc::post('categoria') .",
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
	case 'borrar_categoria':
		Misc::control('listar');
		$borrar_producto = "DELETE FROM Productos WHERE ID_Categoria_Departamento = " . $_GET['id_categoria'];	
		$db->execute($borrar_producto);
		$borra_cat = "DELETE FROM Productos_Categorias_Departamentos WHERE ID_Categoria_Departamento = " . $_GET['id_categoria'];	
		$db->execute($borra_cat);
		header("location: index.php");
		exit;
	break;
	
	
	case "orden":
		Misc::control('listar');
		$titulo = "Ordenar Categorias";
		$consulta_orden = "SELECT * FROM ". $nombre_tabla . " ORDER BY Orden";
		$campo_orden = "Orden";
		$campo_mostrar = "Categoria_Departamento";

		break;
	//LISTAR
	default:
		Misc::control('listar');
		
		$consulta_listado = "SELECT * FROM ". $nombre_tabla;
		$columnas_listado = array('Categoria_Departamento');
		$campos_listado = array('Categoria_Departamento');
		$campos_busqueda = array('Categoria_Departamento');
	
		$ajax_params["enabled"] = true;
		$ajax_params["nombre_columna"] = "Online/Offline";
		$ajax_params["nombre_campo"] = "Online";
		$export_data['xls'] = false;
		/* CAMBIAR SOLO SI EL EXCEL ES DIFERENTE AL LISTADO
		$export_data['consulta_listado'] = "SELECT * FROM ". $nombre_tabla;
		$export_data['columnas_listado'] = array('Nombre', 'Apellido');
		$export_data['campos_listado'] = array('Nombre', 'Apellido');
		*/
		$ordenar["grupo"] = true;
		$ordenar["texto_grupo"] = "Ordenar Categorias";
		$ordenar["items"] = false;
		$ordenar["texto_items"] = "";
		$ordenar["link_items"] = "";
		$ordenar["campo_items"] = "";
		
		$orderby = 'Orden';
		$ordertype = 'ASC';
		
		
		$filtro_buscador[] = array(
								'label' => 'Estado',
								'query' => '',
								'data' => array(
												array('id' => '1', 'value' => 'Online'),
												array('id' => '0', 'value' => 'Offline')
												),
								'id' => 'id',
								'value' => 'value',
								'query_field' => 'Online'
								);
								

}

Misc::modulo_end();
?>
