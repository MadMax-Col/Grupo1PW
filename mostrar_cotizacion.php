<?php
// Conexión a la base de datos
$serverName = "kepler.database.windows.net";
$connectionOptions = array(
    "Database" => "Kepler_DB",
    "Uid" => "kepler_2412",
    "PWD" => "13120071P4ssw0rd",
    "Encrypt" => true
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Obtener el ID del cliente
$cliente_id = $_GET['cliente_id'];

// Consultar los datos del cliente
$clienteQuery = "
    SELECT nombres_apellidos, ciudad, direccion, celular
    FROM Clientes
    WHERE cliente_id = ?
";
$paramsCliente = array($cliente_id);
$getCliente = sqlsrv_query($conn, $clienteQuery, $paramsCliente);

if ($getCliente === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Obtener los datos del cliente
$cliente = sqlsrv_fetch_array($getCliente, SQLSRV_FETCH_ASSOC);

// Consultar los detalles de la cotización
$query = "
    SELECT P.nombre_producto, CO.cantidad, P.precio_unitario, CO.total
    FROM Cotizaciones CO
    JOIN Productos P ON CO.producto_id = P.producto_id
    WHERE CO.cliente_id = ?
";
$params = array($cliente_id);
$results = sqlsrv_query($conn, $query, $params);

if ($results === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Cotización</title>
    <link rel="stylesheet" href="Styles.css">
</head>
<body>
    <h1>Resumen de la Cotización</h1>

    <!-- Mostrar la información del cliente en el encabezado -->
    <div>
        <h2>Información del Cliente</h2>
        <p><strong>Nombres y Apellidos:</strong> <?php echo $cliente['nombres_apellidos']; ?></p>
        <p><strong>Ciudad:</strong> <?php echo $cliente['ciudad']; ?></p>
        <p><strong>Dirección:</strong> <?php echo $cliente['direccion']; ?></p>
        <p><strong>Celular:</strong> <?php echo $cliente['celular']; ?></p>
    </div>

    <table border="1">
        <tr>
            <th>Nombre del Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>

        <?php
        $granTotal = 0;
        while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
            $granTotal += $row['total'];
            echo "<tr>";
            echo "<td>" . $row['nombre_producto'] . "</td>";
            echo "<td>" . $row['cantidad'] . "</td>";
            echo "<td>$" . number_format($row['precio_unitario'], 2) . "</td>";
            echo "<td>$" . number_format($row['total'], 2) . "</td>";
            echo "</tr>";
        }
        ?>

        <tr>
            <td colspan="3">Total General</td>
            <td><?php echo "$" . number_format($granTotal, 2); ?></td>
        </tr>
    </table>

    <a href="index.html">Volver al inicio</a>
</body>
</html>
