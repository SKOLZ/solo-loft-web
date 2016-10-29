<form action="?do=jcrop" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">
    <h4>Vista Previa</h4>
    <div>
    	<img src="{$IMAGENES.path}/{$IMAGENES.archivo}" id="cropbox" style="border:1px solid #CCC" />
        <input type="hidden" name="resize" value="1" />
        <input type="hidden" name="archivo" value="{$IMAGENES.archivo}" />
        <input type="hidden" name="path" value="{$IMAGENES.path}" />
        <input type="hidden" name="w" id="ancho" />
        <input type="hidden" name="h" id="alto" />
        <input type="hidden" name="x" id="x" />
        <input type="hidden" name="y" id="y" />
        {section name=i loop=$IMAGENES.dimensiones}
        <input type="hidden" name="imagen[{$smarty.section.i.index}][ancho]" value="{$IMAGENES.dimensiones[i].ancho}" />
        <input type="hidden" name="imagen[{$smarty.section.i.index}][alto]" value="{$IMAGENES.dimensiones[i].alto}" />
        <input type="hidden" name="imagen[{$smarty.section.i.index}][nombre]" value="{$IMAGENES.dimensiones[i].nombre}" />
        {/section}
    </div> 
    
    <div>
        <p class="Center">     	
            <input type="hidden" class="hidden" name="indice" value="{$indice}" />
            <input type="submit" name="submit" value="Dar de alta" class="BtnAlta" />
        </p>   
    </div>
</form>