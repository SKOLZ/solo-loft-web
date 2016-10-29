<?php
/*
+-------------------------------------------------------------------+
| CLASE IMAGEN														|
+-------------------------------------------------------------------+
| Proyecto:		MATE - Sistema Administrador de Contenidos			|
| Módulo:		Núcleo del Sistema									|
| Archivo:		clase.imagen.php									|
+-------------------------------------------------------------------+
| Autores:		FEdEX <fedex@urbanoX.net>							|
| Copyright:	2008 Urbano Comp.									|
| Versión:		1.5													|
| Última Rev:	2008-12-19 14:39 (UTC-3)							|
+-------------------------------------------------------------------+
|																	|
| Clase para el tratamiento de imagenes								|
+-------------------------------------------------------------------+
|																	|
| CHANGELOG:														|
| v.1.5 (2008-12-19, FEdEX): se modificó el método thumbnail para	|
| crear vistas previas con los datos enviados desde el cliente		|
| utilizando alguna librería JS como jCrop.							|
|																	|
| v.1.0 (2008-07-28, FEdEX): se modificó el método thumbnail para	|
| corregir un error al redimensionar imagenes con un ancho>alto		|
| que las deformaba													|
+-------------------------------------------------------------------+
*/
class Imagen{
	
	function Imagen(){
		$this->GD_Info();
	}

