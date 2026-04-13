<?php $pageTitle = '404 - No encontrado'; require_once APP_PATH . '/views/partials/header.php'; ?>
<section class="min-h-screen flex items-center justify-center bg-neutral-50 py-20">
  <div class="text-center">
    <div class="text-9xl font-display font-black text-primary/20">404</div>
    <h1 class="font-display font-bold text-4xl text-neutral-900 -mt-4 mb-4">Página no encontrada</h1>
    <p class="text-neutral-400 text-lg mb-8">La página que buscas no existe o fue movida.</p>
    <a href="<?= APP_URL ?>/inicio" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold hover:bg-primary-dark transition-colors">
      <i class="fas fa-home"></i> Volver al inicio
    </a>
  </div>
</section>
<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
