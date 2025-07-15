<?php 

$host = "localhost";
$user = "root";
$pasword = "";
$bd = "bustillos";

$conexion =  new mysqli($host,$user, $pasword, $bd);

if($conexion ->connect_error){
    die("Conexion fallida". $conexion->connect_error);
}

$nombre = $_POST['nombre'];

$ask = "SELECT * FROM reserva WHERE nombre = '$nombre'";
$result = $conexion->query($ask);

if($result->num_rows == 0){
    echo "Su reserva no existe";
}else{
    echo "Desea cancelar su reserva";
}



?>