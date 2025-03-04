<?php
session_start();
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/database.php';

verificarRol('maestro');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['archivo'])) {
    $nombre_archivo = basename($_FILES['archivo']['name']);
    $ruta_temporal = $_FILES['archivo']['tmp_name'];
    $ruta_destino = __DIR__ . '/uploads/' . uniqid() . '_' . $nombre_archivo;
    
    // Validar tipo de archivo
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
    $permitidos = ['pdf', 'docx', 'jpg'];
    
    if (in_array($extension, $permitidos)) {
        if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
            $stmt = $pdo->prepare("INSERT INTO archivos 
                (nombre, ruta, tipo, usuario_id) 
                VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $nombre_archivo,
                $ruta_destino,
                'ejercicio',
                $_SESSION['user']['id']
            ]);
            echo "Archivo subido con éxito!";
        }
    } else {
        die("Tipo de archivo no permitido");
    }
}
?>