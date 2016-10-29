<?php 
require_once("../../includes/init.php");
Misc::modulo_init();

/*
Si no esta seteada la variable $subtitulo_modulo se setea automaticamente (Alta y edicion, Detalles, Listado)
*/

/* VARIABLES DEL MODULO */

$nombre_modulo = 'Productos';

$nombre_tabla = 'Productos';

$primary_key = 'ID_Producto';

$prefix_tpl = 'productos';



$imagenes[] = array(
					'nombre_imagen' => '{LAST_ID}_original',
					'nombre_campo_form' => 'imagen_jcrop',
					'path' => '../../../upload/productos',
					'dimensiones' => array(
											
											array('ancho' => 185, 'alto' => 185, 'nombre' => '{LAST_ID}_detalle'),
											array('ancho' => 155, 'alto' => 155, 'nombre' => '{LAST_ID}_th')
								
											
									),
					'tipo_resize' => 'jcrop',
					'update_db' => array(
										'tabla_actualizar' => $nombre_tabla,
										'primary_key' => $primary_key,
										'primary_key_value' => '{LAST_ID}',
										'campo_actualizar' => 'Img_Ext'
									)
					);
					
$imagenes[] = array(
					'nombre_imagen' => '{LAST_ID_ADICIONAL}_original',
					'nombre_campo_form' => 'imagenes_adicionales[]',
					'path' => '../../../upload/productos/adicionales',
					'dimensiones' => array(
											array('ancho' => 1663, 'alto' => 752, 'nombre' => '{LAST_ID_ADICIONAL}_detalle')
											
					
									),
					'tipo_resize' => 'ancho',
					'update_db' => array(
										'tabla_actualizar' => 'Productos_Imagenes_Adicionales',
										'primary_key_name' => $primary_key,
										'primary_key_value' => '{LAST_ID}',
										'campo_actualizar' => 'Img_Ext'
									)
					);

					
/* FIN VARIABLES DEL MODULO */

