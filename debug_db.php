<?php
// Datos de tu configuración
$host = '192.168.100.223';
$db   = 'db01';
$user = 'root';
$pass = '123456';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "<h1>CONEXIÓN EXITOSA</h1>";
    echo "El contenedor de PHP se conectó correctamente a MariaDB en la IP $host.";
} catch (PDOException $e) {
    echo "<h1>ERROR DE CONEXIÓN</h1>";
    echo "Mensaje: " . $e->getMessage();
}