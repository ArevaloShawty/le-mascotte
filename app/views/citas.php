<?php $pageTitle = 'Agendar Cita'; require_once APP_PATH . '/views/partials/header.php'; ?>

<!-- Hero -->
<section class="bg-gradient-to-r from-orange-50 to-white py-14 border-b border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-bold mb-4">
        <i class="fas fa-stethoscope"></i> Clínica Veterinaria
      </span>
      <h1 class="font-display font-black text-5xl text-neutral-900 mb-3">Agendar Cita <span class="text-primary">Médica</span></h1>
      <p class="text-neutral-500 text-lg">Cuida la salud de tu mascota con nuestros veterinarios especializados</p>
    </div>
  </div>
</section>

<section class="py-16 bg-neutral-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-3 gap-10">

      <!-- Form -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl shadow-sm p-8 border border-neutral-100">
          <h2 class="font-display font-bold text-2xl text-neutral-900 mb-6">Datos de la Cita</h2>

          <!-- Flash messages -->
          <?php if (!empty($_SESSION['success'])): ?>
          <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle text-green-500"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
          </div>
          <?php unset($_SESSION['success']); endif; ?>
          <?php if (!empty($_SESSION['error'])): ?>
          <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
          </div>
          <?php unset($_SESSION['error']); endif; ?>

          <form id="cita-form" action="<?= APP_URL ?>/citas" method="POST" class="space-y-5">

            <div class="grid sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-2">
                  <i class="fas fa-user text-primary mr-1"></i> Nombre del Dueño *
                </label>
                <input type="text" name="nombre_dueno" placeholder="Tu nombre completo" required
                       class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all">
              </div>
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-2">
                  <i class="fas fa-phone text-primary mr-1"></i> Teléfono *
                </label>
                <input type="tel" name="telefono" placeholder="+503 0000-0000" required
                       class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all">
              </div>
            </div>

            <div>
              <label class="block text-sm font-bold text-neutral-700 mb-2">
                <i class="fas fa-envelope text-primary mr-1"></i> Email (opcional)
              </label>
              <input type="email" name="email" placeholder="tu@email.com"
                     class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all">
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-2">
                  <i class="fas fa-paw text-primary mr-1"></i> Nombre de la Mascota *
                </label>
                <input type="text" name="nombre_mascota" placeholder="Nombre de tu mascota" required
                       class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all">
              </div>
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-2">
                  <i class="fas fa-dragon text-primary mr-1"></i> Tipo de Mascota *
                </label>
                <select name="tipo_mascota" required
                        class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all bg-white">
                  <option value="">Selecciona...</option>
                  <option value="perro">🐶 Perro</option>
                  <option value="gato">🐱 Gato</option>
                  <option value="ave">🦜 Ave</option>
                  <option value="reptil">🦎 Reptil</option>
                  <option value="roedor">🐹 Roedor</option>
                  <option value="otro">🐾 Otro</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-bold text-neutral-700 mb-2">
                <i class="fas fa-notes-medical text-primary mr-1"></i> Motivo de Consulta *
              </label>
              <textarea name="motivo_consulta" rows="3" required
                        placeholder="Describe brevemente el motivo de la consulta..."
                        class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all resize-none"></textarea>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-2">
                  <i class="fas fa-calendar text-primary mr-1"></i> Fecha Preferida *
                </label>
                <input type="date" name="fecha_preferida" id="fecha-cita" required
                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                       class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all">
              </div>
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-2">
                  <i class="fas fa-clock text-primary mr-1"></i> Hora Preferida *
                </label>
                <select name="hora_preferida" id="hora-cita" required
                        class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all bg-white">
                  <option value="">Selecciona una fecha primero</option>
                </select>
              </div>
            </div>

            <button type="submit"
                    class="w-full bg-primary text-white py-4 rounded-2xl font-bold text-base hover:bg-primary-dark hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
              <i class="fas fa-calendar-check"></i>
              <span id="btn-cita-text">Confirmar Cita</span>
            </button>
          </form>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Hours -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-neutral-100">
          <h3 class="font-bold text-lg text-neutral-900 mb-4 flex items-center gap-2">
            <i class="fas fa-clock text-primary"></i> Horarios de Atención
          </h3>
          <div class="space-y-3">
            <?php foreach ([
              ['Lunes - Viernes','9:00 - 20:00'],
              ['Sábado','10:00 - 18:00'],
              ['Domingo','10:00 - 14:00'],
            ] as [$dia,$hora]): ?>
            <div class="flex justify-between items-center py-2 border-b border-neutral-100 last:border-0">
              <span class="text-sm text-neutral-600"><?= $dia ?></span>
              <span class="text-sm font-bold text-neutral-900"><?= $hora ?></span>
            </div>
            <?php endforeach; ?>
            <div class="flex items-center gap-2 pt-2">
              <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
              <span class="text-sm font-bold text-green-600">Emergencias 24/7</span>
            </div>
          </div>
        </div>

        <!-- Services -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-neutral-100">
          <h3 class="font-bold text-lg text-neutral-900 mb-4">Nuestros Servicios</h3>
          <ul class="space-y-2">
            <?php foreach ([
              'Consulta general','Vacunación',
              'Cirugía','Diagnóstico por imagen',
              'Odontología veterinaria','Exóticos especialistas',
              'Emergencias','Hospitalización',
            ] as $srv): ?>
            <li class="flex items-center gap-2 text-sm text-neutral-600">
              <i class="fas fa-check-circle text-primary text-xs"></i> <?= $srv ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Contact -->
        <div class="bg-primary rounded-3xl p-6 text-white">
          <i class="fas fa-phone-alt text-3xl mb-3 opacity-80"></i>
          <h3 class="font-bold text-lg mb-1">Emergencias 24/7</h3>
          <p class="text-orange-100 text-sm mb-3">¿Tu mascota necesita atención urgente?</p>
          <a href="tel:+50322000000" class="inline-flex items-center gap-2 bg-white text-primary px-4 py-2 rounded-xl font-bold text-sm hover:shadow-lg transition-all">
            <i class="fas fa-phone"></i> +503 2200-0000
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// Horarios disponibles y lógica de citas
const horariosDisponibles = ['09:00','09:30','10:00','10:30','11:00','11:30',
  '12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];

document.getElementById('fecha-cita')?.addEventListener('change', async function() {
  const fecha = this.value;
  const selectHora = document.getElementById('hora-cita');
  selectHora.innerHTML = '<option value="">Cargando horarios...</option>';

  try {
    const res = await fetch(`<?= APP_URL ?>/citas/horarios?fecha=${fecha}`);
    const data = await res.json();
    const ocupados = data.horarios || [];

    selectHora.innerHTML = '<option value="">Selecciona una hora</option>';
    horariosDisponibles.forEach(hora => {
      if (!ocupados.includes(hora)) {
        const opt = document.createElement('option');
        opt.value = hora;
        opt.textContent = hora;
        selectHora.appendChild(opt);
      }
    });
    if (selectHora.options.length === 1) {
      selectHora.innerHTML = '<option value="">No hay horarios disponibles</option>';
    }
  } catch {
    selectHora.innerHTML = '<option value="">Error al cargar horarios</option>';
  }
});

// AJAX form submit
document.getElementById('cita-form')?.addEventListener('submit', async function(e) {
  e.preventDefault();
  const btn = document.getElementById('btn-cita-text');
  btn.textContent = 'Procesando...';

  const formData = new FormData(this);
  try {
    const res = await fetch('<?= APP_URL ?>/citas', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    });
    const data = await res.json();
    if (data.success) {
      Toast.show(data.message, 'success');
      this.reset();
      document.getElementById('hora-cita').innerHTML = '<option value="">Selecciona una fecha primero</option>';
    } else {
      Toast.show(data.message, 'error');
    }
  } catch {
    Toast.show('Error al enviar. Intenta de nuevo.', 'error');
  } finally {
    btn.textContent = 'Confirmar Cita';
  }
});
</script>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
