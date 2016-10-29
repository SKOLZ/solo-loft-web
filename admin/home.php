<?php

require_once("includes/init.php");

$title = "Onas";


require_once('classes/nusoap/nusoap.php');

$soapclient = new soapclient2('http://onas.promaker.com.ar/ws/');

//$soapclient = new soapclient2('http://prmkrwebservice.promaker.des/index.php');

if (!$soapclient->getError()) {
	$result = $soapclient->call( 'onas_home', array('client' => $_SESSION['onas']['config']['site_name']) );
	if (!$soapclient->getError()) {
		$smarty->assign('home_onas', $result);
	}
}



$smarty->display('home.tpl');


?>
