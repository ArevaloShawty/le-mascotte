/**
 * Le Mascotte - Main JavaScript
 * Módulos: Cart, Toast, Navbar
 */

'use strict';

/* ═══════════════════════════════════════════════════════
   CART MODULE
   Gestiona el carrito en localStorage
═══════════════════════════════════════════════════════ */
const Cart = (() => {
  const STORAGE_KEY = 'le_mascotte_cart';

  /** Obtener items del carrito */
  function getItems() {
    try {
      return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    } catch { return []; }
  }

  /** Guardar items */
  function saveItems(items) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  }

  /** Calcular subtotal */
  function getSubtotal() {
    return getItems().reduce((sum, i) => sum + (i.precio * i.cantidad), 0);
  }

  /** Actualizar badge del carrito */
  function updateBadge() {
    const count = getItems().reduce((s, i) => s + i.cantidad, 0);
    const badge = document.getElementById('cart-count');
    if (!badge) return;
    if (count > 0) {
      badge.textContent = count;
      badge.classList.remove('hidden');
    } else {
      badge.classList.add('hidden');
    }
  }

  /** Agregar producto */
  function addItem(producto) {
    const items = getItems();
    const idx = items.findIndex(i => i.id === producto.id);
    if (idx >= 0) {
      items[idx].cantidad += 1;
    } else {
      items.push({ ...producto, cantidad: 1 });
    }
    saveItems(items);
    updateBadge();
    Toast.show(`"${producto.nombre}" agregado al carrito 🛒`, 'success');
  }

  /** Cambiar cantidad */
  function updateQty(id, qty) {
    const items = getItems();
    const idx = items.findIndex(i => i.id === id);
    if (idx < 0) return;
    if (qty <= 0) {
      items.splice(idx, 1);
    } else {
      items[idx].cantidad = qty;
    }
    saveItems(items);
    updateBadge();
    renderCartPage();
  }

  /** Eliminar item */
  function removeItem(id) {
    const items = getItems().filter(i => i.id !== id);
    saveItems(items);
    updateBadge();
    renderCartPage();
    Toast.show('Producto eliminado', 'info');
  }

  /** Vaciar carrito */
  function clear() {
    saveItems([]);
    updateBadge();
  }

  /** Renderizar página de carrito */
  function renderCartPage() {
    const items    = getItems();
    const emptyEl  = document.getElementById('cart-empty');
    const contentEl= document.getElementById('cart-content');
    const listEl   = document.getElementById('cart-items-list');
    if (!emptyEl || !contentEl) return;

    if (items.length === 0) {
      emptyEl.classList.remove('hidden');
      contentEl.classList.add('hidden');
      return;
    }

    emptyEl.classList.add('hidden');
    contentEl.classList.remove('hidden');

    // Render items
    listEl.innerHTML = items.map(item => `
      <div class="cart-item">
        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-neutral-100 flex-shrink-0">
          <img src="${item.imagen}&auto=format&fit=crop&w=160" alt="${escapeHtml(item.nombre)}" class="w-full h-full object-cover">
        </div>
        <div>
          <p class="font-bold text-neutral-900 text-sm leading-tight">${escapeHtml(item.nombre)}</p>
          <p class="text-primary font-black text-lg mt-1">$${(item.precio * item.cantidad).toFixed(2)}</p>
          <p class="text-neutral-400 text-xs">$${item.precio.toFixed(2)} c/u</p>
        </div>
        <div class="flex flex-col items-end gap-2">
          <button onclick="Cart.removeItem(${item.id})" class="w-7 h-7 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 flex items-center justify-center transition-colors">
            <i class="fas fa-trash text-xs"></i>
          </button>
          <div class="flex items-center gap-2 bg-neutral-100 rounded-xl px-2 py-1">
            <button onclick="Cart.updateQty(${item.id}, ${item.cantidad - 1})" class="w-6 h-6 rounded-lg hover:bg-white flex items-center justify-center font-bold transition-colors">−</button>
            <span class="font-bold text-sm min-w-[1.5rem] text-center">${item.cantidad}</span>
            <button onclick="Cart.updateQty(${item.id}, ${item.cantidad + 1})" class="w-6 h-6 rounded-lg hover:bg-white flex items-center justify-center font-bold transition-colors">+</button>
          </div>
        </div>
      </div>
    `).join('');

    // Update totals
    const subtotal = getSubtotal();
    const tax      = subtotal * 0.13;
    const total    = subtotal + tax;

    setEl('summary-subtotal', '$' + subtotal.toFixed(2));
    setEl('summary-tax',      '$' + tax.toFixed(2));
    setEl('summary-total',    '$' + total.toFixed(2));
  }

  /** Init: actualizar badge en toda la app */
  function init() {
    updateBadge();
  }

  return { getItems, addItem, updateQty, removeItem, clear, getSubtotal, renderCartPage, init };
})();


/* ═══════════════════════════════════════════════════════
   TOAST MODULE
═══════════════════════════════════════════════════════ */
const Toast = (() => {
  let timer = null;

  function show(message, type = 'success') {
    const toast   = document.getElementById('toast');
    const msgEl   = document.getElementById('toast-msg');
    const iconEl  = document.getElementById('toast-icon');
    if (!toast) return;

    const config = {
      success: { bg: 'bg-green-100',  text: 'text-green-600',  icon: 'fa-check-circle' },
      error:   { bg: 'bg-red-100',    text: 'text-red-600',    icon: 'fa-exclamation-circle' },
      info:    { bg: 'bg-blue-100',   text: 'text-blue-600',   icon: 'fa-info-circle' },
      warning: { bg: 'bg-yellow-100', text: 'text-yellow-600', icon: 'fa-exclamation-triangle' },
    }[type] || config.success;

    msgEl.textContent = message;
    iconEl.className  = `w-8 h-8 rounded-full flex items-center justify-center text-sm ${config.bg} ${config.text}`;
    iconEl.innerHTML  = `<i class="fas ${config.icon}"></i>`;

    toast.classList.remove('hidden');
    toast.classList.add('show');

    clearTimeout(timer);
    timer = setTimeout(() => {
      toast.classList.add('hidden');
      toast.classList.remove('show');
    }, 3500);
  }

  return { show };
})();


/* ═══════════════════════════════════════════════════════
   NAVBAR SCROLL EFFECT
═══════════════════════════════════════════════════════ */
window.addEventListener('scroll', () => {
  const nav = document.querySelector('.navbar');
  nav?.classList.toggle('scrolled', window.scrollY > 20);
}, { passive: true });


/* ═══════════════════════════════════════════════════════
   LAZY IMAGE LOADING
═══════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  const imgs = document.querySelectorAll('.lazy-img');
  if ('IntersectionObserver' in window) {
    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('loaded');
          obs.unobserve(e.target);
        }
      });
    });
    imgs.forEach(img => obs.observe(img));
  }
});


/* ═══════════════════════════════════════════════════════
   UTILS
═══════════════════════════════════════════════════════ */
function escapeHtml(str) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(str));
  return div.innerHTML;
}

function setEl(id, val) {
  const el = document.getElementById(id);
  if (el) el.textContent = val;
}
