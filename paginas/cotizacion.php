<?php
if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
    echo "<script>
            alert('No estás autorizado para ver esta página');
            location.href='../index.php';
          </script>";
}

// Obtener todos los álbumes para los select
try {
    $sql = "SELECT numero_album, titulo, artista, precio 
            FROM album 
            WHERE existencias > 0";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(array());
    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo $e->getMessage();
}

// Obtener todos los clientes para el select de cliente
try {
    $sql2 = "SELECT numero_cliente, nombre, apellido, 
                    direccion, correo_electronico
             FROM cliente 
             WHERE rol = 0";
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->execute(array());
    $clientes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>

<style>
    .cotizacion-contenedor {
        width: 75%;
        margin: 3% auto;
        font-family: Verdana, Geneva, sans-serif;
        font-size: 13px;
        color: #333;
    }

    /* ── Título principal ── */
    .cot-titulo {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: 3px;
        margin-bottom: 5px;
        color: #000;
    }

    /* ── Fila logo + datos generales ── */
    .cot-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
    }
    .cot-logo {
        font-size: 1.4rem;
        color: #3a7bd5;
        font-weight: bold;
    }
    .cot-datos-generales {
        text-align: right;
        font-size: 13px;
    }
    .cot-datos-generales span {
        font-weight: bold;
    }

    /* ── Dos columnas: Empresa / Cliente ── */
    .cot-partes {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    .cot-parte {
        flex: 1;
        border: 1px solid #ccc;
        padding: 10px;
    }
    .cot-parte-titulo {
        background-color: #555;
        color: #fff;
        text-align: center;
        padding: 5px;
        font-weight: bold;
        margin: -10px -10px 10px -10px;
        font-size: 12px;
        letter-spacing: 1px;
    }
    .cot-parte p {
        margin: 3px 0;
    }

    /* ── Sección descripción ── */
    .cot-descripcion-titulo {
        background-color: #eee;
        border: 1px solid #ccc;
        padding: 8px 10px;
        font-weight: bold;
        font-size: 12px;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    /* ── Tabla de artículos ── */
    .cot-tabla {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    .cot-tabla th {
        background-color: #555;
        color: #fff;
        padding: 6px 8px;
        text-align: left;
        font-size: 12px;
        letter-spacing: 1px;
    }
    .cot-tabla th.derecha,
    .cot-tabla td.derecha {
        text-align: right;
    }
    .cot-tabla td {
        padding: 5px 8px;
        border-bottom: 1px solid #ddd;
        vertical-align: middle;
    }
    .cot-tabla tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* ── Inputs y selects dentro de la tabla ── */
    .cot-tabla select,
    .cot-tabla input[type="number"] {
        width: 100%;
        padding: 3px;
        border: 1px solid #ccc;
        border-radius: 3px;
        background-color: #fff;
        font-size: 12px;
        height: 28px;
        margin: 0;
        color: #333;
        display: inline-block;
    }
    .td-id {
        width: 30px;
        text-align: center;
        color: #777;
    }
    .td-uds {
        width: 60px;
    }
    .td-precio {
        width: 90px;
        text-align: right;
    }
    .td-total {
        width: 100px;
        text-align: right;
        font-weight: bold;
    }

    /* ── Sección de totales ── */
    .cot-totales {
        width: 100%;
        margin-top: 5px;
    }
    .cot-totales td {
        padding: 4px 8px;
    }
    .cot-totales .etiqueta {
        text-align: right;
        font-weight: bold;
        font-size: 12px;
        letter-spacing: 1px;
        color: #555;
        width: 70%;
    }
    .cot-totales .valor {
        text-align: right;
        font-weight: bold;
        width: 15%;
    }
    .cot-totales .total-final {
        background-color: #555;
        color: #fff;
    }

    /* ── Firmas ── */
    .cot-firmas {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-size: 12px;
    }
    .cot-firma-bloque {
        width: 45%;
    }
    .cot-firma-bloque p {
        font-weight: bold;
        border-top: 1px solid #555;
        padding-top: 5px;
        margin-bottom: 5px;
    }
    .cot-firma-bloque span {
        display: block;
        margin: 2px 0;
        color: #666;
    }

    /* ── Botón imprimir ── */
    .btn-imprimir {
        display: block;
        margin: 15px auto;
        padding: 10px 30px;
        background-color: #555;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        letter-spacing: 1px;
    }
    .btn-imprimir:hover {
        background-color: #333;
    }
    @media print {
        .btn-imprimir { display: none; }
        .encabezado   { display: none; }
    }
</style>

<div class="cotizacion-contenedor">

    <!-- ══ TÍTULO ══ -->
    <div class="cot-titulo">COTIZACIÓN</div>

    <!-- ══ HEADER: logo + datos generales ══ -->
    <div class="cot-header">
        <div class="cot-logo">mi_tiendita</div>
        <div class="cot-datos-generales">
            <p><span>Fecha:</span> 
               <?php echo date('d/m/Y'); ?>
            </p>
            <p><span>Precio total: $</span> 
               <span id="resumen-total">0.00</span>
            </p>
            <p><span>N° cotización:</span> 
               COT-<?php echo date('Ymd') . rand(10,99); ?>
            </p>
        </div>
    </div>

    <!-- ══ EMPRESA / CLIENTE ══ -->
    <div class="cot-partes">

        <!-- Empresa -->
        <div class="cot-parte">
            <div class="cot-parte-titulo">EMPRESA</div>
            <p><strong>Nombre:</strong> Mi Tiendita S.A.</p>
            <p><strong>Dirección:</strong> Calle Principal #123</p>
            <p><strong>Teléfono:</strong> 55-1234-5678</p>
            <p><strong>Email:</strong> contacto@mitiendita.com</p>
            <p><strong>Contacto:</strong> Administrador</p>
        </div>

        <!-- Cliente (select dinámico) -->
        <div class="cot-parte">
            <div class="cot-parte-titulo">CLIENTE</div>
            <p>
                <strong>Nombre:</strong>
                <select id="select-cliente" 
                        onchange="cargarDatosCliente(this)">
                    <option value="">-- Seleccionar cliente --</option>
                    <?php foreach($clientes as $c): ?>
                    <option 
                        value="<?php echo $c['numero_cliente']; ?>"
                        data-nombre="<?php echo $c['nombre']  
                                           . ' ' . $c['apellido']; ?>"
                        data-direccion="<?php echo $c['direccion']; ?>"
                        data-correo="<?php echo $c['correo_electronico']; ?>">
                        <?php echo $c['nombre'] . ' ' . $c['apellido']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p><strong>Dirección:</strong> 
               <span id="cli-direccion">—</span>
            </p>
            <p><strong>Email:</strong> 
               <span id="cli-correo">—</span>
            </p>
        </div>

    </div><!-- fin cot-partes -->

    <!-- ══ DESCRIPCIÓN DEL SERVICIO ══ -->
    <div class="cot-descripcion-titulo">
        DESCRIPCIÓN DEL SERVICIO Y COTIZACIÓN
    </div>

    <!-- ══ TABLA DE ARTÍCULOS ══ -->
    <table class="cot-tabla">
        <thead>
            <tr>
                
                <th>DESCRIPCIÓN</th>
                <th class="td-uds derecha">UDS</th>
                <th class="td-precio derecha">PRECIO</th>
                <th class="td-total derecha">TOTAL</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Crear 5 filas con select de álbumes
        for($i = 1; $i <= 5; $i++):
        ?>
            <tr id="fila-<?php echo $i; ?>">
                

                <!-- Select de álbumes -->
                <td>
                    <select id="album-<?php echo $i; ?>" onchange="actualizarFila(<?php echo $i; ?>)">
                        <option value="" 
                                data-precio="0">
                            -- Seleccionar álbum --
                        </option>
                        <?php foreach($albums as $album): ?>
                        <option 
                            value="<?php echo $album['numero_album']; ?>"
                            data-precio="<?php echo $album['precio']; ?>">
                            <?php echo $album['titulo'] 
                                     . ' — ' 
                                     . $album['artista']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Cantidad -->
                <td class="td-uds">
                    <input 
                        type="number" 
                        id="cantidad-<?php echo $i; ?>"
                        value="1" 
                        min="1"
                        onchange="actualizarFila(<?php echo $i; ?>)" />
                </td>

                <!-- Precio unitario (solo lectura) -->
                <td class="td-precio">
                    $ <span id="precio-<?php echo $i; ?>">0.00</span>
                </td>

                <!-- Total de la fila -->
                <td class="td-total">
                    $ <span id="total-<?php echo $i; ?>">0.00</span>
                </td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <!-- ══ TOTALES ══ -->
    <table class="cot-totales">
        <tr>
            <td class="etiqueta">SUBTOTAL</td>
            <td class="valor">$</td>
            <td class="valor" id="subtotal">0.00</td>
        </tr>
        <tr>
            <td class="etiqueta">IVA</td>
            <td class="valor"></td>
            <td class="valor">16%</td>
        </tr>
        <tr>
            <td class="etiqueta">IMPORTE IVA</td>
            <td class="valor">$</td>
            <td class="valor" id="importe-iva">0.00</td>
        </tr>
        <tr>
            <td class="etiqueta total-final">TOTAL</td>
            <td class="valor total-final">$</td>
            <td class="valor total-final" id="total-final">0.00</td>
        </tr>
    </table>

    <!-- ══ FIRMAS ══ -->
    <div class="cot-firmas">
        <div class="cot-firma-bloque">
            <p>FIRMA EMPRESA</p>
            <span>Firma y sello:</span>
            <span>Lugar y fecha:</span>
        </div>
        <div class="cot-firma-bloque" style="text-align:right;">
            <p>FIRMA CLIENTE</p>
            <span>Firma:</span>
            <span>Lugar y fecha:</span>
        </div>
    </div>

    <!-- ══ BOTÓN IMPRIMIR ══ -->
    <button class="btn-imprimir" onclick="window.print()">
        🖨️ Imprimir / Guardar PDF
    </button>

</div><!-- fin cotizacion-contenedor -->

<script>
// ── Cargar datos del cliente seleccionado ──
function cargarDatosCliente(select) {
    var opcion     = select.options[select.selectedIndex];
    var nombre     = opcion.getAttribute('data-nombre');
    var direccion  = opcion.getAttribute('data-direccion');
    var correo     = opcion.getAttribute('data-correo');

    document.getElementById('cli-direccion').innerText 
        = direccion || '—';
    document.getElementById('cli-correo').innerText    
        = correo    || '—';
}

// ── Actualizar precio y total de una fila ──
function actualizarFila(id) {
    var selectAlbum = document.getElementById('album-'    + id);
    var cantidad    = document.getElementById('cantidad-' + id);
    var spanPrecio  = document.getElementById('precio-'   + id);
    var spanTotal   = document.getElementById('total-'    + id);

    // Obtener precio del data-attribute del option seleccionado
    var opcion  = selectAlbum.options[selectAlbum.selectedIndex];
    var precio  = parseFloat(opcion.getAttribute('data-precio')) || 0;
    var uds     = parseInt(cantidad.value) || 1;
    var total   = precio * uds;

    spanPrecio.innerText = precio.toFixed(2);
    spanTotal.innerText  = total.toFixed(2);

    // Recalcular totales generales
    recalcularTotales();
}

// ── Recalcular subtotal, IVA y total general ──
function recalcularTotales() {
    var subtotal = 0;

    // Sumar todos los totales de las 5 filas
    for(var i = 1; i <= 5; i++) {
        var spanTotal = document.getElementById('total-' + i);
        subtotal += parseFloat(spanTotal.innerText) || 0;
    }

    var iva          = subtotal * 0.16;
    var totalFinal   = subtotal + iva;

    document.getElementById('subtotal').innerText    
        = subtotal.toFixed(2);
    document.getElementById('importe-iva').innerText 
        = iva.toFixed(2);
    document.getElementById('total-final').innerText 
        = totalFinal.toFixed(2);

    // Actualizar también el resumen del header
    document.getElementById('resumen-total').innerText 
        = totalFinal.toFixed(2);
}
</script>