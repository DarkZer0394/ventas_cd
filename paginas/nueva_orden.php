<?php
// Verificar sesión activa
if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
    echo "<script>
            alert('No estás autorizado para ver esta página');
            location.href='../index.php';
          </script>";
}

try {
    $sql = "SELECT numero_de_orden FROM orden 
            WHERE numero_de_cliente = ? 
            ORDER BY numero_de_orden DESC 
            LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(array($_SESSION["NUMERO_DE_CLIENTE"]));
    $orden = $stmt->fetch(PDO::FETCH_ASSOC);
    $numeroDeOrden = $orden['numero_de_orden'];

} catch(PDOException $e) {
    echo $e->getMessage();
}

$enlace = sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])
);
$enlace = $enlace . "/factura.php?numeroDeOrden=" . $numeroDeOrden;

$asunto = "Confirmación de pedido";
$mensaje = "
    <p>Estimado " . $_SESSION["USUARIO"] . ",</p>
    <p>Gracias por su pedido. 
       Esta orden será enviada dentro de dos días.</p>
    <p>Haga clic <a href='" . $enlace . "'>aqui</a> 
       para ver su factura.</p>
    <p>Atentamente,<br>
    <strong>Mi_tiendita</strong></p>
";

enviarCorreo(
    $_SESSION["CORREO"],
    $_SESSION["USUARIO"],
    $asunto,
    $mensaje
);

echo "<script>
        alert('Tu pedido ha sido registrado. Revisa tu correo electrónico.');
        location.href='index.php?pagina=tienda';
      </script>";
?>