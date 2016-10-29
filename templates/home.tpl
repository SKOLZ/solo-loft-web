{include file="includes/inicia.tpl"}
<body>
        <div id="page-holder" class="page-holder-home">
            <div id="main-stage">
                <!-- Slides -->
                <div class="home-slideshow-holder">
            		<div class="preload-layer" style="display:block; opacity:1;z-index:9999;position: absolute;left:50%;margin-left:-830px;">
                        <img src="{$SITE_PATH}img/preview.jpg" alt="" style="display:block; opacity:1;"/> 	
                    </div>
                    <div class="info-panel info-panel-carousel" style="display:none;">
                        <h4 class="data-title title">Solo loft<br /><span class="h4-resaltado">/bienvenidos</span></h4>
                        <dl class="first data-client">
                            <dd>Consultora Roca Real Estate, desde 1992 desarrolla su actividad  de asesoramiento a peque&ntilde;os y grandes  inversores en el rubro inmobiliarios.</dd>
                        </dl>
                    </div>
                    
                    <div id="main-logo" style="display:none;" >
                        <a href="{$SITE_PATH}"><img src="{$SITE_PATH}img/solo-loft-roca-consultora.png" alt=""></a>
                        <form action="resultados.php" method="get" id="search-theme-form">
                            <div>
                                <input maxlength="128" name="busqueda" size="23" title="Enter the terms you wish to search for." class="form-text buscar_input" type="text" value="" onFocus="eFocus(this)" onBlur="eBlur(this)" />
                                <input name="op" class="form-submit" value="" type="submit" />
                            </div>
                        </form>
                        
                        <ul id="menu-roca">
                            <a href="{$SITE_PATH}"><li class="active">NOSOTROS</li></a>
                            <a href="{$SITE_PATH}propiedades.php"><li>PROPIEDADES</li></a>
                            <a href="{$SITE_PATH}contacto.php"><li>CONTACTO</li></a>
                        </ul>
                    </div>
                    
                    <div style="display: none;" class="gallery-button-holder">
                        <a href="#" class="prev">Previous</a>
                        <a href="#" class="next">Next</a>
                    </div>
                    
                    <div class="home-slideshow">
                    	{foreach from=$slides item=slide name=foo}
                        <!--INCIO LOOP-->
                        <div class="slide slide-{$smarty.foreach.foo.iteration}" style="background:url({$SITE_PATH}upload/productos/slide/{$slide.ID_Slide}_original.{$slide.Img_Ext}) no-repeat top center">
                        
                        	<p style="background: url({$SITE_PATH}css/opacity.80.png) repeat scroll left top transparent; padding: 7px; position: absolute; right: 10px; top: 450px; z-index: 9999; color:#FFF; text-align:right; font-size:14px !important;">{$slide.Titulo_Amarillo|escape:"htmlall"}</p>
                        
                        </div>
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
            
			<div id="blurb-holder">
            	<div class="center-boxing">
                    
                    {foreach from=$destacados key=part_id item=destacado name=propiedades}
                	<a href="detalle.php?id={$destacado.ID_Producto}">
                    	<div class="last-complex {if $smarty.foreach.propiedades.last}ultima{/if}">
                    	{if file_exists("upload/productos/"|cat:$destacado.ID_Producto|cat:"_th."|cat:$destacado.Img_Ext)}
                        <img src="{$SITE_PATH}upload/productos/{$destacado.ID_Producto}_th.{$destacado.Img_Ext}" width="155" height="154" alt="{$destacado.Titulo}" style="float:left;">
                        {else}
                        <img src="{$SITE_PATH}img/imagen-no-disp-155x155.jpg" width="155" height="154" alt="{$destacado.Titulo}" style="float:left;">
                        {/if}
                        <h2>{$destacado.Titulo|escape:"htmlall"}<br />
                        <span>complejo</span></h2>
                    	</div>
                    </a>
                    {/foreach}
                    
            	</div>
            </div>

            <div id="sub-main-stage">
                <div id="sub-content" style="min-height:390px;">
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