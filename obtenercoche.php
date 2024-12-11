<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

// Obtener el ID del coche de la solicitud
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$response = ['success' => false];

// Verificar si el ID es válido
if ($id > 0) {
  $stmt = $conn->prepare("SELECT * FROM coches WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  // Si el coche existe, devolver los detalles
  if ($result->num_rows > 0) {
    $coche = $result->fetch_assoc();
    $response = [
      'success' => true,
      'coche' => $coche
    ];
  }
}

echo json_encode($response);

$conn->close();
?>
