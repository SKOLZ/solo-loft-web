<?php /* Smarty version 2.6.26, created on 2013-02-05 21:13:54
         compiled from includes/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'onas', 'includes/header.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_onas(array(), $this);?>
<div id="contenedor">
<div id="borde" class="bordes">

<div id="header" class="bordes-top bloque">
<div class="bloque">
	<p class="left">
    <?php if (! $this->_tpl_vars['UNBRAND']): ?>
    <a href="<?php echo $this->_tpl_vars['PATH']; ?>
home.php" name="subir" id="subir"><img src="<?php echo $this->_tpl_vars['PATH']; ?>
images/logo-woodstock.png" alt="" class="left" /></a>
    <?php endif; ?>
    </p>
	<p class="right" style="display:none">ONAS 3.0</p>
</div>
</div>