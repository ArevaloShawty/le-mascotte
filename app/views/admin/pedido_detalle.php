<?php $pageTitle = 'Pedido #' . str_pad($pedido['id'],4,'0',STR_PAD_LEFT); require APP_PATH . '/views/admin/partials/header.php'; ?>

<div class="mb-5">
  <a href="<?= APP_URL ?>/admin/pedidos" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-primary transition-colors font-semibold">
    <i class="fas fa-arrow-left"></i> Volver a pedidos
  </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

  <!-- Left: Items + totals -->
  <div class="lg:col-span-2 space-y-5">

    <!-- Products table -->
    <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-neutral-100">
        <h2 class="font-bold text-neutral-900">Productos del pedido</h2>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-neutral-50">
          <tr>
            <th class="text-left px-6 py-3 text-xs font-bold text-neutral-500 uppercase">Producto</th>
            <th class="text-center px-4 py-3 text-xs font-bold text-neutral-500 uppercase">Cant.</th>
            <th class="text-right px-4 py-3 text-xs font-bold text-neutral-500 uppercase">Precio unit.</th>
            <th class="text-right px-6 py-3 text-xs font-bold text-neutral-500 uppercase">Subtotal</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          <?php foreach ($pedido['items'] as $item): ?>
          <tr class="hover:bg-neutral-50">
            <td class="px-6 py-3.5 font-semibold text-neutral-900"><?= htmlspecialchars($item['nombre_producto']) ?></td>
            <td class="px-4 py-3.5 text-center"><span class="bg-neutral-100 text-neutral-700 font-bold px-2 py-0.5 rounded-lg"><?= $item['cantidad'] ?></span></td>
            <td class="px-4 py-3.5 text-right text-neutral-600">$<?= number_format($item['precio_unitario'],2) ?></td>
            <td class="px-6 py-3.5 text-right font-bold text-neutral-900">$<?= number_format($item['precio_unitario']*$item['cantidad'],2) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot class="bg-neutral-50 border-t border-neutral-100">
          <tr><td colspan="3" class="px-6 py-2 text-right text-xs text-neutral-500 font-bold">Subtotal</td>
              <td class="px-6 py-2 text-right font-bold">$<?= number_format($pedido['subtotal'],2) ?></td></tr>
          <tr><td colspan="3" class="px-6 py-2 text-right text-xs text-neutral-500 font-bold">IVA (13%)</td>
              <td class="px-6 py-2 text-right font-bold">$<?= number_format($pedido['impuesto'],2) ?></td></tr>
          <tr><td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-neutral-900">TOTAL</td>
              <td class="px-6 py-3 text-right text-xl font-black text-primary">$<?= number_format($pedido['total'],2) ?></td></tr>
        </tfoot>
      </table>
    </div>

    <!-- Delivery address (destacada) -->
    <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6">
      <h3 class="font-bold text-orange-900 mb-3 flex items-center gap-2">
        <i class="fas fa-map-marker-alt text-primary"></i> Dirección de entrega
      </h3>
      <p class="text-orange-800 font-semibold text-base leading-relaxed">
        <?= htmlspecialchars($pedido['direccion_entrega']) ?>
      </p>
      <div class="mt-3 pt-3 border-t border-orange-200 flex flex-wrap gap-4 text-sm">
        <span class="flex items-center gap-1.5 text-orange-700">
          <i class="fas fa-user text-primary"></i>
          <strong><?= htmlspecialchars($pedido['nombre_cliente']) ?></strong>
        </span>
        <span class="flex items-center gap-1.5 text-orange-700">
          <i class="fas fa-phone text-primary"></i>
          <a href="tel:<?= $pedido['telefono'] ?>" class="font-bold hover:underline"><?= htmlspecialchars($pedido['telefono']??'') ?></a>
        </span>
        <span class="flex items-center gap-1.5 text-orange-700">
          <i class="fas fa-envelope text-primary"></i>
          <a href="mailto:<?= $pedido['email_cliente'] ?>" class="font-bold hover:underline"><?= htmlspecialchars($pedido['email_cliente']) ?></a>
        </span>
      </div>
    </div>

    <?php if (!empty($pedido['notas'])): ?>
    <div class="bg-white rounded-2xl border border-neutral-100 p-5">
      <h3 class="font-bold text-neutral-900 mb-2"><i class="fas fa-sticky-note text-amber-400 mr-2"></i>Notas del cliente</h3>
      <p class="text-sm text-neutral-600"><?= htmlspecialchars($pedido['notas']) ?></p>
    </div>
    <?php endif; ?>
  </div>

  <!-- Right: Status + actions -->
  <div class="space-y-5">

    <!-- Order info -->
    <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm p-5">
      <h3 class="font-bold text-neutral-900 mb-4">Información del pedido</h3>
      <?php
      $badgeColor = match($pedido['estado']) {
        'entregado'  => 'bg-green-100 text-green-700',
        'enviado'    => 'bg-blue-100 text-blue-700',
        'cancelado'  => 'bg-red-100 text-red-700',
        'procesando' => 'bg-purple-100 text-purple-700',
        'confirmado' => 'bg-teal-100 text-teal-700',
        default      => 'bg-amber-100 text-amber-700'
      };
      ?>
      <div class="space-y-3 text-sm">
        <div class="flex justify-between items-center py-2 border-b border-neutral-100">
          <span class="text-neutral-500">Número</span>
          <span class="font-bold text-primary">#<?= str_pad($pedido['id'],4,'0',STR_PAD_LEFT) ?></span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-neutral-100">
          <span class="text-neutral-500">Fecha</span>
          <span class="font-bold"><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></span>
        </div>
        <div class="flex justify-between items-center py-2">
          <span class="text-neutral-500">Estado actual</span>
          <span class="text-xs px-2.5 py-1 rounded-full font-bold <?= $badgeColor ?>"><?= ucfirst($pedido['estado']) ?></span>
        </div>
      </div>
    </div>

    <!-- Change status -->
    <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm p-5">
      <h3 class="font-bold text-neutral-900 mb-4">Actualizar estado</h3>
      <p class="text-xs text-neutral-400 mb-3">Al cambiar el estado, se enviará un correo automático al cliente.</p>
      <select id="nuevo-estado" class="w-full px-4 py-2.5 rounded-xl border border-neutral-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 mb-3">
        <?php foreach (['pendiente','confirmado','procesando','enviado','entregado','cancelado'] as $e): ?>
        <option value="<?= $e ?>" <?= $pedido['estado']===$e?'selected':'' ?>><?= ucfirst($e) ?></option>
        <?php endforeach; ?>
      </select>
      <button onclick="actualizarEstado(<?= $pedido['id'] ?>)"
              class="w-full bg-primary text-white py-3 rounded-xl font-bold text-sm hover:bg-primary-dark transition-colors">
        <i class="fas fa-save mr-2"></i>Guardar y notificar cliente
      </button>
    </div>

    <!-- Email actions -->
    <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm p-5">
      <h3 class="font-bold text-neutral-900 mb-4">Acciones de correo</h3>
      <div class="space-y-2">
        <a href="mailto:<?= htmlspecialchars($pedido['email_cliente']) ?>?subject=Tu pedido #<?= str_pad($pedido['id'],4,'0',STR_PAD_LEFT) ?> — Le Mascotte"
           class="w-full flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-100 transition-colors">
          <i class="fas fa-envelope"></i> Escribir al cliente
        </a>
        <a href="tel:<?= htmlspecialchars($pedido['telefono']??'') ?>"
           class="w-full flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-green-100 transition-colors">
          <i class="fas fa-phone"></i> Llamar al cliente
        </a>
        <button onclick="window.print()"
                class="w-full flex items-center gap-2 bg-neutral-100 text-neutral-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-neutral-200 transition-colors">
          <i class="fas fa-print"></i> Imprimir pedido
        </button>
      </div>
    </div>

  </div>
</div>

<script>
async function actualizarEstado(id) {
  const estado = document.getElementById('nuevo-estado').value;
  if (!confirm(`¿Cambiar estado a "${estado}" y notificar al cliente?`)) return;
  try {
    const fd = new FormData();
    fd.append('estado', estado);
    const res = await fetch('<?= APP_URL ?>/admin/pedidos/' + id + '/estado', { method:'POST', body:fd });
    const data = await res.json();
    Toast.show(data.message, data.success ? 'success' : 'error');
    if (data.success) setTimeout(()=>location.reload(), 1500);
  } catch { Toast.show('Error al actualizar', 'error'); }
}
</script>

<?php require APP_PATH . '/views/admin/partials/footer.php'; ?>
