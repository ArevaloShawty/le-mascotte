  </main>
</div>

<script>
const Toast = {
  show(msg, type='success') {
    const t = document.getElementById('toast');
    const m = document.getElementById('toast-msg');
    const i = document.getElementById('toast-icon');
    const cfg = {
      success:{bg:'bg-green-100',text:'text-green-600',icon:'fa-check-circle'},
      error:{bg:'bg-red-100',text:'text-red-600',icon:'fa-exclamation-circle'},
      info:{bg:'bg-blue-100',text:'text-blue-600',icon:'fa-info-circle'},
    }[type]||{bg:'bg-green-100',text:'text-green-600',icon:'fa-check-circle'};
    m.textContent = msg;
    i.className = `w-7 h-7 rounded-full flex items-center justify-center text-xs ${cfg.bg} ${cfg.text}`;
    i.innerHTML = `<i class="fas ${cfg.icon}"></i>`;
    t.classList.remove('hidden');
    setTimeout(()=>t.classList.add('hidden'), 3500);
  }
};

// Confirm dialogs
document.querySelectorAll('[data-confirm]').forEach(el => {
  el.addEventListener('click', e => {
    if (!confirm(el.dataset.confirm)) e.preventDefault();
  });
});
</script>
</body>
</html>