if($do == 'eliminarimagenadicional'){
	$res = $db->execute("DELETE FROM Productos_Imagenes_Adicionales WHERE ID_Imagen_Adicional = ". (int)($_GET['id']));
	if($res){
		echo 'ok';
	}else{
		echo 'ko';
	}
	exit;
}

	
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
				
				/* si es complejo */
				if (($_POST['id_categoria']) == 1 || ($_POST['id_categoria']) == 3 || ($_POST['id_categoria']) == 6) {
					$query = "UPDATE $nombre_tabla SET 								
						ID_Categoria = ". Misc::post('id_categoria', 'int') .", 
						Titulo = ". Misc::post('titulo') .",	
						Encabezado = ". Misc::post('encabezado') .",	
						Descripcion = ". Misc::post('descripcion') .",
						Ubicacion = ". Misc::post('ubicacion') .",
						Servicios = ". Misc::post('servicios') .",
						Superficie_total = ". Misc::post('superficie_total') .",
						Altura_pisos = ". Misc::post('altura_pisos') .",
						Cantidad_unidades = ". Misc::post('cantidad_unidades') .",
						Cocheras = ". Misc::post('cantidad_cocheras') .",
						Etapa_construccion = ". Misc::post('etapa_construccion') .",
						Destacado = ". Misc::post('destacado', 'int') .",
						Home = ". Misc::post('home', 'int') .",
						Online = ". Misc::post('online', 'int') ." 
						WHERE $primary_key = ". Misc::post('indice', 'int'); 
						
				/* si es departamento */
				} elseif(($_POST['id_categoria']) == 2 || ($_POST['id_categoria']) == 4 || ($_POST['id_categoria']) == 5 || ($_POST['id_categoria']) == 7 || ($_POST['id_categoria']) == 8){
					$query = "UPDATE $nombre_tabla SET 		
						ID_Categoria = ". Misc::post('id_categoria', 'int') .", 
						ID_Categoria_Departamento = ". Misc::post('id_categoria_dto', 'int') .", 
						ID_Perteneciente = ". Misc::post('id_perteneciente', 'int') .", 
						Titulo = ". Misc::post('titulo') .",	
						Encabezado = ". Misc::post('encabezado') .",	
						Descripcion = ". Misc::post('descripcion') .",
						Cantidad_ambientes = ". Misc::post('cantidad_ambientes') .",
						Superficie_dto = ". Misc::post('superficie_dto') .",
						Apto_profesional = ". Misc::post('apto_profesional', 'int') .",
						Servicios_dto = ". Misc::post('servicios_dto') .",
						Expensas = ". Misc::post('expensas') .",
						Otros_datos = ". Misc::post('otros_datos') .",
						Destacado = ". Misc::post('destacado', 'int') .",
						Home = ". Misc::post('home', 'int') .",
						Online = ". Misc::post('online', 'int') ." 
						WHERE $primary_key = ". Misc::post('indice', 'int'); 
				}
			}else{
				/* si es complejo */
				if (($_POST['id_categoria']) == 1 || ($_POST['id_categoria']) == 3 || ($_POST['id_categoria']) == 6) {
					
				 	$query = "INSERT INTO $nombre_tabla (ID_Categoria, Titulo, Encabezado, Descripcion, Ubicacion, Servicios, Superficie_total, Altura_pisos, Cantidad_unidades, Cocheras, Etapa_construccion, Destacado, Home, Online) VALUES (
						". Misc::post('id_categoria', 'int')  .", 
						". Misc::post('titulo') .",
						". Misc::post('encabezado') .",
						". Misc::post('descripcion') .",
						". Misc::post('ubicacion') .",
						". Misc::post('servicios') .",
						". Misc::post('superficie_total') .",
						". Misc::post('altura_pisos') .",
						". Misc::post('cantidad_unidades') .",
						". Misc::post('cantidad_cocheras') .",
						". Misc::post('etapa_construccion') .",
						". Misc::post('destacado', 'int') .",
						". Misc::post('home', 'int') .", 
						". Misc::post('online', 'int') .")"; 
						
				/* si es departamento */
				} elseif(($_POST['id_categoria']) == 2 || ($_POST['id_categoria']) == 4 || ($_POST['id_categoria']) == 5 || ($_POST['id_categoria']) == 7 || ($_POST['id_categoria']) == 8){
					
					$query = "INSERT INTO $nombre_tabla (ID_Categoria, ID_Categoria_Departamento, ID_Perteneciente, Titulo, Encabezado, Descripcion, Cantidad_ambientes, Superficie_dto, Apto_profesional, Servicios_dto, Expensas, Otros_datos, Destacado, Home, Online) VALUES (
						". Misc::post('id_categoria', 'int')  .",  
						". Misc::post('id_categoria_dto', 'int')  .",
						". Misc::post('id_perteneciente', 'int')  .",  
						". Misc::post('titulo') .",
						". Misc::post('encabezado') .",
						". Misc::post('descripcion') .",
						". Misc::post('cantidad_ambientes') .",
						". Misc::post('superficie_dto') .",
						". Misc::post('apto_profesional', 'int') .",
						". Misc::post('servicios_dto') .",
						". Misc::post('expensas') .",
						". Misc::post('otros_datos') .",
						". Misc::post('destacado', 'int') .",
						". Misc::post('home', 'int') .", 
						". Misc::post('online', 'int') .")"; 
				}
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
				
				$imagenes_adicionales = $db->getAll("SELECT * FROM Productos_Imagenes_Adicionales WHERE ID_Producto = ". $id);
				$smarty->assign('imagenes_adicionales', $imagenes_adicionales);	
			} 
			
			$categorias = $db->getAll("SELECT * FROM Productos_Categorias ORDER BY Categoria");
			$smarty->assign('categorias', $categorias);
			
			$categorias_dto = $db->getAll("SELECT * FROM Productos_Categorias_Departamentos ORDER BY Categoria_Departamento");
			$smarty->assign('categorias_dto', $categorias_dto);
			
			$complejos = $db->getAll("SELECT * FROM Productos WHERE ID_Categoria = 1 ORDER BY Titulo");
			$smarty->assign('complejos', $complejos);
		}
		break;
	case 'jcrop':
		Misc::finalizarJCrop();
	break;
	case 'view':
		Misc::control('listar');
		$form = $db->getRow("SELECT *,p.Online
							FROM Productos p
							LEFT JOIN Productos_Categorias c ON c.ID_Categoria = p.ID_Categoria
							LEFT JOIN Productos_Categorias_Departamentos d ON d.ID_Categoria_Departamento = p.ID_Categoria_Departamento
							WHERE ". $primary_key ." = ". $id);
		$smarty->assign('form', $form);
		
		 
		$imagenes_adicionales = $db->getAll("SELECT * FROM Productos_Imagenes_Adicionales WHERE ID_Producto = ". $id);
		$smarty->assign('imagenes_adicionales', $imagenes_adicionales);
		$complejos = $db->getAll("SELECT * FROM Productos WHERE ID_Categoria = 1 ORDER BY Titulo");
		$smarty->assign('complejos', $complejos);
		
		break;
	case "orden":
		Misc::control('listar');

		$titulo = "Ordenar productos";
		$consulta_orden = "SELECT * FROM ". $nombre_tabla . " ORDER BY ID_Producto";
		$campo_orden = "Orden";
		$campo_mostrar = "Nombre";

		break;
	//LISTAR
	default:
		Misc::control('listar');
		
		// Borro los productos relacionados de la sesion por si hizo click en el boton volver
		$_SESSION['relacionados'] = NULL;
		unset($_SESSION['relacionados']);
		
		$consulta_listado = "SELECT *,p.Online
							FROM Productos p
							LEFT JOIN Productos_Categorias c ON c.ID_Categoria = p.ID_Categoria";
		$columnas_listado = array('Titulo','Categoria');
		$campos_listado = array('Titulo','Categoria');
		$campos_busqueda = array('Titulo');
	
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
		
		
		$filtro_buscador[] = array(
								'label' => 'Categorias',
								'query' => 'SELECT ID_Categoria, Categoria FROM Productos_Categorias ORDER BY Orden',
								'id' => 'ID_Categoria',
								'value' => 'Categoria',
								'query_field' => 'p.ID_Categoria'
								);					
		
	
								
		$filtro_buscador[] = array(
								'label' => 'Estado',
								'query' => '',
								'data' => array(
												array('id' => '1', 'value' => 'Online'),
												array('id' => '0', 'value' => 'Offline')
												),
								'id' => 'id',
								'value' => 'value',
								'query_field' => 'p.Online'
								);
		
}

Misc::modulo_end();
?>
