<?php $pageTitle = 'Contacto'; require_once APP_PATH . '/views/partials/header.php'; ?>

<section class="py-14 bg-gradient-to-r from-orange-50 to-white border-b border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <h1 class="font-display font-black text-5xl text-neutral-900 mb-3">
      <span class="text-primary">Contáctanos</span>
    </h1>
    <p class="text-neutral-500 text-lg">Estamos aquí para ayudarte y responder todas tus preguntas</p>
  </div>
</section>

<section class="py-16 bg-neutral-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12">

      <!-- Contact Form -->
      <div class="bg-white rounded-3xl p-8 shadow-sm border border-neutral-100">
        <h2 class="font-display font-bold text-2xl text-neutral-900 mb-6">Envíanos un Mensaje</h2>
        <form id="contacto-form" class="space-y-5">
          <div class="grid sm:grid-cols-2 gap-5">
            <div>
              <label class="block text-sm font-bold text-neutral-700 mb-1.5">Nombre *</label>
              <input type="text" name="nombre" required placeholder="Tu nombre"
                     class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
            </div>
            <div>
              <label class="block text-sm font-bold text-neutral-700 mb-1.5">Email *</label>
              <input type="email" name="email" required placeholder="tu@email.com"
                     class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
            </div>
          </div>
          <div>
            <label class="block text-sm font-bold text-neutral-700 mb-1.5">Asunto</label>
            <input type="text" name="asunto" placeholder="¿En qué te podemos ayudar?"
                   class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
          </div>
          <div>
            <label class="block text-sm font-bold text-neutral-700 mb-1.5">Mensaje *</label>
            <textarea name="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí..."
                      class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm resize-none"></textarea>
          </div>
          <button type="submit"
                  class="w-full bg-primary text-white py-4 rounded-2xl font-bold hover:bg-primary-dark hover:shadow-xl transition-all">
            <i class="fas fa-paper-plane mr-2"></i> Enviar Mensaje
          </button>
        </form>
      </div>

      <!-- Info + Map -->
      <div class="space-y-6">
        <!-- Info Cards -->
        <div class="grid grid-cols-2 gap-4">
          <?php $infos = [
            ['fa-map-marker-alt','Ubicación','San Salvador, El Salvador'],
            ['fa-phone','Teléfono','+503 2200-0000'],
            ['fa-envelope','Email','info@lemascotte.com'],
            ['fa-clock','Horario','Lun-Vie 9:00-20:00'],
          ]; foreach ($infos as [$icon,$title,$val]): ?>
          <div class="bg-white rounded-2xl p-4 shadow-sm border border-neutral-100">
            <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-3">
              <i class="fas <?= $icon ?> text-sm"></i>
            </div>
            <p class="text-xs font-bold text-neutral-400 uppercase tracking-wider"><?= $title ?></p>
            <p class="text-sm font-bold text-neutral-900 mt-0.5"><?= $val ?></p>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Map Placeholder -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-neutral-100 h-64 relative">
          <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-neutral-100 flex flex-col items-center justify-center">
            <i class="fas fa-map-marker-alt text-5xl text-primary mb-3"></i>
            <p class="font-bold text-neutral-900">Le Mascotte</p>
            <p class="text-sm text-neutral-500">San Salvador, El Salvador</p>
            <a href="https://maps.google.com" target="_blank"
               class="mt-4 inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-dark transition-colors">
              <i class="fas fa-directions"></i> Ver en Maps
            </a>
          </div>
        </div>

        <!-- Emergency CTA -->
        <div class="bg-neutral-900 rounded-3xl p-6 text-white flex items-center gap-4">
          <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-ambulance"></i>
          </div>
          <div>
            <p class="font-bold">Emergencias Veterinarias 24/7</p>
            <p class="text-neutral-400 text-sm mb-2">No esperes si tu mascota necesita ayuda urgente</p>
            <a href="tel:+50322000000" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold">
              <i class="fas fa-phone"></i> Llamar ahora
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.getElementById('contacto-form')?.addEventListener('submit', async function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  try {
    const res = await fetch('<?= APP_URL ?>/contacto', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: fd
    });
    const data = await res.json();
    if (data.success) {
      Toast.show(data.message, 'success');
      this.reset();
    } else {
      Toast.show(data.message, 'error');
    }
  } catch { Toast.show('Error al enviar. Intenta de nuevo.', 'error'); }
});
</script>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
