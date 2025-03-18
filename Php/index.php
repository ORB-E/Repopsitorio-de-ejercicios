<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: Html/login.html');
    exit();
}
// Incluir contenido HTML del index original
include '../index.html';
?>