/**
 * ADMIN DASHBOARD — app.js
 * Clean, modular JavaScript
 * No dependencies, vanilla JS only
 * Ready for Laravel Blade integration
 */

/* ============================================================
   1. SIDEBAR MANAGER
   ============================================================ */
const SidebarManager = (() => {
  const COLLAPSED_KEY = 'sidebar_collapsed';

  let sidebar, mainContent, overlay, toggleBtn;

  function init() {
    sidebar     = document.getElementById('sidebar');
    mainContent = document.getElementById('mainContent');
    overlay     = document.getElementById('sidebarOverlay');
    toggleBtn   = document.getElementById('sidebarToggle');

    if (!sidebar) return;

    // Restore state from localStorage
    if (localStorage.getItem(COLLAPSED_KEY) === 'true') {
      sidebar.classList.add('collapsed');
      mainContent?.classList.add('expanded');
    }

    // Desktop toggle
    toggleBtn?.addEventListener('click', () => {
      if (window.innerWidth <= 768) {
        openMobile();
      } else {
        toggleCollapse();
      }
    });

    // Mobile overlay close
    overlay?.addEventListener('click', closeMobile);

    // Close mobile on resize to desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth > 768) {
        closeMobile();
      }
    });

    setActiveLink();
  }

  function toggleCollapse() {
    const isCollapsed = sidebar.classList.toggle('collapsed');
    mainContent?.classList.toggle('expanded', isCollapsed);
    localStorage.setItem(COLLAPSED_KEY, isCollapsed);
  }

  function openMobile() {
    sidebar.classList.add('mobile-open');
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeMobile() {
    sidebar.classList.remove('mobile-open');
    overlay?.classList.remove('show');
    document.body.style.overflow = '';
  }

  function setActiveLink() {
    const currentPath = window.location.pathname;
    const currentPage = window.location.href;

    const links = sidebar?.querySelectorAll('.sidebar-link[data-page]');
    links?.forEach(link => {
      const page = link.getAttribute('data-page');
      const href = link.getAttribute('href');

      if (
        (page && currentPage.includes(page)) ||
        (href && href !== '#' && currentPage.endsWith(href))
      ) {
        link.classList.add('active');
      }
    });
  }

  return { init, toggleCollapse, openMobile, closeMobile };
})();

/* ============================================================
   2. TOAST NOTIFICATION MANAGER
   ============================================================ */
