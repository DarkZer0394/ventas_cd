<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA")  {
		echo "<script> alert('No estás autorizado para ver esta página');location.href='../index.php';</script>"; 
	}
?>
<div class="contenido" >
	<form name="informes" id="informes" action="" method="POST" >
		<select style="font-size:1.0rem" name="informe">
			<option  value="">Elegir informe</option>
			<option  value="pedidos">Pedidos</option>
			<option  value="existencias">Existencias</option>
		</select>
		<br>
		<div class="contenedorIcon">
			<input type="submit" class="icon" id="enviar"    name="enviar" value="&rarr;" />
		</div>
		<br>
	</form>
</div>
<?php
	if(isset($_POST["enviar"]) && $_POST["informe"]== "pedidos") {
		include_once("pedidos.php"); 
	}
	elseif(isset($_POST["enviar"]) && $_POST["informe"]== "existencias") {
		include_once("existencias.php");
	}
?>