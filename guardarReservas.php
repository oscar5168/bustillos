<?php 
$host = "localhost";
$usuario = "root";
$pasword = "";
$bd = "bustillos";

$conexion = new mysqli($host, $usuario,$pasword,$bd);

if($conexion->connect_error){
    die("error de conexion: ".$conexion->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$reservas = $data["reservas"];
$disponibles = $data["disponibles"];


foreach ($reservas as $reserva) {
    $d = intval($reserva["dias"]);
    $m = intval($reserva["mes"]);
    $a = intval($reserva["anio"]);
    $estado = $conexion->real_escape_string($reserva["estado"]);

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

foreach($disponibles as $disp){
    $d = intval($disp["dias"]);
    $m = intval($disp["mes"]);
    $a = intval(value: $disp["anio"]);
    $estado = $conexion->real_escape_string($disp["estado"]);
 
    $delete = $conexion->prepare("DELETE FROM diasocupados WHERE dias = ? AND mes = ? AND anio = ?");
    $delete->bind_param("iii", $d, $m, $a);
    $delete->execute();
    $delete->close();
}

$conexion->close();
echo "Días guardados";
?>