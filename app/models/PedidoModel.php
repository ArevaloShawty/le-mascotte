<?php
// app/models/PedidoModel.php

require_once ROOT_PATH . '/config/database.php';

class PedidoModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function crear(array $pedido, array $items): int {
        $pedidoId = $this->db->insert(
            "INSERT INTO pedidos (nombre_cliente, email_cliente, telefono, direccion_entrega, subtotal, impuesto, total, notas)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $pedido['nombre'],
                $pedido['email'],
                $pedido['telefono'],
                $pedido['direccion'],
                $pedido['subtotal'],
                $pedido['impuesto'],
                $pedido['total'],
                $pedido['notas'] ?? ''
            ]
        );

        foreach ($items as $item) {
            $this->db->execute(
                "INSERT INTO detalle_pedidos (pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal)
                 VALUES (?, ?, ?, ?, ?, ?)",
                [
                    $pedidoId,
                    $item['id'],
                    $item['nombre'],
                    $item['precio'],
                    $item['cantidad'],
                    $item['precio'] * $item['cantidad']
                ]
            );
        }

        return $pedidoId;
    }

    public function getById(int $id): array|false {
        $pedido = $this->db->fetchOne("SELECT * FROM pedidos WHERE id = ?", [$id]);
        if ($pedido) {
            $pedido['items'] = $this->db->fetchAll(
                "SELECT * FROM detalle_pedidos WHERE pedido_id = ?", [$id]
            );
        }
        return $pedido;
    }
}
?>
