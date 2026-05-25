<?php
session_start();
include_once("conexion.php");

if(!isset($_GET["numeroDeOrden"])) {
    echo "Número de orden no válido.";
    exit;
}

$numeroDeOrden = $_GET["numeroDeOrden"];

try {
    
    $sql = "SELECT orden.numero_de_orden, 
                   orden.fecha,
                   cliente.nombre,
                   cliente.apellido
            FROM orden
            INNER JOIN cliente 
                ON orden.numero_de_cliente = cliente.numero_cliente
            WHERE orden.numero_de_orden = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(array($numeroDeOrden));
    $orden = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql2 = "SELECT articulo.cantidad,
                    articulo.precio_de_venta,
                    album.titulo,
                    album.portada,
                    (articulo.cantidad * articulo.precio_de_venta) 
                        AS importe
             FROM articulo
             INNER JOIN album 
                 ON articulo.numero_de_album = album.numero_album
             WHERE articulo.numero_de_orden = ?";
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->execute(array($numeroDeOrden));
    $articulos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <link rel="stylesheet" href="estilos/tienda.css" />

</head>
<body>
<div class="factura">
    <h2>Factura</h2>

    <div class="encabezado-factura">

        <div>
            <table>
                <tr>
                    <td>Cliente</td>
                    <td>Fecha</td>
                    <td>Número de orden</td>
                </tr>
                <tr>
                    <td>
                        <strong>
                        <?php 
                            echo $orden['nombre'] . " " 
                               . $orden['apellido']; 
                        ?>
                        </strong>
                    </td>
                    <td>
                        <?php 
                            echo date('d-m-Y', 
                                strtotime($orden['fecha'])); 
                        ?>
                    </td>
                    <td>
                        <?php echo $orden['numero_de_orden']; ?>
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <?php if(!empty($articulos[0]['portada'])): ?>
                <img 
                    src="imagenes/<?php echo $articulos[0]['portada']; ?>" 
                    width="80" 
                    alt="portada" 
                />
            <?php endif; ?>
        </div>

    </div>

    <table class="detalle-tabla">
        <tr>
            <th>Título</th>
            <th>cantidad</th>
            <th>precio</th>
            <th>Importe</th>
        </tr>
        <?php foreach($articulos as $articulo): ?>
        <tr>
            <td><?php echo $articulo['titulo'];         ?></td>
            <td><?php echo $articulo['cantidad'];       ?></td>
            <td><?php echo $articulo['precio_de_venta'];?></td>
            <td><?php echo $articulo['importe'];        ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>
</body>
</html>