<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Iniciar sesión para acceder a la información del usuario
session_start();

// Verificar si el usuario está autenticado (si tiene una sesión activa)
$is_logged_in = isset($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está autenticado, mostrar un mensaje de advertencia
    echo "<div class='alert alert-warning'>Debe iniciar sesión para ver sus favoritos.</div>";
    exit; // Terminar la ejecución del script si el usuario no está autenticado
}

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Consulta SQL para obtener los coches que el usuario ha marcado como favoritos
$stmt = $conn->prepare("
    SELECT coches.id, coches.marca, coches.modelo, coches.precio, coches.imagen 
    FROM favoritos 
    JOIN coches ON favoritos.coche_id = coches.id 
    WHERE favoritos.user_id = ?
");
$stmt->bind_param("i", $user_id); // Vincular el ID del usuario a la consulta
$stmt->execute(); // Ejecutar la consulta
$result = $stmt->get_result(); // Obtener el resultado de la consulta
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
    <!-- Incluir Bootstrap para estilos y funcionalidad -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css"> <!-- Vincular archivo CSS personalizado -->
    <script src="script.js"></script> <!-- Vincular archivo JS personalizado -->
</head>

<body>
    <!-- Cabecera con el logo y el título -->
    <header class="cabecera">
        <div class="contenedorlogo">
            <img src="imagenes/Logo1.jpg" alt="Logo Concesionario" class="logo" />
        </div>
        <h1 class="titulo">Mis Favoritos</h1>
    </header>

    <!-- Menú de navegación -->
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

    <main class="container mt-4">
        <!-- Título para la sección de favoritos -->
        <h2 class="text-center">Coches Favoritos</h2>
        <div class="row">
            <?php
            // Verificar si el usuario tiene coches favoritos
            if ($result->num_rows > 0) {
                // Mostrar cada coche favorito en una tarjeta
                while ($row = $result->fetch_assoc()) {
                    echo "
                <div class='col-md-4 mb-4'>
        <div class='card'>
            <img src='uploads/{$row['imagen']}' class='card-img-top' alt='{$row['modelo']}'>
            <div class='card-body'>
                <h5 class='card-title'>{$row['marca']} {$row['modelo']}</h5>
                <p class='card-text'>Precio: {$row['precio']} €</p>
                <button class='btn btn-danger eliminar-favorito' data-id='{$row['id']}'>Eliminar</button>
            </div>
        </div>
    </div>";
                }
            } else {
                // Mostrar un mensaje si no hay coches favoritos
                echo "<div class='alert alert-info text-center'>No tienes coches en tus favoritos.</div>";
            }
            ?>
        </div>
    </main>

    <!-- Pie de página -->
    <footer>
        <p class="text-center">© 2024 Concesionario de Coches. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
