<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA")  {
		echo "<script>alert('No estás autorizado para ver esta página');location.href='../index.php';</script>"; 
	}
	$sql = "SELECT * FROM album WHERE numero_album = ?";
	$stmt = $conexion->prepare($sql);
	$stmt->execute(array($_GET['numero']));
	$álbumes = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($álbumes as $álbum) {}
?>
		<div class="contenido">
			<form name="editar" class="form"action="index.php?pagina=mutar_album" method="POST">
				<p id="titulo_de_pagina">Editar álbum</p>
				<input type="hidden" name="numero_album" id="numero_album" value="<?php echo $álbum['numero_album']; ?>" />
				<label>Título:</label>
				<input type="text" name="titulo" id="titulo" value="<?php echo $álbum['titulo']; ?>" />
				<label>Artista:</label>
				<input type="text" name="artista" id="artista" value="<?php echo $álbum['artista']; ?>" />
				<label>Género:</label>
				<input type="text" name="genero" id="genero" value="<?php echo $álbum['genero']; ?>" />
				<label>Precio:</label><input type="text" name="precio" id="precio" value="<?php echo $álbum['precio']; ?>" />
				<br>
				<div class="contenedorIcon">
					<input type="submit" class="icon" id="enviar"  name="enviar"  value="&rarr;" />
				</div>
				<a href="index.php?pagina=mostrar_albumes">Regresar</a>
			</form>
		</div>
