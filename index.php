<?php
session_start();
include_once("conexion.php");
include_once("funciones.php");
include_once("encabezado.html");


if(isset($_GET["pagina"])){
	$pagina = $_GET["pagina"];
}
else{
	$pagina= "inicio";
}
if($pagina){
	include("paginas/" . $pagina . ".php");
}
?>