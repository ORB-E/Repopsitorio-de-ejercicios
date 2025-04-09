<?php
    $ServerName = "127.0.0.1"; // sin puerto en esta línea
    $Username = "root";
    $Password = ""; // o tu contraseña si estás seguro que es correcta
    $dbname = "institucion";
    $Port = 3306;

    $conn = new mysqli($ServerName, $Username, $Password, $dbname, $Port);

    if($conn->connect_error){
        die("Conexión fallida: " . $conn->connect_error);
    } else {
        echo "Conexión establecida";
    }
?>
