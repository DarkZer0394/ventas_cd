<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
		echo "<script>alert('No estás autorizado para ver esta página');location.href='../index.php';</script>";
	}
	if(isset($_POST['enviar'])) {
		$numeroCliente  = htmlspecialchars($_POST['numero_cliente']);
		$nombre         = htmlspecialchars($_POST['nombre']);
		$apellido       = htmlspecialchars($_POST['apellido']);
		$direccion      = htmlspecialchars($_POST['direccion']);
		$codigoPostal   = htmlspecialchars($_POST['codigo_postal']);
		$ciudad         = htmlspecialchars($_POST['ciudad']);
		$correo         = htmlspecialchars($_POST['correo_electronico']);

		$sql = "UPDATE cliente SET nombre = ?, apellido = ?, direccion = ?, codigo_postal = ?, ciudad = ?, correo_electronico = ? WHERE numero_cliente   = ?";
		$stmt = $conexion->prepare($sql);

		try {
			$stmt->execute(array($nombre,$apellido,$direccion,$codigoPostal,$ciudad,$correo,$numeroCliente));
			echo "<script>alert('Cliente actualizado correctamente.');location.href='index.php?pagina=mostrar_clientes';</script>";
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
?>