<h4>Titulo</h4>
<p>{$form.Titulo}</p>

<!--<h4>Colores</h4> 
    <p>
           {foreach from=$colores item=color}
        	<input type="checkbox" name="id_color[{$color.ID_Color}]"  disabled="disabled" value="1" class="check" {if $color.Seleccionada > 0}checked="checked" {/if} /><img src="../../../upload/colores/{$color.ID_Color}_th.{$color.Img_Ext}" alt="{$color.Color}" /><br />
           {/foreach}
        </select>
</p>-->

<h4>Categoria</h4>
<p>{$form.Categoria}</p>

<h4>Encabezado</h4>
<p>{$form.Encabezado}</p>

<h4>Descripcion</h4>
<p>{$form.Descripcion}</p>

<h4>Imagen</h4>
 <p>
{if file_exists("../../../upload/productos/"|cat:$form.ID_Producto|cat:"_th."|cat:$form.Img_Ext)}
     <img src="../../../upload/productos/{$form.ID_Producto}_th.{$form.Img_Ext}" />
  {else}
             Imagen no disponible
   {/if}
</p>

<h4>Imagenes adicionales</h4>
<p>
{if $imagenes_adicionales > 0}
	{foreach from=$imagenes_adicionales item=imagen}
	<img src="../../../upload/productos/adicionales/{$imagen.ID_Imagen_Adicional}_detalle.{$imagen.Img_Ext}" width="720" style="margin-bottom:20px;" />
	{/foreach}
	
  {else}
             No se encontraron Imagenes Adicionales
{/if}
</p>

<!--DATOS PARA COMPLEJO-->
<div id="complejo_view" style="display:none;">
    <h4>Ubicaci&oacute;n</h4>
    <p>{$form.Ubicacion}</p>
    
    <h4>Servicios</h4>
    <p>{$form.Servicios}</p>
    
    <h4>Superficie total</h4>
    <p>{$form.Superficie_total}</p>
    
    <h4>Altura y cantidad de pisos</h4>
    <p>{$form.Altura_pisos}</p>
    
    <h4>Cantidad de unidades</h4>
    <p>{$form.Cantidad_unidades}</p>
    
    <h4>Cantidad de cocheras</h4>
    <p>{$form.Cocheras}</p>
    
    <h4>Etapa de construcci&oacute;n y finalizaci&oacute;n</h4>
    <p>{$form.Etapa_construccion}</p>
</div>

<!--DATOS PARA DEPARTAMENTO-->
<div id="departamento_view" style="display:none;">
    <h4>Categoria Departamento</h4>
    <p>{$form.Categoria_Departamento}</p>
    
    <h4>Complejo al que pertenece</h4>
    <p>{foreach from=$complejos item=complejo}
    {if $form.ID_Perteneciente == $complejo.ID_Producto}{$complejo.Titulo}{/if}
    {/foreach}</p>
    
    <h4>Cantidad de ambientes</h4>
    <p>{$form.Cantidad_ambientes}</p>
    
    <h4>Superficie departamento</h4>
    <p>{$form.Superficie_dto}</p>
    
    <h4>Apto profesional</h4>
    <p>{if $form.Apto_profesional == 1}Si{else}No{/if}</p> 
    
    <h4>Servicios del departamento</h4>
    <p>{$form.Servicios_dto}</p>
    
    <h4>Expensas</h4>
    <p>{$form.Expensas}</p>
    
    <h4>Otros Datos</h4>
    <p>{$form.Otros_datos}</p>
</div>

<h4>Destacado</h4>
<p>{if $form.Destacado == 1}Si{else}No{/if}</p> 

<h4>Home</h4>
<p>{if $form.Novedades == 1}Si{else}No{/if}</p> 

<h4>Online</h4>
<p>{if $form.Online == 1}Si{else}No{/if}</p> 

<div class="Center">
    <a class="BtnEditar">Editar</a>
    <a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a>
</div>