<?php $pageTitle = 'Pedido Confirmado'; require_once APP_PATH . '/views/partials/header.php'; ?>

<section class="py-20 bg-neutral-50 min-h-screen">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl shadow-sm border border-neutral-100 overflow-hidden">
      <!-- Header success -->
      <div class="bg-gradient-to-r from-green-400 to-green-500 px-8 py-10 text-center text-white">
        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">✅</div>
        <h1 class="font-display font-black text-3xl mb-2">¡Pedido Confirmado!</h1>
        <p class="text-green-100">Hemos recibido tu pedido. Te contactaremos pronto.</p>
      </div>

      <div class="p-8">
        <div class="flex items-center justify-between mb-6">
          <div>
            <p class="text-xs text-neutral-400 font-semibold uppercase tracking-wider">Número de pedido</p>
            <p class="font-display font-black text-2xl text-primary">#<?= str_pad($pedido['id'],4,'0',STR_PAD_LEFT) ?></p>
          </div>
          <div class="text-right">
            <p class="text-xs text-neutral-400 font-semibold uppercase tracking-wider">Fecha</p>
            <p class="font-bold text-neutral-900"><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></p>
          </div>
        </div>

        <!-- Delivery address highlight -->
        <div class="bg-orange-50 border border-orange-200 rounded-2xl p-5 mb-6">
          <p class="text-xs font-bold text-orange-600 uppercase tracking-wider mb-2">
            <i class="fas fa-map-marker-alt mr-1"></i>Dirección de entrega
          </p>
          <p class="font-bold text-neutral-900"><?= htmlspecialchars($pedido['nombre_cliente']) ?></p>
          <p class="text-neutral-600 text-sm mt-1"><?= htmlspecialchars($pedido['direccion_entrega']) ?></p>
          <p class="text-sm text-neutral-500 mt-1">
            <i class="fas fa-phone text-primary mr-1"></i><?= htmlspecialchars($pedido['telefono']) ?>
          </p>
        </div>

        <!-- Items -->
        <h3 class="font-bold text-neutral-900 mb-3">Productos</h3>
        <div class="space-y-2 mb-5">
          <?php foreach ($pedido['items'] as $item): ?>
          <div class="flex justify-between items-center py-2 border-b border-neutral-100 text-sm last:border-0">
            <span class="text-neutral-700"><?= htmlspecialchars($item['nombre_producto']) ?> <span class="text-neutral-400">×<?= $item['cantidad'] ?></span></span>
            <span class="font-bold text-neutral-900">$<?= number_format($item['precio_unitario']*$item['cantidad'],2) ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Totals -->
        <div class="bg-neutral-50 rounded-2xl p-4 text-sm space-y-1.5">
          <div class="flex justify-between"><span class="text-neutral-500">Subtotal</span><span class="font-bold">$<?= number_format($pedido['subtotal'],2) ?></span></div>
          <div class="flex justify-between"><span class="text-neutral-500">IVA (13%)</span><span class="font-bold">$<?= number_format($pedido['impuesto'],2) ?></span></div>
          <div class="flex justify-between text-base pt-2 border-t border-neutral-200 mt-2">
            <span class="font-bold text-neutral-900">Total</span>
            <span class="font-black text-primary text-xl">$<?= number_format($pedido['total'],2) ?></span>
          </div>
        </div>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4 flex gap-3">
          <i class="fas fa-envelope text-blue-500 mt-0.5 flex-shrink-0"></i>
          <p class="text-sm text-blue-800">Hemos enviado una confirmación a <strong><?= htmlspecialchars($pedido['email_cliente']) ?></strong>. Si no lo ves, revisa tu carpeta de spam.</p>
        </div>

        <div class="flex gap-3 mt-6">
          <a href="<?= APP_URL ?>/productos" class="flex-1 text-center bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary-dark transition-colors">
            <i class="fas fa-store mr-2"></i>Seguir comprando
          </a>
          <a href="<?= APP_URL ?>/citas" class="flex-1 text-center bg-neutral-100 text-neutral-700 py-3 rounded-xl font-bold hover:bg-neutral-200 transition-colors">
            <i class="fas fa-calendar-check mr-2"></i>Agendar Cita
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
