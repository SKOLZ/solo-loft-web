<?php /* Smarty version 2.6.26, created on 2013-03-25 23:33:21
         compiled from file:../modulos/productos/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'file:../modulos/productos/view.tpl', 23, false),)), $this); ?>
<h4>Titulo</h4>
<p><?php echo $this->_tpl_vars['form']['Titulo']; ?>
</p>

<!--<h4>Colores</h4> 
    <p>
           <?php $_from = $this->_tpl_vars['colores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['color']):
?>
        	<input type="checkbox" name="id_color[<?php echo $this->_tpl_vars['color']['ID_Color']; ?>
]"  disabled="disabled" value="1" class="check" <?php if ($this->_tpl_vars['color']['Seleccionada'] > 0): ?>checked="checked" <?php endif; ?> /><img src="../../../upload/colores/<?php echo $this->_tpl_vars['color']['ID_Color']; ?>
_th.<?php echo $this->_tpl_vars['color']['Img_Ext']; ?>
" alt="<?php echo $this->_tpl_vars['color']['Color']; ?>
" /><br />
           <?php endforeach; endif; unset($_from); ?>
        </select>
</p>-->

<h4>Categoria</h4>
<p><?php echo $this->_tpl_vars['form']['Categoria']; ?>
</p>

<h4>Encabezado</h4>
<p><?php echo $this->_tpl_vars['form']['Encabezado']; ?>
</p>

<h4>Descripcion</h4>
<p><?php echo $this->_tpl_vars['form']['Descripcion']; ?>
</p>

<h4>Imagen</h4>
 <p>
<?php if (file_exists ( ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="../../../upload/productos/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['form']['ID_Producto']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['form']['ID_Producto'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "_th.") : smarty_modifier_cat($_tmp, "_th.")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['form']['Img_Ext']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['form']['Img_Ext'])) )): ?>
     <img src="../../../upload/productos/<?php echo $this->_tpl_vars['form']['ID_Producto']; ?>
_th.<?php echo $this->_tpl_vars['form']['Img_Ext']; ?>
" />
  <?php else: ?>
             Imagen no disponible
   <?php endif; ?>
</p>

<h4>Imagenes adicionales</h4>
<p>
<?php if ($this->_tpl_vars['imagenes_adicionales'] > 0): ?>
	<?php $_from = $this->_tpl_vars['imagenes_adicionales']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['imagen']):
?>
	<img src="../../../upload/productos/adicionales/<?php echo $this->_tpl_vars['imagen']['ID_Imagen_Adicional']; ?>
_detalle.<?php echo $this->_tpl_vars['imagen']['Img_Ext']; ?>
" width="720" style="margin-bottom:20px;" />
	<?php endforeach; endif; unset($_from); ?>
	
  <?php else: ?>
             No se encontraron Imagenes Adicionales
<?php endif; ?>
</p>

<!--DATOS PARA COMPLEJO-->
<div id="complejo_view" style="display:none;">
    <h4>Ubicaci&oacute;n</h4>
    <p><?php echo $this->_tpl_vars['form']['Ubicacion']; ?>
</p>
    
    <h4>Servicios</h4>
    <p><?php echo $this->_tpl_vars['form']['Servicios']; ?>
</p>
    
    <h4>Superficie total</h4>
    <p><?php echo $this->_tpl_vars['form']['Superficie_total']; ?>
</p>
    
    <h4>Altura y cantidad de pisos</h4>
    <p><?php echo $this->_tpl_vars['form']['Altura_pisos']; ?>
</p>
    
    <h4>Cantidad de unidades</h4>
    <p><?php echo $this->_tpl_vars['form']['Cantidad_unidades']; ?>
</p>
    
    <h4>Cantidad de cocheras</h4>
    <p><?php echo $this->_tpl_vars['form']['Cocheras']; ?>
</p>
    
    <h4>Etapa de construcci&oacute;n y finalizaci&oacute;n</h4>
    <p><?php echo $this->_tpl_vars['form']['Etapa_construccion']; ?>
</p>
</div>

<!--DATOS PARA DEPARTAMENTO-->
<div id="departamento_view" style="display:none;">
    <h4>Categoria Departamento</h4>
    <p><?php echo $this->_tpl_vars['form']['Categoria_Departamento']; ?>
</p>
    
    <h4>Complejo al que pertenece</h4>
    <p><?php $_from = $this->_tpl_vars['complejos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['complejo']):
?>
    <?php if ($this->_tpl_vars['form']['ID_Perteneciente'] == $this->_tpl_vars['complejo']['ID_Producto']): ?><?php echo $this->_tpl_vars['complejo']['Titulo']; ?>
<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?></p>
    
    <h4>Cantidad de ambientes</h4>
    <p><?php echo $this->_tpl_vars['form']['Cantidad_ambientes']; ?>
</p>
    
    <h4>Superficie departamento</h4>
    <p><?php echo $this->_tpl_vars['form']['Superficie_dto']; ?>
</p>
    
    <h4>Apto profesional</h4>
    <p><?php if ($this->_tpl_vars['form']['Apto_profesional'] == 1): ?>Si<?php else: ?>No<?php endif; ?></p> 
    
    <h4>Servicios del departamento</h4>
    <p><?php echo $this->_tpl_vars['form']['Servicios_dto']; ?>
</p>
    
    <h4>Expensas</h4>
    <p><?php echo $this->_tpl_vars['form']['Expensas']; ?>
</p>
    
    <h4>Otros Datos</h4>
    <p><?php echo $this->_tpl_vars['form']['Otros_datos']; ?>
</p>
</div>

<h4>Destacado</h4>
<p><?php if ($this->_tpl_vars['form']['Destacado'] == 1): ?>Si<?php else: ?>No<?php endif; ?></p> 

<h4>Home</h4>
<p><?php if ($this->_tpl_vars['form']['Novedades'] == 1): ?>Si<?php else: ?>No<?php endif; ?></p> 

<h4>Online</h4>
<p><?php if ($this->_tpl_vars['form']['Online'] == 1): ?>Si<?php else: ?>No<?php endif; ?></p> 

<div class="Center">
    <a class="BtnEditar">Editar</a>
    <a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a>
</div>