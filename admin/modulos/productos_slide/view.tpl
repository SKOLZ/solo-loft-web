<h4>Titulo</h4>
<p>{$form.Titulo_Amarillo}</p>

<h4>Imagen</h4>
<p> {if file_exists("../../../upload/productos/slide/"|cat:$form.ID_Slide|cat:"_th."|cat:$form.Img_Ext)}
     <img src="../../../upload/productos/slide/{$form.ID_Slide}_th.{$form.Img_Ext}" />
     {else}
             Imagen no disponible
     {/if}
</p>


<h4>Online</h4>
<p>{if $form.Online == 1}Si{else}No{/if}</p> 

<div class="Center">
    <a class="BtnEditar">Editar</a>
    <a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a>
</div>
