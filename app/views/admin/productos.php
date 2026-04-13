<?php $pageTitle = 'Productos'; require APP_PATH . '/views/admin/partials/header.php'; ?>

<div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
    <h2 class="font-bold text-neutral-900">Catálogo de productos <span class="text-neutral-400 font-normal text-sm">(<?= count($productos) ?>)</span></h2>
    <span class="text-xs text-neutral-400 bg-neutral-100 px-3 py-1.5 rounded-full">Puedes activar/desactivar productos aquí</span>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-neutral-50 border-b border-neutral-100">
        <tr>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">#</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Producto</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Categoría</th>
          <th class="text-right px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Precio</th>
          <th class="text-center px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Stock</th>
          <th class="text-center px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Exótico</th>
          <th class="text-center px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Activo</th>
          <th class="px-5 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-100">
        <?php foreach ($productos as $p): ?>
        <tr id="prod-<?= $p['id'] ?>" class="hover:bg-neutral-50 transition-colors <?= !$p['activo'] ? 'opacity-50' : '' ?>">
          <td class="px-5 py-3 text-neutral-400 font-semibold"><?= $p['id'] ?></td>
          <td class="px-5 py-3">
            <div class="flex items-center gap-3">
              <?php if (!empty($p['imagen_url'])): ?>
              <img src="<?= htmlspecialchars($p['imagen_url']) ?>&w=50&h=50&fit=crop" class="w-10 h-10 rounded-lg object-cover bg-neutral-100" alt="">
              <?php endif; ?>
              <div>
                <p class="font-bold text-neutral-900"><?= htmlspecialchars($p['nombre']) ?></p>
                <p class="text-xs text-neutral-400 max-w-xs truncate"><?= htmlspecialchars($p['descripcion']??'') ?></p>
              </div>
            </div>
          </td>
          <td class="px-5 py-3"><span class="text-xs bg-neutral-100 text-neutral-700 px-2.5 py-1 rounded-full font-semibold"><?= htmlspecialchars($p['categoria']??'—') ?></span></td>
          <td class="px-5 py-3 text-right font-black text-primary">$<?= number_format($p['precio'],2) ?></td>
          <td class="px-5 py-3 text-center">
            <span class="<?= $p['stock'] > 5 ? 'text-green-600' : 'text-red-500' ?> font-bold text-xs"><?= $p['stock'] ?></span>
          </td>
          <td class="px-5 py-3 text-center">
            <?= $p['es_exotico'] ? '<span class="text-lg">🦎</span>' : '<span class="text-neutral-300">—</span>' ?>
          </td>
          <td class="px-5 py-3 text-center">
            <button onclick="toggleProducto(<?= $p['id'] ?>)"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors <?= $p['activo'] ? 'bg-primary' : 'bg-neutral-300' ?>">
              <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform <?= $p['activo'] ? 'translate-x-6' : 'translate-x-1' ?>"></span>
            </button>
          </td>
          <td class="px-5 py-3 text-xs text-neutral-400"><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
async function toggleProducto(id) {
  const res = await fetch('<?= APP_URL ?>/admin/productos/' + id + '/toggle', { method:'POST' });
  const data = await res.json();
  if (data.success) { Toast.show('Producto actualizado', 'success'); setTimeout(()=>location.reload(), 1000); }
}
</script>

<?php require APP_PATH . '/views/admin/partials/footer.php'; ?>
