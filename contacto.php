<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contacto</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body class="contact-page">
  <header>
    <div class="cabecera">
      <div class="contenedorlogo">
        <img src="imagenes/Logo1.jpg" alt="Logo Concesionario" class="logo" />
      </div>
      <h1 class="titulo">Passion Motorsport</h1>
    </div>
  </header>

  <nav>
    <a href="index.php">Inicio</a>
    <a href="catalogo.php">Catálogo</a>
    <?php if ($is_logged_in): ?>
      <a href="favoritos.php">Favoritos</a>
      <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>
      <a href="auth.html">Iniciar sesión/Registrarse</a>
    <?php endif; ?>
    <a href="contacto.php">Contacto</a>
  </nav>

  <div class="contenedor contacto-container">
    <div class="informacion">
      <h2>Contacto</h2>
      <ul>
        <li>C. de la Reina nº12, Madrid</li>
        <li>(+34) 684-060-467</li>
        <li>passionmotorsport@gmail.com</li>
      </ul>
      <img class="logo" src="imagenes/Logo1.jpg" alt="Logo Grupo Passion Motorsport" />
      <p>Grupo Passion Motorsport</p>
    </div>

    <div class="contacto">
      <h3>¿Cómo podemos ayudarte?</h3>
      <form action="" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required />

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />

        <label for="movil">Móvil</label>
        <input type="tel" id="movil" name="movil" required />

        <label for="mensaje">Problema</label>
        <textarea id="mensaje" name="message" rows="4" required></textarea>

        <button type="submit">Enviar</button>
      </form>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 Passion Motorsport. Todos los derechos reservados.</p>
  </footer>
</body>

</html>