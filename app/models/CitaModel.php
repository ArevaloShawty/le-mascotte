<?php
// app/models/CitaModel.php

require_once ROOT_PATH . '/config/database.php';

class CitaModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function crear(array $data): int|false {
        // Validar que no haya otra cita a la misma hora
        $existe = $this->db->fetchOne(
            "SELECT id FROM citas WHERE fecha_preferida = ? AND hora_preferida = ? AND estado != 'cancelada'",
            [$data['fecha_preferida'], $data['hora_preferida']]
        );

        if ($existe) {
            return false; // Horario ocupado
        }

        return $this->db->insert(
            "INSERT INTO citas (nombre_dueno, email, telefono, nombre_mascota, tipo_mascota, motivo_consulta, fecha_preferida, hora_preferida) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['nombre_dueno'],
                $data['email'] ?? null,
                $data['telefono'],
                $data['nombre_mascota'],
                $data['tipo_mascota'],
                $data['motivo_consulta'],
                $data['fecha_preferida'],
                $data['hora_preferida']
            ]
        );
    }

    public function getById(int $id): array|false {
        return $this->db->fetchOne("SELECT * FROM citas WHERE id = ?", [$id]);
    }

    public function getHorariosOcupados(string $fecha): array {
        $citas = $this->db->fetchAll(
            "SELECT hora_preferida FROM citas WHERE fecha_preferida = ? AND estado != 'cancelada'",
            [$fecha]
        );
        return array_column($citas, 'hora_preferida');
    }
}
?>
