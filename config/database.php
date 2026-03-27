<?php

// Definición de constantes para la conexión
// Asegúrate de que no haya espacios en blanco antes del <?php
define('DB_HOST', '192.168.56.250');
define('DB_NAME', 'db01');
define('DB_USER', 'root');
define('DB_PASS', 'Marco6366546.');

/**
 * Retorna una instancia de conexión PDO a MariaDB
 */
function getDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, DB_USER, DB_PASS, $options);

    } catch (PDOException $e) {
        // Si hay un error, devolvemos un JSON limpio y cortamos la ejecución
        // Esto evita que el error se mezcle con el HTML del frontend
        if (!headers_sent()) {
            header('Content-Type: application/json');
            http_response_code(500);
        }
        
        echo json_encode([
            'error' => 'Error de conexión a la base de datos',
            'details' => $e->getMessage()
        ]);
        exit;
    }
}