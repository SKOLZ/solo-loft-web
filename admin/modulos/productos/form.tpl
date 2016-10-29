<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">

<h4>Titulo</h4>
<p><input type="text" name="titulo" id="titulo" class="required" value="{$form.Titulo}" /></p> 

<h4>Encabezado (texto naranja)</h4> 
<p><input type="text" name="encabezado" id="encabezado" class="required" value="{$form.Encabezado}" /></p> 

<h4>Categoria</h4>
<p>
    <select name="id_categoria" id="id_categoria" class="required" onchange="mostrarBloque(value);return false;">
    	<option value="0">-- seleccionar --</option>
    	{foreach from=$categorias item=categoria}
        <option value="{$categoria.ID_Categoria}" {if $form.ID_Categoria == $categoria.ID_Categoria}selected="selected"{/if}>{$categoria.Categoria}</option>
    	{/foreach}
    </select>
</p> 
    
<h4>Descripcion</h4>
<p><textarea id="descripcion" name="descripcion">{$form.Descripcion}</textarea></p> 

<h4>Imagen para Listados</h4>
<p><input type="file" name="imagen_jcrop" id="imagen" /></p>  
<p>
{if $indice != ''}
 
 {if file_exists("../../../upload/productos/"|cat:$form.ID_Producto|cat:"_th."|cat:$form.Img_Ext)}
 <img src="../../../upload/productos/{$form.ID_Producto}_th.{$form.Img_Ext}" />
 {else}
         Imagen no disponible
 {/if}
{/if}
</p>

<h4>Imagenes para el Pasador</h4>
    <div class="img_adicionales">
        {foreach from=$imagenes_adicionales item=imagen}
            <div id="container_adicional_{$imagen.ID_Imagen_Adicional}">
                <img src="../../../upload/productos/adicionales/{$imagen.ID_Imagen_Adicional}_detalle.{$imagen.Img_Ext}" width="320" style="margin-bottom:20px;" />
                <a href="#" onclick="borrarImagenAdicional({$imagen.ID_Imagen_Adicional}); return false;" class="delete" title="Borrar">borrar</a>
            </div>
        {/foreach}
    </div>
    
<div style="float:left; width:50%">
    <div id="campo_imagen_adicional"><p><input type="file" name="imagenes_adicionales[]" /></p></div>
    <div id="container_imagenes_adicionales"></div>
    <div class="agregar_img">
        <a href="#" onclick="$('#container_imagenes_adicionales').append($('#campo_imagen_adicional').html()); return false;">[+] Agregar imagen</a>
    </div> 
</div>

<!--DATOS PARA COMPLEJO-->
<div id="complejo" style="display:none;">
    <h4>Ubicaci&oacute;n</h4>
    <p><input type="text" name="ubicacion" id="ubicacion" value="{$form.Ubicacion}" /></p> 
    
    <h4>Servicios</h4>
    <p><input type="text" name="servicios" id="servicios" value="{$form.Servicios}" /></p> 
    
    <h4>Superficie total</h4>
    <p><input type="text" name="superficie_total" id="superficie_total" value="{$form.Superficie_total}" /></p> 
    
    <h4>Altura y cantidad de pisos</h4>
    <p><input type="text" name="altura_pisos" id="altura_pisos" value="{$form.Altura_pisos}" /></p> 
    
    <h4>Cantidad de unidades</h4>
    <p><input type="text" name="cantidad_unidades" id="cantidad_unidades" value="{$form.Cantidad_unidades}" /></p> 
    
    <h4>Cantidad de cocheras</h4>
    <p><input type="text" name="cantidad_cocheras" id="cantidad_cocheras" value="{$form.Cocheras}" /></p> 
    
    <h4>Etapa de construcci&oacute;n y finalizaci&oacute;n</h4>
    <p><input type="text" name="etapa_construccion" id="etapa_construccion" value="{$form.Etapa_construccion}" /></p>  
</div>

<!--DATOS PARA DEPARTAMENTO-->
<div id="departamento" style="display:none;">
    <h4>Categoria Departamento</h4>
    <p>
        <select name="id_categoria_dto" id="id_categoria_dto" class="required">
            <option value="0">-- seleccionar --</option>
            {foreach from=$categorias_dto item=categoria_dto}
            <option value="{$categoria_dto.ID_Categoria_Departamento}" {if $form.ID_Categoria_Departamento == $categoria_dto.ID_Categoria_Departamento}selected="selected"{/if}>{$categoria_dto.Categoria_Departamento}</option>
            {/foreach}
        </select>
    </p> 
    
    <h4>Complejo al que pertenece</h4>
    <p>
        <select name="id_perteneciente" id="id_perteneciente" class="required">
            <option value="0">-- seleccionar --</option>
            {foreach from=$complejos item=complejo}
            <option value="{$complejo.ID_Producto}" {if $form.ID_Producto == $complejo.ID_Producto}selected="selected"{/if}>{$complejo.Titulo}</option>
            {/foreach}
        </select>
    </p> 
    
    <h4>Cantidad de ambientes</h4>
    <p><input type="text" name="cantidad_ambientes" id="cantidad_ambientes" value="{$form.Cantidad_ambientes}" /></p> 
    
    <h4>Superficie departamento</h4>
    <p><input type="text" name="superficie_dto" id="superficie_dto" value="{$form.Superficie_dto}" /></p> 
    
    <h4>Apto profesional</h4>
    <p><input type="radio" name="apto_profesional" {if $form.Apto_profesional == 1}checked="checked"{/if} value="1" class="check">Si
	<input type="radio" name="apto_profesional" {if $form.Apto_profesional != 1}checked="checked"{/if} value="0" class="check">No</p> 
    
    <h4>Servicios del departamento</h4>
    <p><input type="text" name="servicios_dto" id="servicios_dto" value="{$form.Servicios_dto}" /></p> 
    
    <h4>Expensas</h4>
    <p><input type="text" name="expensas" id="expensas" value="{$form.Expensas}" /></p> 
    
    <h4>Otros Datos</h4>
    <p><input type="text" name="otros_datos" id="otros_datos" value="{$form.Otros_datos}" /></p>  
</div>

<h4>Destacado</h4>
<p style="font-style:italic;">(Se muestra en listados de busqueda y en la seccion Propiedades)</p>
<p><input type="radio" name="destacado" {if $form.Destacado == 1}checked="checked"{/if} value="1" class="check">Si
<input type="radio" name="destacado" {if $form.Destacado != 1}checked="checked"{/if} value="0" class="check">No</p>   

<h4>Home</h4>
<p style="font-style:italic;">(Se muestra en bloques en la Home)</p>
<p><input type="radio" name="home" {if $form.Home == 1}checked="checked"{/if} value="1" class="check">Si
<input type="radio" name="home" {if $form.Home != 1}checked="checked"{/if} value="0" class="check">No</p>   
 
<h4>Online</h4>
<p><input type="radio" name="online" {if $form.Online == 1}checked="checked"{/if} value="1" class="check">Si
<input type="radio" name="online" {if $form.Online != 1}checked="checked"{/if} value="0" class="check">No</p>
    
	    
   <div class="Center">     	
    	<input type="hidden" name="indice" value="{$indice}" />
	    <input type="submit" name="submit" value="Guardar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>     
</form>

{literal}
<script type="text/javascript">
function borrarImagenAdicional(id_adicional){
	$.get('index.php?do=eliminarimagenadicional&id='+id_adicional, function(res){
		if(res == 'ok'){
			$('#container_adicional_'+id_adicional).remove();
		}else{
			alert("Ocurrio un error");
		}
	});
}
</script>
{/literal}