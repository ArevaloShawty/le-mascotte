<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

$request  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// En InfinityFree si el sitio está en la raíz, el base suele ser vacío o el nombre de la carpeta
// Si el proyecto está en htdocs directamente, deja $base = '';
$base     = '/le-mascotte'; 
$route    = trim(str_replace($base, '', $request), '/');
$segments = explode('/', $route);

$page   = $segments[0] ?: 'inicio';
$sub    = $segments[1] ?? null;
$param  = $segments[2] ?? null;
$action = $segments[3] ?? null;

// RUTAS ADMIN
if ($page === 'admin') {
    require_once APP_PATH . '/controllers/AdminController.php';
    $ctrl = new AdminController();
    $adminSub = $sub ?: 'dashboard';
    if ($adminSub === 'login' && $_SERVER['REQUEST_METHOD'] === 'GET')  { $ctrl->loginForm(); }
    elseif ($adminSub === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') { $ctrl->loginPost(); }
    elseif ($adminSub === 'logout')    { $ctrl->logout(); }
    elseif ($adminSub === 'pedidos' && $param === null) { $ctrl->pedidos(); }
    elseif ($adminSub === 'pedidos' && is_numeric($param) && $action === 'estado') { $ctrl->pedidoActualizar((int)$param); }
    elseif ($adminSub === 'pedidos' && is_numeric($param)) { $ctrl->pedidoDetalle((int)$param); }
    elseif ($adminSub === 'citas' && is_numeric($param) && $action === 'estado') { $ctrl->citaActualizar((int)$param); }
    elseif ($adminSub === 'citas') { $ctrl->citas(); }
    elseif ($adminSub === 'mensajes' && is_numeric($param) && $action === 'leido') { $ctrl->mensajeLeido((int)$param); }
    elseif ($adminSub === 'mensajes') { $ctrl->mensajes(); }
    elseif ($adminSub === 'productos' && is_numeric($param) && $action === 'toggle') { $ctrl->productoToggle((int)$param); }
    elseif ($adminSub === 'productos') { $ctrl->productos(); }
    else { $ctrl->dashboard(); }
    exit;
}

// RUTAS PUBLICAS
switch ($page) {
    case '': case 'inicio':
        require_once APP_PATH . '/controllers/HomeController.php';
        (new HomeController())->index(); break;
    case 'productos':
        require_once APP_PATH . '/controllers/ProductoController.php';
        $c = new ProductoController();
        if ($sub==='api') $c->apiGetAll();
        elseif ($sub && is_numeric($sub)) $c->detalle((int)$sub);
        else $c->index(); break;
    case 'exoticos':
        require_once APP_PATH . '/controllers/ProductoController.php';
        (new ProductoController())->exoticos(); break;
    case 'carrito':
        require_once APP_PATH . '/controllers/OtrosControllers.php';
        (new PedidoController())->carrito(); break;
    case 'checkout':
        require_once APP_PATH . '/controllers/OtrosControllers.php';
        $c = new PedidoController();
        if ($_SERVER['REQUEST_METHOD']==='POST') $c->confirmar();
        elseif ($sub==='confirmacion'&&$param) $c->confirmacion((int)$param);
        else $c->checkout(); break;
    case 'citas':
        require_once APP_PATH . '/controllers/CitaController.php';
        $c = new CitaController();
        if ($_SERVER['REQUEST_METHOD']==='POST') $c->crear();
        elseif ($sub==='horarios') $c->horariosOcupados();
        else $c->index(); break;
    case 'contacto':
        require_once APP_PATH . '/controllers/OtrosControllers.php';
        $c = new ContactoController();
        if ($_SERVER['REQUEST_METHOD']==='POST') $c->enviar();
        else $c->index(); break;
    default:
        http_response_code(404); require APP_PATH . '/views/404.php'; break;
}