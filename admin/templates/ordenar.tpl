<form action="" method="post" id="form_ordenar" name="form_ordenar">
    <table id="tabla_ordenar" cellspacing="0" cellpadding="2" style="width:100);clear:both">
    	{strip}
		{foreach from=$items item=item}
		<tr id="{$item[$primary_key]}"><td>
        {if $ordenar_imagenes}
        	<img height="100" src="{$ruta_imagenes}/{$item[$campo_mostrar]}{$suffix_imagen}.{$item[$ext_imagen]}" />
        {else}
	        {$item[$campo_mostrar]}
        {/if}
        </td></tr>
		{/foreach}
        {/strip}
	</table>

	 <div class="Center">     	
	    <input type="button" id="btn_ordenar" name="btn_ordenar" value="Ordenar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" onclick="history.back(-1);">Volver</a></span>
    </div>   
</form>
