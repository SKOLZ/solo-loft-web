<form action="" method="post" id="form_onas" name="form_onas" 
    <h4>Variable</h4>
    <p><input type="text" name="key_name" id="key_name" class="required Estado" value="{$config.Key_Name}" /></p> 
    
    <h4>Valor</h4>
    <p><input type="text" name="valor" id="valor" class="Estado" value="{$config.Value}" /></p>       	
   
    <p class="Center">     	
    	<input type="hidden" name="indice" value="{$config.Key_Name}" />
	    <input type="submit" name="submit" value="Dar de alta" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </p>   
</form>