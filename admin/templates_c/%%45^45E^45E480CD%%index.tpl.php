<?php /* Smarty version 2.6.26, created on 2013-02-05 21:13:44
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'onas', 'index.tpl', 5, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>Onas 3.0</title>
</head>
<body class="login">
<?php echo smarty_function_onas(array(), $this);?>

<div id="container">

<div id="content" class="bloque">

<div class="bloque grad-top" id="top-login">
	<img src="images/onas-logo-login.png" alt="Onas Content Management" />
</div>
<div class="bloque" id="login">

<?php if ($this->_tpl_vars['mensaje_error'] != ''): ?>
<div class="Mensaje bloque" style="margin-bottom:20px;">
	<span><?php echo $this->_tpl_vars['mensaje_error']; ?>
</span>
</div>       
<?php endif; ?>

<form action="" method="post">
<p>
Nombre de Usuario<br />
<input type="text" name="user" />
</p>
<p>
Contrase&ntilde;a<br />
<input type="password" name="pass" />
</p>
<p style="text-align:center;">
	<input type="submit" name="submit" value="Ingresar" class="login-btn" />
</p>
</form>
</div>

<div id="creditos" class="bloque grad">
<p>Onas&trade; es un producto registrado, todos sus derechos reservados.
Prohibida su reproducci&oacute;n total o parcial.</p>
</div>


</div>
</div>
</body>
</html>