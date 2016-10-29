<?
	class Modulos {				
		
		//esta funcion interpreta la informacion de la base de datos para generar el
		//arbol en forma de bloques jerarquicos <ul><li> y el formulario auxilar form
		//que utilizan las funciones JS de identacion
		function getHTMLArbolModulos() {	
			global $db;
			$SQLQry = "SELECT m.ID_Modulo, m.ID_Padre, m.Texto, m.Nested, m.Url, m.Modulo_Custom "
				. "FROM " . TABLE_PREFIX . "onas_Modulos m ORDER BY Orden";
			$rst = $db->getAll($SQLQry);
			
			
			$botonera = '<table id="sortable_list" style="cursor: move; color: #000000">';
			$formulario = '<form id="indentacion" action="#">';
			
			$i=0;
			foreach($rst as $row){
				
				$i++;
				$botonera .= '<tr id="' . $row['ID_Modulo'] . '"><td id="li_' . $row['ID_Modulo'] . '" class="liorden" style="padding-left: '
					.  ($row['Nested'] * 40) . 'px">';
				$botonera .= '<input type="button" onclick="indentar(\'li_' . $row['ID_Modulo'] 
					. '\', false);" value="<" /> ' . stripslashes($row['Texto']) 
					. ' <input type="button" onclick="indentar(\'li_' . $row['ID_Modulo'] 
					. '\', true);" value=">" />';
				$botonera .= "</td></tr>\n";
				$formulario .= '<input type="hidden" id="indent_li_' . $row['ID_Modulo'] 
					. '" name="indent_li_' . $row['ID_Modulo'] 
					. '" value="' . $row['Nested'] . '" />'
					. "\n";
		
			}
		
			return $botonera . "</table>\n" . $formulario . '</form>';
			
		}
		
		function procesarSecuenciaReajusteArbolModulos() {
			global $db;
			//convierto las variables POST en arrays convenientes
			$secuence = explode("&sortable_list[]=", "&" . $_POST["secuenceData"]);
			$identationAux = explode("&indent_li_", "&" . $_POST["identationData"]);
			//por construccion los 1ros 2 valores no tiene datos utiles
			unset($secuence[0]);
			unset($identationAux[0]);
			//combinando informacion de orden e identacion armo la matriz de identacion definitiva
			$identation = array();
			foreach($identationAux as $identVal) {
				$keyVal = explode("=", $identVal);
				$identation[$keyVal[0]] = $keyVal[1];
			}
			
			//recorro los arrays y los reinterpreto para generar las consultas de update requeridas
			$idPadres = array();
			$identationActual = -1;
			$orden = 0;
			foreach($secuence as $elemSecuence) {
				$orden++;
				if ($identation[$elemSecuence]  != $identationActual) {
					$identationActual = $identation[$elemSecuence];
				}
				$idPadres[$identationActual] = $elemSecuence;
				if (isset($idPadres[$identationActual-1])) {
					$idPadreToSet = $idPadres[$identationActual-1];
				} else {
					$idPadreToSet = 0;
				}
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos SET ID_padre = " . $idPadreToSet . ", Nested = " 
					. $identationActual . ", Orden = " . $orden . " WHERE ID_Modulo = " . $elemSecuence . ";";
				
				//echo $SQLQry ;
				$res = $db->execute($SQLCmd);
				if (!$res) die("FALLO el comando: " . $SQLCmd);
			}
			
		}
		
		function saveProfile($tpl, $data, $id=NULL) {
			global $db;
			$debug = false;
			
			if (!is_numeric($id) && !isset($id)) $id = 0;
			
			if ($debug) echo "ID: " . $id . "<br />";
			if ($debug) echo "<pre>" . var_export($data, true) . "</pre>";
			
			//si no es un nuevo nodo
			if ($id > 0) {
			
				//restriccion: 
				//	un nodo no puede ser su propio padre
				//		nota: se mostraba con una marca (x) en el combo
				//	un nodo no puede ser tener como padre un descendiente
				//		nota: esto requeria mas analisis para una exposicion visual
				
				$SQLQry = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE ID_Modulo = " . $id;
				$rcModulo = $db->getRow($SQLQry);
				
				
				$ordenMin = $rcModulo["Orden"];
				
				$SQLQry = "SELECT Orden FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE Orden > " . $rcModulo["Orden"] 
					. " AND Nested <= " . $rcModulo["Nested"] . " ORDER BY Orden";
				$rcModulo = $db->getRow($SQLQry);
								
				if (count($rcModulo) == 0) {
					$ordenMax = 10000;
				} else {
					$ordenMax = $rcModulo["Orden"];
				}
				
				$SQLQry = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE ID_Modulo = " . $data["id_padre"] . "";
				$rcModulo = $db->getRow($SQLQry);
				
				
				if (isset ($rcModulo["Orden"]) && ($rcModulo["Orden"] >= $ordenMin) && ($rcModulo["Orden"] < $ordenMax)) {
					return false;
				}
				
			}
		
			
			//hago un update de los valores del modulo o lo defino
			//(valores no ligados a su hubicacion en la jerarquia)
			if ($id > 0) {
				
				$esUpdate = true;
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos SET "
					. "	ID_Padre = " . (int)($data['id_padre']) .  ", "
					. "	Texto = ".$db->qstr($data['texto']).", "
					. "	Url = ".$db->qstr($data['url']).", "
					. " ID_Tipo = " . (int)($data['id_tipo'])  .  ", "
					. "	Modulo_Custom = " .  (int)($data['custom'])			
					. " WHERE ID_Modulo = " . (int)($id); 				
				if (!$db->execute($SQLCmd)) return false;	
				
				$last = (int)($id);		
			
			} else {
				
				$esUpdate = false;
				
				// REVISAR ESTA PARTE CON EL MAIL DE SEBAS
				$SQLCmd = "INSERT INTO " . TABLE_PREFIX . "onas_Modulos ("
					. "ID_Padre, Texto, Url, Orden, nested, ID_Tipo, Modulo_Custom"
					. ") VALUES ("
					. (int)($data['id_padre']) .  ", "
					. $db->qstr($data['texto']).", "
					. $db->qstr($data['url']).", "
					. "10000, 0, "
					. (int)($data['id_tipo'])  .  ", "
					. (int)($data['custom']) . ")";	
					
					
				// OBTIENE EL ULTIMO ID INSERTADO EN MS SQL SERVER
				// Para compatibilidad con MSSQL (revisar)
				//$sql	= "SET NOCOUNT ON ". $SQLCmd ." SELECT @@IDENTITY AS nuevoId";
				//$last= $id		= $db->getOne($sql);
				
				$sql = $SQLCmd;
				$db->execute($sql);
				$last = $id		= $db->insert_ID();
					
				if ($debug) echo $SQLCmd . "<hr/>";
				

				$rango = 1;
			}

			//
			
			//obtengo el modulo en cuestion
			$SQLQry = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos "
				. "WHERE ID_Modulo = " . $id;
			$res = $db->getRow($SQLQry);
			$rcModulo = $res;
			
			//
			
			if ($esUpdate) {
				
				//Solo si se trata de un Update analizamos si tiene
				//hijos (=> un intervalo de  orden que debe ser desplazado)
				$SQLQry = "SELECT COUNT(ID_Modulo) AS cantHijos FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE ID_Padre = " . $id;
				if ($debug) echo $SQLQry . "<hr />";
				$res = $db->getRow($SQLQry);
				$rc = $res;
				
				if ($rc["cantHijos"] == 0) {
					
					$rango = 1;
					
				} else {
					
					//determino el rango del bloque a mover obteniendo el orden
					//del siguiente elemento de igual o menor nested
					
					$SQLQry = "SELECT Orden FROM " . TABLE_PREFIX . "onas_Modulos "
						. "WHERE Orden > " . $rcModulo["Orden"] 
						. " AND Nested <= " . $rcModulo["Nested"] . " ORDER BY Orden ";
					if ($debug) echo $SQLQry . "<hr />";
					$res = $db->getRow($SQLQry);
					
					if (count($res) == 0) {
						$SQLQry = "SELECT Orden FROM " . TABLE_PREFIX . "onas_Modulos ORDER BY Orden DESC ";
						$res = $db->getRow($SQLQry);
						if (count($res) == 0) {
							//no hay items
							$rango = 1;
						} else {
							$rc = $res;
							$rango =  ($rc["Orden"] + 1) - $rcModulo["Orden"];
						}
					}  else {
						$rc = $res;
						$rango =  $rc["Orden"] - $rcModulo["Orden"];
					}

				}

				//ajusto el orden del bloque que se ha de mover
				//utilizandouna posicion segura (10000)
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos SET Orden = (Orden - " 
					. $rcModulo["Orden"] . " + 10000) WHERE Orden >= " . (int)($rcModulo["Orden"])
					. " AND ORDEN < " . ($rcModulo["Orden"] + $rango) . ";";
				if ($debug) echo $SQLCmd . "<hr />";
				$res = $db->execute($SQLCmd);
				
				//ajusta el orden de todos los subsiguientes nodos (el mismo efecto que si el
				//bloque se eliminara de la estructura)
				//de las posicion orden >= 10000
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos SET Orden = Orden - " . (int)($rango) . " WHERE Orden >= " 
					. (int)($rcModulo["Orden"] + $rango) . " AND orden < 10000;";
				if ($debug) echo $SQLCmd . "<hr />";
				$res = $db->execute($SQLCmd);
				
			}
			
			//
			
			//ajusta los datos de la estructura como si se tratase de una insert
			//(si es el caso de un update el bloque anterior se encargo de prepararla)
			if ((int)($data['id_padre']) > 0) {
				
				
				if ($debug) echo "1<br />";
				
				//obtengo la referencia al nodo padre destino para determinar el valor del nested
				$SQLQry = "SELECT Nested FROM " . TABLE_PREFIX . "onas_Modulos WHERE ID_Modulo = " 
					. $data['id_padre'] . " ";
				$res = $db->getRow($SQLQry);
				$rcModuloPadreDestino = $res;	
				
				$despNested = ($rcModuloPadreDestino["Nested"] + 1) - $rcModulo["Nested"];
				
				$SQLQry = "SELECT Nested, Orden FROM " . TABLE_PREFIX . "onas_Modulos WHERE ID_Padre = " 
					. $data['id_padre'] . " AND orden < 10000 ORDER BY Orden";
				
				if ($debug) echo $SQLQry . "<hr />";
				$rs = $db->getRow($SQLQry);
				
				if (count($rs) > 0) {
					
					if ($debug) echo "1.1<br />";
					
					//en este caso hay hermanos, la poscion segura es tomar la del
					//primero y desplazar todo los ordenes desde dicha poscion
					$row = $rs;
					$orden = (int)($row['Orden']);
					$nested = (int)($row['Nested']);
					
				} else {
					
					if ($debug) echo "1.2<br />";
					
					//en este caso no hay 'hermanos', asi que necesito la referencia
					//al padre y desplazar desde los subsiguientes.
					$SQLQry = "SELECT Nested, Orden FROM " . TABLE_PREFIX . "onas_Modulos WHERE ID_Modulo = " 
						. $data['id_padre'];
					$rs = $db->getRow($SQLQry);
					$row = $rs;
					$orden = (int)($row['Orden']) + 1;
					$nested = (int)($row['Nested']) + 1;

				}
				
				$ordenDespRef = $orden - 1;
				
				//hago espacio en la estructura para la nueva
				//hubicacion del bloque de nodos (preservando el area borrador)
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos "
					. "SET Orden = Orden + " . $rango 
					. " WHERE Orden > ". $ordenDespRef . " AND Orden < 10000;";	
				if ($debug) echo $SQLCmd . "<hr />";
				$res = $db->execute($SQLCmd);
				
				//movemos el bloque de la poscion segura a 
				//su locacion definitiva ajustamos el nested
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos "
					. "SET Orden = Orden - 10000 + " . $orden . ", "
					. "Nested = (Nested + (" . $despNested . ")) WHERE Orden >= 10000;";
				if ($debug) echo $SQLCmd . "<hr />";
				$res = $db->execute($SQLCmd);
				
			} else {
			
				if ($debug) echo "2<br />";
				
				//Si un elemnto se define que tiene como padre a la raiz
				//se lo envia a la ultima posicion (y se ajusta su nested = 0).
				//no es necesario desplazar ordenes.
				$SQLQry = "SELECT Orden FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE Orden < 10000 ORDER BY Orden DESC";
				$res = $db->getRow($SQLQry);
				$rc = $res;
				$orden = $rc["Orden"] + 1;
				$nested = 0;
				
				$despNested = - $rcModulo["Nested"];
				
				
				//movemos el bloque de la poscion segura a 
				//su locacion definitiva ajustamos el nested
				$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos "
					. "SET Orden = Orden - 10000 + " . $orden . ", "
					. "Nested = (Nested + (" . $despNested . ")) WHERE Orden >= 10000;";
				if ($debug) echo $SQLCmd . "<hr />";
				$res = $db->execute($SQLCmd);
				
			}
			if(!isset($data['permiso'])){
				$data['permiso'] = null;
			}
			$this->setPermisos($last, $data['permiso']);
			return true;
			
		}
		
		
		function setPermisos($id_modulo, $permisos) {
			global $db;
			$sql = "DELETE FROM " . TABLE_PREFIX . "onas_Modulos_Permisos WHERE ID_Modulo = " . (int)($id_modulo);
			$db->execute($sql);
			if (count($permisos)) {
				foreach ($permisos as $usuario => $permiso) {
					$totalbits = 0;				
					foreach ($permiso as $bit => $on) {					
						$totalbits = $totalbits + $bit;
					}
					if ($totalbits > 0) {
						$sql = "INSERT INTO " . TABLE_PREFIX . "onas_Modulos_Permisos (ID_Usuario, ID_Modulo, Permisos) VALUES (" . (int)($usuario) . ", " . $id_modulo . ", " . $totalbits . ")";
						$db->execute($sql);
					}
				}
			}		
		}
		
		function loadProfile($smarty, $id) {
			global $db;
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'onas_Modulos WHERE ID_Modulo = ' . (int)($id);
			$rs = $db->getRow($sql);
			$modulo=$rs;
			if (count($rs)>0) {
				$this->Tipo_Modulo = $modulo['ID_Tipo'];		
				$smarty->assign('modulo', $modulo);
			}else{
				$this->Tipo_Modulo = 0;
			}
			
						
			//buscamos el bloque (ordenMin ordenMax) que contiene los nodos actual
			//y descendencia para evitar que se defina como padre el mismo nodo o
			//uno descendiente.
			//solo tendra sentido buscar nodos para vedar si es una actualizacion
			//como limites se utilizara en su defecto el area de borrador
			if ($id > 0) {

				$SQLQry = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE ID_Modulo = " . $id ;
				$rcModulo = $db->getRow($SQLQry);
				$ordenMin = $rcModulo["Orden"];
				
				$SQLQry = "SELECT Orden FROM " . TABLE_PREFIX . "onas_Modulos "
					. "WHERE Orden > " . $rcModulo["Orden"] 
					. " AND Nested <= " . $rcModulo["Nested"] . " ORDER BY Orden";
				$rcModulo = $db->getRow($SQLQry);
				
				if (count($rcModulo) == 0) {
					$ordenMax = 10000;
				} else {
					$ordenMax = $rcModulo["Orden"];
				}
				
			} else {
			
				$ordenMin = 10000;
				$ordenMax = 10000;
				
			}

			
			$sql = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos ORDER BY Orden, ID_Tipo, Texto";
			$rs = $db->getAll($sql);			
			$arr_padre_list = array();
			
			if(isset($modulo['ID_Modulo'])){
				$check_selected = true;
			}else{
				$check_selected = false;
			}
			foreach($rs as $opcion) {
				//desabilitamos el nodo en la seleccion de padre si corresponde
				if (($opcion["Orden"] >= $ordenMin) && ($opcion["Orden"] < $ordenMax)) {
					$disabled = ' disabled="disabled"';
				} else {
					$disabled = '';
				}
				
				if($check_selected){
					$selected = ($opcion['ID_Modulo'] == $modulo['ID_Padre']) ? 'selected="selected"' : '';
				}else{
					$selected = '';
				}
				
				$spaces = '';
				for ($i = 1; $i <= $opcion['Nested']; $i++) {
					$spaces .= "&nbsp;&nbsp;";
				}
				
				$arr_padre_list[] = array('ID' => $opcion['ID_Modulo'], 
					'PATH' => $spaces . $opcion['Texto'], 'SELECTED' => $selected, 
					"DISABLED" => $disabled);
			}
			$smarty->assign('padre_list', $arr_padre_list);
			$sql = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos_Tipos";
			$rs = $db->getAll($sql);	
			$arr_tipo_list = array();
			foreach($rs as $opcion) {	
				if($check_selected){
					$selected = ($opcion['ID_Tipo'] == $modulo['ID_Tipo']) ? 'selected="selected"' : '';		
				}else{
					$selected = '';
				}
				$arr_tipo_list[] = array('ID' => $opcion['ID_Tipo'], 
					'PATH' => $opcion['Nombre'], 'SELECTED' => $selected);
			} 
			$smarty->assign('tipo_list', $arr_tipo_list);
			
		}
		
		function view($smarty, $id) {
			global $db;
			$sql = "SELECT p.Texto AS Padre, t.Nombre AS Tipo, t.ID_Tipo, m.Texto, m.Url FROM onas_Modulos	m 
			LEFT JOIN " . TABLE_PREFIX . "onas_Modulos p ON p.ID_Modulo = m.ID_Padre 
			LEFT JOIN " . TABLE_PREFIX . "onas_Modulos_Tipos t ON m.ID_Tipo = t.ID_Tipo 
			WHERE m.ID_Modulo = " . (int)($id);
			
			$rs = $db->getRow($sql);
			
			$modulo = $rs;
			
			$this->Tipo_Modulo = $modulo["ID_Tipo"];
			$smarty->assign('modulo', $modulo);

		}
			
		function delete($id) {
			global $db;
			//si no esta def. la variable o no es numercica no se procesa el metodo
			if ((!isset($id)) || (!is_numeric($id))) return false;
			
			//Esta restriccion evita que se pueda borrar un nodo que tenga descendencia
			//nota: este sera el error mas comun y por ello se detallara como caso mas
			//		probable en la advertencia.
			$sql = "SELECT COUNT(ID_Modulo) AS cantHijos "
				. "FROM " . TABLE_PREFIX . "onas_Modulos WHERE ID_Padre = " . (int)($id);
			$rs = $db->getRow($sql);
			$rc = $rs;
			
			if ($rc["cantHijos"] > 0) return false;
			
			$SQLQry = "SELECT Orden FROM " . TABLE_PREFIX . "onas_Modulos "
				. "WHERE ID_Modulo = " . $id;
			$res = $db->getOne($SQLQry);
			$rcModuloABorrar = $res;
			
			//ajusta el orden de todos los subsiguientes nodos
			$SQLCmd = "UPDATE " . TABLE_PREFIX . "onas_Modulos SET Orden = Orden - 1 WHERE Orden > " 
				. (int)($rcModuloABorrar);
			$res = $db->execute($SQLCmd);
			
			if ($res) {
				//se elimina el nodo
				$SQLCmd = 'DELETE FROM ' . TABLE_PREFIX . 'onas_Modulos WHERE ID_Modulo = ' . (int)($id);
				$res = $db->execute($SQLCmd);
				
			}
			
			return $res;
			
		}
				
	}
?>
