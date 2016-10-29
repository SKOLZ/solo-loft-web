<?php /* Smarty version 2.6.26, created on 2013-03-13 21:23:28
         compiled from core/usuarios_form.tpl */ ?>
<form action="" method="post" id="form_onas" name="form_onas">
    <h4>Nombre</h4>
    <p><input type="text" name="nombre" id="nombre" class="required" value="<?php echo $this->_tpl_vars['usuario']['Nombre']; ?>
" /></p> 
    
	<h4>Apellido</h4>
    <p><input type="text" name="apellido" id="apellido" class="required" value="<?php echo $this->_tpl_vars['usuario']['Apellido']; ?>
" /></p> 
	
	<h4>Username</h4>
    <p><input type="text" name="username" id="username" class="required" value="<?php echo $this->_tpl_vars['usuario']['Username']; ?>
" /></p> 
	
	<h4>Password</h4>
    <p><input type="password" name="password" id="password" class="" value="" /></p>
	
	<h4>Permisos</h4>
    <div class="listar_permisos"><ul><?php echo $this->_tpl_vars['permisos']; ?>
</ul></div>
   
    <div class="Center">     	
    	<input type="hidden" name="indice" value="<?php echo $this->_tpl_vars['usuario']['ID_Usuario']; ?>
" />
	    <input type="submit" name="submit" value="Dar de alta" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>   
</form>