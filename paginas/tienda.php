<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"]!= "ACTIVA"){
		echo "<script>
					alert('No estás autorizado para ver esta página');
					location.href='../index.php';
   			  </script>";
	}
?>

<div class="contenido" >
	<form name="búsqueda" id="búsqueda" action="" method="POST" >
		<div style="background-color:#C2F98E; height:20px; margin-top:5%;  padding:5.5px;">
			<input type="text" style = "float:left ;width:75%;" id="patrón" name="patrón" placeholder="Buscar álbumes" />
			<input type="submit" style = "float:none; width:20%; font-size:1.2rem;" id="buscar" name="buscar"  value="&#128270;"/><br>
		</div>
	</form>
</div>
<div class="contenido" >
	<form name="oferta" id="oferta"action="index.php?pagina=ordenar" method="POST" >
<?php
	if(isset($_POST["buscar"]) && !empty($_POST["patrón"])){
		$patrón = htmlspecialchars($_POST["patrón"]);
		$sql = "SELECT * fROM album WHERE titulo LIKE '%$patrón%' || artista LIKE '%$patrón%' || genero LIKE '%$patrón%'";
	}else{
		$sql = "SELECT * FROM album LIMIT 3";
	}     
	$stmt = $conexion->prepare($sql);
	$stmt->execute();
	$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$iteracion = 0;
	foreach($albums as $album) {
		echo "<img width = '120px' src = 'imagenes/". $album['portada'] ."'alt = 'no se encontró la imagen' />";
		echo "<input type='hidden' name = 'numero_album[$iteracion]' id = 'numero_album[$iteracion] ' value = '". $album['numero_album'] . "' />";
		echo "<input type='hidden' name = 'titulo[$iteracion]' id = 'titulo[$iteracion]' value = '". $album['titulo'] . "' />";
		echo "<input type='hidden' name = 'artista[$iteracion]' id = 'artista[$iteracion]' value = '". $album['artista'] . "' />";
		echo "<input type='hidden' name = 'genero[$iteracion]' id = 'genero[$iteracion]' value = '". $album['genero'] . "'  />";
		echo "<input type='hidden' name = 'precio[$iteracion]' id = 'precio[$iteracion]' value = '". $album['precio'] . "'  />";
		echo "<br> Titulo: " . $album['titulo'] ."<br>". "Precio: " . $album["precio"];
		echo "<br> Existencias: " .  $album["existencias"];
		echo "<br>Cantidad a ordenar :";
		echo "<input class= 'cantidad' type='text' name= 'cantidad[$iteracion]' id = 'cantidad[$iteracion]' value ='0'/>";
		echo "<hr />";
		$iteracion ++;
	}    
	echo "<input type = 'hidden' name = 'iteracion'	id = 'iteracion' value = '".$iteracion."'/>";
?>
	<input type = "checkbox" name="botonDeCanasta" id="botonDeCanasta" onclick="mostrarCanasta();" style="display:none;" />
	<label for="botonDeCanasta" style="font-size:4.2rem; cursor:pointer; ">&#128717;</label><br>
	<br>
	<div class = "contenedorIcon">
		<input type = "submit" class = "icon" id = "enviar" name = "enviar" value = "&rarr;" />
	</div>
	<br>
	</form>

</div>
<?php include 'canasta.php'; ?>
<script src="javascript/tienda.js"></script>
