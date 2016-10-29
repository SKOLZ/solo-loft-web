{include file="includes/inicia.tpl"}
	<body style="">
        <div id="page-holder" class="page-holder-home">
        
            <div id="content" style=" height:752px; width:100%; background:url({$SITE_PATH}img/seccion_back.jpg);">
                
                <div id="main-logo" style="height:752px !important;">
                	<a href="{$SITE_PATH}"><img src="{$SITE_PATH}img/solo-loft-roca-consultora.png" alt=""></a>
                	<form action="{$SITE_PATH}resultados.php" method="get" id="search-theme-form">
                        <div>
                            <input maxlength="128" name="busqueda" size="23" title="" class="form-text buscar_input" type="text" value="" onFocus="eFocus(this)" onBlur="eBlur(this)" />
                            <input name="op" class="form-submit" value="" type="submit" />
                        </div>
                    </form>
                    
                    <ul id="menu-roca">
                    	<a href="{$SITE_PATH}"><li>NOSOTROS</li></a>
                        <a href="{$SITE_PATH}propiedades.php"><li class="active">PROPIEDADES</li></a>
                        
                        <a class="submenu" href="{$SITE_PATH}propiedades.php"><li{if $activar_complejo} class="active_sub"{/if}>COMPLEJOS</li></a>
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?ventas=true"><li{if $activar_venta} class="active_sub"{/if}>VENTAS</li></a>
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?alquileres=true"><li{if $activar_alquiler} class="active_sub"{/if}>ALQUILERES</li></a>
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?temporales=true"><li{if $activar_temporal} class="active_sub"{/if}>TEMPORALES</li></a>
                        
                        <a href="{$SITE_PATH}contacto.php"><li>CONTACTO</li></a>
                    </ul>
                </div>
                
                {foreach from=$destacados item=destacado}
                <div class="destacado_mes">
                    <a href="detalle.php?id={$destacado.ID_Producto}">
                    {if file_exists("upload/productos/"|cat:$destacado.ID_Producto|cat:"_detalle."|cat:$destacado.Img_Ext)}
                    	<img class="img_destacado" src="upload/productos/{$destacado.ID_Producto}_detalle.{$destacado.Img_Ext}" width="185" height="184" alt="{$destacado.Titulo}" style="float:left;">
                    {else}
                    	<img class="img_destacado" src="img/imagen-no-disp-185x184.jpg" width="185" height="184" alt="{$destacado.Titulo}" style="float:left;">
                    {/if}
                    </a>
                	<h4 class="data-title title">
                    	DESTACADO DEL MES
                    </h4>
                	<h4 class="data-title title">
                    	{$destacado.Titulo|escape:"htmlall"}<br><span class="h4-resaltado">/COMPLEJO</span>
                    </h4>
                    <dl class="first data-client">
                    	<dd>{$destacado.Encabezado|escape:"htmlall"}</dd>
                    </dl>
                </div>
                {/foreach}
                
                <div class="propiedad_content">
                    {if $complejo|count !=''}
                    	{foreach from=$complejo item=complex}
                	<a href="detalle.php?id={$complex.ID_Producto}"><div class="propiedad_thumb">
                    	{if file_exists("upload/productos/"|cat:$complex.ID_Producto|cat:"_th."|cat:$complex.Img_Ext)}
                        <img src="upload/productos/{$complex.ID_Producto}_th.{$complex.Img_Ext}" width="155" height="155" alt="{$complex.Titulo}" style="float:left;">
                        {else}
                        <img src="img/imagen-no-disp-155x155.jpg" width="155" height="155" alt="{$complex.Titulo}" style="float:left;">
                        {/if}
                        <h2>{$complex.Titulo|escape:"htmlall"}<br />
                        <span>complejo</span></h2>
                    </div></a>
                    	{/foreach}
                    {else}
                    <div class="mensaje"><p>No se encontraron resultados con el criterio ingresado.</p></div>
                    {/if}
                    {if $paginador_total_paginas > 1}	
                        <div class="paginador">
                            {if $paginador_pagina_actual > 1}
                                <a href="{querystring pag=$paginador_pagina_actual-1}" title="Anterior" class="previous">&lt; anterior</a>
                            {/if}
                            {section name=loop_paginador start=$paginador_loop_start loop=$paginador_loop_end step=1}
                                 {if $smarty.section.loop_paginador.index > 1} - {/if}<a href="{querystring pag=$smarty.section.loop_paginador.index}"{if $paginador_pagina_actual == $smarty.section.loop_paginador.index} class="activo" title="Página actual"{/if}><span>{$smarty.section.loop_paginador.index}</span></a>
                            {/section}
                            {if $paginador_pagina_actual < $paginador_total_paginas}
                                <a href="{querystring pag=$paginador_pagina_actual+1}" title="Siguiente" class="next">siguiente &gt;</a>
                            {/if}
                            {if $paginador_mostrar_resumen}
                        	<div class="paginador-resumen">{$paginador_total_registros} {$nombre_unidades}. P&aacute;gina {$paginador_pagina_actual} de {$paginador_total_paginas}.</div>
                        	{/if}
                        </div>
                    {/if}
                </div>
                
            </div>

            <div id="sub-main-stage">
{include file="includes/finaliza.tpl"}