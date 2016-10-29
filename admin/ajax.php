<?php
require_once("includes/init.php");
require_once("classes/misc.class.php");
require_once("classes/usuarios.class.php");


function checkusername($params){
	if($_GET["user"] == ""){
		echo "document.getElementById('flagUsername').value = '';";
		exit;
	}
	if((int)($_GET["indice"]) > 0){
		$where = " AND ID_Usuario <> ". (int)($_GET["indice"]);
	}else{
		$where = "";
	}
	$q = "SELECT ID_Usuario FROM " . TABLE_PREFIX . "onas_Usuarios WHERE Username LIKE '". mysql_real_escape_string($_GET["user"]) ."'" . $where;

	$rst = mysql_query($q);
	if(mysql_num_rows($rst) == 0){
		echo "document.getElementById('flagUsername').value = '1';";
	}else{
		echo "document.getElementById('flagUsername').value = '';";
		echo "alert('El nombre de usuario ya esta en uso, por favor seleccione otro');";
	}
}

function listausuarios($params){
	global $smarty;
	echo Usuarios::getUsuarios($smarty, $params["tipo"]);
}

function setorden($params, $getparams){
	global $db;
	
	if(!isset( $getparams['nombre_tabla']) || !isset($getparams['campo_orden']) ||!isset($getparams['primary_key'] )){
		echo "alert('Error de configuracion del modulo');";
	}
	
	if(isset($params['tabla_ordenar']) && count($params['tabla_ordenar']) > 0){
		$cont = 1;
		foreach($params['tabla_ordenar'] as $id){
			$db->execute("UPDATE ". $getparams['nombre_tabla'] ." SET ". $getparams['campo_orden'] ." = ". $cont ." WHERE ". $getparams['primary_key'] ." = ". $id);
			if(!$db){
				echo "alert('Ocurrio un error al ordenar los items');";
			}
			$cont++;
		}
		echo "alert('Los items fueron ordenados con exito');";
	}
}

function ping($get){
	echo time();
}

switch($_GET["function"]){
	case "setorden":
		setorden($_POST, $_GET);
	break;
	case "checkusername":
		checkusername($_GET);
	break;
	case "listausuarios":
		listausuarios($_GET);
	break;
	case "ping":
		ping($_GET);
	break;
}

?>
