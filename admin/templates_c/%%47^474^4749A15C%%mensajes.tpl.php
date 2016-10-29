<?php /* Smarty version 2.6.26, created on 2013-03-13 21:28:59
         compiled from mensajes.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>Onas 3.0</title>


</head>
<body>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="contenido" class="bloque">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    
    <div id="contenido-central">
    
	<div class="bloque bordes" id="grad1"><h3><?php echo $this->_tpl_vars['nombre_modulo']; ?>
</h3></div>    
    
    
<div class="bloque marginT">
    

<div id="editar-box" class="bloque">
	<div class="bordes-top bloque grad"><h4 class="alta-icon"><?php echo $this->_tpl_vars['subtitulo_modulo']; ?>
</h4></div>   
	<div id="editar" class="bloque bordes-bot">
    <div style="width:700px; margin:0 auto;">
    
<div  class="bloque" id="campos">
    
<div class="bloque Mensaje2">
    <span><?php echo $this->_tpl_vars['mensaje']; ?>
 
    <a href="<?php echo $this->_tpl_vars['mensaje_link']; ?>
"><?php echo $this->_tpl_vars['mensaje_boton']; ?>
</a>
    </span>
</div>

</div>
</div>
</div> 
</div>
<!-- fin Editar -->
    

    
</div>
    
    



    

	</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>