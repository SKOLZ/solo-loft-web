<?php /* Smarty version 2.6.26, created on 2013-03-27 11:14:54
         compiled from core/usuarios_view.tpl */ ?>
<h4>Nombre</h4>
<p><?php echo $this->_tpl_vars['usuario']['Nombre']; ?>
</p>

<h4>Apellido</h4>
<p><?php echo $this->_tpl_vars['usuario']['Apellido']; ?>
</p>

<h4>Usuario</h4>
<p><?php echo $this->_tpl_vars['usuario']['Username']; ?>
</p>

<h4>Permisos</h4>
<div class="listar_permisos"><ul><?php echo $this->_tpl_vars['permisos']; ?>
</ul></div>

<div class="Center"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></div>