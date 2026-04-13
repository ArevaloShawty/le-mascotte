<?php $pageTitle = 'Checkout'; require_once APP_PATH . '/views/partials/header.php'; ?>

<section class="py-14 bg-white border-b border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="font-display font-black text-4xl text-neutral-900">
      <i class="fas fa-lock text-primary mr-3"></i>Checkout
    </h1>
    <p class="text-neutral-500 mt-1">Completa tus datos para finalizar la compra</p>
  </div>
</section>

<section class="py-12 bg-neutral-50 min-h-screen">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div id="checkout-empty" class="hidden text-center py-20">
      <div class="text-7xl mb-4">🛒</div>
      <h2 class="font-display font-bold text-2xl text-neutral-900 mb-3">Tu carrito está vacío</h2>
      <a href="<?= APP_URL ?>/productos" class="inline-flex items-center gap-2 bg-primary text-white px-7 py-3 rounded-xl font-bold">
        <i class="fas fa-store"></i> Ver productos
      </a>
    </div>

    <div id="checkout-content" class="hidden grid lg:grid-cols-5 gap-8">
      <!-- Form -->
      <div class="lg:col-span-3">
        <div class="bg-white rounded-3xl shadow-sm border border-neutral-100 p-8">
          <h2 class="font-display font-bold text-2xl text-neutral-900 mb-6">Datos de entrega</h2>
          <form id="checkout-form" class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-1.5"><i class="fas fa-user text-primary mr-1"></i>Nombre completo *</label>
                <input type="text" name="nombre" required placeholder="Tu nombre"
                       class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
              </div>
              <div>
                <label class="block text-sm font-bold text-neutral-700 mb-1.5"><i class="fas fa-phone text-primary mr-1"></i>Teléfono *</label>
                <input type="tel" name="telefono" required placeholder="+503 0000-0000"
                       class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
              </div>
            </div>
            <div>
              <label class="block text-sm font-bold text-neutral-700 mb-1.5"><i class="fas fa-envelope text-primary mr-1"></i>Email *</label>
              <input type="email" name="email" required placeholder="tu@email.com"
                     class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
              <p class="text-xs text-neutral-400 mt-1">Te enviaremos la confirmación del pedido a este correo.</p>
            </div>
            <div>
              <label class="block text-sm font-bold text-neutral-700 mb-1.5"><i class="fas fa-map-marker-alt text-primary mr-1"></i>Dirección de entrega *</label>
              <textarea name="direccion" rows="3" required placeholder="Dirección completa, colonia, municipio, departamento..."
                        class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm resize-none"></textarea>
            </div>

            <!-- Order summary inline -->
            <div class="bg-neutral-50 rounded-2xl p-5 border border-neutral-200">
              <h3 class="font-bold text-neutral-900 text-sm mb-3">Resumen del pedido</h3>
              <div id="checkout-items-list" class="space-y-2 mb-3 max-h-48 overflow-y-auto"></div>
              <div class="border-t border-neutral-200 pt-3 space-y-1.5 text-sm">
                <div class="flex justify-between"><span class="text-neutral-500">Subtotal</span><span class="font-bold" id="co-subtotal">$0.00</span></div>
                <div class="flex justify-between"><span class="text-neutral-500">IVA (13%)</span><span class="font-bold" id="co-tax">$0.00</span></div>
                <div class="flex justify-between text-base font-bold mt-2 pt-2 border-t border-neutral-200">
                  <span>Total a pagar</span>
                  <span class="text-primary text-xl font-black" id="co-total">$0.00</span>
                </div>
              </div>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
              <i class="fas fa-shield-alt text-amber-500 mt-0.5 flex-shrink-0"></i>
              <p class="text-xs text-amber-800"><strong>Pago contra entrega.</strong> Tu pedido será confirmado y coordinaremos la entrega. Aceptamos efectivo y tarjeta al momento de la entrega.</p>
            </div>

            <button type="submit"
                    class="w-full bg-primary text-white py-4 rounded-2xl font-bold text-base hover:bg-primary-dark hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
              <i class="fas fa-check-circle"></i>
              <span id="btn-checkout-text">Confirmar Pedido</span>
            </button>
          </form>
        </div>
      </div>

      <!-- Sidebar info -->
      <div class="lg:col-span-2 space-y-5">
        <div class="bg-primary rounded-3xl p-6 text-white">
          <i class="fas fa-truck text-3xl mb-3 opacity-80"></i>
          <h3 class="font-bold text-lg mb-1">Envío a domicilio</h3>
          <p class="text-orange-100 text-sm mb-3">Realizamos entregas en San Salvador y área metropolitana.</p>
          <p class="text-xs text-orange-200">El costo de envío se coordina al confirmar el pedido.</p>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-neutral-100">
          <h3 class="font-bold text-neutral-900 mb-3 flex items-center gap-2"><i class="fas fa-headset text-primary"></i> ¿Dudas?</h3>
          <p class="text-sm text-neutral-500 mb-3">Estamos disponibles para ayudarte con tu pedido.</p>
          <a href="tel:+50322000000" class="flex items-center gap-2 text-sm font-bold text-primary hover:underline">
            <i class="fas fa-phone"></i> +503 2200-0000
          </a>
          <a href="<?= APP_URL ?>/contacto" class="flex items-center gap-2 text-sm font-bold text-neutral-500 hover:text-primary mt-2 transition-colors">
            <i class="fas fa-envelope"></i> Enviar mensaje
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const items = Cart.getItems();
  if (!items.length) {
    document.getElementById('checkout-empty').classList.remove('hidden');
    return;
  }
  document.getElementById('checkout-content').classList.remove('hidden');

  // Render items
  const listEl = document.getElementById('checkout-items-list');
  listEl.innerHTML = items.map(i => `
    <div class="flex justify-between items-center text-sm">
      <span class="text-neutral-700 truncate pr-2">${escapeHtml(i.nombre)} <span class="text-neutral-400">×${i.cantidad}</span></span>
      <span class="font-bold text-neutral-900 flex-shrink-0">$${(i.precio*i.cantidad).toFixed(2)}</span>
    </div>
  `).join('');

  const sub = Cart.getSubtotal();
  const tax = sub * 0.13;
  document.getElementById('co-subtotal').textContent = '$' + sub.toFixed(2);
  document.getElementById('co-tax').textContent = '$' + tax.toFixed(2);
  document.getElementById('co-total').textContent = '$' + (sub+tax).toFixed(2);

  // Submit
  document.getElementById('checkout-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btn-checkout-text');
    btn.textContent = 'Procesando...';

    const fd = new FormData(this);
    fd.append('items', JSON.stringify(Cart.getItems()));
    try {
      const res = await fetch('<?= APP_URL ?>/checkout', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.success) {
        Cart.clear();
        Toast.show('¡Pedido confirmado! Revisa tu correo 📧', 'success');
        setTimeout(() => location.href = '<?= APP_URL ?>/inicio', 3000);
      } else {
        Toast.show(data.message || 'Error al procesar', 'error');
        btn.textContent = 'Confirmar Pedido';
      }
    } catch {
      Toast.show('Error de conexión. Intenta de nuevo.', 'error');
      btn.textContent = 'Confirmar Pedido';
    }
  });
});
</script>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
