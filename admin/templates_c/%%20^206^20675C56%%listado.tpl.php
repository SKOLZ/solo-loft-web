<?php /* Smarty version 2.6.26, created on 2013-02-28 10:33:16
         compiled from listado.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'querystring', 'listado.tpl', 162, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>Onas 3.0</title>
<?php echo '
<script type="text/javascript">
// Over the las filas de la tabla
$(document).ready(
function(){
	$(".overs tr").mouseover(
		function() {
			$(this).addClass("over");
		}).mouseout(
			function() {
				$(this).removeClass("over");});
				$(".overs tr:even").addClass("alt");
'; ?>

<?php if ($this->_tpl_vars['mensaje_notificacion_error'] != ''): ?>
	alert('<?php echo $this->_tpl_vars['mensaje_notificacion_error']; ?>
');
<?php endif; ?>
<?php echo '
}

);

function ajax_update_radio(id, status){
	$.get(\'index.php?do=ajax&id=\'+id+\'&status=\'+status, function(res){
		eval(res);
	});

}
</script>
<style type="text/css">
<!--
.errMsg {color:#900;width:100% !important;text-align:center;font-weight:bold !important}
.errMsg a {color:#039;background:url({PATH}images/lupa.gif) left top no-repeat;padding-left:20px;height:35px;display:inline-block}
-->
</style>
'; ?>

</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="contenido" class="bloque"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div id="contenido-central">
    <div class="bloque bordes" id="grad1">
      <h3><?php echo $this->_tpl_vars['nombre_modulo']; ?>
</h3>
    </div>
    <div class="bloque">
      <div id="busqueda-box" class="left">
        <div class="bordes-top bloque grad">
          <h4 class="buscar-icon"><?php echo $this->_tpl_vars['subtitulo_modulo']; ?>
</h4>
        </div>
        <div id="busqueda" class="bloque bordes-bot">
          <div style="width:98%; margin:0 auto;">
            <p  style="text-indent:10px;"><span class="celeste"><strong>&raquo;</strong></span> Ingrese un mínimo de 3 caracteres en el campo <strong>"B&uacute;squeda"</strong></p>
            <div class="bloque">
              <form action="" method="get">
                <p>B&uacute;squeda
                  <input type="text" name="campo_busqueda" id="campo_busqueda" value="<?php echo $this->_tpl_vars['texto_busqueda']; ?>
" class="">
                  <input type="submit" value="Buscar" class="btn-buscar">
                </p>
                <?php if ($this->_tpl_vars['link_reset_filtro'] != ''): ?>
                <p class="errMsg" style="text-align:left; padding-left: 180px; padding-top: 4px;"><a href="<?php echo $this->_tpl_vars['link_reset_filtro']; ?>
" style="font-weight:normal" class="QFB">Limpiar criterios de busqueda</a></p>
                <?php endif; ?>
                <?php $_from = $this->_tpl_vars['filtro_buscador']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['filtro']):
?>
                <?php if ($this->_tpl_vars['filtro']['type'] == 'date'): ?>
                <p>
                	<div class="fecha_filtro"><span><?php echo $this->_tpl_vars['filtro']['label']; ?>
: </span>
                		<label class="fecha_label">Desde:</label> <input type="text" name="buscar_fechas[<?php echo $this->_tpl_vars['filtro']['query_field']; ?>
][desde]" class="desde fecha_input calendar" value="<?php if (is_array ( $this->_tpl_vars['get_buscar_fechas'] )): ?><?php echo $this->_tpl_vars['get_buscar_fechas'][$this->_tpl_vars['filtro']['query_field']]['desde']; ?>
<?php endif; ?>" />
                        <label class="fecha_label">Hasta:</label> <input type="text" name="buscar_fechas[<?php echo $this->_tpl_vars['filtro']['query_field']; ?>
][hasta]" class="hasta fecha_input calendar" value="<?php if (is_array ( $this->_tpl_vars['get_buscar_fechas'] )): ?><?php echo $this->_tpl_vars['get_buscar_fechas'][$this->_tpl_vars['filtro']['query_field']]['hasta']; ?>
<?php endif; ?>" />
                    </div>
                </p>
                <?php else: ?>
                <p>
                <span><?php echo $this->_tpl_vars['filtro']['label']; ?>
: 
                	<select name="buscar[<?php echo $this->_tpl_vars['filtro']['query_field']; ?>
]">
                    	<option value="">--</option>
                        <?php $_from = $this->_tpl_vars['filtro']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                    		<option value="<?php echo $this->_tpl_vars['data'][$this->_tpl_vars['filtro']['id']]; ?>
" <?php if ($this->_tpl_vars['get_buscar'][$this->_tpl_vars['filtro']['query_field']] == $this->_tpl_vars['data'][$this->_tpl_vars['filtro']['id']]): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['data'][$this->_tpl_vars['filtro']['value']]; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
                </p>  
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <!--
                <p>
                <span>Tipo: <select name=""><option value="">Todos</option></select></span>
                <span>Marca: <select name=""><option value="">Todos</option></select></span>	
                 </p>  
                 <p><span>Categoria: <select name=""><option value="">Todos</option></select></span>
                    <span>Modelo: <select name=""><option value="">Todos</option></select></span> 
                 </p>  
                -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- fin Busqueda -->
      <?php if ($this->_tpl_vars['link_agregar'] != ''): ?>
      <div id="agregar-producto-box" class="right">
        <div class="bordes-top bloque grad">
          <h4 class="agregar-icon">Agregar un registro</h4>
        </div>
        <div id="busqueda" class="bloque bordes-bot">
          <div style="width:94px; margin:0 auto;"> <img src="<?php echo $this->_tpl_vars['PATH']; ?>
images/icon-agregar.jpg" alt="Agregar un registro"><br />
            <a href="<?php echo $this->_tpl_vars['link_agregar']; ?>
" class="boton">Agregar</a> </div>
        </div>
      </div>
      <?php endif; ?> </div>
    <div id="notificacion_evento_ajax"></div>
    <?php if ($this->_tpl_vars['mensaje_notificacion_evento'] != ''): ?>
    <div class="Mensaje marginT bloque"> <span><?php echo $this->_tpl_vars['mensaje_notificacion_evento']; ?>
</span> </div>
    <?php endif; ?>
    <div class="bordes-top bloque marginT" id="grad2" style="position:relative; background: #003366;">
      <h4>Resultado de busqueda 
        <?php if ($this->_tpl_vars['link_export_xls'] != ''): ?> <a href="<?php echo $this->_tpl_vars['link_export_xls']; ?>
" class="Excel">Exportar Excel</a> <?php endif; ?>
        
        <?php if ($this->_tpl_vars['ordenar']): ?> <a href="<?php echo $this->_tpl_vars['ordenar_link']; ?>
" class="Reordenar"><?php echo $this->_tpl_vars['ordenar_texto']; ?>
</a> <?php endif; ?> </h4>
      
      <?php if (! $this->_tpl_vars['sin_resultados']): ?>
      <div  id="mostrar-select">
        <form action="" method="post" id="form_itemsxpag">
          Mostrar resultados
          <select name="itemxpagina" id="itemxpagina" onChange="$('#form_itemsxpag').submit();">
            
			<?php $_from = $this->_tpl_vars['opciones_itemsxpag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['opcion']):
?>
        		
            <option value="<?php echo $this->_tpl_vars['opcion']; ?>
" <?php if ($this->_tpl_vars['opcion'] == $this->_tpl_vars['items_x_pagina']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['opcion']; ?>
</option>
            
			<?php endforeach; endif; unset($_from); ?>
		
          </select>
        </form>
      </div>
      <?php endif; ?>
    </div>
    <div id="listado-productos" class="bloque bordes-bot">
      <table class="overs">
        <thead>
          <tr> <?php $_from = $this->_tpl_vars['arr_headers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
?>
            <th><?php echo $this->_tpl_vars['header']['nombre']; ?>
 <a href="<?php echo $this->_tpl_vars['header']['link_orden_asc']; ?>
" title="A-Z"><img src="<?php echo $this->_tpl_vars['PATH']; ?>
images/flecha-up.gif" alt="A-Z"></a> <a href="<?php echo $this->_tpl_vars['header']['link_orden_desc']; ?>
"  title="Z-A"><img src="<?php echo $this->_tpl_vars['PATH']; ?>
images/flecha-down.gif" alt="Z-A"></a> </th>
            <?php endforeach; endif; unset($_from); ?>
            
            <?php if ($this->_tpl_vars['radio_ajax']): ?>
            <th class="cent"><?php echo $this->_tpl_vars['radio_ajax_nombre']; ?>
</th>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['ordenar_items']): ?>
            <th>&nbsp;</th>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['btn_editar']): ?>
            <th>&nbsp;</th>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['btn_borrar']): ?>
            <th>&nbsp;</th>
            <?php endif; ?> </tr>
        </thead>
        <tbody>
        
        <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
        <tr > <?php $_from = $this->_tpl_vars['arr_campos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['campo']):
?>
          <td onClick="location.href='<?php echo smarty_function_querystring(array('do' => $this->_tpl_vars['do_listado'],'id' => $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]), $this);?>
'"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['campo']]; ?>
</td>
          <?php endforeach; endif; unset($_from); ?>
          <?php if ($this->_tpl_vars['radio_ajax']): ?>
          <td class="cent"><div id="ajax_ajax_ajax">
            <input type="radio" name="radio_ajax[<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]; ?>
]" <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['radio_ajax_nombre_campo']] == 1): ?>checked="checked"<?php endif; ?> onClick="ajax_update_radio(<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]; ?>
,1);">
            &nbsp;
            <input type="radio" name="radio_ajax[<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]; ?>
]" <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['radio_ajax_nombre_campo']] != 1): ?>checked="checked"<?php endif; ?> onClick="ajax_update_radio(<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]; ?>
,0);">
            &nbsp;
            </td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['ordenar_items']): ?>
          <td class="cent">
          <?php if ($this->_tpl_vars['condicion_campo'] != '' && condicion_valor != ''): ?>
          	<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['condicion_campo']] == $this->_tpl_vars['condicion_valor']): ?>
            	<a href="<?php echo $this->_tpl_vars['ordenar_texto_link_items']; ?>
<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['ordenar_texto_campo_items']]; ?>
"><?php echo $this->_tpl_vars['ordenar_texto_items']; ?>
</a>
            <?php else: ?>
            	&nbsp;
            <?php endif; ?>
          <?php else: ?>
          	<a href="<?php echo $this->_tpl_vars['ordenar_texto_link_items']; ?>
<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['ordenar_texto_campo_items']]; ?>
"><?php echo $this->_tpl_vars['ordenar_texto_items']; ?>
</a>
          <?php endif; ?>
          
          </td>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['btn_editar']): ?>
          <td class="cent"><a href="<?php echo smarty_function_querystring(array('do' => 'form','id' => $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]), $this);?>
"  title="Editar"><img src="<?php echo $this->_tpl_vars['PATH']; ?>
images/icon-modificar.gif" alt="Modificar"></a></td>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['btn_borrar']): ?>
          <td class="cent"><a href="<?php echo smarty_function_querystring(array('do' => 'delete','id' => $this->_tpl_vars['row'][$this->_tpl_vars['primary_key']]), $this);?>
" onClick="return confirm('Desea eliminar el registro?');" title="Borrar"><img src="<?php echo $this->_tpl_vars['PATH']; ?>
images/icon-cruz.gif" alt="Borrar"></a></td>
          <?php endif; ?> </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['sin_resultados']): ?>
        <tr>
          <td class="cent">No hay resultados para el criterio de busqueda usado</td>
        </tr>
        <?php endif; ?>
        </tbody>
        
      </table>
      <?php if ($this->_tpl_vars['mostrar_paginador']): ?>
      <div id="paginas" class="bordes-bot">
        <p> <?php if ($this->_tpl_vars['link_anterior_paginador'] != ''): ?> <a href="<?php echo $this->_tpl_vars['link_anterior_paginador']; ?>
" class="font10">&lt;&lt; ant</a> <?php endif; ?>
          <?php $_from = $this->_tpl_vars['arr_paginador_numeros']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['numero']):
?> <a href="<?php echo $this->_tpl_vars['numero']['LINK_PAGINADOR']; ?>
" <?php echo $this->_tpl_vars['numero']['ACTIVO']; ?>
><?php echo $this->_tpl_vars['numero']['PAGINA']; ?>
</a> <?php endforeach; endif; unset($_from); ?>
          <?php if ($this->_tpl_vars['link_siguiente_paginador'] != ''): ?> <a href="<?php echo $this->_tpl_vars['link_siguiente_paginador']; ?>
" class="font10">sig &gt;&gt;</a> <?php endif; ?> </p>
      </div>
      <?php endif; ?> </div>
    <!-- fin Listado Productos -->
    <div class="bloque" id="opciones-bottom" > <a href="#subir">Ir arriba</a> <?php if ($this->_tpl_vars['link_agregar'] != ''): ?> <a href="<?php echo $this->_tpl_vars['link_agregar']; ?>
" class="agregar right">Agregar registro</a> <?php endif; ?> </div>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 