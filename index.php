<?php
/**
 * ARCHIVO: index.php (Front Controller)
 * PROYECTO: Actividad 02 - CRUD Usuarios
 */

// 1. Mostrar errores para depuración (Útil para el reporte en Dokuwiki)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Configuración de cabeceras API (CORS)
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Manejo de peticiones preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 3. CARGA JERÁRQUICA (ACTUALIZADO CON DOBLE GUION BAJO _DIR_)
try {
    // Primero: La conexión (Define la función getDB)
    require_once __DIR__ . '/config/database.php';
    
    // Segundo: El Modelo (Usa la función getDB)
    require_once __DIR__ . '/models/Usuario.php';
    
    // Tercero: El Controlador (Instancia la clase Usuario)
    require_once __DIR__ . '/controllers/UsuarioController.php';

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error crítico cargando dependencias', 
        'message' => $e->getMessage()
    ]);
    exit;
}

// 4. Lógica de Enrutamiento
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Identificamos el endpoint /api/usuarios ignorando la carpeta del proyecto
$api_path = '/api/usuarios';
$pos = strpos($uri, $api_path);

if ($pos !== false) {
    // Extraemos la ruta desde '/api/usuarios' en adelante
    $route = substr($uri, $pos);
} else {
    $route = $uri;
}

// 5. Ejecución del Controlador
try {
    $controller = new UsuarioController();

    if ($method === 'GET' && $route === '/api/usuarios') {
        $controller->index();
        
    } elseif ($method === 'GET' && preg_match('#^/api/usuarios/(\d+)$#', $route, $matches)) {
        $controller->show($matches[1]);
        
    } elseif ($method === 'POST' && $route === '/api/usuarios') {
        $controller->store();
        
    } elseif (($method === 'PUT' || $method === 'PATCH') && preg_match('#^/api/usuarios/(\d+)$#', $route, $matches)) {
        $controller->update($matches[1]);
        
    } elseif ($method === 'DELETE' && preg_match('#^/api/usuarios/(\d+)$#', $route, $matches)) {
        $controller->destroy($matches[1]);
        
    } else {
        // Respuesta 404 si la ruta no existe
        http_response_code(404);
        echo json_encode([
            'error' => 'Ruta no encontrada', 
            'debug' => [
                'metodo' => $method,
                'ruta_procesada' => $route
            ]
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error interno en el controlador', 
        'message' => $e->getMessage()
    ]);
}