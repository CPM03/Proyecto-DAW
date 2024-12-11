<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión actual

// Redirigir al usuario a la página de inicio u otra página
header("Location: auth.html");
exit();
?>