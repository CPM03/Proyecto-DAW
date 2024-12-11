<?php
// Configuración de las credenciales de conexión
$host = 'localhost'; // Servidor de la base de datos, generalmente 'localhost' para servidores locales
$usuario = 'root'; // Usuario de la base de datos (por defecto en MySQL)
$password = ''; // Contraseña del usuario (vacío para entornos locales, pero debe configurarse en producción)
$nombre_bd = 'bdconcesionario'; // Nombre de la base de datos a la que nos queremos conectar

// Crear una nueva conexión con la base de datos
$conn = new mysqli($host, $usuario, $password, $nombre_bd);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) { 
    // Si hay un error en la conexión, se termina la ejecución y se muestra el error
    die("Error en la conexión: " . $conn->connect_error);
}

// Si la conexión es exitosa, el script continúa sin mostrar mensaje alguno
?>
