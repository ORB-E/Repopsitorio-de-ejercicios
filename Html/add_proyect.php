<?php
/**
 * Proyecto: Asesorías Rápidas
 * Autor: [Brayam Ortega]
 * Fecha: [27/05/2025]
 * Descripción: Sitio web para subir y consultar proyectos y ejemplos académicos.
 * Derechos reservados © [Brayam Ortega] 2025
 */
session_start();
include '../php/includes/conexion.php';

// Solo usuarios autenticados
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Obtener ID de usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($usuario_id);
$stmt->fetch();
$stmt->close();

// Procesamiento de formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determinar si viene de proyectos o ejemplos
    $isProyecto = isset($_POST['titulo_proyecto']);

    if ($isProyecto) {
        // Campos de proyecto
        $titulo = trim($_POST['titulo_proyecto']);
        $descripcion = trim($_POST['descripcion_proyecto']);
        $campoFile = 'imagen_proyecto';
        $tabla = 'proyectos';
        $colImagen = 'imagen';
        $destinoDir = "../Img/imgProyectos/";
    } else {
        // Campos de ejemplo
        $titulo = trim($_POST['titulo_ejemplo']);
        $descripcion = trim($_POST['descripcion_ejemplo']);
        $campoFile = 'imagen_ejemplo';
        $tabla = 'ejemplos';
        $colImagen = 'imagen';
        $destinoDir = "../Img/imgEjemplos/";
    }

    // Procesar imagen
    if (isset($_FILES[$campoFile]) && $_FILES[$campoFile]['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($destinoDir)) {
            mkdir($destinoDir, 0755, true);
        }

        $tmpName = $_FILES[$campoFile]['tmp_name'];
        $baseName = basename($_FILES[$campoFile]['name']);
        $ext = strtolower(pathinfo($baseName, PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $permitidos)) {
            $nuevoNombre = time() . "_" . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $baseName);
            $rutaFinal = $destinoDir . $nuevoNombre;

            if (move_uploaded_file($tmpName, $rutaFinal)) {
                // Preparar SQL dinámico
                if ($isProyecto) {
                    // Fecha de inicio/fin puestas al día actual
                    $hoy = date('Y-m-d');
                    $sql = "INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin, usuario_id, imagen)
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt2 = $conn->prepare($sql);
                    $stmt2->bind_param(
                        "ssssds",
                        $titulo,
                        $descripcion,
                        $hoy,
                        $hoy,
                        $usuario_id,
                        $nuevoNombre
                    );
                } else {
                    $sql = "INSERT INTO ejemplos (titulo, descripcion, imagen, usuario_id) 
        VALUES ( ?, ?, ?, ?)";

                    $stmt2 = $conn->prepare($sql);
                    $stmt2->bind_param(
                        "sssi",  // 4 parámetros: 3 strings, 1 int
                        $titulo,
                        $descripcion,
                        $nuevoNombre,
                        $usuario_id
                    );

                }

                if ($stmt2->execute()) {
                    header("Location: ../index.php?msg=" . ($isProyecto ? "Proyecto+subido+correctamente" : "Ejemplo+subido+correctamente"));
                    exit();
                } else {
                    echo "<div class=\"alert alert-danger\">Error al guardar: " . htmlspecialchars($stmt2->error) . "</div>";
                }
                $stmt2->close();
            } else {
                echo "<div class=\"alert alert-danger\">No se pudo mover la imagen.</div>";
            }
        } else {
            echo "<div class=\"alert alert-warning\">Formato de imagen no permitido.</div>";
        }
    } else {
        echo "<div class=\"alert alert-warning\">Error al procesar archivo.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subir Proyectos / Ejemplos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Css/styles.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
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
                            <!--<a class="nav-link" href="#">Proyectos</a>-->
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

    <main class="container flex-fill mt-4">
        <div class="btn-container text-center mb-4">
            <button class="btn btn-primary toggle-btn me-2" data-div="proyectos">Subir Proyectos</button>
            <button class="btn btn-primary toggle-btn" data-div="ejemplos">Subir Ejemplos</button>
        </div>

        <!-- Formulario Proyectos -->
        <div id="proyectos" class="hidden-div active">
            <h2>Subir Proyecto</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titulo_proyecto" class="form-label">Título del proyecto</label>
                    <input type="text" id="titulo_proyecto" name="titulo_proyecto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion_proyecto" class="form-label">Descripción</label>
                    <textarea id="descripcion_proyecto" name="descripcion_proyecto" class="form-control" rows="5"
                        required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen_proyecto" class="form-label">Imagen</label>
                    <input type="file" id="imagen_proyecto" name="imagen_proyecto" class="form-control" accept="image/*"
                        required>
                </div>
                <button type="submit" class="btn btn-success">Subir proyecto</button>
                <a href="../index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>

        <!-- Formulario Ejemplos -->
        <div id="ejemplos" class="hidden-div">
            <h2>Subir Ejemplo</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titulo_ejemplo" class="form-label">Título del ejemplo</label>
                    <input type="text" id="titulo_ejemplo" name="titulo_ejemplo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion_ejemplo" class="form-label">Descripción</label>
                    <textarea id="descripcion_ejemplo" name="descripcion_ejemplo" class="form-control" rows="5"
                        required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen_ejemplo" class="form-label">Imagen</label>
                    <input type="file" id="imagen_ejemplo" name="imagen_ejemplo" class="form-control" accept="image/*"
                        required>
                </div>
                <button type="submit" class="btn btn-success">Subir ejemplo</button>
                <a href="../index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy; Asesorías Rápidas. Desarrollado por [Brayam Ortega]. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Js/index.js"></script>
</body>

</html>