<?php
/**
 * artisan-web.php - Browser-based Laravel fixer for shared hosting
 * Visit: https://liquidbrokarage.com/public/artisan-web.php?token=bitcloven_fix_2024
 * DELETE THIS FILE after running it!
 */

define('SECRET_TOKEN', 'bitcloven_fix_2024');

if (!isset($_GET['token']) || $_GET['token'] !== SECRET_TOKEN) {
    http_response_code(403);
    die('403 Forbidden. Add ?token=bitcloven_fix_2024 to the URL.');
}

$publicDir      = __DIR__;
$baseDir        = dirname($publicDir);
$bootstrapCache = $baseDir . '/bootstrap/cache';

$results = [];

function delFiles(string $dir, string $label): string {
    if (!is_dir($dir)) return "info|{$label}: directory not found";
    $deleted = 0;
    foreach (glob($dir . '/*') as $f) {
        if (is_file($f) && basename($f) !== '.gitignore') { unlink($f) && $deleted++; }
    }
    return "ok|{$label}: {$deleted} file(s) deleted";
}

// 1. Config cache
$f = $bootstrapCache . '/config.php';
$results[] = file_exists($f) ? (unlink($f) ? 'ok|Config cache cleared' : 'err|Failed to clear config cache') : 'info|No config cache (already clear)';

// 2. Route cache
foreach (['/routes-v7.php', '/routes.php'] as $rf) {
    $f = $bootstrapCache . $rf;
    if (file_exists($f)) { $results[] = unlink($f) ? 'ok|Route cache cleared' : 'err|Failed to clear route cache'; break; }
}

// 3. Services + packages cache
foreach (['/services.php', '/packages.php'] as $cf) {
    $f = $bootstrapCache . $cf;
    if (file_exists($f)) { unlink($f); }
}
$results[] = 'ok|Bootstrap cache cleared';

// 4. View cache
$results[] = delFiles($baseDir . '/storage/framework/views', 'View cache');

// 5. App cache
$results[] = delFiles($baseDir . '/storage/framework/cache/data', 'App cache');

// 6. Storage symlink
$link = $publicDir . '/storage';
$src  = $baseDir . '/storage/app/public';
if (is_link($link)) {
    $results[] = 'info|Storage symlink already exists';
} elseif (file_exists($link) && !is_link($link)) {
    $results[] = 'warn|/public/storage exists as real folder — delete it via File Manager then re-run';
} else {
    if (@symlink($src, $link)) {
        $results[] = 'ok|Storage symlink created';
    } else {
        @mkdir($link, 0755, true);
        $ht = "Options -Indexes\n<IfModule mod_rewrite.c>\n  RewriteEngine On\n  RewriteRule ^(.*)$ /storage/app/public/\$1 [L]\n</IfModule>\n";
        $results[] = file_put_contents($link . '/.htaccess', $ht) !== false
            ? 'warn|symlink() blocked — redirect fallback applied'
            : 'err|Could not create symlink or fallback';
    }
}

// 7. Storage writability
foreach (['/storage/framework/cache/data', '/storage/framework/sessions', '/storage/framework/views', '/storage/logs'] as $d) {
    $path = $baseDir . $d;
    if (!is_dir($path)) @mkdir($path, 0775, true);
    if (!is_writable($path)) @chmod($path, 0775);
    $results[] = is_writable($path) ? "ok|Writable: {$d}" : "warn|Not writable: {$d}";
}

