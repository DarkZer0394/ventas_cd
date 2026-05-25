<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
		echo "<script>
				alert('No estás autorizado para ver esta página');
				location.href='../index.php';
			</script>";
	}    
	if(isset($_POST['enviar'])) {
		$nombre =htmlspecialchars($_POST['nombre']);
		$apellido =htmlspecialchars($_POST['apellido']);
		$direccion =htmlspecialchars($_POST['direccion']);
		$codigoPostal =htmlspecialchars($_POST['codigo_postal']);
		$ciudad =htmlspecialchars($_POST['ciudad']);
		$CorreoElectronico =htmlspecialchars($_POST['correo_electronico']);
		$query = "UPDATE cliente SET nombre = ?,apellido= ?,direccion=?,codigo_postal=?,ciudad=?,correo_electronico=? WHERE correo_electronico=?";
		$stmt = $conexion->prepare($query);
		try{
			$stmt = $stmt->execute(array($nombre,$apellido,$direccion,$codigoPostal,$ciudad,$CorreoElectronico,$CorreoElectronico));
			if($stmt) {
				echo "<script>alert('Perfil ha sido actualizado');
						location.href='index.php?pagina=tienda';
						</script>";
			}
		}catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
?>