const Toast = (() => {
  const AUTO_HIDE_MS = 4500;
  const ICONS = {
    success: 'fa-circle-check',
    error:   'fa-circle-xmark',
    warning: 'fa-triangle-exclamation',
    info:    'fa-circle-info',
  };

  let container;

  function getContainer() {
    if (!container) {
      container = document.getElementById('toastContainer');
      if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container';
        document.body.appendChild(container);
      }
    }
    return container;
  }

  function show({ type = 'info', title = '', message = '', duration = AUTO_HIDE_MS }) {
    const c = getContainer();
    const icon = ICONS[type] || ICONS.info;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
      <div class="toast-icon"><i class="fa-solid ${icon}"></i></div>
      <div class="toast-body">
        ${title    ? `<div class="toast-title">${title}</div>` : ''}
        ${message  ? `<div class="toast-message">${message}</div>` : ''}
      </div>
      <button class="toast-close" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      <div class="toast-progress" style="animation-duration: ${duration}ms;"></div>
    `;

    c.appendChild(toast);

    // Close button
    toast.querySelector('.toast-close').addEventListener('click', () => dismiss(toast));

    // Auto hide
    const timer = setTimeout(() => dismiss(toast), duration);
    toast._timer = timer;

    return toast;
  }

  function dismiss(toast) {
    clearTimeout(toast._timer);
    toast.classList.add('hiding');
    toast.addEventListener('animationend', () => toast.remove(), { once: true });
  }

  // Shortcuts
  const success = (title, message, opts = {}) => show({ type: 'success', title, message, ...opts });
  const error   = (title, message, opts = {}) => show({ type: 'error',   title, message, ...opts });
  const warning = (title, message, opts = {}) => show({ type: 'warning', title, message, ...opts });
  const info    = (title, message, opts = {}) => show({ type: 'info',    title, message, ...opts });

  return { show, dismiss, success, error, warning, info };
})();

/* ============================================================
   3. CONFIRM DIALOG MANAGER
   ============================================================ */
const ConfirmDialog = (() => {
  let overlay, modal, titleEl, bodyEl, confirmBtn, cancelBtn;
  let _resolve = null;

  const TYPE_ICON = {
    warning: { icon: 'fa-triangle-exclamation', cls: 'warning' },
    danger:  { icon: 'fa-trash-can',            cls: 'danger'  },
    info:    { icon: 'fa-circle-info',           cls: 'info'    },
    success: { icon: 'fa-circle-check',          cls: 'success' },
  };

  function init() {
    overlay    = document.getElementById('confirmOverlay');
    titleEl    = document.getElementById('confirmTitle');
    bodyEl     = document.getElementById('confirmBody');
    confirmBtn = document.getElementById('confirmOk');
    cancelBtn  = document.getElementById('confirmCancel');

    if (!overlay) return;

    cancelBtn.addEventListener('click', () => resolve(false));
    confirmBtn.addEventListener('click', () => resolve(true));

    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) resolve(false);
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && overlay.classList.contains('open')) {
        resolve(false);
      }
    });
  }

  function show({
    title         = 'Are you sure?',
    body          = 'This action cannot be undone.',
    type          = 'warning',
    confirmText   = 'Confirm',
    cancelText    = 'Cancel',
    confirmClass  = 'btn-danger',
  } = {}) {
    if (!overlay) return Promise.resolve(false);

    const { icon, cls } = TYPE_ICON[type] || TYPE_ICON.warning;

    document.getElementById('confirmIcon').innerHTML = `<i class="fa-solid ${icon}"></i>`;
    document.getElementById('confirmIcon').className = `modal-icon ${cls}`;
    titleEl.textContent   = title;
    bodyEl.textContent    = body;
    confirmBtn.textContent = confirmText;
    confirmBtn.className   = `btn ${confirmClass}`;
    cancelBtn.textContent  = cancelText;

    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';

    return new Promise((res) => { _resolve = res; });
  }

  function resolve(value) {
    _resolve?.(value);
    _resolve = null;
    overlay?.classList.remove('open');
    document.body.style.overflow = '';
  }

  return { init, show };
})();

/* ============================================================
   4. NAVBAR DROPDOWN MANAGER
   ============================================================ */
const NavDropdown = (() => {
  function init() {
    document.querySelectorAll('.navbar-dropdown').forEach(dd => {
      const trigger = dd.querySelector('.navbar-dropdown-trigger');
      if (!trigger) return;

      trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = dd.classList.contains('open');
        closeAll();
        if (!isOpen) dd.classList.add('open');
      });
    });

    document.addEventListener('click', closeAll);
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeAll();
    });
  }

  function closeAll() {
    document.querySelectorAll('.navbar-dropdown.open').forEach(dd => {
      dd.classList.remove('open');
    });
  }

  return { init };
})();

/* ============================================================
   5. FILE UPLOAD DRAG & DROP
   ============================================================ */
const FileUpload = (() => {
  function init() {
    document.querySelectorAll('.file-upload-area[data-input]').forEach(area => {
      const inputId = area.getAttribute('data-input');
      const input   = document.getElementById(inputId);

      if (!input) return;

      // Click to browse
      area.addEventListener('click', () => input.click());

      // Drag events
      area.addEventListener('dragover',  (e) => { e.preventDefault(); area.classList.add('dragging'); });
      area.addEventListener('dragleave', ()  => { area.classList.remove('dragging'); });
      area.addEventListener('drop',      (e) => {
        e.preventDefault();
        area.classList.remove('dragging');
        const files = e.dataTransfer.files;
        if (files.length) handleFiles(area, files);
      });

      // Input change
      input.addEventListener('change', () => {
        if (input.files.length) handleFiles(area, input.files);
      });
    });
  }

  function handleFiles(area, files) {
    const names = Array.from(files).map(f => f.name).join(', ');
    const hint = area.querySelector('.file-upload-text');
    if (hint) {
      hint.innerHTML = `<strong>${files.length} file(s) selected:</strong> ${names}`;
    }
  }

  return { init };
})();

/* ============================================================
   6. PAGE LOADER
   ============================================================ */
const PageLoader = (() => {
  function hide() {
    const loader = document.getElementById('pageLoader');
    if (!loader) return;
    loader.classList.add('hidden');
    setTimeout(() => loader.remove(), 400);
  }

  return { hide };
})();

/* ============================================================
   7. TABLE UTILS
   ============================================================ */
const TableUtils = (() => {
  function init() {
    // Search filter
    document.querySelectorAll('[data-table-search]').forEach(input => {
      const tableId = input.getAttribute('data-table-search');
      const table   = document.getElementById(tableId);
      if (!table) return;

      input.addEventListener('input', () => {
        const q = input.value.toLowerCase().trim();
        table.querySelectorAll('tbody tr').forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = (!q || text.includes(q)) ? '' : 'none';
        });
      });
    });
  }

  return { init };
})();

/* ============================================================
   8. FORM UTILS
   ============================================================ */
const FormUtils = (() => {
  function init() {
    // Show/hide password toggle
    document.querySelectorAll('.show-password-toggle').forEach(btn => {
      const targetId = btn.getAttribute('data-target');
      const input    = document.getElementById(targetId);
      if (!input) return;

      btn.addEventListener('click', () => {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        const icon = btn.querySelector('i');
        icon.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
      });
    });
  }

  return { init };
})();

/* ============================================================
   9. GLOBAL HELPERS
   ============================================================ */

/**
 * Handle delete action on any element with data-confirm-delete
 * Usage: <button data-confirm-delete data-item="User 'John'">Delete</button>
 */
function initDeleteButtons() {
  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('[data-confirm-delete]');
    if (!btn) return;

    const item = btn.getAttribute('data-item') || 'this item';
    const confirmed = await ConfirmDialog.show({
      title:        `Delete ${item}?`,
      body:         `This action is permanent and cannot be undone.`,
      type:         'danger',
      confirmText:  'Yes, Delete',
      confirmClass: 'btn-danger',
    });

    if (confirmed) {
      Toast.success('Deleted', `${item} has been successfully deleted.`);
      // In Laravel: submit a form, or do axios.delete()
      // btn.closest('tr')?.remove(); // example: remove table row
    }
  });
}

/* ============================================================
   10. INIT
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => {
  SidebarManager.init();
  NavDropdown.init();
  ConfirmDialog.init();
  FileUpload.init();
  TableUtils.init();
  FormUtils.init();
  ApprovalFilter.init();
  initDeleteButtons();

  // Hide page loader after everything is ready
  window.addEventListener('load', () => {
    setTimeout(PageLoader.hide, 300);
  });
});

// Expose globally for use in Blade templates
window.Toast          = Toast;
window.ConfirmDialog  = ConfirmDialog;
window.SidebarManager = SidebarManager;


/* ============================================================
   8. APPROVAL FILTER HELPER
   ============================================================ */
const ApprovalFilter = (() => {
  function init() {
    const form = document.querySelector('[data-approval-filter]');
    if (!form) return;

    form.querySelectorAll('select').forEach((el) => {
      el.addEventListener('change', () => form.submit());
    });
  }

  return { init };
})();
