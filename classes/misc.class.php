<?php

class Misc{
	// Valida direcciones de email
	function checkEmail($email) {
		$pattern = "/^[\w-]+(\.[\w-]+)*@";
		$pattern .= "([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i";
		if (preg_match($pattern, $email)) {
			return true;
		}else{
			return false;
		}
	}
	
	// Analoga a implode pero para arrays multidimensionales
	function multi_implode($glue, $pieces){
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
	
	
	function getQuerystring($valores = NULL){
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
	
	// Retorna los campos de Usos sin los espacios en blanco
	function trim_value(&$pieces) { 
		$pieces = trim($pieces); 
	}
	
	// ORDENA ARRAYS MULTIDIMENSIONALES
	function msort($array, $id="id") {
        $temp_array = array();
        while(count($array)>0) {
            $lowest_id = 0;
            $index=0;
            foreach ($array as $item) {
                if (isset($item[$id]) && $array[$lowest_id][$id]) {
                    if ($item[$id]<$array[$lowest_id][$id]) {
                        $lowest_id = $index;
                    }
                }
                $index++;
            }
            $temp_array[] = $array[$lowest_id];
            $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
        }
        return $temp_array;
    }
	
	// Retorna LANG del pais que pertenece la IP
	function ipLang($code){
		switch($code){
			case 'AR';
			case 'BO';
			case 'CL';
			case 'CO';
			case 'CR';
			case 'DO';
			case 'EC';
			case 'ES';
			case 'GT';
			case 'HN';
			case 'MX';
			case 'NI';
			case 'PA';
			case 'PE';
			case 'PR';
			case 'PY';
			case 'SV';
			case 'VE';
			case 'UY';
				$lang = "es";
				return $lang;
			break;
			case 'AU';
			case 'CA';
			case 'GB';
			case 'IE';
			case 'IN';
			case 'MT';
			case 'NZ';
			case 'PH';
			case 'SG';
			case 'US';
			case 'ZA';
				$lang = "en";
				return $lang;
			break;
			case 'BR';
			case 'PT';
				$lang = "pt";
				return $lang;
			break;
			default:
				$lang = "es";
				return $lang;
		}
	}

}



?>
