<?php
/**
 * Proyecto: Asesorías Rápidas
 * Autor: [Brayam Ortega]
 * Fecha: [27/05/2025]
 * Descripción: Sitio web para subir y consultar proyectos y ejemplos académicos.
 * Derechos reservados © [Brayam Ortega] 2025
 */
session_start();
include 'php/includes/conexion.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesorias Rapidas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Js/index.js" defer></script>
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
                            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                           <!-- <a class="nav-link" href="#">Proyectos</a> -->
                        </li>
                        <li class="nav-item">
                            <!--<a class="nav-link" href="#">Ejemplos</a>-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://tecuruapan.edu.mx/extensiones-control-escolar/">Contacto</a>
                        </li>
                    </ul>
                    <div class="login-section d-flex align-items-center">
                        <?php if (isset($_SESSION['username'])): ?>
                            <span class="text-white me-2">
                                Hola, <?= htmlspecialchars($_SESSION['username']) ?>
                            </span>
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                <a href="Html/add_profesor.php" class="btn btn-success me-2">Añadir Profesor</a>
                            <?php endif; ?>
                            <a href="Html/logout.php" class="btn btn-danger">Cerrar Sesión</a>
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
            <?php if (isset($_SESSION['username'])): ?>
                <a href="Html/add_proyect.php" class="btn btn-success">Subir Proyecto</a>
            <?php endif; ?>

            <button class="btn btn-primary toggle-btn me-2" data-div="proyectos">Ver Proyectos</button>
            <button class="btn btn-primary toggle-btn" data-div="trabajos">Ver Ejemplos</button>
        </div>

        <!-- Sección de Proyectos -->
        <div id="proyectos" class="hidden-div active">
            <h2>Proyectos</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4 project-list">
                <?php
                $sql = "SELECT p.id, p.nombre, p.descripcion, p.imagen, p.creado_en, u.username
                        FROM proyectos p
                        JOIN usuarios u ON p.usuario_id = u.id
                        ORDER BY p.creado_en DESC";

                if ($res = $conn->query($sql)) {
                    while ($p = $res->fetch_assoc()):
                        $rutaImg = __DIR__ . "/Img/imgProyectos/" . $p['imagen'];
                        $webImg = "Img/imgProyectos/" . htmlspecialchars($p['imagen']);
                        ?>
                        <div class="col">
                            <div class="card h-100">
                                <?php
                                if (!empty($p['imagen']) && file_exists($rutaImg)) {
                                    echo '<img src="' . $webImg . '" class="card-img-top" alt="' . htmlspecialchars($p['nombre']) . '">';

                                } else {
                                    echo '<div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px">Sin imagen</div>';
                                }
                                ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($p['nombre']) ?></h5>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($p['descripcion'])) ?></p>
                                </div>
                                <div class="card-footer text-muted">
                                    Subido por <?= htmlspecialchars($p['username']) ?>
                                    <span class="float-end"><?= date("d/m/Y", strtotime($p['creado_en'])) ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    $res->free();
                } else {
                    echo "<p class='text-danger'>No se pudieron cargar los proyectos.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Sección de Ejemplos -->
        <div id="trabajos" class="hidden-div">
            <h2>Ejemplos</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4 example-gallery">
                <?php
                $sql2 = "SELECT t.id, t.titulo, t.descripcion, t.imagen, t.creado_en, u.username
                         FROM ejemplos t
                         JOIN usuarios u ON t.usuario_id = u.id
                         ORDER BY t.creado_en DESC";

                if ($res2 = $conn->query($sql2)) {
                    while ($t = $res2->fetch_assoc()):
                        $rutaImgE = __DIR__ . "/Img/imgEjemplos/" . $t['imagen'];
                        $webImgE = "Img/imgEjemplos/" . htmlspecialchars($t['imagen']);
                        ?>
                        <div class="col">
                            <div class="card h-100">
                                <?php
                                if (!empty($t['imagen']) && file_exists($rutaImgE)) {
                                    echo '<img src="' . $webImgE . '" class="card-img-top" alt="' . htmlspecialchars($t['titulo']) . '">';
                                } else {
                                    echo '<div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px">Sin imagen</div>';
                                }
                                ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($t['titulo']) ?></h5>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($t['descripcion'])) ?></p>
                                </div>
                                <div class="card-footer text-muted">
                                    Subido por <?= htmlspecialchars($t['username']) ?>
                                    <span class="float-end"><?= date("d/m/Y", strtotime($t['creado_en'])) ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    $res2->free();
                } else {
                    echo "<p class='text-danger'>No se pudieron cargar los trabajos.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto" style="margin-top: 5%;">
        <div class="container">
            <p class="mb-0">&copy; Asesorías Rápidas. Desarrollado por [Brayam Ortega]. Todos los derechos reservados.</p>

        </div>
    </footer>
</body>

</html>
