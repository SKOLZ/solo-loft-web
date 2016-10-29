<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">
   
    <h4>Titulo</h4>
    <p><input type="text" name="titulo_amarillo" id="titulo_amarillo" class="" value="{$form.Titulo_Amarillo}" /></p> 
    
    <h4>Imagen</h4>
   	<p><input type="file" name="imagen" id="imagen" /></p>  
	<p>
      {if $indice != ''}
     
          {if file_exists("../../../upload/productos/slide/"|cat:$form.ID_Slide|cat:"_th."|cat:$form.Img_Ext)}
      <img src="../../../upload/productos/slide/{$form.ID_Slide}_th.{$form.Img_Ext}" />
         {else}
                 Imagen no disponible
         {/if}
         
     {/if}
    </p>
  
    <h4>Online</h4>
	<p><input type="radio" name="online" {if $form.Online == 1}checked="checked"{/if} value="1" class="check">Si
	<input type="radio" name="online" {if $form.Online != 1}checked="checked"{/if} value="0" class="check">No</p>

   <div class="Center">     	
    	<input type="hidden" name="indice" value="{$indice}" />
	    <input type="submit" name="submit" value="Guardar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>    

</form>