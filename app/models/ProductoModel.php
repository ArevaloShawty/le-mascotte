<?php
// app/models/ProductoModel.php

require_once ROOT_PATH . '/config/database.php';

class ProductoModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(array $filters = []): array {
        $sql = "SELECT * FROM v_productos_completos WHERE 1=1";
        $params = [];

        if (!empty($filters['categoria'])) {
            $sql .= " AND categoria_slug = ?";
            $params[] = $filters['categoria'];
        }
        if (isset($filters['exotico'])) {
            $sql .= " AND es_exotico = ?";
            $params[] = $filters['exotico'];
        }
        if (!empty($filters['buscar'])) {
            $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
            $params[] = '%' . $filters['buscar'] . '%';
            $params[] = '%' . $filters['buscar'] . '%';
        }
        if (!empty($filters['destacado'])) {
            $sql .= " AND destacado = 1";
        }

        $sql .= " ORDER BY destacado DESC, id DESC";

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return $this->db->fetchAll($sql, $params);
    }

    public function getById(int $id): array|false {
        return $this->db->fetchOne(
            "SELECT * FROM v_productos_completos WHERE id = ?", [$id]
        );
    }

    public function getExoticos(): array {
        return $this->getAll(['exotico' => 1]);
    }

    public function getDestacados(int $limit = 6): array {
        return $this->getAll(['destacado' => true, 'limit' => $limit]);
    }

    public function getCategorias(): array {
        return $this->db->fetchAll("SELECT * FROM categorias WHERE activo = 1 ORDER BY tipo, nombre");
    }

    public function getByCategoria(string $slug): array {
        return $this->getAll(['categoria' => $slug]);
    }
}
?>
