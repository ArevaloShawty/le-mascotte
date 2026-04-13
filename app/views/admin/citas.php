<?php $pageTitle = 'Citas'; require APP_PATH . '/views/admin/partials/header.php'; ?>

<!-- Filters -->
<div class="bg-white rounded-2xl border border-neutral-100 shadow-sm p-5 mb-6">
  <form method="GET" class="flex flex-wrap gap-3">
    <input type="text" name="buscar" value="<?= htmlspecialchars($_GET['buscar']??'') ?>"
           placeholder="Buscar por dueño, mascota o teléfono..."
           class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
    <input type="date" name="fecha" value="<?= htmlspecialchars($_GET['fecha']??'') ?>"
           class="px-4 py-2.5 rounded-xl border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 bg-white">
    <select name="estado" class="px-4 py-2.5 rounded-xl border border-neutral-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/30">
      <option value="">Todos los estados</option>
      <?php foreach (['solicitada','confirmada','completada','cancelada'] as $e): ?>
      <option value="<?= $e ?>" <?= ($_GET['estado']??'')===$e?'selected':'' ?>><?= ucfirst($e) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-dark transition-colors">Filtrar</button>
    <a href="<?= APP_URL ?>/admin/citas" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-neutral-100 text-neutral-600 hover:bg-neutral-200 transition-colors">Limpiar</a>
    <a href="<?= APP_URL ?>/admin/citas?fecha=<?= date('Y-m-d') ?>"
       class="px-5 py-2.5 rounded-xl text-sm font-bold bg-orange-50 text-primary hover:bg-orange-100 transition-colors">
      <i class="fas fa-calendar-day mr-1"></i>Hoy
    </a>
  </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
  <div class="px-6 py-4 border-b border-neutral-100">
    <h2 class="font-bold text-neutral-900">Citas programadas <span class="text-neutral-400 font-normal text-sm">(<?= count($citas) ?>)</span></h2>
  </div>

  <?php if (empty($citas)): ?>
  <div class="py-16 text-center">
    <i class="fas fa-calendar-times text-4xl text-neutral-300 mb-3"></i>
    <p class="text-neutral-400">No se encontraron citas</p>
  </div>
  <?php else: ?>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-neutral-50 border-b border-neutral-100">
        <tr>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Mascota</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Dueño / Contacto</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Motivo</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Fecha y hora</th>
          <th class="text-left px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Estado</th>
          <th class="px-5 py-3 text-xs font-bold text-neutral-500 uppercase">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-100">
        <?php foreach ($citas as $c):
          $emoji = match($c['tipo_mascota']) { 'perro'=>'🐶','gato'=>'🐱','ave'=>'🦜','reptil'=>'🦎','roedor'=>'🐹',default=>'🐾' };
          $badgeColor = match($c['estado']) {
            'confirmada' => 'bg-green-100 text-green-700',
            'completada' => 'bg-blue-100 text-blue-700',
            'cancelada'  => 'bg-red-100 text-red-700',
            default      => 'bg-amber-100 text-amber-700'
          };
          $esHoy = ($c['fecha_preferida'] === date('Y-m-d'));
        ?>
        <tr class="hover:bg-neutral-50 transition-colors <?= $esHoy ? 'bg-orange-50/30' : '' ?>">
          <td class="px-5 py-3.5">
            <div class="flex items-center gap-2">
              <span class="text-xl"><?= $emoji ?></span>
              <div>
                <p class="font-bold text-neutral-900"><?= htmlspecialchars($c['nombre_mascota']) ?></p>
                <p class="text-xs text-neutral-400"><?= ucfirst($c['tipo_mascota']) ?></p>
              </div>
            </div>
          </td>
          <td class="px-5 py-3.5">
            <p class="font-bold text-neutral-900"><?= htmlspecialchars($c['nombre_dueno']) ?></p>
            <p class="text-xs text-neutral-400"><i class="fas fa-phone text-xs mr-1"></i>
              <a href="tel:<?= $c['telefono'] ?>" class="hover:text-primary"><?= htmlspecialchars($c['telefono']) ?></a>
            </p>
            <?php if (!empty($c['email'])): ?>
            <p class="text-xs text-neutral-400"><i class="fas fa-envelope text-xs mr-1"></i>
              <a href="mailto:<?= $c['email'] ?>" class="hover:text-primary"><?= htmlspecialchars($c['email']) ?></a>
            </p>
            <?php endif; ?>
          </td>
          <td class="px-5 py-3.5 max-w-xs">
            <p class="text-xs text-neutral-600 line-clamp-2"><?= htmlspecialchars($c['motivo_consulta']) ?></p>
          </td>
          <td class="px-5 py-3.5">
            <p class="font-bold text-neutral-900"><?= date('d/m/Y', strtotime($c['fecha_preferida'])) ?></p>
            <p class="text-xs text-primary font-bold"><?= substr($c['hora_preferida'],0,5) ?></p>
            <?php if ($esHoy): ?><span class="text-xs bg-primary/10 text-primary px-1.5 py-0.5 rounded font-bold">Hoy</span><?php endif; ?>
          </td>
          <td class="px-5 py-3.5">
            <span class="text-xs px-2.5 py-1 rounded-full font-bold <?= $badgeColor ?>"><?= ucfirst($c['estado']) ?></span>
          </td>
          <td class="px-5 py-3.5">
            <div class="flex gap-1.5 flex-wrap">
              <?php if ($c['estado'] === 'solicitada'): ?>
              <button onclick="cambiarCita(<?= $c['id'] ?>,'confirmada','')"
                      class="text-xs bg-green-100 text-green-700 px-2.5 py-1.5 rounded-lg font-bold hover:bg-green-200 transition-colors">
                <i class="fas fa-check mr-1"></i>Confirmar
              </button>
              <?php endif; ?>
              <?php if (in_array($c['estado'],['solicitada','confirmada'])): ?>
              <button onclick="cambiarCita(<?= $c['id'] ?>,'completada','')"
                      class="text-xs bg-blue-100 text-blue-700 px-2.5 py-1.5 rounded-lg font-bold hover:bg-blue-200 transition-colors">
                <i class="fas fa-check-double mr-1"></i>Completar
              </button>
              <button onclick="cambiarCita(<?= $c['id'] ?>,'cancelada','')"
                      class="text-xs bg-red-100 text-red-700 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 transition-colors">
                <i class="fas fa-times mr-1"></i>Cancelar
              </button>
              <?php endif; ?>
              <?php if (!empty($c['email'])): ?>
              <a href="mailto:<?= htmlspecialchars($c['email']) ?>?subject=Tu cita en Le Mascotte"
                 class="text-xs bg-neutral-100 text-neutral-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-neutral-200 transition-colors">
                <i class="fas fa-envelope"></i>
              </a>
              <?php endif; ?>
              <a href="tel:<?= htmlspecialchars($c['telefono']) ?>"
                 class="text-xs bg-neutral-100 text-neutral-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-neutral-200 transition-colors">
                <i class="fas fa-phone"></i>
              </a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<script>
async function cambiarCita(id, estado, notas) {
  const msg = estado === 'confirmada'
    ? `¿Confirmar esta cita? Se enviará un correo al cliente si tiene email registrado.`
    : `¿Cambiar estado a "${estado}"?`;
  if (!confirm(msg)) return;
  const fd = new FormData();
  fd.append('estado', estado);
  fd.append('notas', notas);
  try {
    const res = await fetch('<?= APP_URL ?>/admin/citas/' + id + '/estado', { method:'POST', body:fd });
    const data = await res.json();
    Toast.show(data.message, data.success ? 'success' : 'error');
    if (data.success) setTimeout(()=>location.reload(), 1500);
  } catch { Toast.show('Error al actualizar', 'error'); }
}
</script>

<?php require APP_PATH . '/views/admin/partials/footer.php'; ?>
