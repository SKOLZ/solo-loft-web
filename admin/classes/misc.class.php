<?php

class Misc{
	// Analoga a implode pero para arrays multidimensionales
	public static function multi_implode($glue, $pieces){
		$string='';
	
		if(is_array($pieces)){
			reset($pieces);
			while(list($key,$value)=each($pieces)){
				$string.=$glue.self::multi_implode($glue, $value);
			}
		}else{
			return $pieces;
		}
	
		return trim($string, $glue);
	}
	/*
		Devuelve la string con todos los parametros pasados por get. 
		$valores puede ser un array multidimensional de llaves y valores a agregar a la querystring actual
		si es null se devuelve la querystring actual
		Si la llave ya existia en la querystring se actualiza el valor
	*/
	public static function getQuerystring($valores = NULL){
		$querystring = "";
		if(count($_GET) > 0){
			$i=0;
			foreach($_GET as $llave => $valor){
				$separador = ($i == 0) ? "?" : "&" ;

				if(is_array($valor)){ // para el fucking buscador avanzado
					foreach($valor as $llaveArray => $valorArray){					
						if(count($valores) > 0){
							foreach($valores as $llavenueva => $valornuevo){
								if($llavenueva == $llave){
									if($valornuevo == ''){
										$valorArray = 'REMOVE';
									}else{
										$valorArray = $valornuevo;
									}
								}
							}
						}
						if($valorArray != 'REMOVE'){
							$querystring .= $separador . $llave ."[". $llaveArray."]" . "=" . $valorArray;
							$i++;
							$separador = ($i == 0) ? "?" : "&" ;
						}
					}
				}else{
					if(count($valores) > 0){
						foreach($valores as $llavenueva => $valornuevo){
							if($llavenueva == $llave){
								if($valornuevo == ''){
									$valor = 'REMOVE';
								}else{
									$valor = $valornuevo;
								}
							}
						}
					}
					if($valor != 'REMOVE'){
						$querystring .= $separador . $llave . "=" . $valor;
						$i++;
						$separador = ($i == 0) ? "?" : "&" ;
					}
				}
			}
		}

		if(!isset($separador) || $separador == ""){
			$separador = "?";
		}
		$i=0;
		if(count($valores) > 0){
			foreach($valores as $llave => $valor){
				$separador = ($i == 0) ? $separador : "&" ;
				$existe = false;
				if(count($_GET) > 0){
					foreach($_GET as $llave2 => $valor2){
						if($llave == $llave2){
							$existe = true;
						}
					}
				}
				if(!$existe && $valor != ''){
					$querystring .= $separador . $llave . "=" . $valor;
				}	
				$i++;
			}
		}
		if($querystring == ''){
			return '?';
		}else{
			return $querystring;
		}
	}
	
	public static function file_upload($archivo, $nuevoNombre=NULL, $carpeta_destino){
		if(!file_exists($carpeta_destino)){
			mkdir($carpeta_destino, 777);
			if(!file_exists($carpeta_destino)){
				echo "<pre>No se pudo crear la carpeta destino</pre>";
				return false;
			}
		}
		
		$ext = explode(".", $archivo["name"]);
		$ext = strtolower(array_pop($ext));
		
		$file = isset($nuevoNombre) ? $nuevoNombre .".".$ext : $archivo["name"];
		if(move_uploaded_file($archivo["tmp_name"], $carpeta_destino  . "/". $file)){
			@chmod($carpeta_destino . "/" . $file, 0744);
			return $file;
		}else{
			return false;
		}
	}
	
	public static function get_ext($name) {
		$ext = explode(".", $name);
		$ext = array_pop($ext);
		return $ext;
	}
	
	public static function is_image($file){
		/* 	Se modifico la funcion original, ya que Internet Explorer interpreta
		 	el MIME type "image/jpeg" como "image/pjpeg". No se sabe por qu�, pero
		 	lo hace. As� que se busca que el type del archivo subido tenga la cadena 
		 	'image'
		*/
		if(substr($file['type'], 0, 5) == 'image'){
			return true;
		}else{
			return false;
		}
	}
	
	
	/*
		Devuelve la cantidad de items por pagina, lo calcula viendo si el usuario tiene una cookie seteada
		sino devuelve el valor por default de configuracion.php
	*/
	public static function obtenerItemsXPagina(){
		if(isset($_COOKIE['itemsxpagina']) && $_COOKIE['itemsxpagina'] > 0){
			return $_COOKIE['itemsxpagina'];
		}else{
			return DEFAULT_ITEMS_X_PAGINA;
		}
	}
	
