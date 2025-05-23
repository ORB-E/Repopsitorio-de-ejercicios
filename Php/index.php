<?php
session_start();


require_once 'conexion.php';

// Verificar la conexión
if ($pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) === 'active') {
    $mensaje = "Conexión exitosa!";
} else {
    $mensaje = "Error de conexión";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina</title>
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
                            <a class="nav-link active" aria-current="page" href="index.html">Inicio</a>
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
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            MATERIAS
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Matematicas</a></li>
                            <li><a class="dropdown-item" href="#">Fisica</a></li>
                            <li><a class="dropdown-item" href="#">Quimica</a></li>
                            <li><a class="dropdown-item" href="#">Programación</a></li>
                            <li><a class="dropdown-item" href="#">Lenguaje</a></li>
                        </ul>
                    </div>
                    <div class="login-section">
                        <a href="Html/login.html" class="btn btn-primary">Iniciar Sesión</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="btn-container">
            <button class="btn btn-primary toggle-btn" data-div="proyectos">Ver Proyectos</button>
            <button class="btn btn-primary toggle-btn" data-div="ejemplos">Ver Ejemplos</button>
        </div>
        <!-- Sección de Proyectos -->
        <div id="proyectos" class="hidden-div active">
            <h2>Mis Proyectos</h2>
            <div class="project-list">
                <div class="project-item">
                    <h3>Proyecto 1</h3>
                    <p>Descripción del primer proyecto...</p>
                    <button class="btn btn-success upload-btn">Subir Archivo</button>
                </div>
            </div>
        </div>
        <!-- Sección de Ejemplos -->
        <div id="ejemplos" class="hidden-div">
            <h2>Ejemplos de Trabajo</h2>
            <div class="example-gallery">
                <div class="example-item">
                    <img src="placeholder.jpg" alt="Ejemplo 1">
                    <p>Ejemplo de diseño web</p>
                </div>
                <div class="example-item">
                    <img src="placeholder.jpg" alt="Ejemplo 2">
                    <p>Ejemplo de aplicación móvil</p>
                </div>
            </div>
        </div>
        <!-- Agregar un div para mostrar el mensaje -->
        <div id="mensaje-conexion">
            <?php if (isset($mensaje) && $mensaje == "Conexión exitosa!") { ?>
                <p style="color: green;"><?php echo $mensaje; ?></p>
            <?php } ?>
        </div>
    </main>
    <footer>
        <p>&copy;</p>
    </footer>
</body>
</html>