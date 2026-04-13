<?php $pageTitle = 'Inicio'; require_once APP_PATH . '/views/partials/header.php'; ?>

<!-- HERO SECTION -->
<section class="hero-section relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-[90vh] flex items-center">
  <!-- Decorative blobs -->
  <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
  <div class="absolute bottom-0 left-0 w-72 h-72 bg-primary/8 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <!-- Text -->
      <div class="animate-hero-text">
        <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-bold mb-6">
          <i class="fas fa-circle-dot animate-pulse"></i>
          Clínica & Tienda abierta ahora
        </span>
        <h1 class="font-display font-black text-5xl sm:text-6xl lg:text-7xl text-neutral-900 leading-tight mb-6">
          Cuidamos a los que <span class="text-primary relative">más quieres
            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" fill="none">
              <path d="M2 8C50 2 250 2 298 8" stroke="#FF6B35" stroke-width="3" stroke-linecap="round"/>
            </svg>
          </span>
        </h1>
        <p class="text-lg sm:text-xl text-neutral-500 mb-8 leading-relaxed max-w-lg">
          Sean de pelo, pluma o escama. Tu clínica veterinaria y tienda de mascotas de confianza en El Salvador.
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="<?= APP_URL ?>/citas" class="inline-flex items-center gap-2 bg-primary text-white px-7 py-4 rounded-2xl font-bold text-base hover:bg-primary-dark hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
            <i class="fas fa-calendar-check"></i> Agendar Cita Médica
          </a>
          <a href="<?= APP_URL ?>/productos" class="inline-flex items-center gap-2 bg-white text-neutral-800 border-2 border-neutral-200 px-7 py-4 rounded-2xl font-bold text-base hover:border-primary hover:text-primary hover:-translate-y-0.5 transition-all duration-200">
            <i class="fas fa-store"></i> Ver Tienda
          </a>
        </div>
        <!-- Stats -->
        <div class="flex gap-8 mt-10 pt-8 border-t border-neutral-200">
          <div><p class="font-display font-bold text-3xl text-primary">500+</p><p class="text-xs text-neutral-500 font-semibold">Clientes felices</p></div>
          <div><p class="font-display font-bold text-3xl text-primary">8+</p><p class="text-xs text-neutral-500 font-semibold">Años de experiencia</p></div>
          <div><p class="font-display font-bold text-3xl text-primary">24/7</p><p class="text-xs text-neutral-500 font-semibold">Emergencias</p></div>
        </div>
      </div>

      <!-- Images Grid -->
      <div class="grid grid-cols-2 gap-4 relative">
        <div class="col-span-2 rounded-3xl overflow-hidden h-64 shadow-xl">
          <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=700&auto=format&fit=crop" alt="Perros" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="rounded-3xl overflow-hidden h-44 shadow-lg">
          <img src="https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=400&auto=format&fit=crop" alt="Aves exóticas" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="rounded-3xl overflow-hidden h-44 shadow-lg">
          <img src="https://images.unsplash.com/photo-1591389703635-e15a07b842d7?w=400&auto=format&fit=crop" alt="Reptiles" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <!-- Badge -->
        <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3">
          <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600"><i class="fas fa-shield-alt"></i></div>
          <div><p class="text-xs font-bold text-neutral-900">Clínica Certificada</p><p class="text-xs text-neutral-400">Veterinarios expertos</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES SECTION -->
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
      <span class="text-primary font-bold text-sm uppercase tracking-widest">Lo que ofrecemos</span>
      <h2 class="font-display font-bold text-4xl sm:text-5xl text-neutral-900 mt-2">Nuestros Servicios</h2>
      <p class="text-neutral-500 mt-3 text-lg">Atención integral para todas tus mascotas</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php $services = [
        ['icon'=>'fa-stethoscope','color'=>'bg-orange-100 text-primary','title'=>'Clínica Veterinaria','desc'=>'Consultas, vacunación, cirugías y atención de emergencias 24/7.','cta'=>'Agendar cita','url'=>'citas'],
        ['icon'=>'fa-store','color'=>'bg-orange-100 text-primary','title'=>'Tienda Completa','desc'=>'Alimentos premium, juguetes, accesorios e higiene para toda mascota.','cta'=>'Ver productos','url'=>'productos'],
        ['icon'=>'fa-dragon','color'=>'bg-orange-100 text-primary','title'=>'Mascotas Exóticas','desc'=>'Especialistas en reptiles, aves y pequeños mamíferos con productos específicos.','cta'=>'Conocer más','url'=>'exoticos'],
      ]; foreach ($services as $s): ?>
      <div class="group bg-neutral-50 hover:bg-primary rounded-3xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer"
           onclick="location.href='<?= APP_URL ?>/<?= $s['url'] ?>'">
        <div class="w-14 h-14 <?= $s['color'] ?> group-hover:bg-white/20 rounded-2xl flex items-center justify-center text-2xl mb-5 transition-colors">
          <i class="fas <?= $s['icon'] ?>"></i>
        </div>
        <h3 class="font-display font-bold text-xl text-neutral-900 group-hover:text-white mb-3"><?= $s['title'] ?></h3>
        <p class="text-neutral-500 group-hover:text-orange-100 text-sm leading-relaxed mb-5"><?= $s['desc'] ?></p>
        <span class="inline-flex items-center gap-2 text-primary group-hover:text-white font-bold text-sm">
          <?= $s['cta'] ?> <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="py-20 bg-neutral-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-10">
      <div>
        <span class="text-primary font-bold text-sm uppercase tracking-widest">Selección especial</span>
        <h2 class="font-display font-bold text-4xl text-neutral-900 mt-1">Productos Destacados</h2>
      </div>
      <a href="<?= APP_URL ?>/productos" class="hidden sm:inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
        Ver todo <i class="fas fa-arrow-right"></i>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($destacados as $producto): ?>
      <?php include APP_PATH . '/views/partials/product_card.php'; ?>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-8 sm:hidden">
      <a href="<?= APP_URL ?>/productos" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-bold">
        Ver todos los productos <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- EXOTIC TEASER -->