// ── 8. RUN MISSING MIGRATIONS VIA LARAVEL KERNEL ─────────────────────────────
$results[] = 'info|--- Running database migrations ---';
try {
    // Bootstrap Laravel
    define('LARAVEL_START', microtime(true));
    require $baseDir . '/vendor/autoload.php';
    $app = require_once $baseDir . '/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // Run migrate
    $exitCode = \Illuminate\Support\Facades\Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);

    $output = \Illuminate\Support\Facades\Artisan::output();
    $outputLines = array_filter(explode("\n", trim($output)));

    if ($exitCode === 0) {
        $results[] = 'ok|Migrations completed successfully';
        foreach ($outputLines as $line) {
            $line = trim(strip_tags($line));
            if (!empty($line)) {
                $results[] = 'info|  › ' . $line;
            }
        }
    } else {
        $results[] = 'warn|Migrations finished with warnings (exit code: ' . $exitCode . ')';
        foreach ($outputLines as $line) {
            $line = trim(strip_tags($line));
            if (!empty($line)) {
                $results[] = 'warn|  › ' . $line;
            }
        }
    }

} catch (\Throwable $e) {
    $results[] = 'err|Migration error: ' . $e->getMessage();
}

// ── Output ────────────────────────────────────────────────────────────────────
function icon(string $type): string {
    return match($type) { 'ok' => '✅', 'err' => '❌', 'warn' => '⚠️', default => 'ℹ️' };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laravel Fixer — liquidbrokarage.com</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{background:#0d0f1a;color:#e2e8f0;font-family:system-ui,sans-serif;min-height:100vh;display:flex;align-items:flex-start;justify-content:center;padding:3rem 1rem}
  .card{background:#131622;border:1px solid #1e2235;border-radius:14px;padding:2rem;max-width:780px;width:100%;box-shadow:0 8px 40px #0008}
  h1{font-size:1.35rem;color:#818cf8;margin-bottom:.2rem}
  .sub{color:#6b7280;font-size:.82rem;margin-bottom:1.5rem}
  ul{list-style:none;display:flex;flex-direction:column;gap:.4rem}
  li{background:#0d0f1a;border-radius:8px;padding:.55rem 1rem;font-size:.85rem;border-left:3px solid #2d3148;display:flex;gap:.6rem;align-items:flex-start;word-break:break-word}
  .ok{border-color:#22c55e}.err{border-color:#ef4444}.warn{border-color:#f59e0b}.info{border-color:#3b82f6}
  .badge{margin-top:.1rem;font-size:.68rem;padding:.1rem .4rem;border-radius:9999px;flex-shrink:0;font-weight:700;white-space:nowrap}
  .ok .badge{background:#14532d;color:#86efac}.err .badge{background:#450a0a;color:#fca5a5}.warn .badge{background:#451a03;color:#fcd34d}.info .badge{background:#1e3a5f;color:#93c5fd}
  .danger{margin-top:1.5rem;background:#2d0000;border:1px solid #7f1d1d;border-radius:8px;padding:1rem;font-size:.84rem;color:#fca5a5}
  .danger strong{display:block;margin-bottom:.4rem;color:#f87171}
  code{background:#1e293b;padding:.1rem .35rem;border-radius:4px;font-size:.8rem}
  .section-sep{border-top:1px solid #1e2235;margin:.75rem 0}
</style>
</head>
<body>
<div class="card">
  <h1>🔧 Laravel Production Fixer</h1>
  <p class="sub">Running on: <code><?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'unknown') ?></code> &nbsp;|&nbsp; PHP <?= phpversion() ?></p>
  <ul>
    <?php foreach ($results as $line):
      if (str_starts_with($line, 'info|---')) { echo '<li class="info" style="border-color:#6366f1"><span class="badge" style="background:#312e81;color:#a5b4fc">STEP</span>' . htmlspecialchars(str_replace('info|--- ', '', $line)) . '</li>'; continue; }
      [$type, $msg] = explode('|', $line, 2);
      $labels = ['ok'=>'DONE','err'=>'FAILED','warn'=>'WARN','info'=>'INFO'];
    ?>
    <li class="<?= $type ?>">
      <span class="badge"><?= $labels[$type] ?? 'INFO' ?></span>
      <?= htmlspecialchars(icon($type) . ' ' . $msg) ?>
    </li>
    <?php endforeach ?>
  </ul>
  <div class="danger">
    <strong>🚨 Delete this file now!</strong>
    Remove <code>public/artisan-web.php</code> from your server using File Manager or FTP immediately after running. Leaving it online is a security risk.
  </div>
</div>
</body>
</html>
