<?php
/**
 * Fix script: Remove raw CSS text leaked into PUC result post content.
 * Run from the project root: php fix_puc_content.php
 */

$host = '127.0.0.1';
$port = '3306';
$dbname = 'govt_job_portal';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage() . "\n");
}

// Find the PUC result post
$slug = 'karnataka-2nd-puc-toppers-2026-science-commerce-arts';
$stmt = $pdo->prepare("SELECT id, slug, title, LEFT(content, 300) as content_preview FROM posts WHERE slug = ?");
$stmt->execute([$slug]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Post not found with slug: $slug\n";
    // Try to find it
    $stmt2 = $pdo->query("SELECT id, slug, title FROM posts WHERE slug LIKE '%puc%' OR title LIKE '%PUC%' LIMIT 5");
    $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    echo "Similar posts found:\n";
    foreach ($results as $r) {
        echo "  ID: {$r['id']}, Slug: {$r['slug']}, Title: {$r['title']}\n";
    }
    exit(1);
}

echo "Found post ID: {$post['id']}\n";
echo "Title: {$post['title']}\n";
echo "Content preview (first 300 chars):\n";
echo $post['content_preview'] . "\n\n";

// Get the full content
$stmt = $pdo->prepare("SELECT id, content FROM posts WHERE id = ?");
$stmt->execute([$post['id']]);
$fullPost = $stmt->fetch(PDO::FETCH_ASSOC);
$content = $fullPost['content'];

echo "Total content length: " . strlen($content) . " bytes\n";

// Check if raw CSS is present in content (not inside <style> tags)
// The leaked CSS would appear as raw text - look for patterns
$cssLeakPatterns = [
    '.stream-icon{font-size',
    '.puc-result .stream-name',
    '.stream-pct{font-size',
    'font-weight:700;letter-spacing',
    '.puc-result .info-grid',
    '.puc-result .topper-section',
];

$hasLeakedCSS = false;
foreach ($cssLeakPatterns as $pattern) {
    if (strpos($content, $pattern) !== false) {
        $hasLeakedCSS = true;
        echo "FOUND leaked CSS pattern: $pattern\n";
    }
}

if (!$hasLeakedCSS) {
    echo "\nNo raw CSS leak detected in content. The content looks clean.\n";
    echo "\nFirst 500 chars of content:\n";
    echo substr($content, 0, 500) . "\n";
    exit(0);
}

echo "\n=== RAW CSS LEAK DETECTED ===\n";

// Show the portion of content where CSS appears
$cssStart = false;
foreach ($cssLeakPatterns as $pattern) {
    $pos = strpos($content, $pattern);
    if ($pos !== false) {
        if ($cssStart === false || $pos < $cssStart) {
            $cssStart = $pos;
        }
    }
}

echo "CSS starts at position: $cssStart\n";
echo "Context around CSS leak:\n";
echo substr($content, max(0, $cssStart - 100), 400) . "\n\n";

// Strategy: Remove the raw CSS block that was leaked into content
// The CSS block appears to start with .stream-icon or .puc-result pattern
// We need to find its boundaries

// Look for the clean HTML content before/after the CSS dump
// The CSS dump is typically formatted as a continuous string of CSS rules

// Pattern: Remove CSS text that is NOT inside <style> tags
// Use regex to find and remove CSS blobs not in style tags

// First, let's see how the CSS appears - is it plain text or inside a <p> tag?
$contextStart = max(0, $cssStart - 200);
$contextLength = min(1000, strlen($content) - $contextStart);
echo "=== Content context (200 chars before CSS) ===\n";
echo substr($content, $contextStart, $contextLength) . "\n\n";

// Find the end of the CSS block
// CSS text ends when we hit a < (HTML tag) or end of the pattern
// Let's find where the CSS blob ends by looking for the next HTML tag after it
$afterCSS = $cssStart;
while ($afterCSS < strlen($content)) {
    $char = $content[$afterCSS];
    // CSS text typically doesn't contain < characters
    if ($char === '<') {
        break;
    }
    $afterCSS++;
}

echo "CSS block ends at position: $afterCSS\n";
echo "CSS block length: " . ($afterCSS - $cssStart) . " chars\n";
echo "CSS block content:\n";
echo substr($content, $cssStart, min(500, $afterCSS - $cssStart)) . "\n\n";

// Ask for confirmation before modifying
echo "=== PROPOSED FIX ===\n";
echo "Remove the raw CSS text from position $cssStart to $afterCSS\n";
echo "Content before CSS (last 100 chars): " . substr($content, max(0, $cssStart - 100), 100) . "\n";
echo "Content after CSS (first 100 chars): " . substr($content, $afterCSS, 100) . "\n\n";

// Create fixed content
$fixedContent = substr($content, 0, $cssStart) . substr($content, $afterCSS);

echo "New content length: " . strlen($fixedContent) . " bytes (was " . strlen($content) . ")\n";
echo "Removed " . (strlen($content) - strlen($fixedContent)) . " bytes\n\n";

// Write backup first
file_put_contents('puc_content_backup.html', $content);
echo "Backup saved to: puc_content_backup.html\n\n";

// Apply the fix
$updateStmt = $pdo->prepare("UPDATE posts SET content = ? WHERE id = ?");
$updateStmt->execute([$fixedContent, $post['id']]);

echo "=== FIXED! ===\n";
echo "Post content updated. Raw CSS text removed.\n";
echo "Rows affected: " . $updateStmt->rowCount() . "\n\n";

// Clear any file cache
$cacheDir = __DIR__ . '/storage/framework/cache/data';
if (is_dir($cacheDir)) {
    echo "Note: Run 'php artisan cache:clear' to clear application cache.\n";
}

echo "Done! Please refresh the page: https://jobone.in/result/$slug\n";
