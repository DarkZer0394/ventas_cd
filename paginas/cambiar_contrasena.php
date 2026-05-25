<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Tienda</title>
		<link rel="stylesheet" href="../estilos/tienda.css" />
	</head>
	<body>
		<div class="contenido">
			<form name="formulario" method="POST"  
					enctype="multipart/form-data" action=""  
					onsubmit=" if(document.formulario.contraseña1 !== document.formulario.contraseña2){
								alert('contraseñas deben ser idénticas');
								return false;">
				<p id="título_de_página">Cambio de contraseña</p>
				<input required type="email" name="correo_electronico" placeholder="por@ejemplo.com" />
				<br>  
				<input required type="password" name="contraseña1" placeholder="nueva contraseña"/>
				<br>
				<input required type="password" name="contraseña2" placeholder="repetir contraseña"  />
				<br>
				<div class="contenedorIcon">
					<input type="submit" class="icon" id="enviar" name="enviar" value="&rarr;" />
				</div>
			</form>
		</div>
	</body>
</html>
<?php
	if(isset($_POST["enviar"])) {
		if(isset($_GET["fichaToken"]) && isset($_GET["marcaTemporal"])){  
			$fichaToken = $_GET["fichaToken"];
			$marcaTemporal = $_GET["marcaTemporal"];
			$mensaje = "";
			$correoElectronico = htmlspecialchars($_POST["correo_electronico"]);
			$contraseña = htmlspecialchars($_POST["contraseña1"]);
			$contraseñaCifrada=password_hash(   $contraseña,PASSWORD_DEFAULT);
			include("../conexion.php");
			$sql = "SELECT * FROM cliente WHERE correo_electronico = ? AND ficha_token = ?";
			$stmt = $conexion->prepare($sql);
			try {
				$stmt->execute(array($correoElectronico,$fichaToken));
				$stmt = $stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt) {
					$marcaTemporal_2 = new DateTime("now");
					$marcaTemporal_2 = $marcaTemporal_2->getTimestamp();
					// controlar caducación de 12 horas 43200
					if(($marcaTemporal_2 - $marcaTemporal) < 43200){
						$query = "UPDATE cliente SET contraseña = ? WHERE correo_electronico = ?";
						$stmt = $conexion->prepare($query);
						$stmt = $stmt->execute(array($contraseñaCifrada,$correoElectronico));
						if($stmt) {
							echo "<script>alert('Tu contraseña ha sido reestablecida.');location.href='../index.php';</script>";
						}    
					}else{
						echo "<script>alert('Enlace ya no es válido.');location.href='../index.php';</script>";
					}    
				}
				}catch(PDOException $e) {
					echo $e->getMessage();
					}
		}
	}
?>