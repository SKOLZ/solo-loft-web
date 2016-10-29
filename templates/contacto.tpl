{include file="includes/inicia.tpl"}
	<body style="">
        <div id="page-holder" class="page-holder-home">
        
            <div id="content" style=" height:500px; width:100%; background:url(http://www.solo-loft.com.ar/upload/productos/adicionales/150_detalle.jpg)">
                
                <div id="main-logo" style="height:500px !important;">
                	<a href="index.php"><img src="img/solo-loft-roca-consultora.png" alt=""></a>
                	<form action="resultados.php" method="get" id="search-theme-form">
                        <div>
                            <input maxlength="128" name="busqueda" size="23" title="Enter the terms you wish to search for." class="form-text buscar_input" type="text" value="" onFocus="eFocus(this)" onBlur="eBlur(this)" />
                            <input name="op" class="form-submit" value="" type="submit" />
                        </div>
                    </form>
                    
                    <ul id="menu-roca">
                    	<a href="index.php"><li>NOSOTROS</li></a>
                        <a href="propiedades.php"><li>PROPIEDADES</li></a>
                        <a href="contacto.php"><li class="active">CONTACTO</li></a>
                    </ul>
                </div>
            </div>

            <div id="sub-main-stage">
                <div id="sub-content" style="height:380px;">
                	<div class="center-boxing">
                        <div class="box-content" style="width:180px !important;">
                        	<!--<img src="img/contacto.jpg" height="270" width="158" alt="">-->
                        	<h3>tel.</h3>
                        	<p>+54 (011) 15-4415-9559<br />
                            +54 (011) 4713-2567<p>
                        </div>
                        <div class="box-content" style="width:370px !important;">
                        	<h3>cont&aacute;ctenos</h3>
                        	<p><span>complete el siguiente formulario 
                            para contactarse con nuestros agentes,
                            asi podremos brindarle una atenci&oacute;n 
                            personalizada.</span></p>
                            
                            
                            
                            <!-- start main content -->
                            {if $contacto_form}  
                            <form id="contact-mail-page" method="post" action="">
                                <p><div id="edit-name-wrapper" class="form-item">
                                    <label for="edit-name">Nombre y Apellido: <span title="This field is required." class="form-required">*</span></label>
                                    <input type="text" id="edit-name" name="contacto_nombre" value="{$datos.contacto_nombre}" class="form-text required" style="width:220px;"/>
                                </div>
                                <div id="edit-tel-wrapper" class="form-item">
                                    <label for="edit-mail">Tel&eacute;fono: <span title="This field is required." class="form-required">*</span></label>
                                    <input type="text" id="edit-mail" name="contacto_telefono" value="{$datos.contacto_telefono}" style="width:220px;" class="form-text required"/>
                                </div>
                                <div id="edit-mail-wrapper" class="form-item">
                                    <label for="edit-mail">E-mail: <span title="This field is required." class="form-required">*</span></label>
                                    <input type="text" id="edit-mail" name="contacto_email" value="{$datos.contacto_email}" style="width:220px;" class="form-text required email" />
                                </div>
                                <div id="edit-message-wrapper" class="form-item">
                                    <label for="edit-message">Consulta: <span title="This field is required." class="form-required">*</span></label>
                                    <textarea class="form-textarea resizable required textarea-processed" id="edit-message" name="contacto_mensaje" rows="5" cols="35" style="opacity: 1; height: 40px !important; width:220px;">{$datos.contacto_mensaje}</textarea>
                                </div><p>
                                <input type="submit" class="form-submit-contact" value="Enviar" id="edit-submit" name="op" style="margin-top:15px;">
                            </form>
                            {/if}
                            {if $sms}
                                <p class="mensaje" style="margin-top:74px;text-align: center;opacity: 0.6; color:#FFF;">El mensaje se ha enviado correctamente,<br />
                                 nos comunicaremos con usted a la brevedad.</p>
                            {/if}
                            
                            
                        </div>
                        <div class="box-content ultima" style="width:350px !important;">
                        	<h3>newsletter</h3>
                            <p><span>suscribi&eacute;ndose a nuestro bolet&iacute;n
                            le enviaremos novedades acerca de nuestras
                            propiedades y servicios. Ingrese su e-mail
                            y forme parte de nosotros.</span></p>
                            
                            <!-- start main content -->
                            {if $newsletter_form} 
                            <form id="contact-mail-page" method="post" action="#newsletter">
                            	<input type="hidden" class="hidden" name="flag_newsletter" value="1" />
                                <p><div id="edit-name-wrapper" class="form-item">
                                    <label for="edit-name-news">Nombre y Apellido: <span title="This field is required." class="form-required">*</span></label>
                                    <input type="text" id="edit-name-news" name="contacto_nombre_news" value="{$datos.contacto_nombre_news}" class="form-text required" style="width:220px;"/>
                                </div>
                                <div id="edit-mail-wrapper" class="form-item">
                                    <label for="edit-mail-news">E-mail: <span title="This field is required." class="form-required">*</span></label>
                                    <input type="text" id="edit-mail-news" name="contacto_email_news" value="{$datos.contacto_email_news}" style="width:220px;" class="form-text required email" />
                                </div><p>
                                <input type="submit" class="form-submit-contact" value="Enviar" id="edit-submit-news" name="op-news" style="margin-top:15px;">
                            </form>
                            {/if}
                            {if $newsletter_ok}
                                <p class="mensaje" style="margin-top:74px;text-align: center;opacity: 0.6; color:#FFF;">Gracias por suscribirse a nuestro Newsletter.</p>
                            {/if}
                        </div>
                	</div>
                </div>
{include file="includes/finaliza.tpl"}