<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

 <?php session_start(); ?>
<?php

include_once("inc/securimage/securimage.php");
$securimage = new Securimage();

if (isset($_POST['boton'])){

            if($_POST['nombre'] == ''){
                $errors[1] = '<span class="error">Insert name</span>';
            }else if($_POST['email'] == '' or !preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/",$_POST['email'])){
                $errors[2] = '<span class="error">Insert a valid email</span>';
            }else if($_POST['mensaje'] == ''){
                $errors[4] = '<span class="error">Insert a message</span>';
            }else{
                
                if ($securimage->check($_POST['captcha_code']) == false) { 
  			echo "The security code entered was incorrect.<br />";
 		} 
		else{ 

                $dest = "hypersampler@gmail.com"; //Email de destino
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $asunto = "Contacto Axbizz"; 
		 		$cuerpo= "Mensaje: ".$_POST['mensaje']."<br>";
                $cuerpo .= "Nombre: ".$_POST['nombre'];
                //Cabeceras del correo
                $headers = "From: $nombre $email\r\n"; //Quien envia?
                $headers .= "X-Mailer: PHP5\n";
                $headers .= 'MIME-Version: 1.0' . "\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; //
 
                if(mail($dest,$asunto,$cuerpo,$headers)){
                    $result = '<div class="result_ok">Email sent correctly</div>';
                    // si el envio fue exitoso reseteamos lo que el usuario escribio:
                    $_POST['nombre'] = '';
                    $_POST['email'] = '';
                    $_POST['asunto'] = '';
                    $_POST['mensaje'] = '';
                }else{
                    $result = '<div class="result_fail">There was an error sending the message </div>';
                  }
                }
	}
}

 ?>
</body>
</html>