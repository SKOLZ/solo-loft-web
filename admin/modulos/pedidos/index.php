<?php 
require_once("../../includes/init.php");
Misc::modulo_init();

/*
Si no esta seteada la variable $subtitulo_modulo se setea automaticamente (Alta y edicion, Detalles, Listado)
*/

/* VARIABLES DEL MODULO */

$nombre_modulo = 'Pedidos';

$nombre_tabla = 'Pedidos';

$primary_key = 'ID_Pedido';

$prefix_tpl = 'pedidos';


$imagenes[] = NULL;			

					



if($do == 'delete'){
	Misc::control('borrar');
	Misc::classicDelete($nombre_tabla, $primary_key, $_GET['id']);
}

switch($do) {
	case 'view':
		Misc::control('listar');
		
		if(!empty($_POST)){
			$db->execute("UPDATE Pedidos SET ID_Estado = " . Misc::post('estado', 'int')  . " WHERE " . $primary_key . " = " .($_GET['id']));
			

		
		}
									
	
		$form = $db->getRow("SELECT *, DATE_FORMAT(p.Fecha, '%d/%m/%Y %H:%i:%s') AS F_Fecha_Formato
							 FROM Pedidos p
							 LEFT JOIN Provincias pv ON p.Provincia = pv.Provincia
							 LEFT JOIN Pedidos_Estados e ON  p.ID_Estado = e.ID_Estado
							 WHERE ". $primary_key ." = ". $id);							
							 
		$smarty->assign('form', $form); 
		
		
		$estados = $db->getAll("SELECT * FROM Pedidos_Estados ORDER BY Estado");
		$smarty->assign('estados', $estados);
		
		
		
		$pedidos = $db->getAll("SELECT i.Precio_Unitario,i.Cantidad,pr.Titulo,pr.Descripcion
								FROM Pedidos_Items i
								LEFT JOIN Productos pr ON pr.ID_Producto = i.ID_Producto");
		$smarty->assign('pedidos', $pedidos);
			
		break;
			
	//LISTAR
	default:
		Misc::control('listar');
		
		$consulta_listado = "SELECT *, DATE_FORMAT(p.Fecha, '%d/%m/%Y %H:%i:%s') AS F_Fecha_Formato
							FROM Pedidos p
							LEFT JOIN Pedidos_Estados e ON  p.ID_Estado = e.ID_Estado";
							
							
		$columnas_listado = array('Nombre','Apellido','Email','Fecha','Estado','Monto Total');
		$campos_listado = array('Nombre','Apellido','Email','F_Fecha_Formato','Estado','Monto_Total');
		$campos_busqueda = array('Nombre','Apellido');
	
	
		$export_data['xls'] = true;
		
		
		$export_data['consulta_listado'] = "SELECT *
											FROM Pedidos p
											LEFT JOIN Pedidos_Estados e ON  p.ID_Estado = e.ID_Estado";
		$export_data['columnas_listado'] = array('Nombre','Apellido','Provincia','Localidad','Codigo_Postal','Email',	
												'Forma_Pago','Comentarios','Fecha','Estado','Monto_Total');
		$export_data['campos_listado'] = array('Nombre','Apellido','Provincia','Localidad','Codigo_Postal','Email',
												'Forma_Pago','Comentarios','Fecha','Estado','Monto_Total'); 
	
		$permisos['editar'] = false;
		$permisos['agregar'] = false;
		
		$orderby = 'Fecha';
		$ordertype = 'DESC';
		
		$filtro_buscador[] = array(
								'label' => 'Estado',
								'query' => 'SELECT ID_Estado, Estado FROM Pedidos_Estados ORDER BY Estado',
								'id' => 'ID_Estado',
								'value' => 'Estado',
								'query_field' => 'p.ID_Estado'
								);	
		
		
		$filtro_buscador[] = array(
								'label' => 'Fecha',
								'query_field' => 'p.Fecha',
								'type' => 'date'
								);
								
						
}

Misc::modulo_end();
?>

