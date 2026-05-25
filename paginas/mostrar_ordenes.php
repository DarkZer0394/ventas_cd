<?php
if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
    echo "<script>alert('No estás autorizado para ver esta página');location.href='../index.php';</script>";
}
?>
<div class="contenido">
    <table id="tabel" border="0" cellspacing="3">
        <caption>
            <h3>Órdenes registradas</h3>
        </caption>
        <thead>
            <tr>
                <th>Número de orden</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Ver detalle</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // JOIN para obtener también el nombre del cliente
            $sql = "SELECT orden.numero_de_orden,orden.fecha,cliente.nombre,cliente.apellido FROM orden INNER JOIN cliente ON orden.numero_de_cliente = cliente.numero_cliente ORDER BY orden.fecha DESC";

            $stmt = $conexion->prepare($sql);
            $stmt->execute(array());
            $ordenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bgcolor = true;
            foreach($ordenes as $orden) {
                echo ($bgcolor ? "<tr bgcolor=#ccc>" : "<tr>");
                echo
                    "<td>" . $orden['numero_de_orden'] . "</td>" .
                    "<td>" . $orden['nombre'] . " ". $orden['apellido'] . "</td>" .
                    "<td>" . date('d-m-Y',strtotime($orden['fecha'])) . "</td>" .
                    "<td>
                        <a style='text-decoration:none'href='factura.php?numeroDeOrden=" . $orden['numero_de_orden'] . "'>&#9989;</a>
                    </td>";
                echo "</tr>";
                $bgcolor = ($bgcolor ? false : true);
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">
                    Total de órdenes: <?php echo count($ordenes); ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>