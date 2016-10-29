<?php

class Paginador{

	var $db;
	var $smarty;
	
	var $_indice_get_pagina = 'pag';
	var $_paginas_mostrar = 2; // configura la cantidad de paginas que salen antes y despues de la pagina actual
	
	
	var $total_por_pagina = 4;
	
	
	var $nombre_unidades = 'registros';
	var $smarty_array = 'res';
	var $mostrar_resumen = true;
	var $query;
	var $query_count;
	
	function __construct($db, $smarty){
		$this->db = $db;
		$this->smarty = $smarty;
	}

	function mostrar(){
		$pagina = (isset($_GET[$this->_indice_get_pagina])) ? $_GET[$this->_indice_get_pagina] : 1;
		$total_records = $this->db->getOne($this->query_count);
		$res = $this->db->selectLimit($this->query, $this->total_por_pagina, ($pagina - 1) * $this->total_por_pagina);
		
		$this->smarty->assign($this->smarty_array, $res->getArray());
		$this->smarty->assign('paginador_pagina_actual', $pagina);
		$total_paginas = ceil($total_records / $this->total_por_pagina);
		$this->smarty->assign('paginador_total_paginas', $total_paginas);
		$this->smarty->assign('paginador_total_registros', $total_records );
		
		
		
		if($total_paginas <= ($this->_paginas_mostrar * 2 ) ){
			$this->smarty->assign('paginador_loop_start', 1);
			$this->smarty->assign('paginador_loop_end',  $total_paginas + 1);
		}else{
			if($pagina < $this->_paginas_mostrar + 1){
				$this->smarty->assign('paginador_loop_start', 1);
				$this->smarty->assign('paginador_loop_end', $this->_paginas_mostrar * 2 + 1 );
			}else if($pagina < ($total_paginas - $this->_paginas_mostrar + 1)){
				$this->smarty->assign('paginador_loop_start',  $pagina - $this->_paginas_mostrar  );
				$this->smarty->assign('paginador_loop_end',  $pagina + $this->_paginas_mostrar +1 );
			}else{
				$this->smarty->assign('paginador_loop_start', $total_paginas - ($this->_paginas_mostrar* 2));
				$this->smarty->assign('paginador_loop_end', $total_paginas + 1);
			}
		}

		
		
		$this->smarty->assign('paginador_mostrar_resumen', $this->mostrar_resumen);
		
		$this->smarty->assign('nombre_unidades', $this->nombre_unidades);
		
	}


}


?>