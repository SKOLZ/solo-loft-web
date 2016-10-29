<form action="" method="post" id="form_onas" name="form_onas" 
    <h4>Padre</h4>
    <p><select name="id_padre" id="id_padre" class="required Estado">
        <option value="0">/</option>
        {foreach from=$padre_list item=padre}
        <option value="{$padre.ID}" {$padre.SELECTED} {$padre.DISABLED}>{$padre.PATH}</option>
        {/foreach}
    </select></p>
    
    <h4>Tipo</h4>
    <p><select name="id_tipo" id="id_tipo" class="required Estado" onchange="cambiarTipoModulo();">
        {foreach from=$tipo_list item=tipo}
        <option value="{$tipo.ID}" {$tipo.SELECTED}>{$tipo.PATH}</option>
        {/foreach}
    </select></p>

    <h4>Nombre</h4>
    <p><input type="text" name="texto" id="texto" class="required Estado" value="{$modulo.Texto}" /></p> 
    
    <h4>Link (ej: modulos/categorias)</h4>
    <p><input type="text" name="url" id="url" class="Estado" value="{$modulo.Url}" /></p>       	

	<p class="Memo"><span>&raquo;</span> Seleccione los usuarios a los cuales desea asignarles permisos para este modulo.</p>

    <ul class="Usuarios" id="ul_usuarios">{$usuarios}</ul> 

    <input type="hidden" name="custom" value="1" />
    
    <div class="Center">     	
    	<input type="hidden" name="indice" value="{$modulo.ID_Modulo}" />
	    <input type="submit" name="submit" value="Dar de alta" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="#" onclick="history.back(-1);">Volver</a></span>
    </div>  
    </div>   
</form>