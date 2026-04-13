<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Le Mascotte' ?> | Le Mascotte</title>
  <meta name="description" content="Le Mascotte - Tienda de mascotas y clínica veterinaria. Cuidamos a los que más quieres.">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary:   { DEFAULT: '#FF6B35', light: '#FF8C5A', dark: '#E5521C' },
            secondary: { DEFAULT: '#FFF8F5', light: '#FFFFFF', dark: '#F5EDE8' },
            accent:    { DEFAULT: '#FF6B35', muted: '#FFB899' },
            neutral:   { 50:'#FAF9F8', 100:'#F5F0ED', 200:'#EDE5E0', 300:'#D4C5BC', 400:'#B09080', 500:'#8C7068', 600:'#6B5248', 700:'#4A3830', 800:'#2E2018', 900:'#1A1008' },
            success:   '#22C55E',
            warning:   '#EAB308',
          },
          fontFamily: {
            display: ['"Playfair Display"', 'serif'],
            body: ['Nunito', 'sans-serif'],
          },
        }
      }
    }
  </script>
</head>
<body class="font-body bg-secondary text-neutral-800 min-h-screen">

<!-- NAVBAR -->
<nav class="navbar fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="<?= APP_URL ?>/inicio" class="flex items-center gap-2 group">
        <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center text-white text-lg shadow-md group-hover:scale-110 transition-transform">
          🐾
        </div>
        <div class="leading-tight">
          <span class="font-display font-bold text-xl text-neutral-900 block">Le Mascotte</span>
          <span class="text-xs text-primary font-semibold -mt-1 block">Clínica & Tienda</span>
        </div>
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-1">
        <?php
        $currentRoute = trim(str_replace('/le-mascotte/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
        $navLinks = [
          ['url' => 'inicio',   'label' => 'Inicio',          'icon' => 'fa-home'],
          ['url' => 'productos','label' => 'Tienda',           'icon' => 'fa-store'],
          ['url' => 'exoticos', 'label' => 'Exóticos',        'icon' => 'fa-dragon'],
          ['url' => 'citas',    'label' => 'Agendar Cita',    'icon' => 'fa-calendar-check'],
          ['url' => 'contacto', 'label' => 'Contacto',        'icon' => 'fa-envelope'],
        ];
        foreach ($navLinks as $link):
          $isActive = ($currentRoute === $link['url'] || ($currentRoute === '' && $link['url'] === 'inicio'));
        ?>
        <a href="<?= APP_URL ?>/<?= $link['url'] ?>"
           class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200
           <?= $isActive ? 'bg-primary text-white' : 'text-neutral-600 hover:bg-primary/10 hover:text-primary' ?>">
          <?= $link['label'] ?>
        </a>
        <?php endforeach; ?>
      </div>

      <!-- Cart & Mobile -->
      <div class="flex items-center gap-2">
        <!-- Cart Button -->
        <a href="<?= APP_URL ?>/carrito" class="relative p-2 rounded-xl bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all duration-200">
          <i class="fas fa-shopping-cart text-lg"></i>
          <span id="cart-count" class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-xs rounded-full flex items-center justify-center font-bold hidden">0</span>
        </a>

        <!-- Mobile menu button -->
        <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl hover:bg-neutral-100 transition-colors">
          <i class="fas fa-bars text-neutral-600"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden border-t border-neutral-100 bg-white pb-4">
    <div class="px-4 pt-2 space-y-1">
      <?php foreach ($navLinks as $link): ?>
      <a href="<?= APP_URL ?>/<?= $link['url'] ?>"
         class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-neutral-600 hover:bg-primary/10 hover:text-primary transition-all">
        <i class="fas <?= $link['icon'] ?> w-4"></i>
        <?= $link['label'] ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</nav>

<!-- Floating Appointment Button -->
<a href="<?= APP_URL ?>/citas"
   class="fixed bottom-6 right-6 z-40 bg-primary text-white px-5 py-3 rounded-full shadow-xl hover:bg-primary-dark hover:shadow-2xl transition-all duration-300 flex items-center gap-2 font-bold text-sm hover:scale-105">
  <i class="fas fa-stethoscope"></i>
  <span class="hidden sm:inline">Agendar Cita</span>
</a>

<main class="pt-16">
