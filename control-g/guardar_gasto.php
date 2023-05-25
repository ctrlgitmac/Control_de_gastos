<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Conexión a la base de datos
$servername = "punored.com";
$username = "u215219";
$password = "1893928";
$dbname = "u215219_cg";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos enviados por Ajax
$gastos = json_decode($_POST['gastos'], true);

// Recorrer y guardar cada gasto en la base de datos
foreach ($gastos as $gasto) {
    $concepto = $gasto['concepto'];
    $monto = $gasto['monto'];
    $imagenes = $gasto['imagenes'];

    // Insertar el gasto en la tabla 'gastos'
    $sql = "INSERT INTO gastos (concepto, monto) VALUES ('$concepto', $monto)";
    if ($conn->query($sql) === TRUE) {
        $gasto_id = $conn->insert_id;

        // Insertar las imágenes asociadas al gasto en la tabla 'imagenes'
        foreach ($imagenes as $imagen) {
            $sql = "INSERT INTO imagenes (gasto_id, nombre) VALUES ($gasto_id, '$imagen')";
            $conn->query($sql);
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();