	public static function setearItemsXPagina($valor){
		setcookie("itemsxpagina", $valor, time() + 31536000); 
	}
	
	public static function obtenerOpcionesItemsXPag($smarty){
		$opciones = array(10, 25, 50, 100, 200);
		$smarty->assign('opciones_itemsxpag', $opciones);
		$smarty->assign('items_x_pagina', Misc::obtenerItemsXPagina()); 
	}
	
	public static function orderby($sql, $campo, $tipo) {
		$sql = trim($sql);
		$pos_orden = stripos($sql, 'order');
		if($pos_orden > 0){
			$sql = substr($sql, 0, $pos_orden);
		}
		$sql .= " ORDER BY ". $campo . " ". $tipo;
		return $sql;
	}
	
	public static function parseWhere($query, $search, $arr_busqueda){
		global $db;
		$where = stripos($query, 'where');
		$group = stripos($query, 'group');
		
		if($where > 0){ // ya tiene una clausula where
			$prefix = ' AND ';
		}else{
			$prefix = ' WHERE ';
		}
		
	
		$string_busqueda = "";
		if(count($arr_busqueda) > 0){
			if(trim($search) != ''){
				$w=0;
				foreach($arr_busqueda as $busqueda){
					$prefijo = ($w==0) ? $prefix ."(" : " OR ";
					$string_busqueda .= $prefijo . $busqueda ." LIKE ". $db->qstr('%'.trim($search).'%');
					$w++;
					$prefix = ' AND ';
				}
				$string_busqueda .= ") ";
			}
			
			if(isset($_GET['buscar']) && is_array($_GET['buscar']) && count($_GET['buscar']) > 0){
				$g=0;
				foreach($_GET['buscar'] as $field => $value){
					if($value != ''){
						$prefix = ($g > 0) ? ' AND ' : $prefix;
						$g++;
						$string_busqueda .= $prefix . ' ' . $field .' = '.  $db->qstr($value);
					}
				}
			}	
			
			if(isset($_GET['buscar_fechas']) && is_array($_GET['buscar_fechas']) && count($_GET['buscar_fechas']) > 0){
				$g=0;
				foreach($_GET['buscar_fechas'] as $field => $value){
					if($value['desde'] != '' && $value['hasta'] != ''){
						$realdesde = explode("/", $value['desde']);
						$realdesde = $realdesde[2] ."-". $realdesde[1] ."-".$realdesde[0];
						
						$realhasta = explode("/", $value['hasta']);
						$realhasta = $realhasta[2] ."-". $realhasta[1] ."-".$realhasta[0];
						
						
						$prefix = ($g > 0) ? ' AND ' : $prefix;
						$g++;
						$string_busqueda .= $prefix . ' ' . $field .' BETWEEN '.  $db->qstr($realdesde) .' AND ' .  $db->qstr($realhasta);
					}
				}
			}	
		}else{ // No hay campos de busqueda definidos (NO TENDRIA QUE MOSTRAR EL BUSCADOR)
			return $query;
		}		
		
		$fake = $prefix ." 1 = 1 ";
		if($group > 0){ // Contiene la clausula GROUP BY, lo agrego antes
			$query = substr_replace($query, $string_busqueda, $group -1, 0);
		}else{ // Hago append
			$query .= $string_busqueda;
		}
		
		return $query;
	}
	
