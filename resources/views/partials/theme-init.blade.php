<script>
(function () {
  var storageKey = 'site-theme';
  var legacyKey = 'theme';
  var stored = localStorage.getItem(storageKey) || localStorage.getItem(legacyKey);
  var theme = stored === 'light' ? 'light' : (stored === 'dark' ? 'dark' : null);

  if (!theme) {
    theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  var root = document.documentElement;
  root.classList.remove('dark', 'light');
  root.classList.add(theme);
  root.style.colorScheme = theme;
})();
</script>
