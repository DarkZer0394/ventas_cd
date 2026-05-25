<?php
include("registrar.html");
include("funciones.php");
include("conexion.php");
if(isset($_POST["enviar"])){
	$aviso="";
	$nombre=htmlspecialchars($_POST['nombre']);
	$apellido=htmlspecialchars($_POST['apellido']);
	$nombreCompleto=$nombre." ".$apellido;
	$direccion=htmlspecialchars($_POST['direccion']);
	$codigoPostal= htmlspecialchars($_POST['codigo_postal']);
	$ciudad= htmlspecialchars($_POST['ciudad']);
	$correoElectronico= htmlspecialchars($_POST['correo_electronico']);
	$contraseña= htmlspecialchars($_POST['contraseña']);
	$contraseñaCifrada= password_hash($contraseña,PASSWORD_DEFAULT);
	//CONFIRMAR SI EL CORREO ELECTRONICO YA EXISTE 
	$sql= "SELECT * FROM cliente WHERE correo_electronico =?";
	$stmt =$conexion->prepare($sql);
	$stmt->execute(array($correoElectronico));
	$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
	if($resultado){
		$aviso = "Este correo electronico ya esta registrado";
	}else{
		$sql= "INSERT INTO cliente(numero_cliente,nombre,apellido,direccion,codigo_postal,ciudad,correo_electronico,contraseña) values (null,?,?,?,?,?,?,?)";
		$stmt = $conexion->prepare($sql);
		try{
			$stmt->execute(array(
					$nombre,
					$apellido,
					$direccion,
					$codigoPostal,
					$ciudad,
					$correoElectronico,
					$contraseñaCifrada)
					);
			$aviso = "has abierto una cuenta.";
		}catch(PDOException $e){
			$aviso = "No se pudo realizar el registro." . $e->getMessage(); 
		}
		// preparar mensaje
		$asunto = "Registro";
		$mensaje = "Estimado $nombreCompleto, por este medio confirmamos la creación de tu cuenta en la tienda en línea.";
		// enviar correo electrónico
		enviarCorreo($correoElectronico, $nombreCompleto,$asunto,$mensaje);
	}
	echo "<div id='aviso'>".$aviso."</div>";
}
?>