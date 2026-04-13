<div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
  <!-- Image -->
  <div class="relative h-52 overflow-hidden bg-neutral-100">
    <img src="<?= htmlspecialchars($producto['imagen_url'] ?? 'https://via.placeholder.com/400x300') ?>&auto=format&fit=crop"
         alt="<?= htmlspecialchars($producto['nombre']) ?>"
         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 lazy-img">
    <!-- Category badge -->
    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-neutral-700 text-xs font-bold px-3 py-1 rounded-full">
      <?= htmlspecialchars($producto['categoria'] ?? '') ?>
    </span>
    <!-- Sale badge -->
    <?php if (!empty($producto['precio_anterior'])): ?>
    <span class="absolute top-3 right-3 bg-primary text-white text-xs font-bold px-2 py-1 rounded-full">
      -<?= round((1 - $producto['precio'] / $producto['precio_anterior']) * 100) ?>%
    </span>
    <?php endif; ?>
    <!-- Exotic tip badge -->
    <?php if (!empty($producto['es_exotico']) && !empty($producto['tip_cuidado'])): ?>
    <span class="absolute bottom-3 left-3 bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
      <i class="fas fa-lightbulb"></i> Tip Incluido
    </span>
    <?php endif; ?>
  </div>

  <!-- Info -->
  <div class="p-5">
    <h3 class="font-bold text-neutral-900 text-base mb-1 line-clamp-2 group-hover:text-primary transition-colors">
      <?= htmlspecialchars($producto['nombre']) ?>
    </h3>
    <p class="text-neutral-400 text-sm mb-4 line-clamp-2"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></p>

    <?php if (!empty($producto['tip_cuidado'])): ?>
    <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 py-2 mb-4">
      <p class="text-xs text-amber-700 flex items-start gap-1.5">
        <i class="fas fa-lightbulb mt-0.5 flex-shrink-0"></i>
        <span class="line-clamp-2"><?= htmlspecialchars($producto['tip_cuidado']) ?></span>
      </p>
    </div>
    <?php endif; ?>

    <div class="flex items-center justify-between">
      <div>
        <span class="font-display font-black text-2xl text-primary">$<?= number_format($producto['precio'], 2) ?></span>
        <?php if (!empty($producto['precio_anterior'])): ?>
        <span class="text-neutral-400 text-sm line-through ml-2">$<?= number_format($producto['precio_anterior'], 2) ?></span>
        <?php endif; ?>
      </div>
      <button
        onclick="Cart.addItem(<?= htmlspecialchars(json_encode([
          'id'     => $producto['id'],
          'nombre' => $producto['nombre'],
          'precio' => (float)$producto['precio'],
          'imagen' => $producto['imagen_url'] ?? '',
        ])) ?>)"
        class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center hover:bg-primary-dark hover:scale-110 transition-all shadow-md hover:shadow-primary/40">
        <i class="fas fa-plus text-sm"></i>
      </button>
    </div>
  </div>
</div>
