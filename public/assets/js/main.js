// MyCar - interacciones minimas de la interfaz

document.addEventListener('DOMContentLoaded', function () {

  // ── Hamburguesa (sidebar en mobile) ──────────────────────────────────────
  var btn     = document.getElementById('hamburgerBtn');
  var sidebar = document.getElementById('sidebar');
  var overlay = document.getElementById('sidebarOverlay');

  function abrirSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
  }

  function cerrarSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
  }

  if (btn && sidebar && overlay) {
    btn.addEventListener('click', function () {
      sidebar.classList.contains('open') ? cerrarSidebar() : abrirSidebar();
    });

    // Cerrar al hacer clic en el overlay
    overlay.addEventListener('click', cerrarSidebar);

    // Cerrar si el usuario navega a otro link del sidebar (en mobile)
    sidebar.querySelectorAll('nav a').forEach(function (link) {
      link.addEventListener('click', cerrarSidebar);
    });

    // Cerrar con la tecla Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') cerrarSidebar();
    });
  }

  // ── Confirmacion para acciones destructivas ───────────────────────────────
  document.querySelectorAll('[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var msg = form.getAttribute('data-confirm') || '¿Confirma la operación?';
      if (!window.confirm(msg)) {
        e.preventDefault();
      }
    });
  });

  // ── Fecha minima de hoy en inputs de tipo date ────────────────────────────
  var today = new Date().toISOString().split('T')[0];
  document.querySelectorAll('input[type="date"][data-min-today]').forEach(function (input) {
    input.setAttribute('min', today);
  });

  // ── Cierra alertas al hacer click ─────────────────────────────────────────
  document.querySelectorAll('.alert').forEach(function (alertBox) {
    alertBox.addEventListener('click', function () {
      alertBox.style.display = 'none';
    });
  });

});