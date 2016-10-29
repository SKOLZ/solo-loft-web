<h4>Nombre</h4>
<p>{$form.Nombre}</p>

<h4>Imagen del Color</h4>
<p> {if file_exists("../../../upload/colores/"|cat:$form.ID_Color|cat:"_color."|cat:$form.Img_Ext)}
     <img src="../../../upload/colores/{$form.ID_Color}_color.{$form.Img_Ext}" />
     {else}
             Imagen del color no disponible
     {/if}
</p>
 

<div class="Center">
    <a class="BtnEditar">Editar</a>
    <a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a>
</div>
