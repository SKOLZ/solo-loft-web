<div class="block block-user" id="block-user-0">
    <div class="title">
        <h3><cufon style="width: 60px; height: 23px;" alt="Newsletter" class="cufon cufon-canvas"><canvas style="width: 78px; height: 27px; top: -4px; left: 0px;" height="27" width="78"></canvas><cufontext>Newsletter</cufontext></cufon></h3>
    </div>
    <div class="content">
        {if $newsletter_form}
        <form action="#newsletter" method="post"  id="user-login-form">
            <input type="hidden" class="hidden" name="flag_newsletter" value="1" />
            <div>
                <p style="color:#b1b1b1; margin-bottom:20px;">Suscribase a nuestro bolet&iacute;n asi podra recibir nuestras novedades acerca de nuestros productos, ofertas y otras noticias sobre nuestra empresa. Tan solo ingresando su nombre y su correo electr&oacute;nico podr&aacute; ingresar a nuestra comunidad.</p>
                <div class="form-item" id="edit-name-wrapper">
                    <label for="edit-name">Nombre y Apellido <span class="form-required" title="This field is required.">*</span></label>
                    <input type="text" id="edit-name" name="nombre_newsletter" class="form-text required" />
                </div>
                <div class="form-item" id="edit-pass-wrapper">
                    <label for="edit-pass">Email <span class="form-required" title="This field is required.">*</span></label>
                    <input type="text" id="edit-pass" name="email_newsletter" class="form-text required" />
                </div>
                <input name="op" id="edit-submit" value="Enviar" class="form-submit" type="submit">
            </div>
        </form>
        {/if}
        {if $newsletter_ok}
        <p class="center">Su email se ha recibido correctamente.<br />
        <b>Muchas gracias!</b></p>
        {/if}
    </div>
</div>