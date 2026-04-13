<?php
// app/controllers/HomeController.php

require_once APP_PATH . '/models/ProductoModel.php';

class HomeController {
    private ProductoModel $productoModel;

    public function __construct() {
        $this->productoModel = new ProductoModel();
    }

    public function index(): void {
        $destacados = $this->productoModel->getDestacados(6);
        $categorias = $this->productoModel->getCategorias();
        require APP_PATH . '/views/home.php';
    }
}
?>
