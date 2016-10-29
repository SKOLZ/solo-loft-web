{include file="includes/top.tpl"}
<title>Onas 3.0</title>
</head>
<body class="login">
{onas}
<div id="container">

<div id="content" class="bloque">

<div class="bloque grad-top" id="top-login">
	<img src="images/onas-logo-login.png" alt="Onas Content Management" />
</div>
<div class="bloque" id="login">

{if $mensaje_error != ''}
<div class="Mensaje bloque" style="margin-bottom:20px;">
	<span>{$mensaje_error}</span>
</div>       
{/if}

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
