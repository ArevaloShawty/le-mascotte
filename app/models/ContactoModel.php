<?php
// app/models/ContactoModel.php

require_once ROOT_PATH . '/config/database.php';

class ContactoModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function guardarMensaje(array $data): int {
        return $this->db->insert(
            "INSERT INTO contacto_mensajes (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)",
            [$data['nombre'], $data['email'], $data['asunto'] ?? '', $data['mensaje']]
        );
    }
}
?>
