<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA")  {
		echo "<script> alert('No estás autorizado para ver esta página');location.href='../index.php';</script>";
	}
	if(isset($_POST['enviar'])){
		$númeroDeÁlbum= htmlspecialchars($_POST['numero_album']);
		$título = htmlspecialchars($_POST['titulo']);
		$artista = htmlspecialchars($_POST['artista']);
		$género = htmlspecialchars($_POST['genero']);
		$precio = htmlspecialchars($_POST['precio']);
		
		$sql = "UPDATE album SET titulo = ?, artista = ?, genero = ?, precio = ?  WHERE numero_album = ?";
		$stmt = $conexion->prepare($sql);
		
		try{
			$stmt = $stmt->execute(array($título, $artista,$género,$precio, $númeroDeÁlbum));
			echo "<script>alert('Álbum ha sido mutado.'); location.href='index.php?pagina=mostrar_albumes';</script>";
		}catch(PDOException $e) {
			echo  $e->getMessage();
		}
	}
?>