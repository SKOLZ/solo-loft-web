<?php

define('SITE_DESCRIPTION','');
define('SITE_KEYWORDS','');
define('REL_CANONICAL','');

require_once('includes/init.php');

$smarty->assign('contacto', true);
$smarty->assign('VALIDATE', true);

/*Begin Contacto*/


if(!empty($_POST) && isset($_POST['contacto_nombre']) ){
	require_once('classes/phpmailer/class.phpmailer.php');
	
	$nombre = $db->qstr($_POST['contacto_nombre']);
	$email = $db->qstr($_POST['contacto_email']);
	$telefono = $db->qstr($_POST['contacto_telefono']);
	$mensaje = $db->qstr($_POST['contacto_mensaje']);
	
	
	$query = "INSERT INTO Contactos (Nombre, Email, Telefono, Mensaje, Fecha) 
			  VALUES (". $nombre .", ". $email .", ". $telefono .", ". $mensaje .", NOW())";
	
	$res = $db->execute($query);
								 
	$mailer = new PHPMailer();
	$mailer->From = MAIL_CONTACTO; // Dirección
	$mailer->FromName = MAIL_CONTACTO_NAME; //nombre con el que llega
	$mailer->isHTML(true); // mensaje tipo html
	
	$mailer->Subject = 'Contacto web de '. $_POST['contacto_nombre']; // Asunto
	$email_template = implode("", file('templates/mails/contacto.tpl'));
	$search = array('{NOMBRE}', '{EMAIL}', '{TELEFONO}','{MENSAJE}', '{SITE_PATH}');
	$replace = array( $_POST['contacto_nombre'], $_POST['contacto_email'], $_POST['contacto_telefono'],$_POST['contacto_mensaje'], SITE_PATH );
	$email_template = str_replace($search, $replace, $email_template);
	$mailer->Body = $email_template;
	
	$mailer->AddAddress(MAIL_CONTACTO);
	$mailer->AddReplyTo($email);
	$res = $mailer->Send();
	
	$smarty->assign('sms', true);
}else{
	$smarty->assign('contacto_form', true);
	$smarty->assign('WFORMS', true);
}
/*End Contacto*/



// Suscripcion al Newsletter
if(isset($_POST['flag_newsletter']) && $_POST['flag_newsletter'] == '1'){
	if(!isset($_POST['contacto_email_news']) || $_POST['contacto_email_news'] == '' || !Misc::checkEmail($_POST['contacto_email_news'])){
		$smarty->assign('onload_js', "");
	}else{
		$res2 = $db->getAll("SELECT * FROM Registrados_Newsletter WHERE Email = ". $db->qstr($_POST['contacto_email_news']));
		if(count($res2) == 0){
			 $res2 = $db->execute("INSERT INTO Registrados_Newsletter (Email, Fecha) VALUES (". $db->qstr($_POST['contacto_email_news']) .", NOW())");
			if($res2){
				$smarty->assign('newsletter_ok', true);

			}else{
				$smarty->assign('onload_js', "");
			}
		}else{
			$smarty->assign('onload_js', "La casilla de Email que ingreso ya se encuentra registrada en nuestra base de datos.");
			//$smarty->assign('mail_existente', true);
			$smarty->assign('newsletter_form', true);
		}
	}	
}else{
	$smarty->assign('newsletter_form', true);
}


$smarty->display('contacto.tpl');

?>