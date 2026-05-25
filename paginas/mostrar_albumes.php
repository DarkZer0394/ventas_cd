<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
		echo "<script>  alert('No estás autorizado para ver esta página'); location.href='../index.php'; </script>"; }
?>
<div class="contenido" >
	<table id='tabel'  border="0" cellspacing="3">
		<caption>
			<h3>Editar álbumes</h3>
		</caption>
		<thead>
		<tr> 
			<th>Título</th> 
			<th>Artista</th>
			<th>Género</th>
			<th>Precio</th>
		</tr>
		</thead>
		<tbody>
		<?php
			$sql = "SELECT * FROM album";
			$stmt = $conexion->prepare($sql);
			$stmt->execute(array());
			$álbumes = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$bgcolor = true;
			foreach($álbumes as $álbum) {
				$númeroDeAlbum = $álbum['numero_album'];
				echo ($bgcolor ? "<tr bgcolor=#ccc>" : "<tr>");
				echo    
					"<td>".$álbum['titulo']."</td>".
					"<td>".$álbum['artista']."</td>".
					"<td>".$álbum['genero']."</td>".
					"<td>".$álbum['precio']."</td>".
					"<td><a style='text-decoration:none' href='index.php?pagina=editar_album&numero=". $álbum['numero_album']."'>&#9989;</a></td>
					</tr>";
					$bgcolor= ($bgcolor ? false:true);
			}
		?> 
		</tbody> 
	</table>
</div>