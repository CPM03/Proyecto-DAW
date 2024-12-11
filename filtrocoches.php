<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Comprobar si se han recibido los filtros a través de la URL
$marca = isset($_GET['marca']) ? $_GET['marca'] : ''; // Filtro por marca
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : ''; // Filtro por precio máximo
$combustible = isset($_GET['combustible']) ? $_GET['combustible'] : ''; // Filtro por tipo de combustible

// Construir la consulta SQL con los filtros
// La consulta inicial selecciona todos los coches
$query = "SELECT * FROM coches WHERE 1=1"; 

// Si se ha recibido el filtro de marca, se agrega a la consulta
if ($marca) {
    $query .= " AND marca = '$marca'"; // Filtra por marca
}

// Si se ha recibido el filtro de precio máximo, se agrega a la consulta
if ($precio_max) {
    $query .= " AND precio <= '$precio_max'"; // Filtra por precio
}

// Si se ha recibido el filtro de combustible, se agrega a la consulta
if ($combustible) {
    $query .= " AND combustible = '$combustible'"; // Filtra por combustible
}

// Ejecutar la consulta
$result = mysqli_query($conn, $query);

// Inicializar un array para almacenar los resultados
$coches = [];

// Recorrer los resultados y almacenarlos en el array
while ($row = mysqli_fetch_assoc($result)) {
    $coches[] = $row; // Agregar cada coche al array
}

// Retornar los datos como JSON
echo json_encode($coches); // Devolver la lista de coches en formato JSON
?>
