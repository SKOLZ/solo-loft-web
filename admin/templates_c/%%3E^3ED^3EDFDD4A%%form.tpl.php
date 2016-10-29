<?php /* Smarty version 2.6.26, created on 2013-03-25 23:31:47
         compiled from file:../modulos/productos/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'file:../modulos/productos/form.tpl', 27, false),)), $this); ?>
<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">

<h4>Titulo</h4>
<p><input type="text" name="titulo" id="titulo" class="required" value="<?php echo $this->_tpl_vars['form']['Titulo']; ?>
" /></p> 

<h4>Encabezado (texto naranja)</h4> 
<p><input type="text" name="encabezado" id="encabezado" class="required" value="<?php echo $this->_tpl_vars['form']['Encabezado']; ?>
" /></p> 

<h4>Categoria</h4>
<p>
    <select name="id_categoria" id="id_categoria" class="required" onchange="mostrarBloque(value);return false;">
    	<option value="0">-- seleccionar --</option>
    	<?php $_from = $this->_tpl_vars['categorias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categoria']):
?>
        <option value="<?php echo $this->_tpl_vars['categoria']['ID_Categoria']; ?>
" <?php if ($this->_tpl_vars['form']['ID_Categoria'] == $this->_tpl_vars['categoria']['ID_Categoria']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['categoria']['Categoria']; ?>
</option>
    	<?php endforeach; endif; unset($_from); ?>
    </select>
</p> 
    
<h4>Descripcion</h4>
<p><textarea id="descripcion" name="descripcion"><?php echo $this->_tpl_vars['form']['Descripcion']; ?>
</textarea></p> 

<h4>Imagen para Listados</h4>
<p><input type="file" name="imagen_jcrop" id="imagen" /></p>  
<p>
<?php if ($this->_tpl_vars['indice'] != ''): ?>
 
 <?php if (file_exists ( ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="../../../upload/productos/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['form']['ID_Producto']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['form']['ID_Producto'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "_th.") : smarty_modifier_cat($_tmp, "_th.")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['form']['Img_Ext']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['form']['Img_Ext'])) )): ?>
 <img src="../../../upload/productos/<?php echo $this->_tpl_vars['form']['ID_Producto']; ?>
_th.<?php echo $this->_tpl_vars['form']['Img_Ext']; ?>
" />
 <?php else: ?>
         Imagen no disponible
 <?php endif; ?>
<?php endif; ?>
</p>

<h4>Imagenes para el Pasador</h4>
    <div class="img_adicionales">
        <?php $_from = $this->_tpl_vars['imagenes_adicionales']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['imagen']):
?>
            <div id="container_adicional_<?php echo $this->_tpl_vars['imagen']['ID_Imagen_Adicional']; ?>
">
                <img src="../../../upload/productos/adicionales/<?php echo $this->_tpl_vars['imagen']['ID_Imagen_Adicional']; ?>
_detalle.<?php echo $this->_tpl_vars['imagen']['Img_Ext']; ?>
" width="320" style="margin-bottom:20px;" />
                <a href="#" onclick="borrarImagenAdicional(<?php echo $this->_tpl_vars['imagen']['ID_Imagen_Adicional']; ?>
); return false;" class="delete" title="Borrar">borrar</a>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
    
<div style="float:left; width:50%">
    <div id="campo_imagen_adicional"><p><input type="file" name="imagenes_adicionales[]" /></p></div>
    <div id="container_imagenes_adicionales"></div>
    <div class="agregar_img">
        <a href="#" onclick="$('#container_imagenes_adicionales').append($('#campo_imagen_adicional').html()); return false;">[+] Agregar imagen</a>
    </div> 
</div>

<!--DATOS PARA COMPLEJO-->
<div id="complejo" style="display:none;">
    <h4>Ubicaci&oacute;n</h4>
    <p><input type="text" name="ubicacion" id="ubicacion" value="<?php echo $this->_tpl_vars['form']['Ubicacion']; ?>
" /></p> 
    
    <h4>Servicios</h4>
    <p><input type="text" name="servicios" id="servicios" value="<?php echo $this->_tpl_vars['form']['Servicios']; ?>
" /></p> 
    
    <h4>Superficie total</h4>
    <p><input type="text" name="superficie_total" id="superficie_total" value="<?php echo $this->_tpl_vars['form']['Superficie_total']; ?>
" /></p> 
    
    <h4>Altura y cantidad de pisos</h4>
    <p><input type="text" name="altura_pisos" id="altura_pisos" value="<?php echo $this->_tpl_vars['form']['Altura_pisos']; ?>
" /></p> 
    
    <h4>Cantidad de unidades</h4>
    <p><input type="text" name="cantidad_unidades" id="cantidad_unidades" value="<?php echo $this->_tpl_vars['form']['Cantidad_unidades']; ?>
" /></p> 
    
    <h4>Cantidad de cocheras</h4>
    <p><input type="text" name="cantidad_cocheras" id="cantidad_cocheras" value="<?php echo $this->_tpl_vars['form']['Cocheras']; ?>
" /></p> 
    
    <h4>Etapa de construcci&oacute;n y finalizaci&oacute;n</h4>
    <p><input type="text" name="etapa_construccion" id="etapa_construccion" value="<?php echo $this->_tpl_vars['form']['Etapa_construccion']; ?>
" /></p>  
</div>

<!--DATOS PARA DEPARTAMENTO-->
<div id="departamento" style="display:none;">
    <h4>Categoria Departamento</h4>
    <p>
        <select name="id_categoria_dto" id="id_categoria_dto" class="required">
            <option value="0">-- seleccionar --</option>
            <?php $_from = $this->_tpl_vars['categorias_dto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categoria_dto']):
?>
            <option value="<?php echo $this->_tpl_vars['categoria_dto']['ID_Categoria_Departamento']; ?>
" <?php if ($this->_tpl_vars['form']['ID_Categoria_Departamento'] == $this->_tpl_vars['categoria_dto']['ID_Categoria_Departamento']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['categoria_dto']['Categoria_Departamento']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
        </select>
    </p> 
    
    <h4>Complejo al que pertenece</h4>
    <p>
        <select name="id_perteneciente" id="id_perteneciente" class="required">
            <option value="0">-- seleccionar --</option>
            <?php $_from = $this->_tpl_vars['complejos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['complejo']):
?>
            <option value="<?php echo $this->_tpl_vars['complejo']['ID_Producto']; ?>
" <?php if ($this->_tpl_vars['form']['ID_Producto'] == $this->_tpl_vars['complejo']['ID_Producto']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['complejo']['Titulo']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
        </select>
    </p> 
    
    <h4>Cantidad de ambientes</h4>
    <p><input type="text" name="cantidad_ambientes" id="cantidad_ambientes" value="<?php echo $this->_tpl_vars['form']['Cantidad_ambientes']; ?>
" /></p> 
    
    <h4>Superficie departamento</h4>
    <p><input type="text" name="superficie_dto" id="superficie_dto" value="<?php echo $this->_tpl_vars['form']['Superficie_dto']; ?>
" /></p> 
    
    <h4>Apto profesional</h4>
    <p><input type="radio" name="apto_profesional" <?php if ($this->_tpl_vars['form']['Apto_profesional'] == 1): ?>checked="checked"<?php endif; ?> value="1" class="check">Si
	<input type="radio" name="apto_profesional" <?php if ($this->_tpl_vars['form']['Apto_profesional'] != 1): ?>checked="checked"<?php endif; ?> value="0" class="check">No</p> 
    
    <h4>Servicios del departamento</h4>
    <p><input type="text" name="servicios_dto" id="servicios_dto" value="<?php echo $this->_tpl_vars['form']['Servicios_dto']; ?>
" /></p> 
    
    <h4>Expensas</h4>
    <p><input type="text" name="expensas" id="expensas" value="<?php echo $this->_tpl_vars['form']['Expensas']; ?>
" /></p> 
    
    <h4>Otros Datos</h4>
    <p><input type="text" name="otros_datos" id="otros_datos" value="<?php echo $this->_tpl_vars['form']['Otros_datos']; ?>
" /></p>  
</div>

<h4>Destacado</h4>
<p style="font-style:italic;">(Se muestra en listados de busqueda y en la seccion Propiedades)</p>
<p><input type="radio" name="destacado" <?php if ($this->_tpl_vars['form']['Destacado'] == 1): ?>checked="checked"<?php endif; ?> value="1" class="check">Si
<input type="radio" name="destacado" <?php if ($this->_tpl_vars['form']['Destacado'] != 1): ?>checked="checked"<?php endif; ?> value="0" class="check">No</p>   

<h4>Home</h4>
<p style="font-style:italic;">(Se muestra en bloques en la Home)</p>
<p><input type="radio" name="home" <?php if ($this->_tpl_vars['form']['Home'] == 1): ?>checked="checked"<?php endif; ?> value="1" class="check">Si
<input type="radio" name="home" <?php if ($this->_tpl_vars['form']['Home'] != 1): ?>checked="checked"<?php endif; ?> value="0" class="check">No</p>   
 
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

<?php echo '
<script type="text/javascript">
function borrarImagenAdicional(id_adicional){
	$.get(\'index.php?do=eliminarimagenadicional&id=\'+id_adicional, function(res){
		if(res == \'ok\'){
			$(\'#container_adicional_\'+id_adicional).remove();
		}else{
			alert("Ocurrio un error");
		}
	});
}
</script>
'; ?>