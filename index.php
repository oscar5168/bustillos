<?php
session_start();
$esDueno = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">Bustillos</div>
      <ul class="menu">
        <li><a href="#Inicio">Inicio</a></li>
        <li><a href="#servicios">Servicios</a></li>
        <li><a href="#calendario-container">Reservas</a></li>
        <li><a href="login.html">LogIn</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h1>Terraza Bustillos</h1>
    <p>Ofrecemos los mejores servicios para ti.</p>
    <a href="#" class="btn">Conócenos</a>
  </section>

  <section id = "servicios" class="servicios">
    <h2>Servicios</h2>
  </section>

  <section id="calendario-container" class="Reservas">
    <h1>Calendario de Reservas</h1>
    <select name="mes" id="mes">
      <option value="1">Enero</option>
      <option value="2">Febrero</option>
      <option value="3">Marzo</option>
      <option value="4">Abril</option>
      <option value="5">Mayo</option>
      <option value="6">Junio</option>
      <option value="7">Julio</option>
      <option value="8">Agosto</option>
      <option value="9">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>  
    </select>

    <div id="calendario"></div>
    <button id="Guardar">Guardar</button>
  </section>

  <form action="logout.php">
    <button>Cerrar sesión</button>
  </form>

  <!-- Pasamos el dato a JS -->
  <script>
     const esDueno = <?php echo isset($_SESSION['admin']) && $_SESSION['admin'] === true ? 'true' : 'false'; ?>;
  </script>

  <!-- Luego cargamos el JS que usará esa variable -->
  <script src="calendario.js"></script>
</body>
</html>
