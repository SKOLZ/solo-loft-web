<form action="" method="post" id="form_onas" name="form_onas">
    <h4>Nombre</h4>
    <p><input type="text" name="nombre" id="nombre" class="required" value="{$usuario.Nombre}" /></p> 
    
	<h4>Apellido</h4>
    <p><input type="text" name="apellido" id="apellido" class="required" value="{$usuario.Apellido}" /></p> 
	
	<h4>Username</h4>
    <p><input type="text" name="username" id="username" class="required" value="{$usuario.Username}" /></p> 
	
	<h4>Password</h4>
    <p><input type="password" name="password" id="password" class="" value="" /></p>
	
	<h4>Permisos</h4>
    <div class="listar_permisos"><ul>{$permisos}</ul></div>
   
    <div class="Center">     	
    	<input type="hidden" name="indice" value="{$usuario.ID_Usuario}" />
	    <input type="submit" name="submit" value="Dar de alta" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>   
</form>