<?php
// función para enviar correos electrónicos vía cuenta Gmail.
	function enviarCorreo($direccionDelRecipiente, $nombreDelRecipiente, $asunto, $mensaje){
	require_once  'bibliotecas/PHPMailerAutoload.php';
	$correo = new PHPMailer();  
	// conéctate con Gmail 
	$correo->IsSMTP();   
	$correo->SMTPAuth = true;
	$correo->SMTPSecure = "ssl";
	$correo->Host = "smtp.gmail.com";
	$correo->Port = 465;
	// identifícate con Gmail
	$correo->Username = "angel.uzielh@gmail.com";
	$correo->Password = "ilei itdo mfvs pdov";
	// componer correo
	$correo->isHTML(true);
	$correo->SetFrom("angel.uzielh@gmail.com", "UzielHdz");
	$correo->Subject = $asunto;
	$correo->CharSet = 'UTF-8';
	$mensaje = "<body style=\"font-family:Verdana, Verdana,Geneva,sans-serif; font-size:14px; color:#000;\">".$mensaje ."</body></html>";
	$correo->AddAddress($direccionDelRecipiente,$nombreDelRecipiente);
	$correo->Body = $mensaje;
	// Enviar correo
	if($correo->Send()){
		echo "<script>alert('Hemos enviado una confirmación a tu correo electrónico' );</script>";
	}else{
		echo "<script>alert('No se pudo enviar correo electrónico');</script>";
		}
	}
	
?>