<?php $pageTitle = 'Pedidos'; require APP_PATH . '/views/admin/partials/header.php'; ?>

<!-- Filters -->
<div class="bg-white rounded-2xl border border-neutral-100 shadow-sm p-5 mb-6">
  <form method="GET" class="flex flex-wrap gap-3">
    <input type="text" name="buscar" value="<?= htmlspecialchars($_GET['buscar']??'') ?>"
           placeholder="Buscar por nombre, email o #pedido..."
           class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
    <select name="estado" class="px-4 py-2.5 rounded-xl border border-neutral-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30">
      <option value="">Todos los estados</option>
      <?php foreach (['pendiente','confirmado','procesando','enviado','entregado','cancelado'] as $e): ?>
      <option value="<?= $e ?>" <?= ($_GET['estado']??'')===$e?'selected':'' ?>><?= ucfirst($e) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-dark transition-colors">Filtrar</button>
    <a href="<?= APP_URL ?>/admin/pedidos" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-neutral-100 text-neutral-600 hover:bg-neutral-200 transition-colors">Limpiar</a>
  </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
    <h2 class="font-bold text-neutral-900">Todos los pedidos <span class="text-neutral-400 font-normal text-sm">(<?= count($pedidos) ?>)</span></h2>
  </div>

  <?php if (empty($pedidos)): ?>
  <div class="py-16 text-center">
    <i class="fas fa-box-open text-4xl text-neutral-300 mb-3"></i>
    <p class="text-neutral-400">No se encontraron pedidos</p>
  </div>
  <?php else: ?>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-neutral-50 border-b border-neutral-100">
        <tr>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">#</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">Cliente</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">Dirección</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">Items</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">Total</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">Estado</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase tracking-wider">Fecha</th>
          <th class="px-5 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-100">
        <?php foreach ($pedidos as $p):
          $badgeColor = match($p['estado']) {
            'entregado'  => 'bg-green-100 text-green-700',
            'enviado'    => 'bg-blue-100 text-blue-700',
            'cancelado'  => 'bg-red-100 text-red-700',
            'procesando' => 'bg-purple-100 text-purple-700',
            'confirmado' => 'bg-teal-100 text-teal-700',
            default      => 'bg-amber-100 text-amber-700'
          };
        ?>
        <tr class="hover:bg-neutral-50 transition-colors">
          <td class="px-5 py-3.5 font-bold text-primary">#<?= str_pad($p['id'],4,'0',STR_PAD_LEFT) ?></td>
          <td class="px-5 py-3.5">
            <p class="font-bold text-neutral-900"><?= htmlspecialchars($p['nombre_cliente']) ?></p>
            <p class="text-xs text-neutral-400"><?= htmlspecialchars($p['email_cliente']) ?></p>
            <p class="text-xs text-neutral-400"><i class="fas fa-phone text-xs mr-1"></i><?= htmlspecialchars($p['telefono']??'') ?></p>
          </td>
          <td class="px-5 py-3.5 max-w-xs">
            <p class="text-xs text-neutral-600 line-clamp-2"><?= htmlspecialchars($p['direccion_entrega']??'') ?></p>
          </td>
          <td class="px-5 py-3.5 text-center">
            <span class="bg-neutral-100 text-neutral-700 text-xs font-bold px-2 py-1 rounded-full"><?= $p['items'] ?></span>
          </td>
          <td class="px-5 py-3.5 font-black text-primary">$<?= number_format($p['total'],2) ?></td>
          <td class="px-5 py-3.5">
            <span class="text-xs px-2.5 py-1 rounded-full font-bold <?= $badgeColor ?>"><?= ucfirst($p['estado']) ?></span>
          </td>
          <td class="px-5 py-3.5 text-xs text-neutral-400"><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
          <td class="px-5 py-3.5">
            <a href="<?= APP_URL ?>/admin/pedidos/<?= $p['id'] ?>"
               class="text-xs bg-primary/10 text-primary font-bold px-3 py-1.5 rounded-lg hover:bg-primary/20 transition-colors">
              Ver detalle
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require APP_PATH . '/views/admin/partials/footer.php'; ?>