	public static function ordenarItems($smarty, $titulo, $consulta_orden, $campo_orden, $campo_mostrar, $ordenar_imagenes = false, $nombre_tabla_imagenes = '', $primary_key_imagenes = '', $ruta_imagenes = '', $ext_imagen = '', $suffix_imagen = ''){
		global $db, $nombre_tabla, $primary_key;
		$items = $db->getAll($consulta_orden);

		$smarty->assign('items', $items);
		$smarty->assign('ordenar_imagenes', $ordenar_imagenes);
		if($ordenar_imagenes){
			$smarty->assign('ext_imagen', $ext_imagen);
			$smarty->assign('suffix_imagen', $suffix_imagen);
			$smarty->assign('ruta_imagenes', $ruta_imagenes);
			$smarty->assign('campo_mostrar', $campo_mostrar);
			$smarty->assign('nombre_tabla', $nombre_tabla_imagenes);
			$smarty->assign('primary_key', $primary_key_imagenes);
		}else{
			$smarty->assign('campo_mostrar', $campo_mostrar);		
			$smarty->assign('nombre_tabla', $nombre_tabla);
			$smarty->assign('primary_key', $primary_key);
		}
		$smarty->assign('campo_orden', $campo_orden);
		
		$smarty->assign('activar_ordenar', true);
		$smarty->assign('form_body', 'ordenar.tpl');		
		global $orden_seteado;
		$orden_seteado = true;
	
	}
	
	
	public static function obtenerListado($smarty, $p=1, $search='', $items_x_pagina=DEFAULT_ITEMS_X_PAGINA, $orderby, $ordertype, $arr_headers, $arr_campos, $sql, $primary_key, $permisos, $export_arr, $arr_campos_busqueda,  $ordenar, $radio_ajax = NULL, $do_listado = 'view') { 
		global $db, $nombre_modulo, $filtro_buscador;
		$p = isset($p) && $p != '' ? $p : 1;			
		
		if($export_arr["xls"] && isset($_GET['export']) && $_GET['export'] == "xls"){		// ESTOY EXPORTANDO A EXCEL
			if(isset($export_arr['columnas_listado']) && is_array($export_arr['columnas_listado']) && count($export_arr['columnas_listado']) > 0){ // Me fijo si se definieron headers distintos para el excel
				$arr_headers = $export_arr['columnas_listado'];
			}
			
			if(isset($export_arr['campos_listado']) && is_array($export_arr['campos_listado']) && count($export_arr['campos_listado']) > 0){ // me fijo si se definieron campos distintos para el excel
				$arr_campos = $export_arr['campos_listado'];
			}
			
			if(isset($export_arr['consulta_listado']) && $export_arr['consulta_listado'] != ''){
				$sql = $export_arr['consulta_listado'];
			}
		}
		
		
		$total_buscador = count($filtro_buscador);
		for($i=0; $i< $total_buscador; $i++){
			if(isset($filtro_buscador[$i]['query']) && $filtro_buscador[$i]['query'] != ''){
				$res = $db->getAll($filtro_buscador[$i]['query']);
				$filtro_buscador[$i]['data'] = $res;
			}
			
		}

		$smarty->assign('do_listado', $do_listado);
	
		$smarty->assign('filtro_buscador', $filtro_buscador);
		if(isset($_GET['buscar'])){
			$smarty->assign('get_buscar', $_GET['buscar']);
		}
		
		if(isset($_GET['buscar_fechas'])){
			$smarty->assign('get_buscar_fechas', $_GET['buscar_fechas']);
		}
		
		if($ordenar["grupo"]){
			$smarty->assign('ordenar', true);
			$smarty->assign('ordenar_texto', $ordenar["texto_grupo"]);
			$smarty->assign('ordenar_link', Misc::getQuerystring(array('do' => 'orden')));
			
		}
		if (trim($search) != "" || ( isset($_GET['buscar']) && is_array($_GET['buscar']) && count($_GET['buscar']) > 0 ) || ( isset($_GET['buscar_fechas']) && is_array($_GET['buscar_fechas']) && count($_GET['buscar_fechas']) > 0 )) {
			$sql = Misc::parseWhere($sql, $search, $arr_campos_busqueda);			
			$smarty->assign('texto_busqueda', $search);
			$smarty->assign('link_reset_filtro', Misc::getQueryString(array('pagina' => '', 'campo_busqueda' => '', 'buscar' => '', 'buscar_fechas' => '')));
		}	
		
		$rs_count = $db->getAll($sql);
		
		$total_count = count($rs_count);	
		if($permisos["agregar"]){		
			$smarty->assign('link_agregar', Misc::getQuerystring(array('do' => 'form', 'id' => '')));
		}
		
		Misc::obtenerOpcionesItemsXPag($smarty);
		
		if ($total_count) {					
			if (isset($orderby)) {
				$sql = Misc::orderby($sql, $orderby, $ordertype);
			}
			
			if($export_arr["xls"] && isset($_GET['export']) && $_GET['export'] == "xls"){
				$rs = $db->execute($sql);
			}else{
				$rs = $db->selectLimit($sql,$items_x_pagina,(($p * $items_x_pagina) - $items_x_pagina));
			}
			
			$paginador = new Paginador($smarty, $total_count, $p, $items_x_pagina);
			$paginador->mostrar();
				

			$total_arr_headers = count($arr_headers);
			for($i = 0; $i < $total_arr_headers; $i++) {
				$arr_headers_smarty[$i]['nombre'] = $arr_headers[$i];
				$arr_headers_smarty[$i]['link_orden_asc'] = Misc::getQuerystring(array('orderby' => str_replace('F_', ' ' , $arr_campos[$i]), 'ordertype' => 'asc'));
				$arr_headers_smarty[$i]['link_orden_desc'] = Misc::getQuerystring(array('orderby' => str_replace('F_', ' ' , $arr_campos[$i]), 'ordertype' => 'desc'));
			}

			$smarty->assign('arr_headers', $arr_headers_smarty);
			
			
			if(isset($radio_ajax["enabled"]) && $radio_ajax["enabled"]){
				$smarty->assign('radio_ajax', true);
				$smarty->assign('radio_ajax_nombre', $radio_ajax["nombre_columna"]);
				$smarty->assign('radio_ajax_nombre_campo', $radio_ajax["nombre_campo"]);
			}
			
			if(isset($ordenar["items"]) && $ordenar["items"]){
				$smarty->assign('ordenar_items', true);
				$smarty->assign('ordenar_texto_items', $ordenar["texto_items"]);
				$smarty->assign('ordenar_texto_link_items', $ordenar["link_items"]);
				$smarty->assign('ordenar_texto_campo_items', $ordenar["campo_items"]);
				
				if(isset($ordenar["condicion_campo"]) && isset($ordenar["condicion_valor"])){
					$smarty->assign('condicion_campo', $ordenar["condicion_campo"]);
					$smarty->assign('condicion_valor', $ordenar["condicion_valor"]);
				}
			}
			
			
			
			
			if(isset($permisos["editar"]) && $permisos["editar"]){
				$smarty->assign('btn_editar', true);
			}
			if(isset($permisos["borrar"]) && $permisos["borrar"]){
				$smarty->assign('btn_borrar', true);
			}
			
			if($export_arr["xls"]){
				$smarty->assign('link_export_xls', Misc::getQuerystring(array('export' => 'xls')));
			}
			if($export_arr["xls"] && isset($_GET['export']) && $_GET['export'] == "xls"){
				$arr_export = array();
				array_push($arr_export, $arr_headers);
			}
			
			if($export_arr["xls"] && isset($_GET['export']) && $_GET['export'] == "xls"){	
				foreach($rs as $row) {
					$tmp_arr_datos = array();					
					foreach ($arr_campos as $campo) {
						array_push($tmp_arr_datos, $row[$campo]);
					}
					array_push($arr_export, $tmp_arr_datos);			
				}			
			}else{
				$rows = $rs->getArray();
				$smarty->assign('rows', $rows);
				$smarty->assign('arr_campos', $arr_campos);
				$smarty->assign('primary_key', $primary_key);
			}
		} else {
			$smarty->assign('sin_resultados', true);
		}
		if($export_arr["xls"] && isset($_GET['export']) && $_GET['export'] == "xls"){
			$Datos = array('datos_exportados' => $arr_export);
			$file = new Export($nombre_modulo, $Datos, "xls", $nombre_modulo.'_'. date('d_m_Y'));
			$link = $file->display();
		}
		
	}
	public static function obtenerIdModulo($url){
		global $db;
		
		$url = substr($url, strlen(PATH_PREFIX));
		$url = str_replace('index.php', '', $url);
		$url = str_replace('loft/admin/', '', $url);
		
		
		
		if(substr($url, (strlen($url) -1), 1) == '/'){
			$url = substr($url, 0, strlen($url) -1);
		}
		
		$q = "SELECT ID_Modulo FROM " . TABLE_PREFIX . "onas_Modulos WHERE Url = ".$db->qstr(substr($url, 1));

		$rst = $db->getOne($q);
		if($rst == 0){
			return false;
		}else{
			return $rst;
		}
	}
	
