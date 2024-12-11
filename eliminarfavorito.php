<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Iniciar sesión para acceder a la información del usuario
session_start();

// Establecer el tipo de respuesta como JSON
header('Content-Type: application/json');

// Verificar si el usuario está autenticado (si tiene una sesión activa)
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está autenticado, devolver un mensaje de error en formato JSON
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión.']);
    exit; // Terminar la ejecución del script
}

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Leer el cuerpo de la solicitud JSON
$data = json_decode(file_get_contents('php://input'), true);

// Obtener el ID del coche desde la solicitud
$coche_id = $data['id'] ?? null; // Si no se recibe 'id', asignar null

// Verificar que se ha recibido el ID del coche
if (!$coche_id) {
    // Si no se recibe el ID del coche, devolver un error
    echo json_encode(['success' => false, 'message' => 'ID del coche no proporcionado.']);
    exit; // Terminar la ejecución del script
}

// Preparar una consulta SQL para eliminar el coche de los favoritos del usuario
$stmt = $conn->prepare("DELETE FROM favoritos WHERE user_id = ? AND coche_id = ?");
$stmt->bind_param("ii", $user_id, $coche_id); // Vincular los parámetros a la consulta (ID del usuario y del coche)

// Ejecutar la consulta
if ($stmt->execute()) {
    // Si la eliminación es exitosa, devolver una respuesta JSON indicando éxito
    echo json_encode(['success' => true]);
} else {
    // Si la eliminación falla, devolver una respuesta JSON indicando fracaso
    echo json_encode(['success' => false]);
}

// Cerrar la declaración y la conexión con la base de datos
$stmt->close();
$conn->close();
