<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
		echo "<script>  alert('No estás autorizado para ver esta página');
				location.href='../index.php'; 
			</script>"; 
	}
	if(isset($_POST["enviar"])) {
	// crear orden
	$fecha = new DateTime();
	$fecha = date_format($fecha,"c");
	$sql = "INSERT INTO orden (numero_de_orden,numero_de_cliente,fecha) values (?,?,?)";
	$stmt = $conexion->prepare($sql);
	$data = array(NULL, $_SESSION['NUMERO_DE_CLIENTE'], $fecha);
	try{
		$stmt->execute($data);
		echo "<script>alert('Orden realizada.');</script>";
	}catch(PDOException $e) {
		echo $e->getMessage();
		echo "<script>
			alert('No fue posible realiar la orden.');
			</script>";
		echo "<script>
			location.href='index.php?página=tienda';
			</script>"; 
	}
	// crear artículo
    $númeroDeOrden = $conexion->lastInsertId();
	for($x=0; $x < $_POST['iteracion']; $x++){
		$cantidad = htmlspecialchars($_POST['cantidad'][$x]);
		if($cantidad == 0) continue;
		$númeroDeÁlbum = $_POST['numero_album'][$x];
		$precioDeVenta = $_POST['precio'][$x];
		$sql = "INSERT INTO articulo (numero_de_articulo,numero_de_orden, numero_de_album, precio_de_venta, cantidad) values (?,?,?,?,?)";
		$stmt = $conexion->prepare($sql);
		$data = array(NULL, $númeroDeOrden, $númeroDeÁlbum, $precioDeVenta, $cantidad);
		try{   
			$stmt->execute($data);
			echo "<script>alert('Artículo agregado ');</script>";
			echo "<script>location.href='index.php?pagina=nueva_orden';</script>";
		}catch(PDOException $e) {
			echo $e->getMessage();
			echo "<script>alert('Artículo no pudo ser agregado agregado ');</script>";
			echo "<script>location.href='index.php?pagina=tienda';   </script>";
		}
	}
	}
?>