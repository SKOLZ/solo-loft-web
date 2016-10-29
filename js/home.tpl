{include file="includes/inicia.tpl"}
<!--<script type="text/javascript" src="js/ak_003.js"></script>
<script type="text/javascript" src="js/ak.js"></script>
<script type="text/javascript" src="js/ak_002.js"></script>-->

<body style="">
        <div id="page-holder" class="page-holder-home">
            <div id="main-stage">
                
                
                <!-- Slides -->
                <div class="home-slideshow-holder">
            
                    <div id="main-logo">
                        <a href="index.php"><img src="img/solo-loft-roca-consultora.png" alt=""></a>
                        <form action="resultados.php" method="get" id="search-theme-form">
                            <div>
                                <input maxlength="128" name="busqueda" size="23" title="Enter the terms you wish to search for." class="form-text buscar_input" type="text" value="" onFocus="eFocus(this)" onBlur="eBlur(this)" />
                                <input name="op" class="form-submit" value="" type="submit" />
                            </div>
                        </form>
                        
                        <ul id="menu-roca">
                            <a href="index.php"><li class="active">NOSOTROS</li></a>
                            <a href="propiedades.php"><li>PROPIEDADES</li></a>
                            <a href="contacto.php"><li>CONTACTO</li></a>
                        </ul>
                    </div>
                    
                    
                    <div style="display: block;" class="gallery-button-holder">
                        <a href="#" class="prev" id="gallery-previous-button">Previous</a>
                        <a href="#" class="next" id="gallery-next-button">Next</a>
                    </div>
            
                    <!-- Preloader
                    <div class="preload-layer">
                        <img src="http://www.scotch-soda.com/images/front-end/preload-layer-logo.gif" alt="" /> 	
                    </div> -->
                    <div class="home-slideshow">
                    	{foreach from=$slides item=slide name=foo}
                        <!--INCIO LOOP-->
                        <div class="slide slide-{$smarty.foreach.foo.iteration}" style="background:url({$SITE_PATH}upload/productos/slide/{$slide.ID_Slide}_th.{$slide.Img_Ext})">			
                        </div>
                        <!--FIN LOOP-->
                        {/foreach}
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
                        <img src="upload/productos/{$destacado.ID_Producto}_th.{$destacado.Img_Ext}" width="155" height="155" alt="{$destacado.Titulo}" style="float:left;">
                        {else}
                        <img src="img/imagen-no-disp-155x155.jpg" width="155" height="155" alt="{$destacado.Titulo}" style="float:left;">
                        {/if}
                        <h2>{$destacado.Titulo}<br />
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
                            <p><span>Consultora Roca Real Estate, desde 1992 desarrolla su actividad  de asesoramiento a pequeños y grandes  inversores en el rubro inmobiliarios.</span></p>
                        	<p>Tanto en el desarrollo de complejos habitacionales como en la compra de una unidad de vivienda, encierran en sí mismo una inversión de ahorros y una potencial inversión. Por esta razón el asesoramiento a la hora de invertir o comprar es fundamental para aplicar correctamente los ahorros.</p>
                        </div>
                        <div class="box-content">
                        	<h3>NOSOTROS</h3>
                        	<p><span>Un grupo de profesionales  especializados  en el rubro  brindan una correcta óptica de los aspectos comerciales, contables e impositivos que confluyen en una operación inmobiliaria.</span></p>
                            <p>Tanto para la confección de contratos, valuaciones, estudios de factibilidad negocios inmobiliarios, o evaluación de proyectos constructivos, Consultora Roca Real Estate pone a disposición de sus clientes  la experiencia y la idoneidad necesaria para una correcta toma de decisiones.</p>
                        </div>
                        <div class="box-content ultima">
                        	<h3>SERVICIOS</h3>
                            <p><span>• VENTAS<br />
                            • ALQUILERES<br />
                            • TASACIONES<br />
                            • PROYECTOS DE FACTIBILIDAD<br />
                            • ADMINISTRACION DE PROPIEDADES<br />
                            • GESTION EN HABILITACIONES<br />
                            • GESTION Y ADMINISTRACION DE PROYECTOS INMOBILIARIOS<br />
                            • EVALUACION DE CONTRATOS Y GARANTIAS</span></p>
                        </div>
                	</div>
                </div>
{include file="includes/finaliza.tpl"}