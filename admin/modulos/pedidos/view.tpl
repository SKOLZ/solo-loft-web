<form action="" method="post" id="form_onas" name="form_onas" enctype="multipart/form-data">

<h4>Nombre</h4>
<p>{$form.Nombre}</p>

<h4>Apellido</h4>
<p>{$form.Apellido}</p>

<h4>Provincia</h4>
<p>{$form.Provincia}</p>

<h4>Localidad</h4>
<p>{$form.Localidad}</p>

<h4>Codigo Postal</h4>
<p>{$form.Codigo_Postal}</p>

<h4>Email</h4>
<p>{$form.Email}</p>

<h4>Forma de Pago</h4>
<p>{$form.Forma_Pago}</p>

<h4>Comentarios</h4>
<p>{$form.Comentarios}</p>

<h4>Fecha</h4>
<p>{$form.F_Fecha_Formato}</p> 

   <h4 class="Titulo">Items</h4>
     <div id="resultado_busqueda" class="table_estadoscuenta center" >

        <table cellspacing="2" cellpadding="2" width="100%">

        	<tr>
                <th><strong>Cantidad</strong></th>
                <th><strong>Titulo</strong></th>
                <th><strong>Descripcion</strong></th>
                <th><strong>Precio</strong></th>

            </tr>
        	
            
            {foreach from=$pedidos item=pedido}
            <tr>
                <td align="center">{$pedido.Cantidad}</td>
                <td align="center">{$pedido.Titulo}</td>
                <td align="center">{$pedido.Descripcion|strip_tags|truncate:120}</td>
                <td align="center">${$pedido.Precio_Unitario}</td>

            </tr>
        	
            {/foreach}
            
		
        </table>
	</div>


<h4>Monto Total</h4>
<p>${$form.Monto_Total}</p>

     <h4>Estado</h4>
    <p>
        <select name="estado" id="estado" class="required" onchange="$('#estados').load('index.php?do=getestados&id_estado='+this.value);">
    	<option value="0">-- seleccionar --</option>
        {foreach from=$estados item=estado}
        	<option value="{$estado.ID_Estado}" {if $form.ID_Estado == $estado.ID_Estado}selected="selected"{/if}>{$estado.Estado}</option>
        {/foreach}
        </select>
    </p> 

 
    <div class="Center">     	
    	<input type="hidden" name="indice" value="{$indice}" />
	    <input type="submit" name="submit" value="Guardar" class="BtnAlta" />
        <span style="vertical-align:top"><a class="BtnVolver" href="index.php" >Volver</a></span>
    </div> 
</form>