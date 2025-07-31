<?php 
session_start();
$conexion = new mysqli("localhost", "root", "", "bustillos");

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$resultado = $conexion->query("SELECT * FROM admin WHERE usuario='$usuario'");

if ($resultado->num_rows == 1) {
    $fila = $resultado->fetch_assoc();
    if (password_verify($contrasena, $fila['contrasena'])) {
        // Guardar información en la sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['admin'] = true;

        // Redirigir a la página con el calendario
        header("Location: index.php");
        exit();
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
?>
