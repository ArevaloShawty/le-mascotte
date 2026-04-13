<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Admin' ?> — Le Mascotte Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { DEFAULT:'#FF6B35', dark:'#E5521C', light:'#FF8C5A' },
            neutral: { 50:'#FAF9F8',100:'#F5F0ED',200:'#EDE5E0',300:'#D4C5BC',400:'#B09080',500:'#8C7068',600:'#6B5248',700:'#4A3830',800:'#2E2018',900:'#1A1008' },
          },
          fontFamily: { body: ['Nunito','sans-serif'] }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Nunito', sans-serif; }
    .sidebar-link.active { background: #FF6B35; color: white; }
    .sidebar-link.active i { color: white; }
    .sidebar-link:not(.active):hover { background: #fff8f5; color: #FF6B35; }
  </style>
</head>
<body class="bg-neutral-50 min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 min-h-screen bg-white border-r border-neutral-200 flex flex-col fixed top-0 left-0 z-30 shadow-sm">
  <!-- Brand -->
  <div class="p-5 border-b border-neutral-100">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center text-white text-lg">🐾</div>
      <div>
        <p class="font-bold text-neutral-900 text-sm leading-tight">Le Mascotte</p>
        <p class="text-xs text-primary font-semibold">Panel Admin</p>
      </div>
    </div>
  </div>

  <!-- Nav -->
  <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
    <?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $navItems = [
      ['/admin',          'fa-gauge',          'Dashboard'],
      ['/admin/pedidos',  'fa-shopping-bag',   'Pedidos'],
      ['/admin/citas',    'fa-calendar-check', 'Citas'],
      ['/admin/mensajes', 'fa-envelope',       'Mensajes'],
      ['/admin/productos','fa-box',            'Productos'],
    ];
    foreach ($navItems as [$path, $icon, $label]):
      $basePath = str_replace('/le-mascotte/public', '', $currentPath);
      $isActive = ($basePath === $path || ($path !== '/admin' && str_starts_with($basePath, $path)));
    ?>
    <a href="<?= APP_URL . $path ?>"
       class="sidebar-link <?= $isActive ? 'active' : '' ?> flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold text-neutral-600 transition-all">
      <i class="fas <?= $icon ?> w-4 text-sm <?= $isActive ? '' : 'text-neutral-400' ?>"></i>
      <?= $label ?>
      <?php if ($path === '/admin/mensajes'): ?>
        <?php $nuevos = (new AdminModel())->getDashboardStats()['mensajes_nuevos']; ?>
        <?php if ($nuevos > 0): ?>
        <span class="ml-auto bg-primary text-white text-xs px-2 py-0.5 rounded-full"><?= $nuevos ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </a>
    <?php endforeach; ?>
  </nav>

  <!-- Footer -->
  <div class="p-4 border-t border-neutral-100">
    <div class="flex items-center gap-3 mb-3">
      <div class="w-8 h-8 bg-primary/15 rounded-full flex items-center justify-center text-primary font-bold text-sm">
        <?= strtoupper(substr($_SESSION['admin_nombre'] ?? 'A', 0, 1)) ?>
      </div>
      <div>
        <p class="text-xs font-bold text-neutral-900"><?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Admin') ?></p>
        <p class="text-xs text-neutral-400"><?= htmlspecialchars($_SESSION['admin_email'] ?? '') ?></p>
      </div>
    </div>
    <div class="flex gap-2">
      <a href="<?= APP_URL ?>/inicio" target="_blank"
         class="flex-1 text-center py-2 rounded-lg text-xs font-bold bg-neutral-100 text-neutral-600 hover:bg-neutral-200 transition-colors">
        <i class="fas fa-external-link-alt mr-1"></i>Ver sitio
      </a>
      <a href="<?= APP_URL ?>/admin/logout"
         class="flex-1 text-center py-2 rounded-lg text-xs font-bold bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
        <i class="fas fa-sign-out-alt mr-1"></i>Salir
      </a>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT -->
<div class="ml-64 flex-1 min-h-screen flex flex-col">
  <!-- Top bar -->
  <header class="bg-white border-b border-neutral-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20">
    <div>
      <h1 class="font-bold text-lg text-neutral-900"><?= $pageTitle ?? 'Dashboard' ?></h1>
      <p class="text-xs text-neutral-400"><?= date('l, d \d\e F \d\e Y') ?></p>
    </div>
    <div class="flex items-center gap-3">
      <span class="text-xs text-neutral-500 bg-neutral-100 px-3 py-1.5 rounded-full font-semibold">
        <i class="fas fa-circle text-green-400 text-xs mr-1"></i>Sistema activo
      </span>
    </div>
  </header>

  <!-- Toast -->
  <div id="toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl border border-neutral-200 px-5 py-3 flex items-center gap-3 min-w-72">
      <div id="toast-icon" class="w-7 h-7 rounded-full flex items-center justify-center text-xs"></div>
      <p id="toast-msg" class="text-sm font-bold text-neutral-800"></p>
    </div>
  </div>

  <main class="flex-1 p-8">
