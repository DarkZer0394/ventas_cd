<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
		echo "<script>
					alert('No estás autorizado para ver esta página');
					location.href='../index.php';
		   	 </script>"; 
	}
	try{
		$sql = "SELECT * FROM cliente WHERE correo_electronico = ?";
		$stmt = $conexion->prepare($sql);
		$stmt->execute(array( $_SESSION["CORREO"] )); 
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e) {
		echo $e->getMessage();
	}
?>

<div class="contenido">
	<form method="POST" action="index.php?pagina=mutar_perfil">
		<p id="título_de_página">Editar</p>
		<input type="text" required name="nombre" value="<?php echo $resultado['nombre']; ?>" />
		<input type="text" required name="apellido" value="<?php echo $resultado['apellido']; ?>" />
		<input type="text" required name="direccion" value="<?php echo $resultado['direccion']; ?>"/>
		<input type="text" required name="codigo_postal" value="<?php echo $resultado['codigo_postal']; ?>" />
		<input type="text" required name="ciudad" value="<?php echo $resultado['ciudad']; ?>" />
		<input type="email" required name="correo_electronico" value="<?php echo $resultado['correo_electronico']; ?>" />
		<br/>  
		<div class="contenedorIcon">
			<input type="submit" class="icon" id="enviar" name="enviar" value="&rarr;" />
		</div>
		<a href="index.php?pagina=tienda">Regresar</a>
	</form>
</div>