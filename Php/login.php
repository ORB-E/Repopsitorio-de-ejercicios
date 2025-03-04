<?php
session_start();
require __DIR__ . '/includes/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'rol' => $user['rol']
        ];
        
        // Redirección según rol
        header('Location: ../Html/index.html');
        exit();
    } else {
        $error = "Credenciales inválidas";
    }
}
?>