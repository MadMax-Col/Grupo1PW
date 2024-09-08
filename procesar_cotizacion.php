<?php
// Conexión a la base de datos
$serverName = "kepler.database.windows.net";
$connectionOptions = array(
    "Database" => "Kepler_DB",
    "Uid" => "kepler_2412",
    "PWD" => "13120071P4ssw0rd",
    "Encrypt" => true
);

// Establecer la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Recibir los datos del formulario
$nombres = $_POST['nombres'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$productos = $_POST['productos'];
$cantidades = $_POST['cantidades'];

// Insertar datos del cliente
$insertClienteQuery = "INSERT INTO Clientes (nombres_apellidos, ciudad, direccion, celular) VALUES (?, ?, ?, ?)";
$params = array($nombres, $ciudad, $direccion, $celular);
sqlsrv_query($conn, $insertClienteQuery, $params);

// Obtener el ID del cliente insertado
$clienteIdQuery = "SELECT @@IDENTITY AS cliente_id";
$getClienteId = sqlsrv_query($conn, $clienteIdQuery);
$clienteId = sqlsrv_fetch_array($getClienteId)['cliente_id'];

// Insertar los productos en la tabla Cotizaciones
for ($i = 0; $i < count($productos); $i++) {
    $productoId = $productos[$i];
    $cantidad = $cantidades[$i];

    // Obtener el precio unitario del producto seleccionado
    $getPrecioQuery = "SELECT precio_unitario FROM Productos WHERE producto_id = ?";
    $paramsPrecio = array($productoId);
    $getPrecioResult = sqlsrv_query($conn, $getPrecioQuery, $paramsPrecio);
    $precioUnitario = sqlsrv_fetch_array($getPrecioResult)['precio_unitario'];

    // Calcular el total para el producto
    $total = $cantidad * $precioUnitario;

    if (!empty($cantidad)) {
        $insertCotizacionQuery = "INSERT INTO Cotizaciones (cliente_id, producto_id, cantidad, total) VALUES (?, ?, ?, ?)";
        $params = array($clienteId, $productoId, $cantidad, $total);
        sqlsrv_query($conn, $insertCotizacionQuery, $params);
    }
}

// Redirigir a la página de resumen de la cotización
header("Location: mostrar_cotizacion.php?cliente_id=$clienteId");
exit();
?>
