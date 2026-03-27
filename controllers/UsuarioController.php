<?php

// Eliminamos los require_once de aquí porque el index.php ya los carga.
// Esto evita el error de "Redeclare class" o rutas fallidas.

class UsuarioController {
    private $usuario;

    public function __construct() {
        // Verificamos si la clase Usuario existe antes de instanciarla
        if (class_exists('Usuario')) {
            $this->usuario = new Usuario();
        } else {
            // Si no existe, lanzamos un error que el index.php capturará como 500
            throw new Exception("Error Crítico: La clase 'Usuario' no fue encontrada. Revisa la carga en index.php");
        }
    }

    private function json($data, $status = 200) {
        // Limpiamos cualquier salida previa para asegurar un JSON puro
        if (ob_get_length()) ob_clean();
        
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function validate($data) {
        $errors = [];

        if (empty($data['nombre']) || strlen($data['nombre']) > 100) {
            $errors[] = 'El nombre es requerido y debe tener máximo 100 caracteres';
        }

        if (empty($data['apellido']) || strlen($data['apellido']) > 100) {
            $errors[] = 'El apellido es requerido y debe tener máximo 100 caracteres';
        }

        if (empty($data['correo']) || !filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El correo es requerido y debe ser válido';
        }

        if (!empty($data['celular']) && strlen($data['celular']) > 30) {
            $errors[] = 'El celular debe tener máximo 30 caracteres';
        }

        return $errors;
    }

    public function index() {
        try {
            $usuarios = $this->usuario->getAll();
            $this->json(['data' => $usuarios]);
        } catch (Exception $e) {
            $this->json(['error' => 'Error al obtener usuarios', 'details' => $e->getMessage()], 500);
        }
    }

    public function show($id) {
        $usuario = $this->usuario->getById($id);
        if (!$usuario) {
            $this->json(['error' => 'Usuario no encontrado'], 404);
        }
        $this->json(['data' => $usuario]);
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->json(['errors' => ['No se recibieron datos válidos']], 400);
        }

        $errors = $this->validate($data);
        if ($errors) {
            $this->json(['errors' => $errors], 422);
        }

        if ($this->usuario->existsByCorreo($data['correo'])) {
            $this->json(['errors' => ['El correo ya está registrado']], 422);
        }

        $id = $this->usuario->create($data);
        $this->json(['message' => 'Usuario creado', 'id' => $id], 201);
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        $existing = $this->usuario->getById($id);
        if (!$existing) {
            $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $errors = $this->validate($data);
        if ($errors) {
            $this->json(['errors' => $errors], 422);
        }

        if ($this->usuario->existsByCorreo($data['correo'], $id)) {
            $this->json(['errors' => ['El correo ya está registrado']], 422);
        }

        $this->usuario->update($id, $data);
        $this->json(['message' => 'Usuario actualizado']);
    }

    public function destroy($id) {
        $existing = $this->usuario->getById($id);
        if (!$existing) {
            $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $this->usuario->delete($id);
        $this->json(['message' => 'Usuario eliminado']);
    }
}