<section class="py-20 bg-gradient-to-r from-neutral-900 to-neutral-800 relative overflow-hidden">
  <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1502780402662-acc01917738e?w=1400')] bg-cover bg-center opacity-15"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <span class="inline-flex items-center gap-2 bg-primary/20 text-primary px-4 py-1.5 rounded-full text-sm font-bold mb-5">
          <i class="fas fa-dragon"></i> Sección Especial
        </span>
        <h2 class="font-display font-black text-5xl text-white mb-5">Mascotas<br><span class="text-primary">Exóticas</span></h2>
        <p class="text-neutral-300 text-lg leading-relaxed mb-6">Reptiles, aves tropicales, pequeños mamíferos. Tenemos terrarios, lámparas UV-B, sustratos especiales y todo lo que tu compañero exótico necesita, más tips de cuidado expertos.</p>
        <a href="<?= APP_URL ?>/exoticos" class="inline-flex items-center gap-2 bg-primary text-white px-7 py-4 rounded-2xl font-bold hover:bg-primary-light hover:shadow-xl transition-all">
          <i class="fas fa-dragon"></i> Explorar Exóticos
        </a>
      </div>
      <div class="grid grid-cols-3 gap-3">
        <?php $exoImages = [
          ['https://images.unsplash.com/photo-1591389703635-e15a07b842d7?w=300','Reptiles'],
          ['https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=300','Aves'],
          ['https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=300','Conejos'],
        ]; foreach ($exoImages as [$img, $label]): ?>
        <div class="relative rounded-2xl overflow-hidden h-40 group">
          <img src="<?= $img ?>&auto=format&fit=crop" alt="<?= $label ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-3">
            <span class="text-white text-xs font-bold"><?= $label ?></span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
