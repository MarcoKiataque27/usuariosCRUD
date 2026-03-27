<?php

class Usuario {
    private $db;

    public function __construct() {
        // Verificamos si la función getDB existe antes de llamarla
        if (function_exists('getDB')) {
            $this->db = getDB();
        } else {
            // Si no existe, lanzamos un error claro para el log
            throw new Exception("Error: La función getDB() no está disponible. Revisa config/database.php");
        }
    }

    public function getAll() {
        try {
            // Usamos query para una consulta simple sin parámetros
            $stmt = $this->db->query("SELECT * FROM usuarios ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // En lugar de solo log, lanzamos excepción para que el Controller la capture
            throw new Exception("Error al leer usuarios: " . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Error al buscar usuario ID $id: " . $e->getMessage());
        }
    }

    public function create($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO usuarios (nombre, apellido, correo, celular)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['nombre'],
                $data['apellido'],
                $data['correo'],
                $data['celular'] ?? null
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Esto es vital para tu Dokuwiki: captura errores de duplicados o columnas
            http_response_code(500);
            echo json_encode(["error" => "Fallo en base de datos: " . $e->getMessage()]);
            exit;
        }
    }

    public function update($id, $data) {
        try {
            $stmt = $this->db->prepare("
                UPDATE usuarios 
                SET nombre = ?, apellido = ?, correo = ?, celular = ?
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['nombre'],
                $data['apellido'],
                $data['correo'],
                $data['celular'] ?? null,
                $id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar ID $id: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar ID $id: " . $e->getMessage());
        }
    }

    public function existsByCorreo($correo, $excludeId = null) {
        try {
            if ($excludeId) {
                $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ? AND id != ?");
                $stmt->execute([$correo, $excludeId]);
            } else {
                $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ?");
                $stmt->execute([$correo]);
            }
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            return false;
        }
    }
}