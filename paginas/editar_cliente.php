<?php
if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
    echo "<script>
            alert('No estás autorizado para ver esta página');
            location.href='../index.php';
          </script>";
}

// Obtener los datos del cliente a editar
try {
    $sql = "SELECT * FROM cliente WHERE numero_cliente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(array($_GET['numero']));
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($clientes as $cliente) {}
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>

<div class="contenido">
    <form name="editar" class="form" 
          action="index.php?pagina=mutar_cliente" method="POST">

        <p id="titulo_de_pagina">Editar cliente</p>

        <input type="hidden" 
               name="numero_cliente" 
               value="<?php echo $cliente['numero_cliente']; ?>" />

        <label>Nombre:</label>
        <input type="text" name="nombre" 
               value="<?php echo $cliente['nombre']; ?>" />

        <label>Apellido:</label>
        <input type="text" name="apellido" 
               value="<?php echo $cliente['apellido']; ?>" />

        <label>Dirección:</label>
        <input type="text" name="direccion" 
               value="<?php echo $cliente['direccion']; ?>" />

        <label>Código postal:</label>
        <input type="text" name="codigo_postal" 
               value="<?php echo $cliente['codigo_postal']; ?>" />

        <label>Ciudad:</label>
        <input type="text" name="ciudad" 
               value="<?php echo $cliente['ciudad']; ?>" />

        <label>Correo electrónico:</label>
        <input type="email" name="correo_electronico" 
               value="<?php echo $cliente['correo_electronico']; ?>" />

        <br/>
        <div class="contenedorIcon">
            <input type="submit" class="icon" 
                   id="enviar" name="enviar" value="&rarr;" />
        </div>
        <a href="index.php?pagina=mostrar_clientes">Regresar</a>
    </form>
</div>