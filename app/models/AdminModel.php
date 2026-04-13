<?php
// app/models/AdminModel.php

require_once ROOT_PATH . '/config/database.php';

class AdminModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // ─── DASHBOARD ────────────────────────────────────────────────
    public function getDashboardStats(): array {
        return [
            'total_pedidos'   => $this->db->fetchOne("SELECT COUNT(*) as n FROM pedidos")['n'],
            'pedidos_hoy'     => $this->db->fetchOne("SELECT COUNT(*) as n FROM pedidos WHERE DATE(created_at)=CURDATE()")['n'],
            'ingresos_hoy'    => $this->db->fetchOne("SELECT COALESCE(SUM(total),0) as n FROM pedidos WHERE DATE(created_at)=CURDATE() AND estado!='cancelado'")['n'],
            'ingresos_mes'    => $this->db->fetchOne("SELECT COALESCE(SUM(total),0) as n FROM pedidos WHERE MONTH(created_at)=MONTH(NOW()) AND YEAR(created_at)=YEAR(NOW()) AND estado!='cancelado'")['n'],
            'citas_hoy'       => $this->db->fetchOne("SELECT COUNT(*) as n FROM citas WHERE fecha_preferida=CURDATE() AND estado!='cancelada'")['n'],
            'citas_pendientes'=> $this->db->fetchOne("SELECT COUNT(*) as n FROM citas WHERE estado='solicitada'")['n'],
            'total_productos' => $this->db->fetchOne("SELECT COUNT(*) as n FROM productos WHERE activo=1")['n'],
            'mensajes_nuevos' => $this->db->fetchOne("SELECT COUNT(*) as n FROM contacto_mensajes WHERE leido=0")['n'],
        ];
    }

    // ─── PEDIDOS ──────────────────────────────────────────────────
    public function getPedidos(array $filters = []): array {
        $sql = "SELECT p.*, COUNT(dp.id) AS items, GROUP_CONCAT(dp.nombre_producto SEPARATOR ', ') AS productos_lista
                FROM pedidos p
                LEFT JOIN detalle_pedidos dp ON p.id = dp.pedido_id
                WHERE 1=1";
        $params = [];
        if (!empty($filters['estado'])) {
            $sql .= " AND p.estado = ?"; $params[] = $filters['estado'];
        }
        if (!empty($filters['buscar'])) {
            $sql .= " AND (p.nombre_cliente LIKE ? OR p.email_cliente LIKE ? OR p.id = ?)";
            $params[] = '%'.$filters['buscar'].'%';
            $params[] = '%'.$filters['buscar'].'%';
            $params[] = (int)$filters['buscar'];
        }
        $sql .= " GROUP BY p.id ORDER BY p.created_at DESC";
        if (!empty($filters['limit'])) $sql .= " LIMIT ".(int)$filters['limit'];
        return $this->db->fetchAll($sql, $params);
    }

    public function getPedidoCompleto(int $id): array|false {
        $pedido = $this->db->fetchOne("SELECT * FROM pedidos WHERE id=?", [$id]);
        if (!$pedido) return false;
        $pedido['items'] = $this->db->fetchAll("SELECT * FROM detalle_pedidos WHERE pedido_id=?", [$id]);
        return $pedido;
    }

    public function actualizarEstadoPedido(int $id, string $estado): bool {
        $estados = ['pendiente','confirmado','procesando','enviado','entregado','cancelado'];
        if (!in_array($estado, $estados)) return false;
        return $this->db->execute("UPDATE pedidos SET estado=? WHERE id=?", [$estado, $id]) > 0;
    }

    // ─── CITAS ────────────────────────────────────────────────────
    public function getCitas(array $filters = []): array {
        $sql = "SELECT * FROM citas WHERE 1=1";
        $params = [];
        if (!empty($filters['estado'])) {
            $sql .= " AND estado=?"; $params[] = $filters['estado'];
        }
        if (!empty($filters['fecha'])) {
            $sql .= " AND fecha_preferida=?"; $params[] = $filters['fecha'];
        }
        if (!empty($filters['buscar'])) {
            $sql .= " AND (nombre_dueno LIKE ? OR nombre_mascota LIKE ? OR telefono LIKE ?)";
            $params[] = '%'.$filters['buscar'].'%';
            $params[] = '%'.$filters['buscar'].'%';
            $params[] = '%'.$filters['buscar'].'%';
        }
        $sql .= " ORDER BY fecha_preferida ASC, hora_preferida ASC";
        return $this->db->fetchAll($sql, $params);
    }

    public function getCitaById(int $id): array|false {
        return $this->db->fetchOne("SELECT * FROM citas WHERE id=?", [$id]);
    }

    public function actualizarEstadoCita(int $id, string $estado, string $notas = ''): bool {
        $estados = ['solicitada','confirmada','completada','cancelada'];
        if (!in_array($estado, $estados)) return false;
        return $this->db->execute(
            "UPDATE citas SET estado=?, notas_veterinario=? WHERE id=?",
            [$estado, $notas, $id]
        ) > 0;
    }

    // ─── MENSAJES ─────────────────────────────────────────────────
    public function getMensajes(bool $soloNuevos = false): array {
        $sql = "SELECT * FROM contacto_mensajes";
        if ($soloNuevos) $sql .= " WHERE leido=0";
        $sql .= " ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function marcarMensajeLeido(int $id): void {
        $this->db->execute("UPDATE contacto_mensajes SET leido=1 WHERE id=?", [$id]);
    }

    // ─── PRODUCTOS (admin) ────────────────────────────────────────
    public function getProductos(): array {
        return $this->db->fetchAll(
            "SELECT p.*, c.nombre AS categoria FROM productos p
             LEFT JOIN categorias c ON p.categoria_id=c.id
             ORDER BY p.id DESC"
        );
    }

    public function toggleProducto(int $id): void {
        $this->db->execute("UPDATE productos SET activo = 1-activo WHERE id=?", [$id]);
    }

    // ─── USUARIOS ADMIN ───────────────────────────────────────────
    public function getAdminByEmail(string $email): array|false {
        return $this->db->fetchOne("SELECT * FROM admin_usuarios WHERE email=? AND activo=1", [$email]);
    }

    public function registrarLogin(int $adminId, string $ip): void {
        $this->db->execute(
            "UPDATE admin_usuarios SET ultimo_login=NOW(), ultimo_ip=? WHERE id=?",
            [$ip, $adminId]
        );
    }
}
?>
