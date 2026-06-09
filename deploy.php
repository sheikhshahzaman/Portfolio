<?php
/* ============================================================
 *  deploy.php  —  git-pull web deploy for Hostinger (Solstice)
 *  ------------------------------------------------------------
 *  Layout assumed:
 *    ~/public_html  = web root + the git checkout (.git, frontend/, backend/)
 *    ~/laravel      = the running Laravel app (artisan, vendor, .env)
 *
 *  It: git-pulls the repo, copies the prebuilt front-end into the
 *  web root and the admin build into /build, copies the changed
 *  backend PHP files into the running app, then runs artisan.
 *
 *  Usage:  https://YOURDOMAIN/deploy.php?key=SECRET
 *  Delete this file afterwards.
 * ============================================================ */

$SECRET = 'CHANGE_ME_to_a_long_random_string';   // set in ?key=

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '1');
set_time_limit(900);
header('Content-Type: text/plain; charset=utf-8');
while (ob_get_level()) ob_end_flush();

if (!hash_equals($SECRET, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit("403 Forbidden\n"); }
if ($SECRET === 'CHANGE_ME_to_a_long_random_string') exit("Set \$SECRET first.\n");

function line($s = '') { echo $s . "\n"; @flush(); }
function can_exec() {
    if (!function_exists('exec')) return false;
    $d = array_map('trim', explode(',', (string) ini_get('disable_functions')));
    return !in_array('exec', $d, true);
}
function sh($cmd) { $o = []; @exec($cmd . ' 2>&1', $o, $rc); echo implode("\n", $o) . "\n"; return [$rc, $o]; }
function rcopy($src, $dst) {
    if (is_dir($src)) {
        @mkdir($dst, 0755, true);
        foreach (scandir($src) as $f) { if ($f === '.' || $f === '..') continue; rcopy("$src/$f", "$dst/$f"); }
    } elseif (is_file($src)) {
        @mkdir(dirname($dst), 0755, true);
        @copy($src, $dst);
    }
}

line("== Solstice git-pull deploy ==  " . date('Y-m-d H:i:s') . "  PHP " . PHP_VERSION);
line('');

$WEB  = __DIR__;
$home = dirname($WEB);
line("Web root : $WEB");

$REPO = null;
foreach ([$WEB, $home] as $d) {
    if (is_dir("$d/.git") && is_dir("$d/frontend") && is_dir("$d/backend")) { $REPO = $d; break; }
}
$LARAVEL = null;
foreach (["$home/laravel", "$WEB/laravel", "$home/backend", "$WEB/backend"] as $d) {
    if (is_file("$d/artisan")) { $LARAVEL = $d; break; }
}
line("Repo     : " . ($REPO ?: 'NOT FOUND'));
line("Laravel  : " . ($LARAVEL ?: 'NOT FOUND'));
line('');
if (!$REPO)    exit("ERROR: git checkout (.git + frontend + backend) not found.\n");
if (!$LARAVEL) exit("ERROR: Laravel app (artisan) not found.\n");
if (!can_exec()) exit("ERROR: exec() is disabled — cannot git pull on this host.\n");

/* ---------- git pull (fast-forward only; abort on failure) ---------- */
$q = escapeshellarg($REPO);
line("$ git branch:");        sh("git -C $q rev-parse --abbrev-ref HEAD");
line("$ before:");            sh("git -C $q log -1 --oneline");
line("$ git pull --ff-only:");
list($rc) = sh("git -C $q pull --ff-only");
line("[exit $rc]");
if ($rc !== 0) exit("\nERROR: git pull failed (see above) — aborting before copy.\n");
line("$ after:");             sh("git -C $q log -1 --oneline");
line('');

/* ---------- copy prebuilt assets into the web root ---------- */
line("→ frontend/dist  ->  web root");
rcopy("$REPO/frontend/dist", $WEB);
line("→ backend/public/build  ->  web root/build");
rcopy("$REPO/backend/public/build", "$WEB/build");
line('');

/* ---------- copy changed backend PHP into the running Laravel app ---------- */
line("→ backend PHP  ->  $LARAVEL");
$files = [
    'app/Http/Controllers/API/PortfolioController.php',
    'app/Http/Controllers/Admin/SettingsController.php',
    'routes/api.php',
    'database/seeders/TranslationKeySeeder.php',
    'database/seeders/PortfolioSeeder.php',
];
foreach ($files as $f) {
    if (is_file("$REPO/backend/$f")) { rcopy("$REPO/backend/$f", "$LARAVEL/$f"); line("   + $f"); }
    else line("   ! missing: backend/$f");
}
line('');

/* ---------- artisan ---------- */
require $LARAVEL . '/vendor/autoload.php';
$app    = require $LARAVEL . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
function artisan($kernel, $cmd, array $p = []) {
    $s = $cmd; foreach ($p as $k => $v) $s .= ' ' . (is_bool($v) ? $k : "$k=$v");
    line("$ php artisan $s");
    try { $c = $kernel->call($cmd, $p); $o = trim($kernel->output()); if ($o !== '') line($o); line($c === 0 ? "[ok]" : "[exit $c]"); }
    catch (\Throwable $e) { line("ERROR: " . $e->getMessage()); }
    line('');
}
artisan($kernel, 'storage:link');
artisan($kernel, 'migrate', ['--force' => true]);
artisan($kernel, 'db:seed', ['--class' => 'TranslationKeySeeder', '--force' => true]);
artisan($kernel, 'optimize:clear');
artisan($kernel, 'config:cache');
artisan($kernel, 'route:cache');
artisan($kernel, 'view:cache');

line("== DONE ==");
line("Verify the site, then DELETE this deploy.php for security.");
