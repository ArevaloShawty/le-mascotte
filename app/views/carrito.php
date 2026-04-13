<?php $pageTitle = 'Carrito'; require_once APP_PATH . '/views/partials/header.php'; ?>

<section class="py-14 bg-white border-b border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="font-display font-black text-4xl text-neutral-900">
      <i class="fas fa-shopping-cart text-primary mr-3"></i>Tu Carrito
    </h1>
  </div>
</section>

<section class="py-10 bg-neutral-50 min-h-screen">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div id="cart-empty" class="hidden text-center py-24">
      <div class="text-8xl mb-6">🛒</div>
      <h2 class="font-display font-bold text-3xl text-neutral-900 mb-3">Tu carrito está vacío</h2>
      <p class="text-neutral-400 text-lg mb-8">Explora nuestra tienda y agrega productos para tus mascotas</p>
      <a href="<?= APP_URL ?>/productos" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold hover:bg-primary-dark transition-colors">
        <i class="fas fa-store"></i> Ir a la Tienda
      </a>
    </div>

    <div id="cart-content" class="hidden grid lg:grid-cols-3 gap-8">
      <!-- Items -->
      <div class="lg:col-span-2 space-y-4" id="cart-items-list"></div>

      <!-- Summary -->
      <div class="space-y-5">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-neutral-100">
          <h2 class="font-bold text-xl text-neutral-900 mb-5">Resumen del Pedido</h2>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-neutral-500">Subtotal</span><span class="font-bold" id="summary-subtotal">$0.00</span></div>
            <div class="flex justify-between"><span class="text-neutral-500">IVA (13%)</span><span class="font-bold" id="summary-tax">$0.00</span></div>
            <div class="flex justify-between"><span class="text-neutral-500">Envío</span><span class="text-green-600 font-bold">Por calcular</span></div>
            <div class="border-t border-neutral-200 pt-3 flex justify-between">
              <span class="font-bold text-neutral-900">Total</span>
              <span class="font-display font-black text-2xl text-primary" id="summary-total">$0.00</span>
            </div>
          </div>
          <button onclick="Checkout.open()" class="w-full mt-6 bg-primary text-white py-4 rounded-2xl font-bold hover:bg-primary-dark hover:shadow-xl transition-all">
            <i class="fas fa-lock mr-2"></i> Proceder al Checkout
          </button>
          <a href="<?= APP_URL ?>/productos" class="w-full mt-3 flex items-center justify-center gap-2 text-neutral-500 hover:text-primary text-sm font-semibold transition-colors">
            <i class="fas fa-arrow-left"></i> Seguir comprando
          </a>
        </div>

        <!-- Appointment upsell -->
        <div class="bg-primary/10 border border-primary/20 rounded-3xl p-5">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white flex-shrink-0">
              <i class="fas fa-stethoscope"></i>
            </div>
            <div>
              <p class="font-bold text-neutral-900 text-sm">¿También necesitas atención veterinaria?</p>
              <p class="text-neutral-500 text-xs mt-1">Agenda una cita médica mientras realizas tu compra.</p>
              <a href="<?= APP_URL ?>/citas" class="inline-flex items-center gap-1 text-primary font-bold text-xs mt-2">
                Agendar cita <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Checkout Modal -->
<div id="checkout-modal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative animate-modal">
    <button onclick="Checkout.close()" class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center transition-colors">
      <i class="fas fa-times text-neutral-500"></i>
    </button>
    <h2 class="font-display font-bold text-2xl text-neutral-900 mb-6">Datos de Entrega</h2>
    <form id="checkout-form" class="space-y-4">
      <div>
        <label class="block text-sm font-bold text-neutral-700 mb-1.5">Nombre completo *</label>
        <input type="text" name="nombre" required class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
      </div>
      <div>
        <label class="block text-sm font-bold text-neutral-700 mb-1.5">Email *</label>
        <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
      </div>
      <div>
        <label class="block text-sm font-bold text-neutral-700 mb-1.5">Teléfono *</label>
        <input type="tel" name="telefono" required class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
      </div>
      <div>
        <label class="block text-sm font-bold text-neutral-700 mb-1.5">Dirección de entrega *</label>
        <textarea name="direccion" rows="2" required class="w-full px-4 py-3 rounded-xl border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm resize-none"></textarea>
      </div>
      <div class="bg-neutral-50 rounded-xl px-4 py-3">
        <div class="flex justify-between text-sm"><span>Subtotal:</span><span id="modal-subtotal" class="font-bold">$0.00</span></div>
        <div class="flex justify-between text-sm mt-1"><span>IVA (13%):</span><span id="modal-tax" class="font-bold">$0.00</span></div>
        <div class="flex justify-between font-bold mt-2 pt-2 border-t border-neutral-200">
          <span>Total:</span><span class="text-primary text-xl" id="modal-total">$0.00</span>
        </div>
      </div>
      <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-bold hover:bg-primary-dark transition-all">
        <i class="fas fa-check-circle mr-2"></i> Confirmar Pedido
      </button>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const APP_URL = '<?= APP_URL ?>';
  Cart.renderCartPage();

  // Checkout modal
  window.Checkout = {
    open() {
      const items = Cart.getItems();
      if (!items.length) return Toast.show('Tu carrito está vacío', 'error');
      const sub = Cart.getSubtotal();
      const tax = sub * 0.13;
      document.getElementById('modal-subtotal').textContent = '$' + sub.toFixed(2);
      document.getElementById('modal-tax').textContent = '$' + tax.toFixed(2);
      document.getElementById('modal-total').textContent = '$' + (sub + tax).toFixed(2);
      document.getElementById('checkout-modal').classList.remove('hidden');
    },
    close() {
      document.getElementById('checkout-modal').classList.add('hidden');
    }
  };

  document.getElementById('checkout-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.append('items', JSON.stringify(Cart.getItems()));
    try {
      const res = await fetch(APP_URL + '/checkout', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.success) {
        Cart.clear();
        Checkout.close();
        Toast.show('¡Pedido confirmado! #' + data.pedido_id, 'success');
        setTimeout(() => location.href = APP_URL + '/inicio', 3000);
      }
    } catch { Toast.show('Error al procesar. Intenta de nuevo.', 'error'); }
  });
});
</script>

<?php require_once APP_PATH . '/views/partials/footer.php'; ?>
