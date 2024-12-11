<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Concesionario de Coches</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header class="cabecera">
    <div class="contenedorlogo">
      <img src="imagenes/Logo1.jpg" alt="Logo Concesionario" class="logo" />
    </div>
    <h1 class="titulo">Passion Motorsport</h1>
  </header>

  <nav>
    <a href="index.php">Inicio</a>
    <a href="catalogo.php">Catálogo</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="favoritos.php">Favoritos</a>
      <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>
      <!-- Mostrar enlace de "Iniciar sesión/Registrarse" si el usuario no está autenticado -->
      <a href="auth.html">Iniciar sesión/Registrarse</a>
    <?php endif; ?>
    <a href="contacto.php">Contacto</a>
  </nav>

  <main>
    <section class="about">
      <h2>Bienvenido a Passion Motor</h2>
      <p>
        En Passion Motors, nos especializamos en reparaciones de coches y en
        la compra-venta de vehículos de ocasión, ofreciendo los mejores coches
        de ocasión en Valencia. Nos enorgullece brindar un servicio integral y
        de confianza, enfocado en la satisfacción total de nuestros clientes.
        Contamos con un equipo de mecánicos expertos que se encargan de
        mantener y reparar su vehículo con la máxima profesionalidad,
        garantizando un cuidado de calidad y eficiencia en cada servicio.
      </p>
    </section>

    <section class="info-section">
      <div class="info-block left">
        <img src="imagenes/coches.jpg" alt="Coche de lujo" />
        <p>
          Además, disponemos de un amplio inventario de coches de ocasión,
          seleccionados rigurosamente para asegurar su fiabilidad y calidad.
          Cada uno de los vehículos que ofrecemos pasa por exhaustivas
          inspecciones para garantizar su óptimo estado, siempre adaptándonos
          a diferentes presupuestos y necesidades.
        </p>
      </div>

      <div class="info-block right">
        <p>
          Explora nuestras opciones de financiamiento y encuentra el coche de
          tus sueños sin preocupaciones.
        </p>
        <img src="imagenes/financiacion.jpg" alt="Coche de lujo" />
      </div>

      <div class="info-block left">
        <img src="imagenes/taller.jpg" alt="Coche de lujo" />
        <p>
          En Passion Motor combinamos nuestra pasión por los coches con un
          firme compromiso hacia la satisfacción del cliente. Ya sea para
          mantener su coche en condiciones óptimas o adquirir su próximo
          vehículo de ocasión, puede confiar en nosotros.
        </p>
      </div>
    </section>
  </main>
  <section class="testimonios">
    <h2>Qué dicen nuestros clientes</h2>
    <div class="opinion-container">
      <div class="opinion">
        <p>"¡Excelente atención y variedad de coches! Estoy muy feliz con mi compra."</p>
        <footer>- Juan Pérez</footer>
      </div>
      <div class="opinion">
        <p>"El proceso de financiamiento fue rápido y sencillo. Muy recomendado."</p>
        <footer>- María López</footer>
      </div>
      <div class="opinion">
        <p>"Gran variedad de coches eléctricos. Me ayudaron a elegir el mejor para mí."</p>
        <footer>- Carlos Gómez</footer>
      </div>
    </div>
  </section>
  </section>

  <footer>
    <p>© 2024 Concesionario de Coches. Todos los derechos reservados.</p>
  </footer>
</body>

</html>