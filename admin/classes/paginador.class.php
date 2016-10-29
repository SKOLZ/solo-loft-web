<?
	class Paginador {
		var $smarty;
		var $Total_Resultados;
		var $Pagina_Actual;
		var $Items_x_Pagina;
		
		function Paginador($smarty, $total_resultados, $pagina_actual, $items_x_pagina){
			$this->smarty = $smarty;
			$this->Total_Resultados = $total_resultados;
			$this->Pagina_Actual = $pagina_actual;
			$this->Items_x_Pagina = $items_x_pagina;
		}
		
		function mostrar() {
			$pagina = ($this->Pagina_Actual > 0) ? $this->Pagina_Actual : 1;
			$offset = ($pagina * $this->Items_x_Pagina) - $this->Items_x_Pagina;	
			
			$total_paginas = ceil($this->Total_Resultados / $this->Items_x_Pagina);			
			
			if ($this->Total_Resultados > 0) {
				$this->smarty->assign('mostrar_paginador', true);
				if($pagina > 1){
					$this->smarty->assign('link_anterior_paginador', Misc::getQuerystring(array("pagina" => ($pagina-1))));
				}
				
				$arr_paginador_numeros = array();
					
				for($pag=1; $pag<=$total_paginas; $pag++){
					if($pag < $total_paginas){
						$separador = " - ";
					}else{
						$separador = "";
					}
					$activo = ($pagina == $pag) ? 'class="activo"' : '';
					$arr_paginador_numeros[] = array("PAGINA" => $pag,
													"LINK_PAGINADOR" => Misc::getQuerystring(array("pagina" => $pag)),
													"SEPARADOR" => $separador,
													"ACTIVO" => $activo
															);
					
				}
				$this->smarty->assign('arr_paginador_numeros', $arr_paginador_numeros);
				
				if($pagina < $total_paginas){
					$this->smarty->assign('link_siguiente_paginador', Misc::getQuerystring(array("pagina" => ($pagina+1))));
				}	
				
			}
		}	
	}
?>
