<?php /* Smarty version 2.6.26, created on 2013-03-13 21:22:06
         compiled from core/modulos_form.tpl */ ?>
<form action="" method="post" id="form_onas" name="form_onas" 
    <h4>Padre</h4>
    <p><select name="id_padre" id="id_padre" class="required Estado">
        <option value="0">/</option>
        <?php $_from = $this->_tpl_vars['padre_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['padre']):
?>
        <option value="<?php echo $this->_tpl_vars['padre']['ID']; ?>
" <?php echo $this->_tpl_vars['padre']['SELECTED']; ?>
 <?php echo $this->_tpl_vars['padre']['DISABLED']; ?>
><?php echo $this->_tpl_vars['padre']['PATH']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
    </select></p>
    
    <h4>Tipo</h4>
    <p><select name="id_tipo" id="id_tipo" class="required Estado" onchange="cambiarTipoModulo();">
        <?php $_from = $this->_tpl_vars['tipo_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tipo']):
?>
        <option value="<?php echo $this->_tpl_vars['tipo']['ID']; ?>
" <?php echo $this->_tpl_vars['tipo']['SELECTED']; ?>
><?php echo $this->_tpl_vars['tipo']['PATH']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
    </select></p>

    <h4>Nombre</h4>
    <p><input type="text" name="texto" id="texto" class="required Estado" value="<?php echo $this->_tpl_vars['modulo']['Texto']; ?>
" /></p> 
    
    <h4>Link (ej: modulos/categorias)</h4>
    <p><input type="text" name="url" id="url" class="Estado" value="<?php echo $this->_tpl_vars['modulo']['Url']; ?>
" /></p>       	

	<p class="Memo"><span>&raquo;</span> Seleccione los usuarios a los cuales desea asignarles permisos para este modulo.</p>

    <ul class="Usuarios" id="ul_usuarios"><?php echo $this->_tpl_vars['usuarios']; ?>
</ul> 

    <input type="hidden" name="custom" value="1" />
    
    <div class="Center">     	
    	<input type="hidden" name="indice" value="<?php echo $this->_tpl_vars['modulo']['ID_Modulo']; ?>
" />
	    <input type="submit" name="submit" value="Dar de alta" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>  
    </div>   
</form>