<?php
if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
    echo "<script>
            alert('No estás autorizado para ver esta página');
            location.href='../index.php';
          </script>";
}
?>
<div class="contenido">
    <table id="tabel" border="0" cellspacing="3">
        <caption>
            <h3>Clientes registrados</h3>
        </caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Direccion</th>
                <th>Codigo Postal</th>
                <th>Ciudad</th>
                <th>Correo electrónico</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT * FROM cliente WHERE rol = 0";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(array());
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bgcolor = true;
            foreach($clientes as $cliente) {
                echo ($bgcolor ? "<tr bgcolor=#ccc>" : "<tr>");
                echo
                    "<td>" . $cliente['nombre'] . "</td>" .
                    "<td>" . $cliente['apellido'] . "</td>" .
                    "<td>" . $cliente['direccion'] . "</td>" .
                    "<td>" . $cliente['codigo_postal'] . "</td>" .
                    "<td>" . $cliente['ciudad'] . "</td>" .
                    "<td>" . $cliente['correo_electronico'] . "</td>" .
                    "<td>
                        <a style='text-decoration:none'href='index.php?pagina=editar_cliente&numero=" . $cliente['numero_cliente'] . "'>&#9989;</a>
                    </td>";
                echo "</tr>";
                $bgcolor = ($bgcolor ? false : true);
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">
                    Total de clientes: <?php echo count($clientes); ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>