	public static function control($accion){
		if(!self::controlarPermisos($accion)){
			header("location: ../../error.php");
			exit;
		}
		return;
	}

	public static function controlarPermisos($accion){
		global $db;
		$id_usuario = $_SESSION['onas']['usuario']['data']['ID_Usuario'];
		$id_modulo = Misc::obtenerIdModulo($_SERVER['PHP_SELF']);
		if(!$id_modulo){
			return false;
		}
		switch(strtolower($accion)){
			case "listar":
				//echo 'no tiene id modulo'; die();
				$id_accion = 1;
				break;
			case "agregar":
				$id_accion = 2;
				break;
			case "editar":
				$id_accion = 4;
				break;
			case "borrar":
				$id_accion = 8;
				break;
			default:
				return false;
		}

		$q  = "SELECT Permisos FROM " . TABLE_PREFIX . "onas_Modulos_Permisos WHERE ID_Usuario = ". $id_usuario ." AND ID_Modulo = ". $id_modulo;
		$rst = $db->getRow($q);
		if(count($rst) == 0){
			return false;
		}else{
			$row = $rst;
			if( ($row["Permisos"] & $id_accion) == $id_accion){
				return true;
			}else{
				return false;
			}	
		}
	}
	
	public static function getDirectoryFiles($path, $match_prefix = false,$match_filter=false){
		if(substr($path, strlen($path-2), 1) != '/'){
			$path .= '/';
		}
		if($match_prefix){
			$prefix_size = strlen($match_prefix);
		}
		
		if ($handle = opendir($path)) {
			$files = array();
			while (false !== ($file = readdir($handle))) {
				if(is_file($path.$file)){
					if($match_prefix){
						if(substr($file, 0, $prefix_size) == $match_prefix){
							array_push($files, $file);
						}
					}elseif(strpos($match_filter,'/')){ //busqueda por expresion regular
						if(preg_match($match_filter,$file)){
							array_push($files, $file);
						}
					}elseif($match_filter){ //busqueda por string
						if(strpos($file,$match_filter)!==false){
							array_push($files, $file);
						}
					}else{
						array_push($files, $file);
					}
				}
			}
			closedir($handle);
			return $files;
		}else{
			return false;
		}
	}
	
