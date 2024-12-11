<?php
include 'conexion.php'; // Incluir la conexión a la base de datos
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Catálogo de Coches</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
    rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css" />
  <script src="script.js"></script>
</head>

<body>
  <header class="cabecera">
    <div class="contenedorlogo">
      <img src="imagenes/Logo1.jpg" alt="Logo Concesionario" class="logo" />
    </div>
    <h1 class="titulo">Catálogo de Coches</h1>
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

  <main>

    <button type="button" class="btn btn-secondary" id="mostrar-filtros">
      <i class="bi bi-funnel"></i> Filtros
    </button>

    <!-- Formulario de filtros dentro de una tarjeta -->
    <div id="filtros" style="display: none;" class="card mt-3 shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Filtrar Coches</h5>
      </div>
      <div class="card-body">
        <form id="form-filtros" action="catalogo.php" method="GET">
          <div class="row">
            <!-- Marca -->
            <div class="col-md-6 mb-3">
              <label for="marca" class="form-label">Marca</label>
              <select name="marca" id="marca" class="form-select">
                <option value="">Todas</option>
                <option value="Audi" <?= isset($_GET['marca']) && $_GET['marca'] == 'Audi' ? 'selected' : '' ?>>Audi</option>
                <option value="Shelby" <?= isset($_GET['marca']) && $_GET['marca'] == 'Shelby' ? 'selected' : '' ?>>Shelby</option>
                <option value="BMW" <?= isset($_GET['marca']) && $_GET['marca'] == 'BMW' ? 'selected' : '' ?>>BMW</option>
              </select>
            </div>

            <!-- Precio máximo -->
            <div class="col-md-6 mb-3">
              <label for="precio_max" class="form-label">Precio máximo</label>
              <input type="number" name="precio_max" id="precio_max" class="form-control" placeholder="Ej. 20000" value="<?= isset($_GET['precio_max']) ? $_GET['precio_max'] : '' ?>">
            </div>
          </div>
          
          <div class="row">
            <!-- Combustible -->
            <div class="col-md-6 mb-3">
              <label for="combustible" class="form-label">Combustible</label>
              <select name="combustible" id="combustible" class="form-select">
                <option value="">Todos</option>
                <option value="Gasolina" <?= isset($_GET['combustible']) && $_GET['combustible'] == 'Gasolina' ? 'selected' : '' ?>>Gasolina</option>
                <option value="Diesel" <?= isset($_GET['combustible']) && $_GET['combustible'] == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                <option value="Eléctrico" <?= isset($_GET['combustible']) && $_GET['combustible'] == 'Eléctrico' ? 'selected' : '' ?>>Eléctrico</option>
              </select>
            </div>
          </div>

          <!-- Botones -->
          <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-outline-danger">Limpiar</button>
            <button type="submit" class="btn btn-primary">Filtrar</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Resultados del Catálogo -->
    <section class="car-list">
      <?php
      // Verificar si se aplicaron filtros
      if (!empty($_GET)) {
        // Construir la URL con los filtros
        $filtros = http_build_query($_GET);
        $url = "http://localhost/Proyecto%20DAW/filtrocoches.php?$filtros";
      } else {
        // Si no hay filtros, obtener todos los coches
        $url = "http://localhost/Proyecto%20DAW/filtrocoches.php";
      }

      // Obtener los datos de filtrocoches.php
      $json = file_get_contents($url);
      $coches = json_decode($json, true);

      if (!empty($coches)) {
        // Mostrar coches filtrados
        foreach ($coches as $coche) {
          echo "<div class='car'>";
          echo "<img src='uploads/" . $coche['imagen'] . "' alt='" . $coche['marca'] . " " . $coche['modelo'] . "' />";
          echo "<h3>" . $coche['marca'] . " " . $coche['modelo'] . "</h3>";
          echo "<p>" . $coche['descripcion'] . "</p>";
          echo "<button type='button' class='btn btn-info' data-id='" . $coche['id'] . "'>Más información</button>";
          echo "<button type='button' class='btn btn-danger like-btn' data-coche-id='" . $coche['id'] . "'";
          if (!$is_logged_in) echo " disabled";
          echo ">Me gusta</button>";
          echo "</div>";
        }
      } else {
        // Mensaje si no hay coches filtrados
        echo "<p>No se encontraron coches con los filtros seleccionados.</p>";
      }
      ?>
      <div id="carModal" class="modal fade" tabindex="-1" aria-labelledby="carModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="carModalLabel">Detalles del Coche</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="car-details" class="modal-body"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2024 Concesionario de Coches. Todos los derechos reservados.</p>
  </footer>
</body>

</html>