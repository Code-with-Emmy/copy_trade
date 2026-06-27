(function () {
  var storageKey = 'site-theme';
  var legacyKey = 'theme';

  var getTheme = function () {
    return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
  };

  var setStoredTheme = function (theme) {
    localStorage.setItem(storageKey, theme);
    localStorage.setItem(legacyKey, theme);
  };

  var applyTheme = function (theme) {
    theme = theme === 'light' ? 'light' : 'dark';
    var root = document.documentElement;

    root.classList.remove('dark', 'light');
    root.classList.add(theme);
    root.style.colorScheme = theme;

    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
      if (btn.dataset.themeToggle) {
        btn.setAttribute('aria-pressed', btn.dataset.themeToggle === theme ? 'true' : 'false');
      }
    });

    document.querySelectorAll('[data-theme-cycle]').forEach(function (btn) {
      btn.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
      btn.setAttribute('title', theme === 'dark' ? 'Light mode' : 'Dark mode');
    });

    window.dispatchEvent(new CustomEvent('dashboard-theme-changed', { detail: { theme: theme } }));
  };

  var initTheme = function () {
    var stored = localStorage.getItem(storageKey) || localStorage.getItem(legacyKey);
    if (stored === 'light' || stored === 'dark') {
      applyTheme(stored);
      return;
    }

    applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  };

  document.addEventListener('DOMContentLoaded', function () {
    initTheme();

    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        var theme = button.dataset.themeToggle === 'light' ? 'light' : 'dark';
        setStoredTheme(theme);
        applyTheme(theme);
      });
    });

    document.querySelectorAll('[data-theme-cycle]').forEach(function (button) {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        var next = getTheme() === 'dark' ? 'light' : 'dark';
        setStoredTheme(next);
        applyTheme(next);

        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }
      });
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (event) {
      if (!localStorage.getItem(storageKey) && !localStorage.getItem(legacyKey)) {
        applyTheme(event.matches ? 'dark' : 'light');
      }
    });
  });
})();
