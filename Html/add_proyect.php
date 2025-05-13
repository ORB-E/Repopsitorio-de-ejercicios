<?Php
session_start();
include '../php/includes/conexion.php';

if(!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
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
    <script src="../Js/index.js" defer></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
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
                        <?php if (isset($_SESSION['username'])): ?>
                            <span class="text-white me-2">Hola,
                                <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>

                                <a href="Html/add_profesor.php" class="btn btn-success" style="margin-right: 5px;">Añadir
                                    Profesor</a>
                            <?php endif; ?>
                            <a href="../Html/logout.php" class="btn btn-danger">Cerrar Sesión</a>

                        <?php else: ?>
                            <a href="Html/login.php" class="btn btn-primary">Iniciar Sesión</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4 flex-grow-1">

        <div class="btn-container text-center mb-4">
            <button class="btn btn-primary toggle-btn me-2" data-div="proyectos">Subir Proyectos</button>
            <button class="btn btn-primary toggle-btn" data-div="ejemplos">Subir Ejemplos</button>
        </div>

        <div id="proyectos" class="hidden-div active">
            <h2>Subir Proyectos</h2>
            <div class="project-list">
                <div class="project-item">
                    <form method="POST" action="subir_ejemplo.php">
                        <div class="mb-3">
                            <label for="titulo_proyecto" class="form-label">Título del proyecto</label>
                            <input type="text" class="form-control" id="titulo_proyecto" name="titulo_proyecto"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_proyecto" class="form-label">Descripción del proyecto</label>

                            <textarea class="form-control" id="descripcion_proyecto" name="descripcion_ejemplo" rows="7"
                                style="resize: none" required></textarea>
                        </div>
                        <div clas.s="mb-3">
                            <label for="imagen_proyecto" class="form-label">Imagen del proyecto</label>
                            <input type="file" class="form-control" id="imagen_proyecto" name="imagen_proyecto"
                                accept="image/*" required>

                        </div>

                        <button type="submit" class="btn btn-success">Subir proyecto</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </form>

                </div>
            </div>
        </div>

        <div id="ejemplos" class="hidden-div">
            <h2>Subir Ejemplo</h2>
            <div class="project-list">
                <div class="project-item">
                    <form method="POST" action="subir_ejemplo.php">
                        <div class="mb-3">
                            <label for="titulo_ejemplo" class="form-label">Título del ejemplo</label>
                            <input type="text" class="form-control" id="titulo_ejemplo" name="titulo_ejemplo" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_ejemplo" class="form-label">Descripción del ejemplo</label>

                            <textarea class="form-control" id="descripcion_ejemplo" name="descripcion_ejemplo" rows="7"
                                style="resize: none" required></textarea>
                        </div>
                        <div clas.s="mb-3">
                            <label for="imagen_ejemplo" class="form-label">Imagen del ejemplo</label>
                            <input type="file" class="form-control" id="imagen_ejemplo" name="imagen_ejemplo"
                                accept="image/*" required>

                        </div>

                        <button type="submit" class="btn btn-success">Subir ejemplo</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </form>

                </div>
            </div>
        </div>
        </div>

    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto" style="margin-top: 10%;">
        <div class="container">
            <p class="mb-0">&copy; 2024 Portafolio Digital. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>