<!DOCTYPE html>
<html lang ="es">
	<head>
		<meta charset="utf-8">
		<title>Tienda</title>
		<link rel="stylesheet" href="estilos/tienda.css" />
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>
	<body>
		<div class="contenido">
			<form name="entrar" method="POST" enctype="multipart/form-data"  action="">
				<p id="título_de_página">Reestablecer contraseña</p>
				<input type="email" required name="correo_electronico" placeholder="Correo electrónico" />
				<div class="g-recaptcha" data-sitekey="6Lf9GLAsAAAAANzDChYrWJapX64pZCDnrPeO8fYg"></div> 
				<br/>
				<div class="contenedorIcon">
					<input type="submit" class="icon" id="enviar" name="enviar" value="&rarr;" />
				</div>
				<a href="index.php">Regresar</a>
			</form>
		</div>
		<?php
		if (isset($_POST["enviar"])) {
			 $aviso = "";
			 $correoElectronico = htmlspecialchars($_POST['correo_electronico']);
			 // esta función genera un token aleatorio de
			 // 64 caracteres de largo.
			 $fichaToken = bin2hex(random_bytes(32));
			 $marcaTemporal = new DateTime("now");
			 $marcaTemporal = $marcaTemporal->getTimestamp();
			 include("conexion.php");
			 // guardar la ficha-token en la base de datos del cliente
			 try {
				  $sql = "UPDATE cliente SET ficha_token = ? WHERE correo_electronico = ?";
				  $stmt = $conexion->prepare($sql);
				  $stmt->execute(array($fichaToken, $correoElectronico));
			 } catch (PDOException $e) {
				  echo $e->getMessage();
			 }
			 // aquí generamos el path o enlace al script cambiar_contraseña.php
			 $enlace = sprintf("%s://%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/paginas/cambiar_contrasena.php");
			 $enlace = $enlace."?fichaToken=".$fichaToken."&marcaTemporal=".$marcaTemporal;
			 // enviar enlace al correo electrónico del cliente
			 include("funciones.php");
			 $asunto = "Reestablecer contraseña";
			 $mensaje = "<p>Si deseas reestablecer tu contraseña haz clic <a href=" . $enlace . ">aquí</a></p>";
			 try {
				  enviarCorreo($correoElectronico, "Cliente", $asunto, $mensaje);
				  $aviso = 'Te enviamos un correo electrónico.';
			 } catch (Exception $e) {
				  $aviso = 'No se pudo enviar correo electrónico';
			 }
			 echo "<div id='aviso'>" . $aviso . "</div>";
		}
		?>
	</body>
</html>