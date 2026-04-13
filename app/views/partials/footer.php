</main>

<!-- FOOTER -->
<footer class="bg-neutral-900 text-neutral-300 pt-16 pb-8 mt-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

      <!-- Brand -->
      <div class="lg:col-span-1">
        <div class="flex items-center gap-2 mb-4">
          <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white text-xl">🐾</div>
          <div>
            <p class="font-display font-bold text-xl text-white">Le Mascotte</p>
            <p class="text-xs text-primary">Clínica & Tienda</p>
          </div>
        </div>
        <p class="text-sm leading-relaxed text-neutral-400">Cuidamos a los que más quieres, sean de pelo, pluma o escama. Tu confianza es nuestra mayor recompensa.</p>
        <div class="flex gap-3 mt-5">
          <a href="#" class="w-9 h-9 bg-neutral-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
            <i class="fab fa-facebook-f text-sm"></i>
          </a>
          <a href="#" class="w-9 h-9 bg-neutral-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
            <i class="fab fa-instagram text-sm"></i>
          </a>
          <a href="#" class="w-9 h-9 bg-neutral-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
            <i class="fab fa-whatsapp text-sm"></i>
          </a>
          <a href="#" class="w-9 h-9 bg-neutral-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
            <i class="fab fa-tiktok text-sm"></i>
          </a>
        </div>
      </div>

      <!-- Links -->
      <div>
        <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Navegación</h3>
        <ul class="space-y-2">
          <?php foreach ([
            ['inicio','Inicio'],['productos','Tienda'],
            ['exoticos','Mascotas Exóticas'],['citas','Agendar Cita'],['contacto','Contacto']
          ] as [$url, $label]): ?>
          <li><a href="<?= APP_URL ?>/<?= $url ?>" class="text-sm text-neutral-400 hover:text-primary transition-colors flex items-center gap-2">
            <i class="fas fa-chevron-right text-xs text-primary/50"></i> <?= $label ?>
          </a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Hours -->
      <div>
        <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Horarios</h3>
        <ul class="space-y-2 text-sm text-neutral-400">
          <li class="flex justify-between"><span>Lunes - Viernes</span><span class="text-white">9:00 - 20:00</span></li>
          <li class="flex justify-between"><span>Sábado</span><span class="text-white">10:00 - 18:00</span></li>
          <li class="flex justify-between"><span>Domingo</span><span class="text-white">10:00 - 14:00</span></li>
          <li class="mt-3 pt-3 border-t border-neutral-800">
            <span class="inline-flex items-center gap-2 text-primary font-semibold">
              <i class="fas fa-circle-dot animate-pulse"></i>
              Emergencias 24/7
            </span>
          </li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Contacto</h3>
        <ul class="space-y-3 text-sm text-neutral-400">
          <li class="flex items-start gap-3"><i class="fas fa-map-marker-alt text-primary mt-0.5"></i><span>San Salvador, El Salvador</span></li>
          <li class="flex items-center gap-3"><i class="fas fa-phone text-primary"></i><a href="tel:+50322000000" class="hover:text-primary transition-colors">+503 2200-0000</a></li>
          <li class="flex items-center gap-3"><i class="fas fa-envelope text-primary"></i><a href="mailto:info@lemascotte.com" class="hover:text-primary transition-colors">info@lemascotte.com</a></li>
        </ul>
        <a href="<?= APP_URL ?>/citas" class="mt-5 inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-dark transition-all hover:shadow-lg">
          <i class="fas fa-calendar-check"></i> Agendar Cita
        </a>
      </div>
    </div>

    <div class="border-t border-neutral-800 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-neutral-500">
      <p>© <?= date('Y') ?> Le Mascotte. Todos los derechos reservados.</p>
      <p>Hecho con <span class="text-primary">❤️</span> para los amantes de las mascotas</p>
    </div>
  </div>
</footer>

<!-- Toast Notification -->
<div id="toast" class="fixed top-20 right-4 z-50 hidden">
  <div class="bg-white rounded-xl shadow-xl border border-neutral-200 px-5 py-4 flex items-center gap-3 min-w-72">
    <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center text-sm"></div>
    <p id="toast-msg" class="text-sm font-semibold text-neutral-800"></p>
  </div>
</div>

<!-- Main JavaScript -->
<script src="<?= APP_URL ?>/js/app.js"></script>
<script>
  // Mobile menu
  document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.toggle('hidden');
  });
  // Init cart
  Cart.init();
</script>
</body>
</html>
