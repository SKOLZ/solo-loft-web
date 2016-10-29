<?php /* Smarty version 2.6.26, created on 2013-03-13 21:24:04
         compiled from file:../modulos/productos_categorias/form.tpl */ ?>
<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">
       
    <h4>Categoria</h4>
    <p><input type="text" name="categoria" id="categoria" class="required" value="<?php echo $this->_tpl_vars['form']['Categoria']; ?>
" /></p> 
        
	<h4>Online</h4>
	<p><input type="radio" name="online" <?php if ($this->_tpl_vars['form']['Online'] == 1): ?>checked="checked"<?php endif; ?> value="1" class="check">Si
	<input type="radio" name="online" <?php if ($this->_tpl_vars['form']['Online'] != 1): ?>checked="checked"<?php endif; ?> value="0" class="check">No</p>

       <div class="Center">     	
    	<input type="hidden" name="indice" value="<?php echo $this->_tpl_vars['indice']; ?>
" />
	    <input type="submit" name="submit" value="Guardar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div> 
</form>