<?php
include '../Php/includes/conexion.php';

// Inicializar el mensaje de error o éxito
$mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Comprobar si el usuario y la contraseña no están vacíos
    if (!empty($username) && !empty($password)) {
        // Preparar la consulta para verificar las credenciales
        $stmt = $conn->prepare("SELECT id, username, contrasena, rol FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si el usuario existe
        if ($result->num_rows > 0) {
            // El usuario existe, obtener la información
            $user = $result->fetch_assoc();
            
            // Verificar la contraseña
            if (password_verify($password, $user['contrasena'])) {
                // Iniciar sesión
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['rol'] = $user['rol'];

                // Redirigir dependiendo del rol
                if ($user['rol'] === 'admin') {
                    header("Location: admin_dashboard.php"); // Redirigir al panel de admin
                } else {
                    header("Location: profesor_dashboard.php"); // Redirigir al panel de profesor
                }
                exit; // Finalizar el script
            } else {
                $mensaje = "Contraseña incorrecta.";
            }
        } else {
            $mensaje = "Usuario no encontrado.";
        }
    } else {
        $mensaje = "Por favor ingresa tu usuario y contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Css/styles.css">
    <link rel="stylesheet" href="../Css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../Js/login.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Proyectos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ejemplos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacto</a>
                        </li>
                    </ul>
                    <div class="login-section">
                        <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <!-- Mostrar mensaje de error si hay -->
            <?php if (!empty($mensaje)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" name="username" required class="form-control">
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required class="form-control">
                        <button type="button" class="toggle-password">
                            <svg class="eye-icon eye-open" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                            </svg>
                            <svg class="eye-icon eye-closed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="display: none;">
                                <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Portafolio Digital. Todos los derechos reservados</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
