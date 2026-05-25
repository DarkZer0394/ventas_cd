<?php
DEFINE("USUARIO","root");
DEFINE("CONTRASEÑA","");
try{
	$conexion = new
	PDO("mysql:host=localhost;dbname=Compras_en_linea",
	USUARIO,CONTRASEÑA);
	$conexion->setAttribute(
	PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
	echo $e->getMessage();
	echo "No se pudo realizar la conexión.";
}
?>