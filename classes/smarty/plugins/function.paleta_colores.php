<?php

function smarty_function_paleta_colores($params, &$smarty){
	if(trim($params['colores']) != ''){
		
		$pieces = explode(",", $params['colores']); // saco las comas y los espacios vacios
	
		$valor_vacio = array_pop($pieces); // elimino el ultimo campo que llega vacio
		
		$str = '';
		
		foreach($pieces as $codigo){
			$str .= '<li class="ui-state-default" id="'. $codigo .'"><span class="ui-icon ui-icon-arrowthick-2-n-s"><span style="background-color:#'.$codigo.'; color:#'.$codigo.'" class="color-picker">#'.$codigo.'</span><span class="numero-color">#'.$codigo.'</span><a href="#" onclick="removeColorPickerItem(this); return false;">quitar</a></span></li>';
		}

		return $str;
		
	}
	
}


?>
