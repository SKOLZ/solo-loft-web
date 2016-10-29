<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="{$PATH}css/estilo.css" rel="stylesheet" type="text/css" />
<link href="{$PATH}css/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
{if $jcrop}
<link href="{$PATH}css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
{/if}
<script type="text/javascript" src="{$PATH}js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="{$PATH}js/jquery.corner.js"></script>
<script type="text/javascript">
{literal}
	function keepAlive(){
		$.post('{/literal}{$PATH}{literal}ajax.php?function=ping');
	}	
	
	$(function(){	// shorthand for $(document).ready() BTW
        $('div.bordes').each(function() {
			$(this).corner("6px");
        });
		$('div.bordes-top').each(function() {
			$(this).corner("top");
        });
		$('div.bordes-bot').each(function() {
			$(this).corner("bottom");
        });
		setInterval("keepAlive()", 240000);
	});
{/literal}	
</script>
<script type="text/javascript" src="{$PATH}js/jquery.dimensions.js"></script>
<script type="text/javascript" src="{$PATH}js/jquery.gradient.js"></script>
<script type="text/javascript">
{literal}
	$(function() {
		$('.grad').gradient({
			from:'006dc4', to:'005490',direction: 'horizontal'
		});
		$('.grad-top').gradient({
			from:'d5d5d5', to:'ffffff',direction: 'horizontal'
		});
	});
{/literal}			
</script>
<script type="text/javascript" src="{$PATH}js/gradient.js"></script>
<script type="text/javascript" src="{$PATH}js/menu.js"></script>
<script type="text/javascript" src="{$PATH}js/jquery.colorbox-min.js"></script>
<script type="text/javascript">
	{literal}
			$(document).ready(function(){
				$("#colorbox_rel").colorbox({opacity:"0.6", width:"50%", height:"80%", inline:true, href:"#buscar_relacionados"});				
				$('.table_relacionados a').click(function(){
                	$(this).parent().parent().remove();
        		});
				mostrarBloque($('#id_categoria').val());
				
				var categoria = "{/literal}{$form.Categoria}{literal}";
				
				if(categoria=="Complejo"){
					$('#complejo_view').show();
					$('#departamento_view').hide();
				}else if(categoria == "Depto."){
					$('#complejo_view').hide();
					$('#departamento_view').show();
				}else if(categoria == "Local"){
					$('#complejo_view').hide();
					$('#departamento_view').show();
				}else if(categoria == "Oficina"){
					$('#complejo_view').hide();
					$('#departamento_view').show();
				}else if(categoria == "Loft"){
					$('#complejo_view').hide();
					$('#departamento_view').show();
				}else if(categoria=="Casa"){
					$('#complejo_view').show();
					$('#departamento_view').hide();
				}else if(categoria=="Fondo de Comercio"){
					$('#complejo_view').show();
					$('#departamento_view').hide();
				}else if(categoria=="Galpón"){
					$('#complejo_view').show();
					$('#departamento_view').hide();
				}
			});
	{/literal}
</script>
{if !$modulo_core}
<script type="text/javascript" src="{$PATH}js/ui.core.js"></script>
<script type="text/javascript" src="{$PATH}js/ui.datepicker.js"></script>
<script type="text/javascript" src="{$PATH}js/jquery-ui-1.7.2.custom.min.js"></script>
{literal}
<script type="text/javascript">
$(function() {
        $(".calendar").datepicker($.extend({showOtherMonths: true, selectOtherMonths: true, changeMonth: true, changeYear: true, showOn: 'both', buttonImageOnly: true, buttonText: '', buttonImage: '../../css/images/calendario2.jpg'}, $.datepicker.regional['es']));
});
</script>
{/literal}
{/if}
<script type="text/javascript">
	{literal}
			function mostrarBloque(value){
				if (value == 1){
					$('#departamento').hide();
					$('#complejo').show();
				} else if (value == 3){
					$('#departamento').hide();
					$('#complejo').show();
				} else if (value == 6){
					$('#departamento').hide();
					$('#complejo').show();
				} else if (value == 2){
					$('#complejo').hide();
					$('#departamento').show();
				} else if (value == 4){
					$('#complejo').hide();
					$('#departamento').show();
				} else if (value == 5){
					$('#complejo').hide();
					$('#departamento').show();
				} else if (value == 7){
					$('#complejo').hide();
					$('#departamento').show();
				} else if (value == 8){
					$('#complejo').hide();
					$('#departamento').show();
				}
			}
	{/literal}
</script>
<!--[if IE 6]>
	<script type="text/javascript" src="{$PATH}js/pngfix.js"></script>
<![endif]-->