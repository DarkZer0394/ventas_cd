<?php
	if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA")  {
		echo "<script>  alert('No estas autorizado para ver esta pagina'); location.href='../index.php'; </script>"; 
	}
?>
<div class="contenido">
	<table border="0" cellspacing="0">
		<caption>Totales por pedidos<br><br></caption>
		<thead>
			<tr>
				<th>Cliente</th>
				<th>Orden</th>
				<th>Titulo</th>
				<th>Cantidad</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$sql = " SELECT cliente.apellido, articulo.numero_de_orden, album.titulo,
					articulo.cantidad FROM cliente
					INNER JOIN (orden 
					INNER JOIN (articulo 
					INNER JOIN album 
					ON album.numero_album = articulo.numero_de_album)
					ON orden.numero_de_orden = articulo.numero_de_orden)
					ON cliente.numero_cliente = orden.numero_de_cliente";
					$stmt = $conexion->prepare($sql);
					$stmt->execute(array()); 
					$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$bgcolor = true;
					$orden = $articulos[0]['numero_de_orden']; 
					$subtotal = 0; 
					$total = 0; 
					$nuevaOrden = true;
					foreach($articulos as $articulo) {  
						if($articulo['numero_de_orden'] != $orden){
							// mostrar subtotal
							echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
							echo "<td></td><td></td> <td> Subtotal.....</td> <td align='center'>".$subtotal."</td></tr>";
							$total += $subtotal;
							$subtotal = 0;
							$nuevaorden = true;
							$orden = $articulo['numero_de_orden'];
						}
						// nuevo grupo
						if($nuevaOrden){ 
							$bgcolor= ($bgcolor ? false:true); 
							echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
							echo "<td>".$articulo['apellido']."</td> <td>".$articulo['numero_de_orden']."</td>";
							echo"<td>".$articulo['titulo']."</td> <td>".$articulo['cantidad']."</td></tr>";
							$subtotal += $articulo['cantidad'];
							$nuevaorden = false;   
						}else{
							// no repetir nombre del cliente ni numero de orden  
							echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
							echo "<td></td><td></td>"; 
							echo"<td>".$articulo['titulo']."</td> <td>".$articulo['cantidad']."</td></tr>";
							$subtotal += $articulo['cantidad'];
						}    
					} 
					// mostrar ultimo subtotal y gran total
					echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
					echo "<td></td><td></td>   <td> Subtotal.....</td> <td>".$subtotal."</td></tr>";
					$total += $subtotal; 
					echo "<tr><td></td><td></td> <td> Total.....</td> <td>".$total."</td> </tr>";
		?>
		</tbody> 
	</table> 
</div>
<div class="contenido">
	<a class="icon" style="font-size:1.5rem;" href="paginas/generar_pdf.php?informe=pedidos">PDF</a>
</div>