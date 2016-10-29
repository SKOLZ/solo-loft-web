{include file="includes/top.tpl"}
<title>Onas 3.0</title>

{if $activar_edicion}
	{if $modulo_core}
		<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
		<script type="text/javascript" src="js/messages_es.js"></script>
		<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="js/ckeditor/adapters/jquery.js"></script>
	{else}
		<script type="text/javascript" src="../../js/jquery.validate.pack.js"></script>
		<script type="text/javascript" src="../../js/messages_es.js"></script>
		<script type="text/javascript" src="../../js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="../../js/ckeditor/adapters/jquery.js"></script>
		<script type="text/javascript" src="../../js/ui.core.js"></script>
		<script type="text/javascript" src="../../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="../../js/colorpicker.js"></script>
        

    


<link rel="stylesheet" media="screen" type="text/css" href="../../css/colorpicker.css" />

   
<script type="text/javascript">
{literal}

function removeColorPickerItem(el){
	$(el).parent().parent().remove();
	updateColorPickerItemList(el.id.substring(3));
}

function updateColorPickerItemList(){
	$(".sortable").sortable(
		 {
		 update: updateColorPickerItemList
		 }
	);
	
	$(".sortable").disableSelection();
	str = '';
	$("#ul_colorpicker li").each( 
		function(index, value){ 
			str += value.id + ',';
		} 
	);
	$("#fld_colorpicker").val(str);
}

$(function() {
	$('.multipleColorSelector').ColorPicker({
		
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onSubmit: function (hsb, hex, rgb, el){
			suffix = el.id.substring(3);
			$(el).ColorPickerHide();
			$("#ul_colorpicker").append('<li class="ui-state-default" id="'+ hex +'"><span class="ui-icon ui-icon-arrowthick-2-n-s"><span style="background-color:#'+ hex +'; color:#'+ hex +'" class="color-picker">#'+ hex +'</span><span class="numero-color">#'+ hex +'</span><a href="#" onclick="removeColorPickerItem(this); return false;">quitar</a></span></li>');
			updateColorPickerItemList();
		}
	});
	
	$(".sortable").sortable(
		 {
		 update: updateColorPickerItemList
		 }
	);
	
 });



CKEDITOR.config.toolbar_Full =
[
    ['Cut','Copy','Paste','PasteText','PasteFromWord','Source'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	'/',
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink'],
    ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak'],
    '/',
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize']
];
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
{/literal}
</script>
	{/if}
{/if}


{if $activar_ordenar}
<script type="text/javascript" src="../../js/jquery.tablednd_0_5.js"></script>

{/if}

{literal}
<script type="text/javascript">
// Over the las filas de la tabla
jQuery(document).ready(
function(){
	$(".BtnEditar").attr('href', location.href.replace('view', "form"));
	
	$("#tabla_ordenar tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
    });
	
	{/literal}
	{if $activar_edicion}
	{literal}
	$("#form_onas").validate();
	$(".editor").ckeditor({
				width: '600px',
				language: 'es'
				});
	{/literal}
	{/if}
	{if $activar_ordenar}
		 $("#tabla_ordenar").tableDnD();
		 {literal}
		 $('#btn_ordenar').click(function(){
		 	$.post('../../ajax.php?function=setorden{/literal}&nombre_tabla={$nombre_tabla}&campo_orden={$campo_orden}&primary_key={$primary_key}{literal}', $('#tabla_ordenar').tableDnDSerialize(), function(res){
		 		eval(res);
		 	});
		 });
		 $("#tabla_ordenar tr:even").addClass("ordenar_alt");

		 {/literal}
	{/if}
	{literal}
	jQuery(".overs tr").mouseover(
		function() {
			jQuery(this).addClass("over");
		}).mouseout(
			function() {
				jQuery(this).removeClass("over");});
				jQuery(".overs tr:even").addClass("alt");
});

function cambiarTipoModulo(){
	$('#ul_usuarios').load('ajax.php?function=listausuarios&tipo='+ $('#id_tipo').val());
}
</script>
{/literal}

{if $jcrop}
<link href="../../css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.Jcrop.js"></script>
<script type="text/javascript">
	var ancho	= {$IMAGENES.dimensiones[0].ancho};
	var alto	= {$IMAGENES.dimensiones[0].alto};
	{literal}
	$(window).load(function(){
	    $(function() {
	        $('#cropbox').Jcrop({
	            onChange: medidas,
				onSelect: medidas,
				aspectRatio:ancho/alto,
	            setSelect:   [ 0, 0, ancho, alto ]
	        });
	    });
	});
	
	function medidas(c){
		document.getElementById('ancho').value=c.w;
		document.getElementById('alto').value=c.h;
		document.getElementById('x').value=c.x;
		document.getElementById('y').value=c.y;
	};
	{/literal}
</script>
{/if}
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
    	<h4 class="alta-icon">{$subtitulo_modulo}</h4></div>   



<div class="bloque" style="background:#FFFFFF">
<div id="View" class="Format">
	{if $activar_edicion}
	<p class="Memo"><span>&raquo;</span> Recuerde revisar previamente el alta de todos los datos a ingresar.</p>
    {elseif $activar_ordenar}
	<p class="Memo"><span>&raquo;</span> Arrastre los elementos en el orden que desee, luego haga click en el bot&oacute;n "Ordenar".</p>
    {else}
    <p>&nbsp;</p>
    {/if}
	{include file=$form_body}
    
</div>

</div>
</div>
</div> 
</div>
<!-- fin Editar -->
    

    
</div>



{include file="includes/footer.tpl"}