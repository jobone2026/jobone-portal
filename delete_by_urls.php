<?php
/**
 * delete_by_urls.php
 * Reads urls.txt (one URL per line), extracts slugs, deletes matching posts.
 *
 * Usage (SSH from Laravel root):
 *   php delete_by_urls.php            → dry run (preview only)
 *   php delete_by_urls.php --confirm  → actually delete
 */

define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// ── Config ────────────────────────────────────────────────────────────────────
$urlFile = __DIR__ . '/urls.txt';
$dryRun  = !in_array('--confirm', $argv ?? []);

// URL path segments that are NOT post slugs (listing/state/category pages)
$skipSegments = [
    'state', 'category', 'jobs', 'all-posts', 'home',
    'government-jobs', 'upload', 'cdn-cgi', 'update-3',
    'fbi-withdraws-national-security-letter-following-microsoft-challenge',
    'phd-opportunities-in-archaeology-13', 'phd-opportunities-in-archaeology-14',
];

// Known post-type URL prefixes (the segment before the slug)
$typeSegments = ['job', 'result', 'admit_card', 'answer_key', 'blog'];

// ── Load URLs ─────────────────────────────────────────────────────────────────
if (!file_exists($urlFile)) {
    echo "❌ urls.txt not found at: $urlFile\n";
    echo "   Create urls.txt with one URL per line and re-run.\n";
    exit(1);
}

$lines = file($urlFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$slugs = [];
$skipped = [];

foreach ($lines as $line) {
    $line = trim($line);
    // Strip date suffix if user included "URL  Apr 28, 2026" format
    $line = preg_replace('/\s+Apr\s+\d+,\s+\d{4}.*$/i', '', $line);
    $line = trim($line);

    if (empty($line) || !filter_var($line, FILTER_VALIDATE_URL)) {
        continue;
    }

    $path = trim(parse_url($line, PHP_URL_PATH) ?? '', '/');
    if (empty($path)) { $skipped[] = $line; continue; }

    $parts = explode('/', $path);

    // Skip known non-post paths
    if (in_array($parts[0], $skipSegments)) { $skipped[] = $line; continue; }

    // Detect template literals that got indexed
    if (strpos($path, '${') !== false) { $skipped[] = $line; continue; }

    // Skip URLs where the "slug" is actually a domain (e.g. /job/www.something.in)
    if (isset($parts[1]) && preg_match('/^www\.|\.in$|\.com$|\.gov\.in$|\.edu\.in$/', $parts[1])) {
        $skipped[] = $line; continue;
    }

    // Extract slug: if first segment is a type prefix, slug is second part
    if (in_array($parts[0], $typeSegments) && isset($parts[1])) {
        $slug = $parts[1];
    } else {
        $slug = $parts[0];
    }

    if (!empty($slug)) {
        $slugs[] = $slug;
    }
}

$slugs = array_unique($slugs);

echo "=== JobOne.in Bulk URL Deletion ===\n";
echo "Mode    : " . ($dryRun ? "DRY RUN – pass --confirm to delete" : "LIVE DELETE") . "\n";
echo "URLs in file   : " . count($lines) . "\n";
echo "Slugs extracted: " . count($slugs) . "\n";
echo "Skipped (non-post URLs): " . count($skipped) . "\n\n";

if (empty($slugs)) {
    echo "No valid slugs extracted. Check urls.txt format.\n";
    exit(0);
}

// ── Query DB ──────────────────────────────────────────────────────────────────
$found = DB::table('posts')->whereIn('slug', $slugs)
    ->get(['id', 'slug', 'type', 'title', 'is_published']);

echo "Found in DB: " . count($found) . " records\n\n";

if ($found->isEmpty()) {
    echo "No matching records found. Nothing to delete.\n";
    exit(0);
}

printf("%-6s %-12s %-10s %-50s %s\n", "ID", "Type", "Published", "Slug", "Title");
echo str_repeat("-", 110) . "\n";
foreach ($found as $post) {
    printf("%-6d %-12s %-10s %-50s %s\n",
        $post->id,
        $post->type ?? '-',
        $post->is_published ? 'YES' : 'NO',
        substr($post->slug, 0, 48),
        substr($post->title ?? '', 0, 40)
    );
}

$foundSlugs = $found->pluck('slug')->toArray();
$notFound   = array_diff($slugs, $foundSlugs);
echo "\n⚠  " . count($notFound) . " slug(s) not found in DB (already deleted or never imported).\n\n";

// ── Delete ────────────────────────────────────────────────────────────────────
if (!$dryRun) {
    $ids = $found->pluck('id')->toArray();
    DB::beginTransaction();
    try {
        $deleted = DB::table('posts')->whereIn('id', $ids)->delete();
        DB::commit();
        echo "✅ Successfully DELETED $deleted post(s).\n";
    } catch (\Exception $e) {
        DB::rollBack();
        echo "❌ Error: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "👆 DRY RUN complete. Run with --confirm to delete.\n";
}
echo "\nDone.\n";