	public static function classicAjaxUpdate($tabla, $campo, $status, $primary_key, $id){
		global $db;
		$q = "UPDATE ". $tabla." SET ". $campo." = ". $status ." WHERE ". $primary_key ." = ". $id;
		$res = $db->execute($q);
		if($res){
			echo '$("#notificacion_evento_ajax").html("<div class=\'Mensaje marginT bloque\'><span>El registro fue actualizado con exito</span></div>");';
		}else{
			echo "alert('Ocurrio un error al actualizar el registro')";
		}
	}
	
	public static function classicDelete($nombre_tabla, $primary_key, $id){
		global $db, $do, $smarty;
		$sql = "DELETE FROM $nombre_tabla WHERE $primary_key = " . (int)($id);	
	
		if ($db->execute($sql)) {
			$smarty->assign('mensaje_notificacion_evento', 'El registro fue eliminado con exito');
		} else {
			$smarty->assign('mensaje_notificacion_evento', 'Ocurrio un error, el registro no pudo ser eliminado');
		}
		$do = '';
	}
	
	public static function modulo_init(){
		global $do, $tipo_form, $smarty;
		$smarty->template_dir = '../../templates';
		$smarty->compile_dir = '../../templates_c';
		require_once('../../classes/imagen.class.php');
		if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else if (isset($_POST["do"])) {
			$do = $_POST["do"];
		}else{
			$do = '';
		}
		
		if($do == 'form' || $do == 'view'){
			global $id;
			if((isset($_GET['id']))){
				$tipo_form =  'editar';
				$smarty->assign('indice', $_GET['id']);
				$id = $_GET['id'];
			}else{
				$tipo_form =  'agregar';
				$id = 0;
			}
		}
		
		if($do == 'form'){
			$smarty->assign('activar_edicion', true);
		}
		
	}
	
