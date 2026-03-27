<?php

class Database {
    // Datos actualizados según el entorno de red de tu proyecto
    private static $host = '192.168.56.250';
    private static $dbname = 'db01';
    private static $username = 'root';
    private static $password = 'Marco6366546.';
    private static $charset = 'utf8mb4';

    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
                
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$pdo = new PDO($dsn, self::$username, self::$password, $options);

            } catch (PDOException $e) {
                // Manejo de errores profesional: responde en JSON y detiene la ejecución
                if (!headers_sent()) {
                    header('Content-Type: application/json');
                    http_response_code(500);
                }
                
                echo json_encode([
                    'error'   => 'Error de conexión a la base de datos',
                    'details' => $e->getMessage()
                ]);
                exit;
            }
        }
        return self::$pdo;
    }
}