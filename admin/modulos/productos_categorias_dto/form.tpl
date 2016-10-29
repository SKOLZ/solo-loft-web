<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">
       
    <h4>Categoria</h4>
    <p><input type="text" name="categoria" id="categoria" class="required" value="{$form.Categoria_Departamento}" /></p> 
        
	<h4>Online</h4>
	<p><input type="radio" name="online" {if $form.Online == 1}checked="checked"{/if} value="1" class="check">Si
	<input type="radio" name="online" {if $form.Online != 1}checked="checked"{/if} value="0" class="check">No</p>

       <div class="Center">     	
    	<input type="hidden" name="indice" value="{$indice}" />
	    <input type="submit" name="submit" value="Guardar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div> 
</form>
