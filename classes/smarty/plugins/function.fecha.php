<?php

/*Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * Smarty {cycle} function plugin
 *
 * Type:			function<br>
 * Name:			Fecha<br>
 * Date:				May 3, 2002<br>
 * Purpose:		Conseguir nombres de los meses mediante una fecha<br>
 *
 * Examples:<br>
 * <pre>
 * {cycle values="#eeeeee,#d0d0d0d"}
 * {cycle name=row values="one,two,three" reset=true}
 * {cycle name=row}
 * </pre>
 * @author		Sebastian Pallares "El Capo" <spallares@promaker.com.ar>
 * @author		credit to Sebastian Gil <sebastian@promaker.com.ar>
 * @version		89.4
 * @param		array
 * @param		Smarty
 * @return			string|null
 */
 
function smarty_function_fecha($params, &$smarty){
   $arr_meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    return $arr_meses[$params['mes']];
}

?>
