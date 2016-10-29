<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">
   
    <h4>Nombre</h4>
    <p><input type="text" name="nombre" id="nombre" class="required" value="{$form.Nombre}" /></p> 

    
 	 <h4>Imagen del Color</h4>
   	 <p><input type="file" name="imagen" id="imagen" /></p>  
	<p>
     {if $indice != ''}
     {if file_exists("../../../upload/colores/"|cat:$form.ID_Color|cat:"_color."|cat:$form.Img_Ext)}
     <img src="../../../upload/colores/{$form.ID_Color}_color.{$form.Img_Ext}" />
     {else}
              Imagen del color no disponible
     {/if}
    {/if}
    </p>
	
	<div class="Center">     	
    	<input type="hidden" name="indice" value="{$indice}" />
	    <input type="submit" name="submit" value="Guardar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>    

</form>
