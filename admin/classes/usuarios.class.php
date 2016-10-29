<?
	class Usuarios {
		var $error;
		
		function Usuarios($db) {
			$this->_db = $db;
			if (isset($_SESSION['onas']['usuario']['data'])) {
				foreach ($_SESSION['onas']['usuario']['data'] as $key => $value) {
					$this->$key = $value;
				}
			}
		}
		
		
		function login($username, $password) {
			if (! isset($username) || ! isset($password) || empty($username) || empty($password)) {
				$this->error = ERR_LOGIN_EMPTY;
				unset($_SESSION['onas']['usuario']);
				return false;
			}
			$user = $this->_db->qstr($username);
			$pass = md5($password);
			$sql = "SELECT * FROM " . TABLE_PREFIX . "onas_Usuarios WHERE Username = $user AND Pswrd = '$pass' ";
			$rs = $this->_db->GetRow($sql);
			
			if (count($rs)) {			
				$user_data = $rs;
				$_SESSION['onas']['usuario'] = array();
				$_SESSION['onas']['usuario']['data'] = $user_data;				
				$_SESSION['onas']['usuario']['loginStatus'] = true;
				$_SESSION['onas']['config'] = array();
				$sql = "SELECT * FROM " . TABLE_PREFIX . "onas_Config";
				$rs = $this->_db->GetAll($sql);
				
				foreach($rs as $config){
					$_SESSION['onas']['config'][$config['Key_Name']] = $config['Value'];				
				}
				return true;
			} else {
				$this->error = ERR_LOGIN_INVALID;
				unset($_SESSION['onas']['usuario']);
				return false;
			}
		}
		
		/* FUNCION ESTATICA */
		function getUsuarios($tpl, $tipo, $id_modulo = 0, $solo_listado = false){
			global $db;
			if($solo_listado){
				$disabled = ' disabled="disabled" ';
			}else{
				$disabled = '';
			}
			if((int)($id_modulo) > 0){
				$q_permisos = "SELECT ID_Usuario, Permisos FROM " . TABLE_PREFIX . "onas_Modulos_Permisos WHERE ID_Modulo = ".$id_modulo;
				$rst_permisos = $db->getAll($q_permisos);
				foreach($rst_permisos as $row_permisos){
					$permisos[$row_permisos["ID_Usuario"]] = $row_permisos["Permisos"];
				}
			}
			$q = "SELECT ID_Usuario, Nombre, Apellido, Username FROM " . TABLE_PREFIX . "onas_Usuarios ORDER BY Username";
			$rst = $db->getAll($q);
			$usuarios = '';
			foreach($rst as $row){
				$usuarios .= '<li><span>'. $row["Username"] .'</span>';
				$checked = (isset($permisos[$row["ID_Usuario"]]) && ($permisos[$row["ID_Usuario"]] & 1) == 1) ? 'checked="checked"' : '';
				$usuarios .= '<input type="checkbox" '.$checked.' '. $disabled .' class="radio" name="permiso[' . $row['ID_Usuario'] . '][1]">Listar';
				if($tipo > 2){
					$checked = (isset($permisos[$row["ID_Usuario"]]) && ($permisos[$row["ID_Usuario"]] & 2) == 2) ? 'checked="checked"' : '';
					$usuarios .= '<input type="checkbox" '.$checked.' '. $disabled .' class="radio" name="permiso[' . $row['ID_Usuario'] . '][2]">Agregar';
					$checked = (isset($permisos[$row["ID_Usuario"]]) && ($permisos[$row["ID_Usuario"]] & 4) == 4) ? 'checked="checked"' : '';
					$usuarios .= '<input type="checkbox" '.$checked.' '. $disabled .' class="radio" name="permiso[' . $row['ID_Usuario'] . '][4]">Editar';
					$checked = (isset($permisos[$row["ID_Usuario"]]) && ($permisos[$row["ID_Usuario"]] & 8) == 8) ? 'checked="checked"' : '';
					$usuarios .= '<input type="checkbox" '.$checked.' '. $disabled .' class="radio" name="permiso[' . $row['ID_Usuario'] . '][8]">Borrar';
				}
				$usuarios .= '</li>';
				
			}
			return $usuarios;
		}
		
		function logout() {
			unset($_SESSION['onas']['usuario']);
		}
		
		function getError() {
			return $this->error;
		}
		
		function isLogged() {
			return isset($_SESSION['onas']['usuario']['loginStatus']) ? $_SESSION['onas']['usuario']['loginStatus'] : NULL;	

		}
		
		function getPermisos ($smarty, $id, $solo_listado = false) {	
			global $db;
			if($solo_listado){
				$disabled = ' disabled="disabled" ';
			}else{
				$disabled = '';
			}
			$selected = array();
			if (isset($id) && is_numeric($id)) {
				$sql = "SELECT * FROM " . TABLE_PREFIX . "onas_Modulos_Permisos WHERE ID_Usuario = " . (int)($id) . " ORDER BY ID_Modulo";
				$rs = $db->getAll($sql);
				foreach ($rs as $row) {
					$selected[$row['ID_Modulo']] = $row['Permisos'];
				}			
			}			
		
			$q = "SELECT m.ID_Modulo, m.ID_Padre, m.Texto, m.Nested, m.Url, m.ID_Tipo, m.Modulo_Custom
				FROM " . TABLE_PREFIX . "onas_Modulos m
				ORDER BY Orden";
			$rst = $db->getAll($q);
			$botonera = '';

			$id_padre_anterior = 0;
			$id_anterior = 0;
			$nested_anterior = 0;
			$i = 0;
			$ul = 0;
			$li = 0;
			foreach($rst as $row){
				if($row["ID_Padre"] != $id_anterior || $row["Nested"] <= $nested_anterior && $i > 0){
					$botonera .= "</li>\n";
					$li--;						
				}
				if($id_padre_anterior != $row["ID_Padre"] ){
					if($nested_anterior < $row["Nested"]){
						$botonera .= "<ul>\n";	
						$ul++;
					}else{
						for($i=$nested_anterior; $i != $row["Nested"] ; $i--){
							$botonera .= "</ul></li>\n";
							$ul--;
							$li--;	
						}
					}
					
				}
				$botonera .= "<li>\n";
				$li++;			
				$botonera .= '<h5>'.$row["Texto"].'</h5>';
				if ($row['ID_Tipo'] == 1) {					
					$checked = (isset($selected[$row['ID_Modulo']]) && ($selected[$row['ID_Modulo']] & 1) == 1) ? 'checked="checked"' : '';
					$botonera .= '<input type="checkbox" '. $disabled .' class="radio" name="permiso[' . $row['ID_Modulo'] . '][1]" ' . $checked . '/> Listar';
					
				} elseif ($row['ID_Tipo'] == 2) {
					$checked = (isset($selected[$row['ID_Modulo']]) &&($selected[$row['ID_Modulo']] & 1) == 1) ? 'checked="checked"' : '';
					$botonera .= '<input type="checkbox" '. $disabled .' class="radio" name="permiso[' . $row['ID_Modulo'] . '][1]" ' . $checked . '/> Listar';
				} elseif ($row['ID_Tipo'] == 3) {
					$checked = (isset($selected[$row['ID_Modulo']]) && ($selected[$row['ID_Modulo']] & 1) == 1) ? 'checked="checked"' : '';
					$botonera .= '<input type="checkbox" '. $disabled .' class="radio" name="permiso[' . $row['ID_Modulo'] . '][1]" ' . $checked . '/> Listar';
					$checked = (isset($selected[$row['ID_Modulo']]) && ($selected[$row['ID_Modulo']] & 2) == 2) ? 'checked="checked"' : '';
					$botonera .= '<input type="checkbox" '. $disabled .' class="radio" name="permiso[' . $row['ID_Modulo'] . '][2]" ' . $checked . '/> Agregar';
					$checked = (isset($selected[$row['ID_Modulo']]) && ($selected[$row['ID_Modulo']] & 4) == 4) ? 'checked="checked"' : '';
					$botonera .= '<input type="checkbox" '. $disabled .' class="radio" name="permiso[' . $row['ID_Modulo'] . '][4]" ' . $checked . '/> Editar';
					$checked = (isset($selected[$row['ID_Modulo']]) && ($selected[$row['ID_Modulo']] & 8) == 8) ? 'checked="checked"' : '';
					$botonera .= '<input type="checkbox" '. $disabled .' class="radio" name="permiso[' . $row['ID_Modulo'] . '][8]" ' . $checked . '/> Borrar';
				}								
				$id_padre_anterior = $row["ID_Padre"];
				$id_anterior = $row["ID_Modulo"];
				$nested_anterior = $row["Nested"];						
				$i++;
			}
			for ($i = 1; $i < $li; $i++) {
				$botonera .= "</li></ul>\n";
			}			
			//echo $nested_anterior;			
			$botonera .= "</li>\n";
			$smarty->assign('permisos', $botonera);								
		}
		
		function setPermisos($id_user, $permisos) {
			$sql = "DELETE FROM " . TABLE_PREFIX . "onas_Modulos_Permisos WHERE ID_Usuario = " . (int)($id_user);
			mysql_query($sql);
			if (count($permisos)) {
				foreach ($permisos as $modulo => $permiso) {
					$totalbits = 0;				
					foreach ($permiso as $bit => $on) {					
						$totalbits = $totalbits + $bit;
					}
					if ($totalbits > 0) {
						$sql = "INSERT INTO " . TABLE_PREFIX . "onas_Modulos_Permisos (ID_Modulo, ID_Usuario, Permisos) VALUES (" . (int)($modulo) . ", " . $id_user . ", " . $totalbits . ")";
						mysql_query($sql);
					}
				}
			}		
		}
		
		function saveProfile($tpl, $data, $id=NULL) {
			if (isset($id) && is_numeric($id)) {
				$sql = "UPDATE " . TABLE_PREFIX . "onas_Usuarios SET 
				Nombre = '" . mysql_real_escape_string($data['nombre']) .  "', 
				Apellido = '" .  mysql_real_escape_string($data['apellido']) .  "', 
				Username = '" .  mysql_real_escape_string($data['usuario']) .  "', 
				Email = '" .  mysql_real_escape_string($data['email']) .  "'";
				if (isset($data['password']) && $data['password'] != '********') { 
					$sql .= ", Pswrd = '" .  md5($data['password']) . "'";
				}
				$sql .= ' WHERE ID_Usuario = ' . (int)($id); 				
				if (! mysql_query($sql)) return false;
				$last = (int)($id);
			} else {
				$sql = "INSERT INTO " . TABLE_PREFIX . "onas_Usuarios (Nombre, Apellido, Username, Email, Pswrd) VALUES (
				'" . mysql_real_escape_string($data['nombre']) . "', 
				'" . mysql_real_escape_string($data['apellido']) . "', 
				'" . mysql_real_escape_string($data['usuario']) . "', 
				'" . mysql_real_escape_string($data['email']) . "', 
				'" . md5($data['password']) . "')"; 
				if (! mysql_query($sql)) return false;
				$sql_last = "SELECT LAST_INSERT_ID() AS last_id FROM " . TABLE_PREFIX . "onas_Usuarios";
				$rs_last = mysql_query($sql_last);
				$row_last = mysql_fetch_assoc($rs_last);
				$last = $row_last['last_id'];
			}			
			$this->setPermisos($last, $data['permiso']);
			return true;
		}
		
		
		
		function delete($id) {
			if (! isset($id) || ! is_numeric($id)) return false;
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'onas_Usuarios WHERE ID_Usuario = ' . (int)($id);
			if (mysql_query($sql)) {
				$sql_permisos = 'DELETE FROM ' . TABLE_PREFIX . 'onas_Modulos_Permisos WHERE ID_Usuario = ' . (int)($id);
				mysql_query($sql_permisos);
				return true;
			} else {
				return false;
			}
		}		
	}
?>
