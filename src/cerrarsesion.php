<?php
// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destruir la sesión si está iniciada
if (isset($_SESSION)) {
    session_destroy();
}

// Redirigir a la página de inicio de sesión
header('Location: login.php');
?>
