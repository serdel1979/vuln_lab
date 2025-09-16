<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $f = $_POST['fullname'];
    // INSERT vulnerable (sin prepared statements, sin validaciones)
    $sql = "INSERT INTO users (username,password,fullname) VALUES ('$u','$p','$f')";
    $mysqli->query($sql);
    echo "Registrado. <a href='index.php'>Volver</a>";
    exit;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Registro</title></head>
<body>
  <h2>Registro (vulnerable)</h2>
  <form method="post">
    Usuario: <input name="username"><br>
    Clave: <input name="password" type="password"><br>
    Nombre completo: <input name="fullname"><br>
    <button>Registrar</button>
  </form>
  <p><a href="index.php">Login</a></p>
</body>
</html>
