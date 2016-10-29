{include file="includes/inicia.tpl"}
<body>
        <div id="page-holder" class="page-holder-home">
            <div id="main-stage">
                <!-- Slides -->
                <div class="home-slideshow-holder">
            		<div class="preload-layer" style="display:block; opacity:1;z-index:9999;position: absolute;left:50%;margin-left:-830px;">
                        <img src="{$SITE_PATH}img/preview.jpg" alt="" style="display:block; opacity:1;"/> 	
                    </div>
                    
                    <div class="info-panel info-panel-carousel">
                    	<ul id="menu-roca-detalle">
                            <a href="{$SITE_PATH}"><li>NOSOTROS</li></a>
                            <a href="{$SITE_PATH}propiedades.php"><li>PROPIEDADES</li></a>
                            <a href="{$SITE_PATH}contacto.php"><li>CONTACTO</li></a>
                        </ul>
                        <h4 class="data-title title">{$producto.Titulo}<br /><span class="h4-resaltado">/{if $producto.ID_Categoria == 2}Departamento{else}Complejo{/if}</span></h4>
                        <dl class="first data-client">
                            <dd>{$producto.Encabezado}</dd>
                        </dl>
                    </div>
                    
                    <div class="home-slideshow">
                    	{foreach from=$img_adicionales item=imagen name=foo}
                        <!--INCIO LOOP-->
                        <div class="slide slide-{$smarty.foreach.foo.iteration}" style="background:url({$SITE_PATH}upload/productos/adicionales/{$imagen.ID_Imagen_Adicional}_detalle.{$imagen.Img_Ext}) no-repeat top center"></div>
                        <!--FIN LOOP-->
                        {/foreach}
                    </div>
                </div>
                <div class="home-slideshow-drag" style="display:none;">
                    <div class="bar">
                        <span></span>
                    </div>
                </div>
                <div class="clear"></div>
                <!-- FinSlides -->
                
            </div>

            <div id="sub-main-stage">
                <div id="sub-content" style="min-height: 380px;margin-bottom: 50px;">
                	<div class="center-boxing">
                        <div class="box-content">
                        	{if $producto.ID_Categoria == 2 || $producto.ID_Categoria == 1}
                        	<h3>DEPTOS.</h3>
                            <ul>
                            	{foreach from=$departamentos_complejo item=departamento}
                                {if $departamento.ID_Producto == $producto.ID_Producto}
                                <li><span style="color:#2e0a0a; text-transform:uppercase;font-size:14px;letter-spacing:2px;">{$departamento.Titulo|escape:"htmlall"}</span></li>
                                {else}
                                <li><a href="detalle.php?id={$departamento.ID_Producto}">{$departamento.Titulo|escape:"htmlall"}</a></li>
                                {/if}
                                {/foreach}
                            </ul>
                            {/if}
                        </div>
                        <div class="box-content">
                        	<h3>review</h3>
                        	<p><span>{$producto.Encabezado}</span></p>
                        	<p>{$producto.Descripcion}</p>
                        </div>
                        <div class="box-content ultima">
                        	<h3>INFO</h3>
                            <p style="line-height:14px;">
                            {if $producto.ID_Categoria == 1}
                                {if $producto.Ubicacion != ''}ubicaci&oacute;n: <span>{$producto.Ubicacion|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Servicios != ''}servicios: <span>{$producto.Servicios|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Superficie_total != ''}superficie total: <span>{$producto.Superficie_total|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Altura_pisos != ''}altura y cantidad de pisos: <span>{$producto.Altura_pisos|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Cantidad_unidades != ''}cantidad de unidades: <span>{$producto.Cantidad_unidades|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Cocheras != ''}cantidad de cocheras: <span>{$producto.Cocheras|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Etapa_construccion != ''}etapa de construcci&oacute;n y finalizaci&oacute;n: <span>{$producto.Etapa_construccion|escape:"htmlall"}</span><br />{/if}
                            {else}
                                {if $producto.Cantidad_ambientes != ''}cantidad de ambientes: <span>{$producto.Cantidad_ambientes|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Superficie_dto != ''}superficie del depto: <span>{$producto.Superficie_dto|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Apto_profesional != ''}apto profesional: <span>{$producto.Apto_profesional|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Servicios_dto != ''}servicios del depto: <span>{$producto.Servicios_dto|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Expensas != ''}expensas: <span>{$producto.Expensas|escape:"htmlall"}</span><br />{/if}
                                {if $producto.Otros_datos != ''}otros datos: <span>{$producto.Otros_datos|escape:"htmlall"}</span><br />{/if}
                            {/if}
                            </p>
                        </div>
                	</div>
                </div>
{include file="includes/finaliza.tpl"}