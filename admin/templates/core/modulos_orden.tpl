{include file="includes/top.tpl"}
<title>Onas 3.0</title>
{literal}
<script type="text/javascript">
// Over the las filas de la tabla
jQuery(document).ready(
function(){
	jQuery(".overs tr").mouseover(
		function() {
			jQuery(this).addClass("over");
		}).mouseout(
			function() {
				jQuery(this).removeClass("over");});
				jQuery(".overs tr:even").addClass("alt");
});

</script>
<script type="text/javascript" src="js/jquery.tablednd_0_5.js"></script>
{/literal}
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
				<div class="bordes-top bloque grad">
        			<h4 class="alta-icon">{$subtitulo_modulo}</h4>
                </div>   
				<div id="editar" class="bloque bordes-bot">
    				<div style="width:400px; margin:0 auto;">
                    	<p><span class="celeste"><strong>&raquo;</strong></span> Recuerde revisar previamente el alta de todos los datos a ingresar.</p>
					</div>
					<div  class="bloque" id="campos">
    					<div style="width:400px; margin:0 auto;">
							<p class="Arbol">Arbol de Jerarqu&iacute;as</p>
							{$html_arbol_modulos}
                            <form action="modulos.php" method="post" name="formData" id="formData">
                                <input type="hidden" name="secuenceData" id="secuenceData" value="" />
                                <input type="hidden" name="identationData" id="identationData" value="" />
                                <input type="hidden" name="do" id="do" value="orden" />
                            </form>

							<div class="Arbol">
                                {if $CAMBIOS_GUARDADOS}
                                <div class="Mensaje marginT bloque">
                                    <span>Los cambios han sido guardados</span>
                                </div>
                                {/if}
							&nbsp;</div>

							<!--<a href="#" onClick="exponer(); return false">debug: dump vars</a>| -->
							<p style="text-align:center"><a href="modulos.php" class="BtnModulos">Volver</a>
							<span style="padding:0 3px 3px; display:inline-block;">|</span>
							<a href="#" onClick="guardar(); return false" class="BtnModulos">Guardar los cambios</a></p>
    					</div>
					</div>
				</div> 
    		</div>
			<!-- fin Editar -->
    	</div>
	</div>
</div>


{literal}
<script language="JavaScript">
function moverLi(id){
	val = (40 * parseInt($('#indent_'+id).val()).toString()) +'px';
	$('#'+id).css('paddingLeft', val);	
}

function setearIndentacion(id, indentacion){
	$('#indent_'+id).value = indentacion;
    moverLi(id);
}

function indentar(id, derecha){
	if(derecha){
	    $('#indent_'+id).val(parseInt($('#indent_'+id).val())+1);
	}else{
	    if($('#indent_'+id).val() > 0){
        	$('#indent_'+id).val(parseInt($('#indent_'+id).val())-1);
        }
	}
    moverLi(id);
    controlarIndentacion();
}

function controlarIndentacion() {
    var id_anterior = 0;
    var indentacion_anterior = null;
    var indentacion_actual = 0;
	$('.liorden').each(function(){
		indentacion_actual = parseInt($(this).val());
		if(indentacion_actual > parseInt(indentacion_anterior) +1){
			setearIndentacion('li_'+id, parseInt(indentacion_anterior)+1);
		}
		if(indentacion_anterior == null && indentacion_actual > 0){
			setearIndentacion('li_'+id, 0);
		}
		id_anterior = $(this).id;
		indentacion_anterior = indentacion_actual;
	
	});
}

function guardar(){
    $('#identationData').val($('#indentacion').serialize());
    $('#secuenceData').val($('#sortable_list').tableDnDSerialize());
	$('#formData').submit();
}


$("#sortable_list").tableDnD();
</script>
{/literal}

{include file="includes/footer.tpl"}