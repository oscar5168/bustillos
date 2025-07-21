<?php
$host = "localhost";
$user = "root";
$pasword = "";
$bd = "bustillos";

$conexion = new mysqli($host, $user, $pasword, $bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// OJO: aquí usamos "dias" porque así se llama la columna
$query = "SELECT dias, mes, anio FROM diasOcupados WHERE estado = 'reservado'";
$resultado = $conexion->query($query);

$dias = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $dias[] = $fila;
    }
}

header('Content-Type: application/json');
echo json_encode($dias);

$conexion->close();
?>
