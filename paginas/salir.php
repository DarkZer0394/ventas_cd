<?php  
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA"){
		echo "<script>    
				alert('No estás autorizado para ver esta página');
				location.href='../index.php';   
			</script>";
	}

	unset($_SESSION["ID"]);
	unset($_SESSION["USUARIO"]);
	unset($_SESSION["STATUS"]);
	unset($_SESSION["CORREO"]);
	unset($_SESSION["ROL"]);
	// destruir sesión 
	session_destroy();  //cerrar conexión
	$conexión = null;
	echo "<script>location.href='".$_SERVER["PHP_SELF"].
	"'</script>";
?>