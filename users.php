<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php'); exit;
}

// Formulario de búsqueda (reflected input)
echo "<h2>Bienvenido, " . $_SESSION['fullname'] . "</h2>";
echo "<p><a href='logout.php'>Logout</a> — <a href='jwt.php'>JWT demo</a></p>";

$q = isset($_GET['q']) ? $_GET['q'] : '';

// Mostrar el formulario de filtrado.
// NOTA: el valor se imprime directamente (vulnerable a reflected XSS).
echo "<form method='get' action='users.php'>";
echo "  Buscar usuarios (username o fullname): <input name='q' value='{$q}'>";
echo "  <button type='submit'>Buscar</button>";
echo "</form>";

// Consulta vulnerable que usa $q sin sanitizar (practica para SQLi/XSS)
$sql = "SELECT id, username, fullname FROM users";
if ($q !== '') {
    // uso de LIKE para filtrar; vulnerable si $q contiene comillas u operadores SQL
    $sql .= " WHERE username LIKE '%$q%' OR fullname LIKE '%$q%'";
}

$res = $mysqli->query($sql);
if (!$res) {
    echo "<p>Error en la consulta: " . $mysqli->error . "</p>";
    exit;
}

echo "<h3>Usuarios</h3>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Usuario</th><th>Nombre</th></tr>";
while ($r = $res->fetch_assoc()) {
    // SE MUESTRAN LOS CAMPOS DIRECTAMENTE: vulnerable a stored XSS si fullname contiene HTML/JS
    echo "<tr>";
    echo "<td>{$r['id']}</td>";
    echo "<td>{$r['username']}</td>";
    echo "<td>{$r['fullname']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
