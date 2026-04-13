<?php $pageTitle = 'Dashboard'; require APP_PATH . '/views/admin/partials/header.php'; ?>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
  <?php $cards = [
    ['fa-shopping-bag','Pedidos hoy',       $stats['pedidos_hoy'],     'bg-orange-50 text-primary',   'Nuevos pedidos del día'],
    ['fa-dollar-sign', 'Ingresos hoy',      '$'.number_format($stats['ingresos_hoy'],2), 'bg-green-50 text-green-600', 'Ventas de hoy'],
    ['fa-calendar',    'Citas hoy',         $stats['citas_hoy'],       'bg-blue-50 text-blue-600',    'Consultas programadas'],
    ['fa-envelope',    'Mensajes nuevos',   $stats['mensajes_nuevos'], 'bg-amber-50 text-amber-600',  'Sin leer'],
  ]; foreach ($cards as [$icon,$title,$val,$color,$sub]): ?>
  <div class="bg-white rounded-2xl p-5 border border-neutral-100 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex items-start justify-between mb-3">
      <div class="w-10 h-10 <?= $color ?> rounded-xl flex items-center justify-center">
        <i class="fas <?= $icon ?> text-sm"></i>
      </div>
    </div>
    <p class="text-2xl font-black text-neutral-900"><?= $val ?></p>
    <p class="text-sm font-bold text-neutral-500 mt-0.5"><?= $title ?></p>
    <p class="text-xs text-neutral-400 mt-1"><?= $sub ?></p>
  </div>
  <?php endforeach; ?>
</div>

<!-- Ingresos mes + citas pendientes -->
<div class="grid lg:grid-cols-2 gap-6 mb-8">
  <div class="bg-white rounded-2xl p-5 border border-neutral-100 shadow-sm">
    <div class="flex items-center justify-between mb-1">
      <p class="font-bold text-neutral-500 text-sm">Ingresos del mes</p>
      <i class="fas fa-chart-line text-primary"></i>
    </div>
    <p class="text-3xl font-black text-neutral-900">$<?= number_format($stats['ingresos_mes'],2) ?></p>
    <p class="text-xs text-neutral-400 mt-1"><?= date('F Y') ?></p>
  </div>
  <div class="bg-white rounded-2xl p-5 border border-neutral-100 shadow-sm">
    <div class="flex items-center justify-between mb-1">
      <p class="font-bold text-neutral-500 text-sm">Citas pendientes</p>
      <i class="fas fa-clock text-amber-500"></i>
    </div>
    <p class="text-3xl font-black text-neutral-900"><?= $stats['citas_pendientes'] ?></p>
    <p class="text-xs text-neutral-400 mt-1">Requieren confirmación</p>
  </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">

  <!-- Últimos pedidos -->
  <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
      <h2 class="font-bold text-neutral-900">Últimos pedidos</h2>
      <a href="<?= APP_URL ?>/admin/pedidos" class="text-xs text-primary font-bold hover:underline">Ver todos</a>
    </div>
    <div class="divide-y divide-neutral-100">
      <?php if (empty($pedidosRecientes)): ?>
      <p class="text-sm text-neutral-400 p-6 text-center">No hay pedidos aún</p>
      <?php else: foreach ($pedidosRecientes as $p):
        $badgeColor = match($p['estado']) {
          'entregado'  => 'bg-green-100 text-green-700',
          'enviado'    => 'bg-blue-100 text-blue-700',
          'cancelado'  => 'bg-red-100 text-red-700',
          'procesando' => 'bg-purple-100 text-purple-700',
          default      => 'bg-amber-100 text-amber-700'
        };
      ?>
      <div class="px-6 py-3 flex items-center gap-3 hover:bg-neutral-50 transition-colors cursor-pointer"
           onclick="location.href='<?= APP_URL ?>/admin/pedidos/<?= $p['id'] ?>'">
        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-xs font-bold flex-shrink-0">
          #<?= $p['id'] ?>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-bold text-neutral-900 truncate"><?= htmlspecialchars($p['nombre_cliente']) ?></p>
          <p class="text-xs text-neutral-400"><?= $p['items'] ?> item(s) · <?= date('d/m H:i', strtotime($p['created_at'])) ?></p>
        </div>
        <div class="text-right flex-shrink-0">
          <p class="text-sm font-black text-primary">$<?= number_format($p['total'],2) ?></p>
          <span class="text-xs px-2 py-0.5 rounded-full font-bold <?= $badgeColor ?>"><?= ucfirst($p['estado']) ?></span>
        </div>
      </div>
      <?php endforeach; endif; ?>
    </div>
  </div>

  <!-- Citas de hoy -->
  <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
      <h2 class="font-bold text-neutral-900">Citas de hoy</h2>
      <a href="<?= APP_URL ?>/admin/citas" class="text-xs text-primary font-bold hover:underline">Ver agenda</a>
    </div>
    <div class="divide-y divide-neutral-100">
      <?php if (empty($citasHoy)): ?>
      <p class="text-sm text-neutral-400 p-6 text-center">Sin citas programadas para hoy</p>
      <?php else: foreach ($citasHoy as $c):
        $bcolor = $c['estado'] === 'confirmada' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700';
        $emoji  = match($c['tipo_mascota']) { 'perro'=>'🐶','gato'=>'🐱','ave'=>'🦜','reptil'=>'🦎','roedor'=>'🐹',default=>'🐾' };
      ?>
      <div class="px-6 py-3 hover:bg-neutral-50 transition-colors">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-lg flex-shrink-0"><?= $emoji ?></div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-neutral-900"><?= htmlspecialchars($c['nombre_mascota']) ?> · <?= htmlspecialchars($c['nombre_dueno']) ?></p>
            <p class="text-xs text-neutral-400 truncate"><?= htmlspecialchars($c['motivo_consulta']) ?></p>
          </div>
          <div class="text-right flex-shrink-0">
            <p class="text-sm font-bold text-neutral-900"><?= substr($c['hora_preferida'],0,5) ?></p>
            <span class="text-xs px-2 py-0.5 rounded-full font-bold <?= $bcolor ?>"><?= ucfirst($c['estado']) ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; endif; ?>
    </div>
  </div>

</div>

<?php require APP_PATH . '/views/admin/partials/footer.php'; ?>
