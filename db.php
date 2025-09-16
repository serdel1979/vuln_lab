<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'vulnapp';
$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_errno) {
    die("DB connect error: " . $mysqli->connect_error);
}
?>
