<?php
class menu {
		function getMenu ($db,$smarty, $id_usuario) {	
			global $PATH;
			$q = "SELECT m.ID_Modulo, m.ID_Padre, m.Texto, m.Nested, m.Url, m.Modulo_Custom
					FROM " . TABLE_PREFIX . "onas_Modulos m
					INNER JOIN " . TABLE_PREFIX . "onas_Modulos_Permisos mp ON m.ID_Modulo = mp.ID_Modulo AND mp.ID_Usuario = ". (int)($id_usuario) ."
					ORDER BY Orden";
			$rst = $db->GetAll($q);
			$botonera = '';
			
			$id_padre_anterior = 0;
			$id_anterior = 0;
			$nested_anterior = 0;
			$i = 0;
			$li = 0;
			foreach($rst as $row){
				if($row['ID_Padre'] != $id_anterior || $row['Nested'] <= $nested_anterior && $i > 0){
					$botonera .= "</li>\n";	
					$li--;
				}
				if($id_padre_anterior != $row['ID_Padre'] ){
					if($nested_anterior < $row['Nested']){
						$botonera .= "<ul>\n";	
					}else{
						for($i=$nested_anterior; $i != $row['Nested'] ; $i--){
							$botonera .= "</ul></li>\n";
							$li--;	
						}
					}
					
				}
				$botonera .= "<li>\n";
				$li++;	
				if($row["Modulo_Custom"] == 1){
					if(trim($row["Url"]) == ""){
						$url = "href=\"#\" onclick=\"return false;\"";
					}else{
						$url = "href=\"". $PATH .$row["Url"] ."\"";
					}
				}else{
					$url = "href=\"modulos.php?id_modulo=". $row["ID_Modulo"] ."\"";
				}
				$botonera .= "<a ". $url .">". $row["Texto"] ."</a>";
				if($row["ID_Padre"] == 0){
					$botonera .= "<span>:</span>\n";
				}else{
					$botonera .= "\n";
				}
				$id_padre_anterior = $row["ID_Padre"];
				$id_anterior = $row["ID_Modulo"];
				$nested_anterior = $row["Nested"];
				$i++;
			}
			for ($i = 1; $i < $li; $i++) {
				$botonera .= "</li></ul>\n";
			}	
			$botonera .= "</li>\n";
			$smarty->assign('BOTONERA', $botonera);	
							
		}
}
?>
