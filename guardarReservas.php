<?php 

$host = "localhost";
$usuario = "root";
$pasword = "";
$bd = "bustillos";

$conexion = new mysqli($host, $usuario,$pasword,$bd);

if($conexion->connect_error){
    die("error de conexion: ".$conexion->connect_error);
}

$input = file_get_contents("php://input");
$dias = json_decode($input, true);

foreach ($dias as $dia) {
    $d = intval($dia["dias"]);
    $m = intval($dia["mes"]);
    $a = intval($dia["anio"]);
    $estado = $conexion->real_escape_string($dia["estado"]);

    // Verificar si ya existe
    $check = $conexion->prepare("SELECT ID FROM diasocupados WHERE dias = ? AND mes = ? AND anio = ?");
    $check->bind_param("iii", $d, $m, $a);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        // Insertar si no existe
        $stmt = $conexion->prepare("INSERT INTO diasocupados (dias, mes, anio, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $d, $m, $a, $estado);
        $stmt->execute();
        $stmt->close();
    }

    $check->close();
}

$conexion->close();
echo "Días guardados";
?>