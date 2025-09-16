<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $p = $_POST['password'];

    // Consulta vulnerable a SQL injection (NO usar esto en producción)
    $sql = "SELECT * FROM users WHERE username = '$u' AND password = '$p' LIMIT 1";
    $res = $mysqli->query($sql);
    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $_SESSION['user'] = $row['username'];
        $_SESSION['fullname'] = $row['fullname'];
        header('Location: users.php');
        exit;
    } else {
        echo "Credenciales inválidas. <a href='index.php'>Volver</a>";
    }
}
?>
