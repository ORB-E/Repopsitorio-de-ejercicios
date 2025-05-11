<?php
session_start();
include 'php/includes/conexion.php';

// Verificar la conexión con mysqli
if ($conn && ! $conn->connect_error) {
    $mensaje = "Conexión exitosa!";
} else {
    $mensaje = "Error de conexión: " . $conn->connect_error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/styles.css">
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
                            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
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
                            <a href="Html/logout.php" class="btn btn-danger">Cerrar Sesión</a>
                        <?php else : ?>
                            <a href="Html/login.php" class="btn btn-primary">Iniciar Sesión</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        
            <div class="btn-container text-center mb-4">
                <button class="btn btn-primary toggle-btn me-2" data-div="proyectos">Ver Proyectos</button>
                <button class="btn btn-primary toggle-btn" data-div="ejemplos">Ver Ejemplos</button>
            </div>

            <!-- Sección de Proyectos -->
            <div id="proyectos" class="hidden-div active">
                <h2>Mis Proyectos</h2>
                <div class="project-list">
                    <div class="project-item">
                        <h3>Proyecto 1</h3>
                        <p>Descripción del primer proyecto...</p>

                        <?php if (isset($_SESSION['username'])): ?>
                            <button class="btn btn-success upload-btn">Subir Archivo</button>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Sección de Ejemplos -->
            <div id="ejemplos" class="hidden-div">
                <h2>Ejemplos de Trabajo</h2>
                <div class="example-gallery">
                    <div class="example-item">
                        <img src="placeholder.jpg" alt="Ejemplo 1" class="img-fluid">
                        <p>Ejemplo de diseño web</p>
                        <?php if (isset($_SESSION['username'])): ?>
                            <button class="btn btn-success upload-btn">Subir Proyecto</button>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        
    </main>

    <footer class="text-center mt-4 mb-3">
        <p>&copy; 2024 Portafolio Digital. Todos los derechos reservados</p>
    </footer>
</body>
</html>