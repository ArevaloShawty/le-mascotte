<?php $pageTitle = 'Mensajes'; require APP_PATH . '/views/admin/partials/header.php'; ?>

<div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-neutral-100">
    <h2 class="font-bold text-neutral-900">Mensajes de contacto <span class="text-neutral-400 font-normal text-sm">(<?= count($mensajes) ?>)</span></h2>
  </div>

  <?php if (empty($mensajes)): ?>
  <div class="py-16 text-center">
    <i class="fas fa-inbox text-4xl text-neutral-300 mb-3"></i>
    <p class="text-neutral-400">No hay mensajes</p>
  </div>
  <?php else: ?>
  <div class="divide-y divide-neutral-100">
    <?php foreach ($mensajes as $m): ?>
    <div id="msg-<?= $m['id'] ?>" class="p-6 hover:bg-neutral-50 transition-colors <?= !$m['leido'] ? 'border-l-4 border-primary bg-orange-50/20' : '' ?>">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 bg-primary/10 rounded-full flex items-center justify-center font-bold text-primary text-sm">
              <?= strtoupper(substr($m['nombre'],0,1)) ?>
            </div>
            <div>
              <p class="font-bold text-neutral-900 text-sm"><?= htmlspecialchars($m['nombre']) ?></p>
              <p class="text-xs text-neutral-400">
                <a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="hover:text-primary"><?= htmlspecialchars($m['email']) ?></a>
                · <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?>
              </p>
            </div>
            <?php if (!$m['leido']): ?>
            <span class="bg-primary text-white text-xs px-2 py-0.5 rounded-full font-bold">Nuevo</span>
            <?php endif; ?>
          </div>
          <?php if (!empty($m['asunto'])): ?>
          <p class="text-sm font-bold text-neutral-800 mb-1"><?= htmlspecialchars($m['asunto']) ?></p>
          <?php endif; ?>
          <p class="text-sm text-neutral-600 leading-relaxed"><?= nl2br(htmlspecialchars($m['mensaje'])) ?></p>
        </div>
        <div class="flex gap-2 flex-shrink-0">
          <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=Re: <?= htmlspecialchars($m['asunto']??'Tu mensaje') ?>"
             class="text-xs bg-primary/10 text-primary px-3 py-1.5 rounded-lg font-bold hover:bg-primary/20 transition-colors">
            <i class="fas fa-reply mr-1"></i>Responder
          </a>
          <?php if (!$m['leido']): ?>
          <button onclick="marcarLeido(<?= $m['id'] ?>)"
                  class="text-xs bg-neutral-100 text-neutral-600 px-3 py-1.5 rounded-lg font-bold hover:bg-neutral-200 transition-colors">
            <i class="fas fa-check mr-1"></i>Leído
          </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<script>
async function marcarLeido(id) {
  const res = await fetch('<?= APP_URL ?>/admin/mensajes/' + id + '/leido', { method:'POST' });
  const data = await res.json();
  if (data.success) {
    const el = document.getElementById('msg-' + id);
    el?.classList.remove('border-l-4','border-primary','bg-orange-50/20');
    el?.querySelector('.bg-primary.text-white')?.remove();
    Toast.show('Marcado como leído', 'success');
  }
}
</script>

<?php require APP_PATH . '/views/admin/partials/footer.php'; ?>
