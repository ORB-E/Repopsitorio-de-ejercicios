<?php
session_start();
include '../php/includes/conexion.php';

// Solo administradores pueden acceder
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($username) || empty($email) || empty($password) || empty($password2)) {
        $mensaje = "Por favor, completa todos los campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo no tiene un formato válido.";
    } elseif ($password !== $password2) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        // Guardar contraseña sin encriptar
        $stmt = $conn->prepare("
            INSERT INTO usuarios (username, contrasena, email, rol)
            VALUES (?, ?, ?, 'profesor')
        ");
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute()) {
            $mensaje = "Profesor agregado exitosamente.";
        } else {
            if ($conn->errno === 1062) {
                $mensaje = "El usuario o correo ya existe.";
            } else {
                $mensaje = "Error al agregar profesor: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Js/index.js" defer></script>
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
                    <div class="login-section d-flex align-items-center">
                        <?php if (isset($_SESSION['username'])) : ?>
                            <span class="text-white me-2">Hola, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            if(isset($_SESSION['admin'])){
                                <a href="add_profesor.php" class="btn btn-success">Añadir Profesor</a>
                            }
                            <a href="../Html/logout.php" class="btn btn-danger">Cerrar Sesión</a>

                        <?php else : ?>
                            <a href="Html/login.php" class="btn btn-primary">Iniciar Sesión</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        
          <div class="container mt-5" style="max-width: 60%;">
            <h2 class="mb-4">Agregar Nuevo Profesor</h2>

            <?php if ($mensaje): ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password2" class="form-label">Repetir contraseña</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>

                <button type="submit" class="btn btn-success">Crear Profesor</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
        
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto" style="margin-top: 5%;">
        <div class="container">
            <p class="mb-0">&copy; 2024 Portafolio Digital. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>