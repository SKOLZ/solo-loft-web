<?php /* Smarty version 2.6.26, created on 2013-03-13 21:29:28
         compiled from file:../modulos/productos_categorias/view.tpl */ ?>
<h4>Categoria</h4>
<p><?php echo $this->_tpl_vars['form']['Categoria']; ?>
</p>

<h4>Online</h4>
<p><?php if ($this->_tpl_vars['form']['Online'] == 1): ?>Si<?php else: ?>No<?php endif; ?></p> 

<div class="Center">
    <a class="BtnEditar">Editar</a>
    <a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a>
</div>