	public static function modulo_end(){
		global $nombre_modulo, $smarty, $do, $subtitulo_modulo, $prefix_tpl;
		
		if($subtitulo_modulo == ''){
			switch($do){
				case 'form':
					$subtitulo_modulo = 'Alta y edici�n';
				break;
				case 'view':
					$subtitulo_modulo = 'Detalle';
				break;
				case 'orden':
					$subtitulo_modulo = 'Ordenar items';
				break;
				default:
					$subtitulo_modulo = 'Listado';
				break;
			}
		}
		$smarty->assign('nombre_modulo', $nombre_modulo);
		$smarty->assign('subtitulo_modulo', $subtitulo_modulo);
		switch($do){
			case 'form':
				if (empty($_POST)) {
					$smarty->assign('form_body', 'file:../modulos/'.$prefix_tpl.'/form.tpl');		
					$smarty->display('form_base.tpl');
				}
			break;
			case 'view':
				$smarty->assign('form_body', 'file:../modulos/'.$prefix_tpl.'/view.tpl');		
				$smarty->display('form_base.tpl');
			break;
			case 'orden':
				global $smarty, $titulo, $consulta_orden, $campo_orden, $campo_mostrar, $orden_seteado;
				if(!isset($orden_seteado)){ // asi puedo llamar al ordenar con otros parametros
					Misc::ordenarItems($smarty, $titulo, $consulta_orden, $campo_orden, $campo_mostrar);
				}
				$smarty->display('form_base.tpl');
				break;
			case '':
				global $columnas_listado, $campos_listado, $consulta_listado, $primary_key, $permisos, $export_data, $campos_busqueda, $ordenar, $ajax_params, $orderby, $ordertype, $do_listado;
				if(!isset($permisos["agregar"])){
					if(Misc::controlarPermisos('agregar')){ $permisos["agregar"] = true; }
				}
				
				if(!isset($permisos["editar"])){
					if(Misc::controlarPermisos('editar')){ $permisos["editar"] = true; }
				}
				
				if(!isset($permisos["borrar"])){
					if(Misc::controlarPermisos('borrar')){ $permisos["borrar"] = true; }
				}
				
				$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
				$campo_busqueda = isset($_GET['campo_busqueda']) ? $_GET['campo_busqueda'] : '';
				
				if(!isset($orderby) || isset($_GET['orderby'])){
					$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : NULL;
				}
								
				if(!isset($ordertype) || isset($_GET['ordertype'])){
					$ordertype = isset($_GET['ordertype']) ? $_GET['ordertype'] : NULL;
				}
				
				if(isset($do_listado)){
					$do_listado = $do_listado;
				}else{
					$do_listado = 'view';
				}
				
				Misc::obtenerListado($smarty, $pagina, $campo_busqueda, Misc::obtenerItemsXPagina(), $orderby, $ordertype, $columnas_listado, $campos_listado, $consulta_listado, $primary_key, $permisos, $export_data, $campos_busqueda, $ordenar, $ajax_params, $do_listado);		
				$smarty->display('listado.tpl');
			break;
		}
	}
	
	public static function post($nombre, $tipo = 'string'){
		global $db;
		if(!isset($_POST[$nombre])){
			switch($tipo){
				case 'int':
					return 0;
				break;
				case 'float':
					return 0.0;
				break;
				default: // string
					return '';
				break;
			}
		}
		switch($tipo){
			case 'int':
				return (int)($_POST[$nombre]);
			break;
			case 'float':
				$valor = (float)($_POST[$nombre]);
				return str_replace(',', '.', $valor);
			break;
			default: // string
				return $db->qstr($_POST[$nombre]);
			break;
		}
	}
	
	public static function mensajeOK(){
		global $smarty, $nombre_modulo;
		$smarty->assign('nombre_modulo', $nombre_modulo);
		$smarty->assign('subtitulo_modulo', 'Notificaci&oacute;n');
		$smarty->assign('mensaje', 'El proceso se ha completado con �xito.');
		$smarty->assign('mensaje_link' , Misc::getQuerystring(array('do' => '', 'id' => '')));
		$smarty->assign('mensaje_boton', 'Continuar');
		$smarty->display('mensajes.tpl');
		exit;
	}
	
	public static function mensajeError(){
		global $smarty, $nombre_modulo;
		$smarty->assign('nombre_modulo', $nombre_modulo);
		$smarty->assign('subtitulo_modulo', 'Notificaci&oacute;n');
		$smarty->assign('mensaje', 'El proceso no se ha completado. Intente nuevamente.');
		$smarty->assign('mensaje_link' , 'javascript:history.go(-1);');
		$smarty->assign('mensaje_boton', 'Volver');
		$smarty->display('mensajes.tpl');
		exit;
	}
	
