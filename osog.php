<?php
/**
 * OSOG.php - One-Stop Operations Guide
 * Quick access to common server operations and diagnostics
 */

// Security: Only allow access from localhost or specific IP
$allowed_ips = ['127.0.0.1', '::1', '3.108.161.67'];
if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
    die('Access denied');
}

// Get action from query parameter
$action = $_GET['action'] ?? 'menu';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSOG - Operations Guide</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #007bff;
        }
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .card-desc {
            font-size: 14px;
            color: #666;
        }
        .output {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin-top: 20px;
            white-space: pre-wrap;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        .status-ok {
            background: #d4edda;
            color: #155724;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ OSOG - One-Stop Operations Guide</h1>
        <p class="subtitle">Quick access to server operations and diagnostics for JobOne.in</p>

        <?php if ($action === 'menu'): ?>
            <div class="grid">
                <div class="card" onclick="location.href='?action=phpinfo'">
                    <div class="card-title">📋 PHP Info</div>
                    <div class="card-desc">View PHP configuration and loaded extensions</div>
                </div>

                <div class="card" onclick="location.href='?action=env'">
                    <div class="card-title">🔧 Environment</div>
                    <div class="card-desc">Check Laravel environment settings</div>
                </div>

                <div class="card" onclick="location.href='?action=cache'">
                    <div class="card-title">🧹 Clear Cache</div>
                    <div class="card-desc">Clear all Laravel caches</div>
                </div>

                <div class="card" onclick="location.href='?action=logs'">
                    <div class="card-title">📝 View Logs</div>
                    <div class="card-desc">View recent Laravel error logs</div>
                </div>

                <div class="card" onclick="location.href='?action=db'">
                    <div class="card-title">💾 Database</div>
                    <div class="card-desc">Check database connection and stats</div>
                </div>

                <div class="card" onclick="location.href='?action=routes'">
                    <div class="card-title">🛣️ Routes</div>
                    <div class="card-desc">List all registered routes</div>
                </div>

                <div class="card" onclick="location.href='?action=permissions'">
                    <div class="card-title">🔐 Permissions</div>
                    <div class="card-desc">Check file and folder permissions</div>
                </div>

                <div class="card" onclick="location.href='?action=git'">
                    <div class="card-title">📦 Git Status</div>
                    <div class="card-desc">View current git branch and commits</div>
                </div>
            </div>

        <?php elseif ($action === 'phpinfo'): ?>
            <h2>PHP Information</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
                <?php
                ob_start();
                phpinfo();
                $phpinfo = ob_get_clean();
                // Strip HTML and show text version
                echo strip_tags($phpinfo);
                ?>
            </div>

        <?php elseif ($action === 'env'): ?>
            <h2>Environment Configuration</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
echo "APP_NAME: " . (getenv('APP_NAME') ?: 'Not set') . "\n";
echo "APP_ENV: " . (getenv('APP_ENV') ?: 'Not set') . "\n";
echo "APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'Not set') . "\n";
echo "APP_URL: " . (getenv('APP_URL') ?: 'Not set') . "\n\n";

echo "DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'Not set') . "\n";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'Not set') . "\n";
echo "DB_DATABASE: " . (getenv('DB_DATABASE') ?: 'Not set') . "\n\n";

echo "PHP Version: " . PHP_VERSION . "\n";
echo "Laravel Path: " . __DIR__ . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
?>
            </div>

        <?php elseif ($action === 'cache'): ?>
            <h2>Clear Cache</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
$commands = [
    'php artisan view:clear',
    'php artisan cache:clear',
    'php artisan config:clear',
    'php artisan route:clear',
];

foreach ($commands as $cmd) {
    echo "Running: $cmd\n";
    exec($cmd . ' 2>&1', $output, $return);
    if ($return === 0) {
        echo "✅ Success\n\n";
    } else {
        echo "❌ Failed\n";
        echo implode("\n", $output) . "\n\n";
    }
}
?>
            </div>

        <?php elseif ($action === 'logs'): ?>
            <h2>Recent Laravel Logs</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
$logFile = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $lines = explode("\n", $logs);
    $recent = array_slice($lines, -100); // Last 100 lines
    echo implode("\n", $recent);
} else {
    echo "No log file found at: $logFile";
}
?>
            </div>

        <?php elseif ($action === 'db'): ?>
            <h2>Database Connection</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $db = DB::connection();
    echo "✅ Database connection successful\n\n";
    
    echo "Connection: " . config('database.default') . "\n";
    echo "Host: " . config('database.connections.mysql.host') . "\n";
    echo "Database: " . config('database.connections.mysql.database') . "\n\n";
    
    // Get table counts
    $tables = ['posts', 'categories', 'states', 'admins', 'authors'];
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "$table: $count records\n";
        } catch (Exception $e) {
            echo "$table: Error - " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Database connection failed\n";
    echo "Error: " . $e->getMessage();
}
?>
            </div>

        <?php elseif ($action === 'routes'): ?>
            <h2>Registered Routes</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
exec('php artisan route:list 2>&1', $output);
echo implode("\n", $output);
?>
            </div>

        <?php elseif ($action === 'permissions'): ?>
            <h2>File Permissions</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
$paths = [
    'storage',
    'storage/logs',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache',
];

foreach ($paths as $path) {
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $writable = is_writable($fullPath) ? '✅' : '❌';
        echo "$writable $path: $perms\n";
    } else {
        echo "❌ $path: Not found\n";
    }
}
?>
            </div>

        <?php elseif ($action === 'git'): ?>
            <h2>Git Status</h2>
            <a href="?action=menu" class="btn">← Back to Menu</a>
            <div class="output">
<?php
echo "Current Branch:\n";
exec('git branch --show-current 2>&1', $branch);
echo implode("\n", $branch) . "\n\n";

echo "Recent Commits:\n";
exec('git log --oneline -10 2>&1', $commits);
echo implode("\n", $commits) . "\n\n";

echo "Current Commit:\n";
exec('git rev-parse HEAD 2>&1', $hash);
echo implode("\n", $hash) . "\n\n";

echo "Git Status:\n";
exec('git status 2>&1', $status);
echo implode("\n", $status);
?>
            </div>

        <?php endif; ?>
    </div>
</body>
</html>
