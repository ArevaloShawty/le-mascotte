<?php
require_once APP_PATH . '/models/PedidoModel.php';
require_once APP_PATH . '/models/ContactoModel.php';
require_once APP_PATH . '/models/Mailer.php';

class PedidoController {
    private PedidoModel $model;
    public function __construct() { $this->model = new PedidoModel(); }

    public function carrito(): void { require APP_PATH . '/views/carrito.php'; }
    public function checkout(): void { require APP_PATH . '/views/checkout.php'; }

    public function confirmar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('carrito');
        $items = json_decode($_POST['items'] ?? '[]', true);
        if (empty($items)) jsonResponse(['success'=>false,'message'=>'El carrito está vacío.'],400);
        $subtotal = array_sum(array_map(fn($i)=>$i['precio']*$i['cantidad'],$items));
        $impuesto = round($subtotal*0.13,2);
        $total    = $subtotal+$impuesto;
        $pedido   = [
            'nombre'    => sanitize($_POST['nombre']??''),
            'email'     => sanitize($_POST['email']??''),
            'telefono'  => sanitize($_POST['telefono']??''),
            'direccion' => sanitize($_POST['direccion']??''),
            'subtotal'  => $subtotal,
            'impuesto'  => $impuesto,
            'total'     => $total,
        ];
        $pedidoId = $this->model->crear($pedido, $items);
        // Enviar correos
        $pedidoCompleto = $this->model->getById($pedidoId);
        if ($pedidoCompleto) {
            Mailer::confirmacionPedido($pedidoCompleto);
            Mailer::notificarAdminNuevoPedido($pedidoCompleto);
        }
        jsonResponse(['success'=>true,'pedido_id'=>$pedidoId,'total'=>$total]);
    }

    public function confirmacion(int $id): void {
        $pedido = $this->model->getById($id);
        if (!$pedido) { http_response_code(404); require APP_PATH.'/views/404.php'; return; }
        require APP_PATH . '/views/confirmacion_pedido.php';
    }
}

class ContactoController {
    private ContactoModel $model;
    public function __construct() { $this->model = new ContactoModel(); }

    public function index(): void { require APP_PATH . '/views/contacto.php'; }

    public function enviar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('contacto');
        $data = [
            'nombre'  => sanitize($_POST['nombre']??''),
            'email'   => sanitize($_POST['email']??''),
            'asunto'  => sanitize($_POST['asunto']??''),
            'mensaje' => sanitize($_POST['mensaje']??''),
        ];
        if (empty($data['nombre'])||empty($data['email'])||empty($data['mensaje'])) {
            jsonResponse(['success'=>false,'message'=>'Completa todos los campos requeridos.'],400);
        }
        $this->model->guardarMensaje($data);
        jsonResponse(['success'=>true,'message'=>'Mensaje enviado. Te contactaremos pronto.']);
    }
}
