<?php
session_start();
// Elimina todas las variables de sesión
session_unset();
// Destruye la sesión
session_destroy();
// Redirige de vuelta al index
header("Location: ../index.php");
exit;
