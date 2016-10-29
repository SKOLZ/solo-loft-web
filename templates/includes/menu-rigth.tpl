<div id="left-col">
    <div class="ind">
        <div class="width">
            <div class="block block-user" id="block-user-1">
                <div class="title">
                    <h3><cufon style="width: 123px; height: 23px;" alt="secciones" class="cufon cufon-canvas"><canvas style="width: 131px; height: 27px; top: -4px; left: 0px;" height="27" width="131"></canvas><cufontext>secciones</cufontext></cufon></h3>
                </div>
                <div class="content">
                    <ul class="menu">
                        <li class="leaf first{if $home} menu-rigth-activo{/if}" ><a href="{$SITE_PATH}" title="">Home</a></li>
                        <li class="leaf{if $nosotros} menu-rigth-activo{/if}" ><a href="{$SITE_PATH}quienes-somos.php" title="">Nosotros</a></li>
                        <li class="leaf{if $productos_menu} menu-rigth-activo{/if}" ><a href="{$SITE_PATH}productos.php" title="">Productos</a></li>
                        <!--<li class="collapsed{if $distribuidores} menu-rigth-activo{/if}" ><a href="{$SITE_PATH}distribuidores.php" title="">Distribuidores</a></li>-->
                        <li class="leaf{if $contacto} menu-rigth-activo{/if}"><a href="{$SITE_PATH}contacto.php" title="">Contacto</a></li>
                    </ul>
                </div>
            </div>
            <div class="block block-block" id="block-block-14">
                <div class="title">
                    <h3><cufon style="width: 87px; height: 23px;" alt="Novedades" class="cufon cufon-canvas"><canvas style="width: 104px; height: 27px; top: -4px; left: 0px;" height="27" width="104"></canvas><cufontext>Novedades</cufontext></cufon></h3>
                </div>
                <div class="content">
                    <ul>
                    	{foreach from=$novedades item=novedad}
                        <li><a href="{$SITE_PATH}detalle.php?id={$novedad.ID_Producto}">{$novedad.Titulo}</a></li>
                        {/foreach}
                    </ul>
                    <a href="{$SITE_PATH}productos.php?item=novedades" class="readmore">M&aacute;s...</a>
                </div>
            </div>
        </div>
    </div>
</div>