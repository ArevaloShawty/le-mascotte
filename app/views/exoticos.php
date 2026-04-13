<?php $pageTitle = 'Mascotas Exóticas'; require_once APP_PATH . '/views/partials/header.php'; ?>

<!-- Hero -->
<section class="bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 text-white py-20 relative overflow-hidden">
  <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1502780402662-acc01917738e?w=1400')] bg-cover bg-center opacity-10"></div>
  <div class="absolute top-0 right-0 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <span class="inline-flex items-center gap-2 bg-primary/20 text-primary px-5 py-2 rounded-full text-sm font-bold mb-6">
      <i class="fas fa-dragon"></i> Sección Especial
    </span>
    <h1 class="font-display font-black text-5xl sm:text-6xl mb-5">Mascotas <span class="text-primary">Exóticas</span></h1>
    <p class="text-neutral-300 text-xl max-w-2xl mx-auto">Productos especializados para reptiles, aves tropicales y pequeños mamíferos. Cada producto incluye tips de cuidado de nuestros expertos.</p>
    <div class="flex flex-wrap justify-center gap-6 mt-10">
      <?php $types = [
        ['🦎','Reptiles','reptiles'],['🦜','Aves','aves'],['🐹','Pequeños Mamíferos','pequenos-mamiferos']
      ]; foreach ($types as [$emoji,$label,$slug]): ?>
      <a href="#cat-<?= $slug ?>" class="flex flex-col items-center gap-2 bg-white/10 hover:bg-primary/30 backdrop-blur px-6 py-4 rounded-2xl transition-all hover:-translate-y-1">
        <span class="text-3xl"><?= $emoji ?></span>
        <span class="text-sm font-bold"><?= $label ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Alert about exotic care -->
<div class="bg-amber-50 border-b border-amber-200 py-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-3 text-amber-800">
      <i class="fas fa-lightbulb text-amber-500 text-xl flex-shrink-0"></i>
      <p class="text-sm"><strong>Consejo Le Mascotte:</strong> Las mascotas exóticas son delicadas. Todos nuestros productos incluyen tips de cuidado y contamos con veterinarios especializados en exóticos. <a href="<?= APP_URL ?>/citas" class="underline font-bold">Agenda una consulta.</a></p>
    </div>
  </div>
</div>

<!-- Products by category -->
<section class="py-16 bg-neutral-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php
    $categorias_exoticas = array_filter($categorias, fn($c) => $c['tipo'] === 'exotico');
    foreach ($categorias_exoticas as $cat):
      $cat_prods = array_filter($productos, fn($p) => $p['categoria_slug'] === $cat['slug']);
      if (empty($cat_prods)) continue;
    ?>
    <div id="cat-<?= $cat['slug'] ?>" class="mb-16">
      <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-primary/15 rounded-2xl flex items-center justify-center text-2xl">
          <?= $cat['tipo'] === 'exotico' ? ($cat['slug'] === 'reptiles' ? '🦎' : ($cat['slug'] === 'aves' ? '🦜' : '🐹')) : '🐾' ?>
        </div>
        <div>
          <h2 class="font-display font-bold text-3xl text-neutral-900"><?= htmlspecialchars($cat['nombre']) ?></h2>
          <p class="text-neutral-400 text-sm"><?= htmlspecialchars($cat['descripcion'] ?? '') ?></p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($cat_prods as $producto): ?>
        <?php include APP_PATH . '/views/partials/product_card.php'; ?>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Clinic CTA -->
<section class="py-16 bg-primary">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
    <i class="fas fa-stethoscope text-5xl mb-5 opacity-80"></i>
    <h2 class="font-display font-bold text-4xl mb-4">¿Tu mascota exótica necesita atención?</h2>
    <p class="text-orange-100 text-lg mb-8">Contamos con veterinarios especializados en animales exóticos. Consultas, revisiones y emergencias.</p>
    <a href="<?= APP_URL ?>/citas" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
      <i class="fas fa-calendar-check"></i> Agendar Consulta Especializada
    </a>
  </div>
</section>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
