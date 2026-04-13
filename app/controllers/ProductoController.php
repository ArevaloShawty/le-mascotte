<?php
// app/controllers/ProductoController.php

require_once APP_PATH . '/models/ProductoModel.php';

class ProductoController {
    private ProductoModel $model;

    public function __construct() {
        $this->model = new ProductoModel();
    }

    public function index(): void {
        $categoriaSlug = $_GET['categoria'] ?? '';
        $buscar = sanitize($_GET['buscar'] ?? '');

        $filters = [];
        if ($categoriaSlug) $filters['categoria'] = sanitize($categoriaSlug);
        if ($buscar) $filters['buscar'] = $buscar;
        $filters['exotico'] = 0;

        $productos = $this->model->getAll($filters);
        $categorias = $this->model->getCategorias();
        $categoriaActual = $categoriaSlug;
        require APP_PATH . '/views/productos.php';
    }

    public function exoticos(): void {
        $productos = $this->model->getExoticos();
        $categorias = $this->model->getCategorias();
        require APP_PATH . '/views/exoticos.php';
    }

    public function detalle(int $id): void {
        $producto = $this->model->getById($id);
        if (!$producto) { http_response_code(404); require APP_PATH . '/views/404.php'; return; }
        require APP_PATH . '/views/detalle_producto.php';
    }

    // API endpoint para AJAX
    public function apiGetAll(): void {
        $categoriaSlug = $_GET['categoria'] ?? '';
        $filters = $categoriaSlug ? ['categoria' => sanitize($categoriaSlug)] : [];
        $filters['exotico'] = 0;
        jsonResponse(['productos' => $this->model->getAll($filters)]);
    }
}
?>
