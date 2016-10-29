{include file="includes/top.tpl"}
<title>Onas 3.0</title>
{literal}
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
{/literal}
{if $mensaje_notificacion_error != ''}
	alert('{$mensaje_notificacion_error}');
{/if}
{literal}
}

);

function ajax_update_radio(id, status){
	$.get('index.php?do=ajax&id='+id+'&status='+status, function(res){
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
{/literal}
</head>
<body>
{include file="includes/header.tpl"}
<div id="contenido" class="bloque"> {include file="includes/login.tpl"}
  {include file="includes/menu.tpl"}
  <div id="contenido-central">
    <div class="bloque bordes" id="grad1">
      <h3>{$nombre_modulo}</h3>
    </div>
    <div class="bloque">
      <div id="busqueda-box" class="left">
        <div class="bordes-top bloque grad">
          <h4 class="buscar-icon">{$subtitulo_modulo}</h4>
        </div>
        <div id="busqueda" class="bloque bordes-bot">
          <div style="width:98%; margin:0 auto;">
            <p  style="text-indent:10px;"><span class="celeste"><strong>&raquo;</strong></span> Ingrese un mínimo de 3 caracteres en el campo <strong>"B&uacute;squeda"</strong></p>
            <div class="bloque">
              <form action="" method="get">
                <p>B&uacute;squeda
                  <input type="text" name="campo_busqueda" id="campo_busqueda" value="{$texto_busqueda}" class="">
                  <input type="submit" value="Buscar" class="btn-buscar">
                </p>
                {if $link_reset_filtro != ''}
                <p class="errMsg" style="text-align:left; padding-left: 180px; padding-top: 4px;"><a href="{$link_reset_filtro}" style="font-weight:normal" class="QFB">Limpiar criterios de busqueda</a></p>
                {/if}
                {foreach from=$filtro_buscador item=filtro}
                {if $filtro.type == 'date'}
                <p>
                	<div class="fecha_filtro"><span>{$filtro.label}: </span>
                		<label class="fecha_label">Desde:</label> <input type="text" name="buscar_fechas[{$filtro.query_field}][desde]" class="desde fecha_input calendar" value="{if is_array($get_buscar_fechas)}{$get_buscar_fechas[$filtro.query_field].desde}{/if}" />
                        <label class="fecha_label">Hasta:</label> <input type="text" name="buscar_fechas[{$filtro.query_field}][hasta]" class="hasta fecha_input calendar" value="{if is_array($get_buscar_fechas)}{$get_buscar_fechas[$filtro.query_field].hasta}{/if}" />
                    </div>
                </p>
                {else}
                <p>
                <span>{$filtro.label}: 
                	<select name="buscar[{$filtro.query_field}]">
                    	<option value="">--</option>
                        {foreach from=$filtro.data item=data}
                    		<option value="{$data[$filtro.id]}" {if $get_buscar[$filtro.query_field] == $data[$filtro.id]} selected="selected" {/if}>{$data[$filtro.value]}</option>
                        {/foreach}
                    </select>
                </span>
                </p>  
                {/if}
                {/foreach}
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
      {if $link_agregar != ''}
      <div id="agregar-producto-box" class="right">
        <div class="bordes-top bloque grad">
          <h4 class="agregar-icon">Agregar un registro</h4>
        </div>
        <div id="busqueda" class="bloque bordes-bot">
          <div style="width:94px; margin:0 auto;"> <img src="{$PATH}images/icon-agregar.jpg" alt="Agregar un registro"><br />
            <a href="{$link_agregar}" class="boton">Agregar</a> </div>
        </div>
      </div>
      {/if} </div>
    <div id="notificacion_evento_ajax"></div>
    {if $mensaje_notificacion_evento != ''}
    <div class="Mensaje marginT bloque"> <span>{$mensaje_notificacion_evento}</span> </div>
    {/if}
    <div class="bordes-top bloque marginT" id="grad2" style="position:relative; background: #003366;">
      <h4>Resultado de busqueda 
        {if $link_export_xls != ''} <a href="{$link_export_xls}" class="Excel">Exportar Excel</a> {/if}
        
        {if $ordenar} <a href="{$ordenar_link}" class="Reordenar">{$ordenar_texto}</a> {/if} </h4>
      
      {if !$sin_resultados}
      <div  id="mostrar-select">
        <form action="" method="post" id="form_itemsxpag">
          Mostrar resultados
          <select name="itemxpagina" id="itemxpagina" onChange="$('#form_itemsxpag').submit();">
            
			{foreach from=$opciones_itemsxpag item=opcion}
        		
            <option value="{$opcion}" {if $opcion == $items_x_pagina}selected="selected"{/if}>{$opcion}</option>
            
			{/foreach}
		
          </select>
        </form>
      </div>
      {/if}
    </div>
    <div id="listado-productos" class="bloque bordes-bot">
      <table class="overs">
        <thead>
          <tr> {foreach from=$arr_headers item=header}
            <th>{$header.nombre} <a href="{$header.link_orden_asc}" title="A-Z"><img src="{$PATH}images/flecha-up.gif" alt="A-Z"></a> <a href="{$header.link_orden_desc}"  title="Z-A"><img src="{$PATH}images/flecha-down.gif" alt="Z-A"></a> </th>
            {/foreach}
            
            {if $radio_ajax}
            <th class="cent">{$radio_ajax_nombre}</th>
            {/if}
            {if $ordenar_items}
            <th>&nbsp;</th>
            {/if}
            {if $btn_editar}
            <th>&nbsp;</th>
            {/if}
            {if $btn_borrar}
            <th>&nbsp;</th>
            {/if} </tr>
        </thead>
        <tbody>
        
        {foreach from=$rows item=row}
        <tr > {foreach from=$arr_campos item=campo}
          <td onClick="location.href='{querystring do=$do_listado id=$row[$primary_key]}'">{$row[$campo]}</td>
          {/foreach}
          {if $radio_ajax}
          <td class="cent"><div id="ajax_ajax_ajax">
            <input type="radio" name="radio_ajax[{$row[$primary_key]}]" {if $row[$radio_ajax_nombre_campo] == 1}checked="checked"{/if} onClick="ajax_update_radio({$row[$primary_key]},1);">
            &nbsp;
            <input type="radio" name="radio_ajax[{$row[$primary_key]}]" {if $row[$radio_ajax_nombre_campo] != 1}checked="checked"{/if} onClick="ajax_update_radio({$row[$primary_key]},0);">
            &nbsp;
            </td>
            {/if}
            {if $ordenar_items}
          <td class="cent">
          {if $condicion_campo != '' && condicion_valor != ''}
          	{if $row[$condicion_campo] == $condicion_valor}
            	<a href="{$ordenar_texto_link_items}{$row[$ordenar_texto_campo_items]}">{$ordenar_texto_items}</a>
            {else}
            	&nbsp;
            {/if}
          {else}
          	<a href="{$ordenar_texto_link_items}{$row[$ordenar_texto_campo_items]}">{$ordenar_texto_items}</a>
          {/if}
          
          </td>
          {/if}
          {if $btn_editar}
          <td class="cent"><a href="{querystring do=form id=$row[$primary_key]}"  title="Editar"><img src="{$PATH}images/icon-modificar.gif" alt="Modificar"></a></td>
          {/if}
          {if $btn_borrar}
          <td class="cent"><a href="{querystring do=delete id=$row[$primary_key]}" onClick="return confirm('Desea eliminar el registro?');" title="Borrar"><img src="{$PATH}images/icon-cruz.gif" alt="Borrar"></a></td>
          {/if} </tr>
        {/foreach}
        {if $sin_resultados}
        <tr>
          <td class="cent">No hay resultados para el criterio de busqueda usado</td>
        </tr>
        {/if}
        </tbody>
        
      </table>
      {if $mostrar_paginador}
      <div id="paginas" class="bordes-bot">
        <p> {if $link_anterior_paginador != ''} <a href="{$link_anterior_paginador}" class="font10">&lt;&lt; ant</a> {/if}
          {foreach from=$arr_paginador_numeros item=numero} <a href="{$numero.LINK_PAGINADOR}" {$numero.ACTIVO}>{$numero.PAGINA}</a> {/foreach}
          {if $link_siguiente_paginador != ''} <a href="{$link_siguiente_paginador}" class="font10">sig &gt;&gt;</a> {/if} </p>
      </div>
      {/if} </div>
    <!-- fin Listado Productos -->
    <div class="bloque" id="opciones-bottom" > <a href="#subir">Ir arriba</a> {if $link_agregar != ''} <a href="{$link_agregar}" class="agregar right">Agregar registro</a> {/if} </div>
  </div>
</div>
{include file="includes/footer.tpl"} 
