<?php
include 'conexion.php'; // Incluye el archivo con la conexión a la base de datos.

session_start(); // Inicia la sesión para gestionar la autenticación del usuario.


// Verificar si la solicitud es POST y si la acción está definida.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action']; // Obtener la acción (registro o inicio de sesión) del formulario.

    // Procesar el registro de un nuevo usuario
    if ($action === 'register') {
        $nombre = $_POST['nombre']; // Obtener el nombre del usuario.
        $email = $_POST['email']; // Obtener el correo electrónico del usuario.
        $password = $_POST['password']; // Obtener la contraseña proporcionada.
        $confirm_password = $_POST['confirm_password']; // Obtener la confirmación de la contraseña.

        // Verificar que las contraseñas coincidan
        if ($password === $confirm_password) {
            // Comprobar si el correo electrónico ya está registrado en la base de datos
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email); // Vincular el correo electrónico a la consulta.
            $stmt->execute(); // Ejecutar la consulta.
            $stmt->store_result(); // Almacenar los resultados para comprobar la existencia del usuario.

            if ($stmt->num_rows > 0) {
                // Si ya existe una cuenta con ese correo, muestra un mensaje de error.
                echo "Ya existe una cuenta registrada con ese correo electrónico.";
            } else {
                // Hashear la contraseña para almacenarla de forma segura.
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Preparar la consulta para insertar al nuevo usuario en la base de datos.
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $nombre, $email, $hashed_password); // Vincular los valores a la consulta.

                // Ejecutar la consulta para insertar el nuevo usuario
                if ($stmt->execute()) {
                    // Si la inserción es exitosa, obtener el ID del usuario insertado.
                    $userId = $conn->insert_id;

                    // Crear las variables de sesión para almacenar la autenticación del usuario.
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['user_name'] = $nombre;

                    // Redirigir al catálogo o página principal del sitio.
                    header("Location: catalogo.php");
                    exit;
                } else {
                    // Si ocurre un error al insertar el usuario, mostrar el mensaje de error.
                    echo "Error al registrar: " . $stmt->error;
                }
            }
            $stmt->close(); // Cerrar la declaración de la consulta.
        } else {
            // Si las contraseñas no coinciden, mostrar un mensaje de error.
            echo "Las contraseñas no coinciden.";
        }
    }

    // Procesar el inicio de sesión de un usuario
    elseif ($action === 'login') {
        $email = $_POST['email']; // Obtener el correo electrónico del usuario.
        $password = $_POST['password']; // Obtener la contraseña proporcionada.

        // Preparar la consulta para verificar si el usuario existe y obtener la contraseña hasheada.
        $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email); // Vincular el correo electrónico a la consulta.
        $stmt->execute(); // Ejecutar la consulta.
        $stmt->store_result(); // Almacenar los resultados para comprobar si existe el usuario.

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password); // Obtener el ID y la contraseña hasheada del usuario.
            $stmt->fetch(); // Obtener los resultados de la consulta.

            // Verificar si la contraseña proporcionada coincide con la contraseña hasheada.
            if (password_verify($password, $hashed_password)) {
                // Si la contraseña es correcta, crear las variables de sesión.
                $_SESSION['user_id'] = $id;
                echo "Inicio de sesión exitoso.";
                header("Location: catalogo.php"); // Redirigir al catálogo o página principal.
                exit;
            } else {
                // Si la contraseña es incorrecta, mostrar un mensaje de error.
                echo "Contraseña incorrecta.";
            }
        } else {
            // Si no se encuentra el usuario, mostrar un mensaje de error.
            echo "No se encontró una cuenta con ese correo electrónico.";
        }

        $stmt->close(); // Cerrar la declaración de la consulta.
    }
}

$conn->close(); // Cerrar la conexión a la base de datos.
?>