	public static function uploadImagenes($imagenes){
		if(!is_array($imagenes)){
			/*if(DEBUG){
				echo "ERROR, EL ARRAY DE IMAGENES ESTA VACIO";
				exit;
			}	*/
			return false;
		}
		
		global $last_id, $smarty, $nombre_modulo, $db;
		$Imagen = new Imagen();
		foreach($imagenes as $imagen){
			
			if(strpos($imagen['nombre_campo_form'],'[]')!==false){
				// Imagenes adicionales
				$nombre_campo_form = str_replace('[]','',$imagen['nombre_campo_form']);
				
				$limite = count($_FILES[$nombre_campo_form]);
				
				for($i=0;$i<$limite;$i++){
					if(isset($_FILES[$nombre_campo_form]['size'][$i])&&$_FILES[$nombre_campo_form]['size'][$i]>0){
						
						$archivo	= $_FILES[$nombre_campo_form]['tmp_name'][$i];
						$ext		= strtolower(array_pop(explode('.',$_FILES[$nombre_campo_form]['name'][$i])));
						
						//Insert de la imagen en la DB
						$consulta = 'INSERT INTO '.$imagen['update_db']['tabla_actualizar'].' ('.$imagen['update_db']['campo_actualizar'].','.$imagen['update_db']['primary_key_name'].')
								VALUES (\''.$ext.'\','.$last_id.')';
						$db->execute($consulta);
						
						$id = $db->Insert_ID();
						
						$path			= $imagen['path'];
						$tipo			= $imagen['tipo_resize'];
						
						$imagen_origen	= $_FILES[$nombre_campo_form]['tmp_name'][$i];
						$nombre_imagen_reemplazado	= str_replace('{LAST_ID_ADICIONAL}',$id,$imagen['nombre_imagen']);
						$imagen_destino				= $path.'/'.$nombre_imagen_reemplazado.'.'.$ext;
						
						
						
						if(!is_dir($path)){
							@mkdir($path,0777,true);
						}
					
						move_uploaded_file($imagen_origen,$imagen_destino);
						$Imagen->fijaImagen($imagen_destino);
						
						foreach ($imagen['dimensiones'] as $dimensiones){
							$nombre_imagen_reemplazado	= str_replace('{LAST_ID_ADICIONAL}',$id,$dimensiones['nombre']);
							$imagen_destino				= $path.'/'.$nombre_imagen_reemplazado;
							$Imagen->thumbnail($imagen_destino,$dimensiones['ancho'],$dimensiones['alto'],array(),$tipo);
							$imagenes = array();
							$imagenes['archivo']		= $nombre_imagen_reemplazado.'.'.$ext;
							$imagenes['path']			= $path;
						}
						
					}
				}
				
			}elseif(isset($_FILES[$imagen['nombre_campo_form']]) && $_FILES[$imagen['nombre_campo_form']]['size'] > 0){
				$imagen['nombre_imagen'] = str_replace('{LAST_ID}', $last_id,  $imagen['nombre_imagen']);
				
				$ext = explode('.', $_FILES[$imagen['nombre_campo_form']]['name']);
				$ext = strtolower(array_pop($ext));
				
				$path			= $imagen['path'];
				$tipo			= $imagen['tipo_resize'];
				
				$imagen_origen	= $_FILES[$imagen['nombre_campo_form']]['tmp_name'];
				$imagen_destino	= $path.'/'.$imagen['nombre_imagen'].'.'.$ext;
				
				if(!is_dir($path)){
					@mkdir($path,0777,true);
				}
				
				move_uploaded_file($imagen_origen,$imagen_destino);
				
				if($tipo=='ancho'){
					foreach ($imagen['dimensiones'] as $dimensiones){
						$Imagen->fijaImagen($imagen_destino);
						
					$nombre_imagen = str_replace('{LAST_ID}', $last_id, $dimensiones['nombre']);
						$Imagen->thumbnail($path.'/'.$nombre_imagen,$dimensiones['ancho'],$dimensiones['alto'],array(),$tipo);
						$imagenes = array();
						$imagenes['archivo']		= $nombre_imagen.'.'.$ext;
						$imagenes['path']			= $path;
					}
				}elseif($tipo=='jcrop'){
					$Imagen->fijaImagen($imagen_destino);
				
					$nombre_imagen = str_replace('{LAST_ID}', $last_id, $imagen['nombre_imagen']);
					$Imagen->thumbnail($path.'/'.$nombre_imagen,($Imagen->ancho>1663)?1663:$Imagen->ancho,($Imagen->ancho>1663)?(1663 * $Imagen->alto / $Imagen->ancho):$Imagen->alto,array(),'auto');
					$imagenes = array();
					$imagenes['archivo']		= $nombre_imagen.'.'.$ext;
					$imagenes['path']			= $path;
					
					$limite = count($imagen['dimensiones']);
					for($i=0;$i<$limite;$i++){
						$imagen['dimensiones'][$i]['nombre'] = str_replace('{LAST_ID}', $last_id, $imagen['dimensiones'][$i]['nombre']);
					}
				
					$imagenes['dimensiones']	= $imagen['dimensiones'];
					$smarty->assign('jcrop',true);
					$smarty->assign('IMAGENES',$imagenes);
					
					$jcrop = true;
				}
				
				$consulta = 'UPDATE '.$imagen['update_db']['tabla_actualizar'].' SET '.$imagen['update_db']['campo_actualizar']."='$ext' WHERE ".$imagen['update_db']['primary_key'].'='.str_replace('{LAST_ID}', $last_id, $imagen['update_db']['primary_key_value']);
				$db->execute($consulta);
				$smarty->assign('indice',$last_id);
			}
		}
		
		if(isset($jcrop)&&$jcrop===true){
			$smarty->assign('form_body', 'jcrop.tpl');
			$smarty->display('form_base.tpl');
			exit();
		}
//		die();
		// Si alguna de las imagenes lleva jcrop hay que cargar el template de jcrop (pero recien aca, asi se terminan de procesar todas las demas imagenes en caso de que la de jcrop no sea la ultima). Si hubo un error tenemos que hacer:
		/*
		$smarty->assign('nombre_modulo', $nombre_modulo);
		$smarty->assign('subtitulo_modulo', 'Notificaci&oacute;n');
		$smarty->assign('mensaje', 'Ocurri&oacute; un error al cargar las imagenes.');
		$smarty->assign('mensaje_link' , 'javascript:history.go(-1);');
		$smarty->assign('mensaje_boton', 'Volver');
		$smarty->display('mensajes.tpl');
		exit;
		*/
		
	}
	
	public static function finalizarJCrop(){
		$Imagen = new Imagen();
		$Imagen->fijaImagen($_POST['path'].'/'.$_POST['archivo']);
		foreach ($_POST['imagen'] as $imagen){
			$Imagen->thumbnail($_POST['path'].'/'.$imagen['nombre'],$imagen['ancho'],$imagen['alto'],array('x'=>$_POST['x'],'y'=>$_POST['y'],'w'=>$_POST['w'],'h'=>$_POST['h']),'jcrop');
		}
		self::mensajeOK();
	}
	
	
		public static function uploadArchivos($archivos){
		if(!is_array($archivos)){
			/*if(DEBUG){
				echo "ERROR, EL ARRAY DE IMAGENES ESTA VACIO";
				exit;
			}	*/
			return false;
		}
		
		global $last_id, $smarty, $nombre_modulo, $db;

		foreach($archivos as $archivo){
			
			if(strpos($archivo['nombre_campo_form'],'[]')!==false){
				// Archivos adicionales
				$nombre_campo_form = str_replace('[]','',$archivo['nombre_campo_form']);
				
				$limite = count($_FILES[$nombre_campo_form]);
				
				for($i=0;$i<$limite;$i++){
					if(isset($_FILES[$nombre_campo_form]['size'][$i])&&$_FILES[$nombre_campo_form]['size'][$i]>0){
						
						$ext			= strtolower(array_pop(explode('.',$_FILES[$nombre_campo_form]['name'][$i])));
						
						//Insert del archivo en la DB
						$consulta = 'INSERT INTO '.$archivo['update_db']['tabla_actualizar'].' ('.$archivo['update_db']['campo_actualizar'].','.$archivo['update_db']['primary_key_name'].')
								VALUES (\''.$ext.'\','.$last_id.')';
						$db->execute($consulta);
						
						$id = $db->Insert_ID();
						
						$path			= $archivo['path'];
						
						
						$nombre_archivo_reemplazado	= str_replace('{LAST_ID_ADICIONAL}',$id,$archivo['nombre_archivo']);
						$archivo_destino	= $path.'/'.$nombre_archivo_reemplazado.'.'.$ext;
						if(!is_dir($path)){
							@mkdir($path,0777,true);
						}
						
						$archivo_origen	= $_FILES[$nombre_campo_form]['tmp_name'][$i];
						move_uploaded_file($archivo_origen,$archivo_destino);
						
					}
				}
				
			}elseif(isset($_FILES[$archivo['nombre_campo_form']]) && $_FILES[$archivo['nombre_campo_form']]['size'] > 0){
				$archivo['nombre_archivo'] = str_replace('{LAST_ID}', $last_id,  $archivo['nombre_archivo']);
				
				$ext = explode('.', $_FILES[$archivo['nombre_campo_form']]['name']);
				$ext = strtolower(array_pop($ext));
				
				$path				= $archivo['path'];
				
				$archivo_origen		= $_FILES[$archivo['nombre_campo_form']]['tmp_name'];
				$archivo_destino	= $path.'/'.$archivo['nombre_archivo'].'.'.$ext;
				
				if(!is_dir($path)){
					@mkdir($path,0777,true);
				}
				
				move_uploaded_file($archivo_origen,$archivo_destino);
				
				$consulta = 'UPDATE '.$archivo['update_db']['tabla_actualizar'].' SET '.$archivo['update_db']['campo_actualizar']."='$ext' WHERE ".$archivo['update_db']['primary_key'].'='.str_replace('{LAST_ID}', $last_id, $archivo['update_db']['primary_key_value']);
				$db->execute($consulta);
				$smarty->assign('indice',$last_id);
			}
		}
	}
		
}

?>
