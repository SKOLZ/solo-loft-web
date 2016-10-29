{include file="includes/top.tpl"}
<title>Onas 3.0</title>


</head>
<body>

{include file="includes/header.tpl"}

<div id="contenido" class="bloque">
	{include file="includes/login.tpl"}
	{include file="includes/menu.tpl"}
    
    <div id="contenido-central">
    
	<div class="bloque bordes" id="grad1"><h3>{$nombre_modulo}</h3></div>    
    
    
<div class="bloque marginT">
    

<div id="editar-box" class="bloque">
	<div class="bordes-top bloque grad"><h4 class="alta-icon">{$subtitulo_modulo}</h4></div>   
	<div id="editar" class="bloque bordes-bot">
    <div style="width:700px; margin:0 auto;">
    
<div  class="bloque" id="campos">
    
<div class="bloque Mensaje2">
    <span>{$mensaje} 
    <a href="{$mensaje_link}">{$mensaje_boton}</a>
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

{include file="includes/footer.tpl"}