	/**
	 * Método:		GD_Info
	 * Autor:		FEdEX <fedex@urbanoX.net>
	 * Versión:		1.0
	 * 
	 * Descripción:
	 * 
	 * Obtiene la información sobre la librería GD para saber qué formatos
	 * de imagen se podrán trabajar
	 * 
	 */
	function GD_Info(){
		$GD_info 	= gd_info();
		$GD_error	= false;
		
		if(!$GD_info['GIF Read Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta la lectura de archivos GIF';
			define('IMAGEN_GIF_LECTURA',0);
		}else{
			define('IMAGEN_GIF_LECTURA',1);
		}
		if(!$GD_info['GIF Create Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta la creación de archivos GIF';
			define('IMAGEN_GIF_ESCRITURA',0);
		}else{
			define('IMAGEN_GIF_ESCRITURA',1);
		}
		
		if(!$GD_info['JPG Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta el manejo de archivos JPG';
			define('IMAGEN_JPG',0);
		}else{
			define('IMAGEN_JPG',1);
		}
		if(!$GD_info['PNG Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta el manejo de archivos PNG';
			define('IMAGEN_PNG',0);
		}else{
			define('IMAGEN_PNG',1);
		}
		if(!$GD_info['WBMP Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta el manejo de archivos WBMP';
			define('IMAGEN_WBMP',0);
		}else{
			define('IMAGEN_WBMP',1);
		}
		
		if(!$GD_info['XPM Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta el manejo de archivos XPM';
			define('IMAGEN_XPM',0);
		}else{
			define('IMAGEN_XPM',1);
		}
		if(!$GD_info['XBM Support']){
			$GD_error = 'La versión instalada de la librería GD no soporta el manejo de archivos XBM';
			define('IMAGEN_XBM',0);
		}else{
			define('IMAGEN_XBM',1);
		}
		
		if(!$GD_error){
			return true;
		}else{
			return $GD_error;
		}
	}

	
	// obtener información básica de la imagen para trabajar
	function fijaImagen($archivo_imagen){

		$datos_imagen		= getimagesize($archivo_imagen);
		$this->ancho		= $datos_imagen[0];
		$this->alto			= $datos_imagen[1];
		$this->formato		= $datos_imagen['mime'];
		$this->original 	= $archivo_imagen;
		
		$ext 				= explode('.',$this->original);
		$this->extension	= '.'.strtolower(array_pop($ext));
		/*switch ($this->formato){
			case 'image/jpg':	$this->extension = '.jpg'; break;
			case 'image/jpeg':	$this->extension = '.jpeg'; break;
			case 'image/gif':	$this->extension = '.gif'; break;
			case 'image/png':	$this->extension = '.png'; break;
		}*/
		
	}
	
	private function creaImagenPHP(){
		switch ($this->formato){
			
			case 'image/jpeg':	$this->imagenPHP = imagecreatefromjpeg($this->original);	break;
			case 'image/jpg':	$this->imagenPHP = imagecreatefromjpeg($this->original);	break;
			case 'image/gif':	$this->imagenPHP = imagecreatefromgif($this->original);		break;
			case 'image/png':	$this->imagenPHP = imagecreatefrompng($this->original);		break;
		}
	}
	
	/**
	 * Método:		thumbnail
	 * Autor:		FEdEX <fedex@urbanoX.net>
	 * Versión:		2.0
	 * 
	 * Descripción:
	 * 
	 * Redimensiona una imagen según los parámetros recibidos.
	 * 
	 * Detecta el tipo de imagen (JPG, GIF o PNG) y las guarda en el formato que
	 * corresponda.
	 * 
	 * Parámetro:	$imagen_nueva		string		Ruta al archivo de la imagen nueva. Si ya existe se sobreescribirá
	 * Parámetro:	$ancho				int			Entero que indica el ancho que tendrá la nueva imagen
	 * Parámetro:	$alto				int			Entero que indica el alto que tendrá la nueva imagen
	 * Parámetro:	$coordenadas		array		Coordenadas X,Y de la imagen original
	 * Parámetro:	$formato			string		encuadre: encuadra el centro de la imagen. proporcional= redimensiona proporcionalmente
	 * 
	 * Devuelve:						string		Nombre de la imagen.
	 */
	function thumbnail($imagen_nueva, $ancho, $alto, $coordenadas, $formato='auto'){
		//$imagen_nueva = eregi_replace('.jpeg|.jpg|.png|.gif','',$imagen_nueva);
		
		switch($formato){
			case 'jcrop':
				
				$this->imagenNueva	= imagecreatetruecolor($ancho, $alto);
				/*$ancho = ($this->ancho<$ancho)?$this->ancho:$ancho;
				$alto = ($this->alto<$alto)?$this->alto:$alto;*/
				
				
				$this->creaImagenPHP();

				//imagecopy($this->imagenNueva, $this->imagenPHP, 0, 0, $coordenadas['x'], $coordenadas['y'], $this->ancho, $this->alto);
				imagecopyresampled($this->imagenNueva, $this->imagenPHP, 0, 0, $coordenadas['x'], $coordenadas['y'], $ancho, $alto, $coordenadas['w'], $coordenadas['h']);
				break;
				
			case 'fijo':
				$this->imagenNueva	= imagecreatetruecolor($ancho, $alto);
				$this->creaImagenPHP();
				imagecopyresampled($this->imagenNueva, $this->imagenPHP, 0, 0, 0, 0, $ancho, $alto, $this->ancho, $this->alto);
				break;
				
			case 'ancho':
				$ancho = floor($ancho);
				$ancho = ($ancho>$this->ancho)?$this->ancho:$ancho;
				$alto = $this->alto * $ancho / $this->ancho;
				$this->imagenNueva	= imagecreatetruecolor($ancho, $alto);
				$this->creaImagenPHP();
				imagecopyresampled($this->imagenNueva, $this->imagenPHP, 0, 0, 0, 0, $ancho, $alto, $this->ancho, $this->alto);
				break;
				
			case 'alto':
				$alto = floor($alto);
				$alto = ($alto>$this->alto)?$this->alto:$alto;
				$ancho = $this->ancho * $alto / $this->alto;
				$this->imagenNueva	= imagecreatetruecolor($ancho, $alto);
				$this->creaImagenPHP();
				imagecopyresampled($this->imagenNueva, $this->imagenPHP, 0, 0, 0, 0, $ancho, $alto, $this->ancho, $this->alto);
				break;
				
			case 'auto':
				if($this->alto>$this->ancho){
					$ancho = $this->ancho * $alto / $this->alto;
					$ancho = floor($ancho);
				}elseif($ancho>$alto){
					$alto = $this->alto * $ancho / $this->ancho;
					$alto = floor($alto);
				}
				$this->imagenNueva	= imagecreatetruecolor($ancho, $alto);
				$this->creaImagenPHP();
				imagecopyresampled($this->imagenNueva, $this->imagenPHP, 0, 0, 0, 0, $ancho, $alto, $this->ancho, $this->alto);
				break;
		}
		
		switch($this->formato){
			
			case 'image/jpeg':	$imagen_terminada = imagejpeg($this->imagenNueva,$imagen_nueva.$this->extension,100);	break;
			case 'image/jpg':	$imagen_terminada = imagejpeg($this->imagenNueva,$imagen_nueva.$this->extension,100);	break;
			case 'image/gif':	$imagen_terminada = imagegif($this->imagenNueva,$imagen_nueva.$this->extension);		break;
			case 'image/png':	$imagen_terminada = imagepng($this->imagenNueva,$imagen_nueva.$this->extension);		break;
		}
		
		imagedestroy($this->imagenNueva);
		
		return $imagen_nueva.$this->extension;
	}
}
?>