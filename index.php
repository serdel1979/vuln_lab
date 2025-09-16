<?php session_start(); ?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Vuln Lab - Login</title></head>
<body>
  <h2>Login</h2>
  <?php if(isset($_SESSION['user'])): ?>
    <p>Logueado como: <?= $_SESSION['user'] ?> — <a href="users.php">Ver usuarios</a> — <a href="logout.php">Logout</a></p>
  <?php else: ?>
    <form action="login.php" method="post">
      Usuario: <input name="username"><br>
      Clave: <input name="password" type="password"><br>
      <button type="submit">Entrar</button>
    </form>
    <p>O <a href="register.php">registrarse</a></p>
  <?php endif; ?>
</body>
</html>
