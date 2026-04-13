<?php $pageTitle = 'Tienda'; require_once APP_PATH . '/views/partials/header.php'; ?>

<section class="py-12 bg-white border-b border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <div>
        <h1 class="font-display font-black text-4xl text-neutral-900">Nuestra Tienda</h1>
        <p class="text-neutral-500 mt-1">Los mejores productos para el cuidado de tus mascotas</p>
      </div>
      <!-- Search -->
      <form action="" method="GET" class="flex gap-2 w-full sm:w-auto">
        <?php if ($categoriaActual): ?>
        <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoriaActual) ?>">
        <?php endif; ?>
        <div class="relative flex-1 sm:w-72">
          <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400 text-sm"></i>
          <input type="text" name="buscar" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
                 placeholder="Buscar productos..."
                 class="w-full pl-10 pr-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
        </div>
        <button type="submit" class="bg-primary text-white px-5 py-3 rounded-xl font-bold hover:bg-primary-dark transition-colors">
          Buscar
        </button>
      </form>
    </div>
  </div>
</section>

<section class="py-10 bg-neutral-50 min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Category Filters -->
    <div class="flex flex-wrap gap-2 mb-8">
      <a href="<?= APP_URL ?>/productos"
         class="px-4 py-2 rounded-xl text-sm font-bold transition-all
         <?= empty($categoriaActual) ? 'bg-primary text-white shadow-md' : 'bg-white text-neutral-600 hover:bg-primary/10 hover:text-primary border border-neutral-200' ?>">
        Todos
      </a>
      <?php foreach ($categorias as $cat):
        if ($cat['tipo'] !== 'producto') continue;
      ?>
      <a href="<?= APP_URL ?>/productos?categoria=<?= urlencode($cat['slug']) ?>"
         class="px-4 py-2 rounded-xl text-sm font-bold transition-all
         <?= $categoriaActual === $cat['slug'] ? 'bg-primary text-white shadow-md' : 'bg-white text-neutral-600 hover:bg-primary/10 hover:text-primary border border-neutral-200' ?>">
        <?= htmlspecialchars($cat['nombre']) ?>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <?php if (empty($productos)): ?>
    <div class="text-center py-20">
      <i class="fas fa-box-open text-5xl text-neutral-300 mb-4"></i>
      <p class="text-neutral-500 text-lg">No se encontraron productos</p>
      <a href="<?= APP_URL ?>/productos" class="mt-4 inline-flex items-center gap-2 text-primary font-bold">
        <i class="fas fa-arrow-left"></i> Ver todos
      </a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <?php foreach ($productos as $producto): ?>
      <?php include APP_PATH . '/views/partials/product_card.php'; ?>
      <?php endforeach; ?>
    </div>
    <p class="text-sm text-neutral-400 mt-6 text-right"><?= count($productos) ?> producto(s) encontrado(s)</p>
    <?php endif; ?>
  </div>
</section>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
