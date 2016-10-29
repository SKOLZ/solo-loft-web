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
                        {if $activar_complejo}
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?id_categoria=complejos">
                        	<li{if $complejos_active} class="active_sub"{/if}>COMPLEJOS</li>
                        </a>
                        {/if}
                        {if $activar_ventas}
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?id_categoria=ventas">
                        	<li{if $ventas_active} class="active_sub"{/if}>VENTAS</li>
                        </a>
                        {/if}
                        {if $activar_alquileres}
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?id_categoria=alquileres">
                        	<li{if $alquileres_active} class="active_sub"{/if}>ALQUILERES</li>
                        </a>
                        {/if}
                        {if $activar_temporales}
                        <a class="submenu" href="{$SITE_PATH}propiedades.php?id_categoria=temporales">
                        	<li{if $temporales_active} class="active_sub"{/if}>TEMPORALES</li>
                        </a>
                        {/if}
                        {foreach from=$categorias item=categoria}
                        <a class="submenu" href="propiedades.php?id_categoria={$categoria.ID_Categoria}"><li{if $categoria_activa ==$categoria.ID_Categoria} class="active_sub"{/if}>{$categoria.Categoria|escape:"htmlall"}</li></a>
                        {/foreach}
                        <a href="{$SITE_PATH}contacto.php"><li>CONTACTO</li></a>
                    </ul>
                </div>
                
                {foreach from=$destacados item=destacado}
                <div class="destacado_mes">
                    
                    {if file_exists("upload/productos/"|cat:$destacado.ID_Producto|cat:"_detalle."|cat:$destacado.Img_Ext)}
                    	<img class="img_destacado" src="{$SITE_PATH}upload/productos/{$destacado.ID_Producto}_detalle.{$destacado.Img_Ext}" width="185" height="184" alt="{$destacado.Titulo}" style="float:left;">
                    {else}
                    	<img class="img_destacado" src="{$SITE_PATH}img/imagen-no-disp-185x184.jpg" width="185" height="184" alt="{$destacado.Titulo}" style="float:left;">
                    {/if}
                    
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
                
                	{foreach from=$complejo item=complex}
                	<a href="detalle.php?id={$complex.ID_Producto}"><div class="propiedad_thumb">
                    	{if file_exists("upload/productos/"|cat:$complex.ID_Producto|cat:"_th."|cat:$complex.Img_Ext)}
                        <img src="{$SITE_PATH}upload/productos/{$complex.ID_Producto}_th.{$complex.Img_Ext}" width="135" alt="{$complex.Titulo}" style="float:left;">
                        {else}
                        <img src="{$SITE_PATH}img/imagen-no-disp-155x155.jpg" width="135" alt="{$complex.Titulo}" style="float:left;">
                        {/if}
                        <h2>{$complex.Titulo|escape:"htmlall"}<br />
                        <span>{foreach from=$categorias_item item=categorias_items}{if $categorias_items.ID_Categoria == $complex.ID_Categoria}/{$categorias_items.Categoria}{/if}{/foreach}</span></h2>
                    </div></a>
                    {/foreach}
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
                <div id="sub-content" style="height:380px;">
                	<div class="center-boxing">
                        <div class="box-content">
                          <h3>TRAYECTORIA</h3>
                            <p><span>Consultora Roca Real Estate, desde 1992 desarrolla su actividad  de asesoramiento a peque&ntilde;os y grandes  inversores en el rubro inmobiliarios.</span></p>
                          <p>Tanto en el desarrollo de complejos habitacionales como en la compra de una unidad de vivienda, encierran en s&iacute; mismo una inversi&oacute;n de ahorros y una potencial inversi&oacute;n. Por esta raz&oacute;n el asesoramiento a la hora de invertir o comprar es fundamental para aplicar correctamente los ahorros.</p>
                        </div>
                        <div class="box-content">
                          <h3>NOSOTROS</h3>
                          <p><span>Un grupo de profesionales  especializados  en el rubro  brindan una correcta &oacute;ptica de los aspectos comerciales, contables e impositivos que confluyen en una operaci&oacute;n inmobiliaria.</span></p>
                            <p>Tanto para la confecci&oacute;n de contratos, valuaciones, estudios de factibilidad negocios inmobiliarios, o evaluaci&oacute;n de proyectos constructivos, Consultora Roca Real Estate pone a disposici&oacute;n de sus clientes  la experiencia y la idoneidad necesaria para una correcta toma de decisiones.</p>
                        </div>
                        <div class="box-content ultima">
                          <h3>SERVICIOS</h3>
                            <p><span>&#8226; VENTAS<br />
                            &#8226; ALQUILERES<br />
                            &#8226; TASACIONES<br />
                            &#8226; PROYECTOS DE FACTIBILIDAD<br />
                            &#8226; ADMINISTRACION DE PROPIEDADES<br />
                            &#8226; GESTION EN HABILITACIONES<br />
                            &#8226; GESTION Y ADMINISTRACION DE PROYECTOS INMOBILIARIOS<br />
                            &#8226; EVALUACION DE CONTRATOS Y GARANTIAS</span></p>
                        </div>
                	</div>
                </div>
{include file="includes/finaliza.tpl"}