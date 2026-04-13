<?php
// app/controllers/AdminController.php

require_once APP_PATH . '/models/AdminModel.php';
require_once APP_PATH . '/models/Mailer.php';

class AdminController {
    private AdminModel $model;

    public function __construct() {
        $this->model = new AdminModel();
    }

    // ─── AUTENTICACIÓN ────────────────────────────────────────────
    private function requireAuth(): void {
        if (empty($_SESSION['admin_id'])) {
            header('Location: ' . APP_URL . '/admin/login');
            exit;
        }
    }

    public function loginForm(): void {
        if (!empty($_SESSION['admin_id'])) {
            header('Location: ' . APP_URL . '/admin'); exit;
        }
        require APP_PATH . '/views/admin/login.php';
    }

    public function loginPost(): void {
        $email = sanitize($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        if (!$email || !$pass) {
            $_SESSION['admin_error'] = 'Ingresa email y contraseña.';
            header('Location: ' . APP_URL . '/admin/login'); exit;
        }

        $admin = $this->model->getAdminByEmail($email);

        if (!$admin || !password_verify($pass, $admin['password_hash'])) {
            $_SESSION['admin_error'] = 'Credenciales incorrectas.';
            header('Location: ' . APP_URL . '/admin/login'); exit;
        }

        $_SESSION['admin_id']     = $admin['id'];
        $_SESSION['admin_nombre'] = $admin['nombre'];
        $_SESSION['admin_email']  = $admin['email'];
        $this->model->registrarLogin($admin['id'], $_SERVER['REMOTE_ADDR'] ?? '');

        header('Location: ' . APP_URL . '/admin'); exit;
    }

    public function logout(): void {
        unset($_SESSION['admin_id'], $_SESSION['admin_nombre'], $_SESSION['admin_email']);
        header('Location: ' . APP_URL . '/admin/login'); exit;
    }

    // ─── DASHBOARD ────────────────────────────────────────────────
    public function dashboard(): void {
        $this->requireAuth();
        $stats          = $this->model->getDashboardStats();
        $pedidosRecientes = $this->model->getPedidos(['limit' => 5]);
        $citasHoy       = $this->model->getCitas(['fecha' => date('Y-m-d')]);
        $mensajes       = $this->model->getMensajes(true);
        require APP_PATH . '/views/admin/dashboard.php';
    }

    // ─── PEDIDOS ──────────────────────────────────────────────────
    public function pedidos(): void {
        $this->requireAuth();
        $filters  = [
            'estado'  => $_GET['estado'] ?? '',
            'buscar'  => sanitize($_GET['buscar'] ?? ''),
        ];
        $pedidos  = $this->model->getPedidos($filters);
        require APP_PATH . '/views/admin/pedidos.php';
    }

    public function pedidoDetalle(int $id): void {
        $this->requireAuth();
        $pedido = $this->model->getPedidoCompleto($id);
        if (!$pedido) { http_response_code(404); echo 'Pedido no encontrado'; return; }
        require APP_PATH . '/views/admin/pedido_detalle.php';
    }

    public function pedidoActualizar(int $id): void {
        $this->requireAuth();
        $estado = sanitize($_POST['estado'] ?? '');
        $ok     = $this->model->actualizarEstadoPedido($id, $estado);

        if ($ok) {
            // Enviar email de actualización al cliente
            $pedido = $this->model->getPedidoCompleto($id);
            if ($pedido) Mailer::actualizacionEstadoPedido($pedido);
            jsonResponse(['success' => true, 'message' => 'Estado actualizado y correo enviado.']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Estado inválido.'], 400);
        }
    }

    // ─── CITAS ────────────────────────────────────────────────────
    public function citas(): void {
        $this->requireAuth();
        $filters = [
            'estado' => $_GET['estado'] ?? '',
            'fecha'  => $_GET['fecha']  ?? '',
            'buscar' => sanitize($_GET['buscar'] ?? ''),
        ];
        $citas = $this->model->getCitas($filters);
        require APP_PATH . '/views/admin/citas.php';
    }

    public function citaActualizar(int $id): void {
        $this->requireAuth();
        $estado = sanitize($_POST['estado'] ?? '');
        $notas  = sanitize($_POST['notas'] ?? '');
        $ok     = $this->model->actualizarEstadoCita($id, $estado, $notas);

        if ($ok) {
            // Enviar email de confirmación si pasa a "confirmada"
            if ($estado === 'confirmada') {
                $cita = $this->model->getCitaById($id);
                if ($cita && !empty($cita['email'])) Mailer::confirmacionCita($cita);
            }
            jsonResponse(['success' => true, 'message' => 'Cita actualizada.']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Estado inválido.'], 400);
        }
    }

    // ─── MENSAJES ─────────────────────────────────────────────────
    public function mensajes(): void {
        $this->requireAuth();
        $mensajes = $this->model->getMensajes();
        require APP_PATH . '/views/admin/mensajes.php';
    }

    public function mensajeLeido(int $id): void {
        $this->requireAuth();
        $this->model->marcarMensajeLeido($id);
        jsonResponse(['success' => true]);
    }

    // ─── PRODUCTOS ────────────────────────────────────────────────
    public function productos(): void {
        $this->requireAuth();
        $productos = $this->model->getProductos();
        require APP_PATH . '/views/admin/productos.php';
    }

    public function productoToggle(int $id): void {
        $this->requireAuth();
        $this->model->toggleProducto($id);
        jsonResponse(['success' => true]);
    }
}
?>
