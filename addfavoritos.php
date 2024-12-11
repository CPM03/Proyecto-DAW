<?php
session_start(); // Inicia la sesión para acceder a la información del usuario logueado.
include('conexion.php'); // Incluye el archivo de conexión a la base de datos.


// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está logueado, se devuelve un mensaje de error.
    echo json_encode(['success' => false, 'message' => 'No estás logueado']);
    exit; // Detiene la ejecución del script.
}

// Obtener los datos enviados desde el frontend
$coche_id = $_POST['coche_id']; // ID del coche que se quiere agregar o eliminar de favoritos.
$action = $_POST['action']; // Acción que el usuario desea realizar: 'add' o 'remove'.
$usuario_id = $_SESSION['user_id']; // Obtiene el ID del usuario logueado desde la sesión.


// Verificar si el coche ya está en los favoritos del usuario
$check_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM favoritos WHERE user_id = ? AND coche_id = ?");
$check_stmt->bind_param("ii", $usuario_id, $coche_id); // Vincula los parámetros a la consulta.
$check_stmt->execute(); // Ejecuta la consulta para verificar si el coche ya está en favoritos.
$check_result = $check_stmt->get_result(); // Obtiene el resultado de la consulta.
$row = $check_result->fetch_assoc(); // Extrae el resultado de la consulta en un formato asociativo.


// Realizar la acción solicitada (agregar o eliminar de favoritos)
if ($row['count'] == 0 && $action == 'add') {
    // Si el coche no está en favoritos y la acción es 'add', se agrega a favoritos.
    $stmt = $conn->prepare("INSERT INTO favoritos (user_id, coche_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $usuario_id, $coche_id); // Vincula los parámetros a la consulta.
    if ($stmt->execute()) {
        // Si la inserción es exitosa, se devuelve un mensaje de éxito.
        echo json_encode(['success' => true, 'message' => 'Coche agregado a favoritos.']);
    } else {
        // Si ocurre un error al agregar, se devuelve un mensaje de error.
        echo json_encode(['success' => false, 'message' => 'Error al agregar a favoritos.']);
    }
} elseif ($row['count'] > 0 && $action == 'remove') {
    // Si el coche está en favoritos y la acción es 'remove', se elimina de favoritos.
    $stmt = $conn->prepare("DELETE FROM favoritos WHERE user_id = ? AND coche_id = ?");
    $stmt->bind_param("ii", $usuario_id, $coche_id); // Vincula los parámetros a la consulta.
    if ($stmt->execute()) {
        // Si la eliminación es exitosa, se devuelve un mensaje de éxito.
        echo json_encode(['success' => true, 'message' => 'Coche eliminado de favoritos.']);
    } else {
        // Si ocurre un error al eliminar, se devuelve un mensaje de error.
        echo json_encode(['success' => false, 'message' => 'Error al eliminar de favoritos.']);
    }
} else {
    // Si se intenta agregar un coche que ya está en favoritos o eliminar uno que no está, se devuelve un mensaje de error.
    echo json_encode(['success' => false, 'message' => 'Este coche ya esta en Favoritos']);
}
