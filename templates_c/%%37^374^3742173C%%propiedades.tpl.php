<?php /* Smarty version 2.6.26, created on 2016-06-29 12:26:31
         compiled from propiedades.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'propiedades.tpl', 40, false),array('modifier', 'cat', 'propiedades.tpl', 49, false),array('function', 'querystring', 'propiedades.tpl', 83, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/inicia.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body style="">
        <div id="page-holder" class="page-holder-home">
        
            <div id="content" style=" height:752px; width:100%; background:url(<?php echo $this->_tpl_vars['SITE_PATH']; ?>
img/seccion_back.jpg);">
                
                <div id="main-logo" style="height:752px !important;">
                	<a href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
"><img src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
img/solo-loft-roca-consultora.png" alt=""></a>
                	<form action="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
resultados.php" method="get" id="search-theme-form">
                        <div>
                            <input maxlength="128" name="busqueda" size="23" title="" class="form-text buscar_input" type="text" value="" onFocus="eFocus(this)" onBlur="eBlur(this)" />
                            <input name="op" class="form-submit" value="" type="submit" />
                        </div>
                    </form>
                    
                    <ul id="menu-roca">
                    	<a href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
"><li>NOSOTROS</li></a>
                        <a href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
propiedades.php"><li class="active">PROPIEDADES</li></a>
                        <?php if ($this->_tpl_vars['activar_complejo']): ?>
                        <a class="submenu" href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
propiedades.php?id_categoria=complejos">
                        	<li<?php if ($this->_tpl_vars['complejos_active']): ?> class="active_sub"<?php endif; ?>>COMPLEJOS</li>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['activar_ventas']): ?>
                        <a class="submenu" href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
propiedades.php?id_categoria=ventas">
                        	<li<?php if ($this->_tpl_vars['ventas_active']): ?> class="active_sub"<?php endif; ?>>VENTAS</li>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['activar_alquileres']): ?>
                        <a class="submenu" href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
propiedades.php?id_categoria=alquileres">
                        	<li<?php if ($this->_tpl_vars['alquileres_active']): ?> class="active_sub"<?php endif; ?>>ALQUILERES</li>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['activar_temporales']): ?>
                        <a class="submenu" href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
propiedades.php?id_categoria=temporales">
                        	<li<?php if ($this->_tpl_vars['temporales_active']): ?> class="active_sub"<?php endif; ?>>TEMPORALES</li>
                        </a>
                        <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['categorias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categoria']):
?>
                        <a class="submenu" href="propiedades.php?id_categoria=<?php echo $this->_tpl_vars['categoria']['ID_Categoria']; ?>
"><li<?php if ($this->_tpl_vars['categoria_activa'] == $this->_tpl_vars['categoria']['ID_Categoria']): ?> class="active_sub"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['categoria']['Categoria'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</li></a>
                        <?php endforeach; endif; unset($_from); ?>
                        <a href="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
contacto.php"><li>CONTACTO</li></a>
                    </ul>
                </div>
                
                <?php $_from = $this->_tpl_vars['destacados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['destacado']):
?>
                <div class="destacado_mes">
                    
                    <?php if (file_exists ( ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="upload/productos/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['destacado']['ID_Producto']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['destacado']['ID_Producto'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "_detalle.") : smarty_modifier_cat($_tmp, "_detalle.")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['destacado']['Img_Ext']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['destacado']['Img_Ext'])) )): ?>
                    	<img class="img_destacado" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
upload/productos/<?php echo $this->_tpl_vars['destacado']['ID_Producto']; ?>
_detalle.<?php echo $this->_tpl_vars['destacado']['Img_Ext']; ?>
" width="185" height="184" alt="<?php echo $this->_tpl_vars['destacado']['Titulo']; ?>
" style="float:left;">
                    <?php else: ?>
                    	<img class="img_destacado" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
img/imagen-no-disp-185x184.jpg" width="185" height="184" alt="<?php echo $this->_tpl_vars['destacado']['Titulo']; ?>
" style="float:left;">
                    <?php endif; ?>
                    
                	<h4 class="data-title title">
                    	DESTACADO DEL MES
                    </h4>
                	<h4 class="data-title title">
                    	<?php echo ((is_array($_tmp=$this->_tpl_vars['destacado']['Titulo'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
<br><span class="h4-resaltado">/COMPLEJO</span>
                    </h4>
                    <dl class="first data-client">
                    	<dd><?php echo ((is_array($_tmp=$this->_tpl_vars['destacado']['Encabezado'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</dd>
                    </dl>
                </div>
                <?php endforeach; endif; unset($_from); ?>
                
                <div class="propiedad_content">
                
                	<?php $_from = $this->_tpl_vars['complejo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['complex']):
?>
                	<a href="detalle.php?id=<?php echo $this->_tpl_vars['complex']['ID_Producto']; ?>
"><div class="propiedad_thumb">
                    	<?php if (file_exists ( ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="upload/productos/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['complex']['ID_Producto']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['complex']['ID_Producto'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "_th.") : smarty_modifier_cat($_tmp, "_th.")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['complex']['Img_Ext']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['complex']['Img_Ext'])) )): ?>
                        <img src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
upload/productos/<?php echo $this->_tpl_vars['complex']['ID_Producto']; ?>
_th.<?php echo $this->_tpl_vars['complex']['Img_Ext']; ?>
" width="135" alt="<?php echo $this->_tpl_vars['complex']['Titulo']; ?>
" style="float:left;">
                        <?php else: ?>
                        <img src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
img/imagen-no-disp-155x155.jpg" width="135" alt="<?php echo $this->_tpl_vars['complex']['Titulo']; ?>
" style="float:left;">
                        <?php endif; ?>
                        <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['complex']['Titulo'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
<br />
                        <span><?php $_from = $this->_tpl_vars['categorias_item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categorias_items']):
?><?php if ($this->_tpl_vars['categorias_items']['ID_Categoria'] == $this->_tpl_vars['complex']['ID_Categoria']): ?>/<?php echo $this->_tpl_vars['categorias_items']['Categoria']; ?>
<?php endif; ?><?php endforeach; endif; unset($_from); ?></span></h2>
                    </div></a>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php if ($this->_tpl_vars['paginador_total_paginas'] > 1): ?>	
                        <div class="paginador">
                            <?php if ($this->_tpl_vars['paginador_pagina_actual'] > 1): ?>
                                <a href="<?php echo smarty_function_querystring(array('pag' => $this->_tpl_vars['paginador_pagina_actual']-1), $this);?>
" title="Anterior" class="previous">&lt; anterior</a>
                            <?php endif; ?>
                            <?php unset($this->_sections['loop_paginador']);
$this->_sections['loop_paginador']['name'] = 'loop_paginador';
$this->_sections['loop_paginador']['start'] = (int)$this->_tpl_vars['paginador_loop_start'];
$this->_sections['loop_paginador']['loop'] = is_array($_loop=$this->_tpl_vars['paginador_loop_end']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop_paginador']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['loop_paginador']['show'] = true;
$this->_sections['loop_paginador']['max'] = $this->_sections['loop_paginador']['loop'];
if ($this->_sections['loop_paginador']['start'] < 0)
    $this->_sections['loop_paginador']['start'] = max($this->_sections['loop_paginador']['step'] > 0 ? 0 : -1, $this->_sections['loop_paginador']['loop'] + $this->_sections['loop_paginador']['start']);
else
    $this->_sections['loop_paginador']['start'] = min($this->_sections['loop_paginador']['start'], $this->_sections['loop_paginador']['step'] > 0 ? $this->_sections['loop_paginador']['loop'] : $this->_sections['loop_paginador']['loop']-1);
if ($this->_sections['loop_paginador']['show']) {
    $this->_sections['loop_paginador']['total'] = min(ceil(($this->_sections['loop_paginador']['step'] > 0 ? $this->_sections['loop_paginador']['loop'] - $this->_sections['loop_paginador']['start'] : $this->_sections['loop_paginador']['start']+1)/abs($this->_sections['loop_paginador']['step'])), $this->_sections['loop_paginador']['max']);
    if ($this->_sections['loop_paginador']['total'] == 0)
        $this->_sections['loop_paginador']['show'] = false;
} else
    $this->_sections['loop_paginador']['total'] = 0;
if ($this->_sections['loop_paginador']['show']):

            for ($this->_sections['loop_paginador']['index'] = $this->_sections['loop_paginador']['start'], $this->_sections['loop_paginador']['iteration'] = 1;
                 $this->_sections['loop_paginador']['iteration'] <= $this->_sections['loop_paginador']['total'];
                 $this->_sections['loop_paginador']['index'] += $this->_sections['loop_paginador']['step'], $this->_sections['loop_paginador']['iteration']++):
$this->_sections['loop_paginador']['rownum'] = $this->_sections['loop_paginador']['iteration'];
$this->_sections['loop_paginador']['index_prev'] = $this->_sections['loop_paginador']['index'] - $this->_sections['loop_paginador']['step'];
$this->_sections['loop_paginador']['index_next'] = $this->_sections['loop_paginador']['index'] + $this->_sections['loop_paginador']['step'];
$this->_sections['loop_paginador']['first']      = ($this->_sections['loop_paginador']['iteration'] == 1);
$this->_sections['loop_paginador']['last']       = ($this->_sections['loop_paginador']['iteration'] == $this->_sections['loop_paginador']['total']);
?>
                                 <?php if ($this->_sections['loop_paginador']['index'] > 1): ?> - <?php endif; ?><a href="<?php echo smarty_function_querystring(array('pag' => $this->_sections['loop_paginador']['index']), $this);?>
"<?php if ($this->_tpl_vars['paginador_pagina_actual'] == $this->_sections['loop_paginador']['index']): ?> class="activo" title="Página actual"<?php endif; ?>><span><?php echo $this->_sections['loop_paginador']['index']; ?>
</span></a>
                            <?php endfor; endif; ?>
                            <?php if ($this->_tpl_vars['paginador_pagina_actual'] < $this->_tpl_vars['paginador_total_paginas']): ?>
                                <a href="<?php echo smarty_function_querystring(array('pag' => $this->_tpl_vars['paginador_pagina_actual']+1), $this);?>
" title="Siguiente" class="next">siguiente &gt;</a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['paginador_mostrar_resumen']): ?>
                        	<div class="paginador-resumen"><?php echo $this->_tpl_vars['paginador_total_registros']; ?>
 <?php echo $this->_tpl_vars['nombre_unidades']; ?>
. P&aacute;gina <?php echo $this->_tpl_vars['paginador_pagina_actual']; ?>
 de <?php echo $this->_tpl_vars['paginador_total_paginas']; ?>
.</div>
                        	<?php endif; ?>
                        </div>
                        
                    <?php endif; ?>
                    
                </div>
            </div>

            <div id="sub-main-stage">
                <div id="sub-content" style="height:380px;">
                	<div class="center-boxing">
                        <div class="box-content">
                          <h3>TRAYECTORIA</h3>
                            <p><span>Consultora Roca Real Estate, desde 1992 desarrolla su actividad  de asesoramiento a peque&ntilde;os y grandes  inversores en el rubro inmobiliarios.</span></p>
                          <p>Tanto en el desarrollo de complejos habitacionales como en la compra de una unidad de vivienda, encierran en s&iacute; mismo una inversi&oacute;n de ahorros y una potencial inversi&oacute;n. Por esta raz&oacute;n el asesoramiento a la hora de invertir o comprar es fundamental para aplicar correctamente los ahorros.</p>
                        </div>
                        <div class="box-content">
                          <h3>NOSOTROS</h3>
                          <p><span>Un grupo de profesionales  especializados  en el rubro  brindan una correcta &oacute;ptica de los aspectos comerciales, contables e impositivos que confluyen en una operaci&oacute;n inmobiliaria.</span></p>
                            <p>Tanto para la confecci&oacute;n de contratos, valuaciones, estudios de factibilidad negocios inmobiliarios, o evaluaci&oacute;n de proyectos constructivos, Consultora Roca Real Estate pone a disposici&oacute;n de sus clientes  la experiencia y la idoneidad necesaria para una correcta toma de decisiones.</p>
                        </div>
                        <div class="box-content ultima">
                          <h3>SERVICIOS</h3>
                            <p><span>&#8226; VENTAS<br />
                            &#8226; ALQUILERES<br />
                            &#8226; TASACIONES<br />
                            &#8226; PROYECTOS DE FACTIBILIDAD<br />
                            &#8226; ADMINISTRACION DE PROPIEDADES<br />
                            &#8226; GESTION EN HABILITACIONES<br />
                            &#8226; GESTION Y ADMINISTRACION DE PROYECTOS INMOBILIARIOS<br />
                            &#8226; EVALUACION DE CONTRATOS Y GARANTIAS</span></p>
                        </div>
                	</div>
                </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/finaliza.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>