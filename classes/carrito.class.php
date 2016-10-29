<?php

class Carrito{
	
	var $db;
	
	function Carrito($db){
		if(!isset($_SESSION['pedido']['items'])){
			$_SESSION['pedido']['items'] = array();
		}
		$this->db = $db;
	}
	
	function agregar($id, $cantidad = 1){
		$producto = $this->db->getRow("SELECT * FROM Productos WHERE ID_Producto = ". (int)($id));
		$producto['Cantidad'] = $cantidad;
		$producto['Monto_x_Cantidad'] = $cantidad * $producto['Precio'];
		$_SESSION['pedido']['items'][$id] = $producto;
		$this->actualizarPrecio();
	}
	
	function quitar($id){
		if($id == 'all'){
			$_SESSION['pedido']['items'] = NULL;
			unset($_SESSION['pedido']['items']);
			$this->actualizarPrecio();
		}else{
			$_SESSION['pedido']['items'][$id] = NULL;
			unset($_SESSION['pedido']['items'][$id]);
			$this->actualizarPrecio();
		}
	}
	
	function actualizarPrecio(){
		$monto_total = 0.0;
		if(isset($_SESSION['pedido']['items'])){
			foreach($_SESSION['pedido']['items'] as $item){
				$monto_total += $item['Precio'] * $item['Cantidad'];
			}
			$_SESSION['pedido']['monto_total'] = $monto_total;
		} 
	}
	
	function finalizar(){
		$res = $this->db->execute("INSERT INTO Pedidos (Nombre, Apellido, Provincia, Localidad, Codigo_Postal, Telefono, Email, Forma_Pago, Comentarios, Fecha, ID_Estado, Monto_Total) VALUES (
							". $this->db->qstr($_POST['nombre']) .",
							". $this->db->qstr($_POST['apellido']) .",
							". $this->db->qstr($_POST['provincia']) .",
							". $this->db->qstr($_POST['localidad']) .",
							". $this->db->qstr($_POST['codigo_postal']) .",
							". $this->db->qstr($_POST['telefono']) .",
							". $this->db->qstr($_POST['email']) .",
							". $this->db->qstr($_POST['forma_pago']) .",
							". $this->db->qstr($_POST['comentarios']) .",
							NOW(), 1, ". str_replace(",", ".",$_SESSION['pedido']['monto_total']) .")");
							
							
		if($res){
			$last_id = $this->db->Insert_ID();
			$this->last_id = $last_id;
			foreach($_SESSION['pedido']['items'] as $producto){
				/*$color = $this->db->getOne("SELECT Nombre FROM Colores WHERE ID_Color = ". (int)($producto['Color']));
				$talle = $this->db->getOne("SELECT Talle FROM Productos_Talles WHERE ID_Talle = ". (int)($producto['Talle']));*/
				
				$res = $this->db->execute("INSERT INTO Pedidos_Items (ID_Pedido, ID_Producto, Precio_Unitario, Cantidad) VALUES (
								". $last_id .",
								". $producto['ID_Producto'] .",
								". str_replace(",", ".", $producto['Precio']) .",
								". (int)($producto['Cantidad']) .")");
				if(!$res){
					return false;
				}
			}
			
			require_once('classes/phpmailer/class.phpmailer.php');
			$mailer = new PHPMailer();
			$mailer->From = MAIL_CONTACTO; // Dirección
			$mailer->FromName = MAIL_CONTACTO_NAME; //nombre con el que llega
			$mailer->isHTML(true); // mensaje tipo html
			$mailer->Subject = 'Nuevo pedido en Web DAGON';
			
			$nombre_provincia = $this->db->getOne("SELECT Provincia FROM Provincias WHERE ID_Provincia = ". (int)($_POST['provincia']));
			
			if($_POST['forma_pago'] == "efectivo"){
				$forma_pago = "Efectivo";
			} else {
				$forma_pago = "Tarjeta de Crédito";
			}
	
			$str_pedido = '<table style="color:#262626; font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; width:600px; font-size:12px;"><tr style="border-bottom: solid 5px #262626; background-color:#262626; color: #00b8d9;font-weight:bold"><td style=" width:80px;">Cantidad</td><td style=" width:400px;">Producto</td><td style=" width:120px;">Precio U.</td></tr>';
			foreach($_SESSION['pedido']['items'] as $producto){
				$str_pedido .= '<tr style="font-style:italic;"><td>'.$producto['Cantidad'].'</td><td>'.$producto['Titulo'].'</td><td>$ '.number_format($producto['Precio']).'</td></tr>';
			}
			$str_pedido .= '</table>';
	
			$email_template = implode("", file('templates/mails/pedido.tpl'));
			$search = array('{NOMBRE}', '{APELLIDO}', '{PROVINCIA}', '{LOCALIDAD}', '{CODIGO_POSTAL}', '{TELEFONO}', '{EMAIL}', '{FORMA_PAGO}', '{COMENTARIOS}', '{PEDIDO}', '{MONTO_TOTAL}', '{SITE_PATH}');
			$replace = array($_POST['nombre'], $_POST['apellido'], $nombre_provincia, $_POST['localidad'], $_POST['codigo_postal'], $_POST['telefono'], $_POST['email'], $forma_pago, $_POST['comentarios'], $str_pedido, number_format($_SESSION['pedido']['monto_total'], 2), SITE_PATH );
			$email_template = str_replace($search, $replace, $email_template);
			$mailer->Body = $email_template;
			
			$mailer->AddAddress($_POST['email'], $_POST['nombre'] .' ' .$_POST['apellido'] );
			$mailer->AddBCC(MAIL_CONTACTO);
			$res = $mailer->Send();
			
			return true;
		}else{
			return false;
		}
	}
	
	function clear(){
		$_SESSION['pedido'] = NULL;
		unset($_SESSION['pedido']);
	}
}
?>