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
        h1 { color: #333; margin-bottom: 10px; font-size: 28px; }
        h2 { color: #333; margin-bottom: 15px; font-size: 22px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 14px; }
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
            text-decoration: none;
            display: block;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #007bff;
        }
        .card-title { font-size: 18px; font-weight: 600; color: #333; margin-bottom: 8px; }
        .card-desc { font-size: 14px; color: #666; }
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
            max-height: 600px;
            overflow-y: auto;
        }
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
        .btn:hover { background: #0056b3; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ OSOG - One-Stop Operations Guide</h1>
        <p class="subtitle">Quick access to server operations and diagnostics for JobOne.in</p>

        @if ($action === 'menu')
            <div class="grid">
                <a href="{{ url('/osog?action=phpinfo') }}" class="card">
                    <div class="card-title">📋 PHP Info</div>
                    <div class="card-desc">View PHP configuration</div>
                </a>

                <a href="{{ url('/osog?action=env') }}" class="card">
                    <div class="card-title">🔧 Environment</div>
                    <div class="card-desc">Check Laravel settings</div>
                </a>

                <a href="{{ url('/osog?action=cache') }}" class="card">
                    <div class="card-title">🧹 Clear Cache</div>
                    <div class="card-desc">Clear all Laravel caches</div>
                </a>

                <a href="{{ url('/osog?action=logs') }}" class="card">
                    <div class="card-title">📝 View Logs</div>
                    <div class="card-desc">View recent error logs</div>
                </a>

                <a href="{{ url('/osog?action=db') }}" class="card">
                    <div class="card-title">💾 Database</div>
                    <div class="card-desc">Check database connection</div>
                </a>

                <a href="{{ url('/osog?action=git') }}" class="card">
                    <div class="card-title">📦 Git Status</div>
                    <div class="card-desc">View git branch and commits</div>
                </a>

                <a href="{{ url('/osog?action=routes') }}" class="card">
                    <div class="card-title">🛣️ Routes</div>
                    <div class="card-desc">List all routes</div>
                </a>

                <a href="{{ url('/osog?action=permissions') }}" class="card">
                    <div class="card-title">🔐 Permissions</div>
                    <div class="card-desc">Check file permissions</div>
                </a>
            </div>

        @elseif ($action === 'phpinfo')
            <h2>PHP Information</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">{{ 'PHP Version: ' . PHP_VERSION }}
Server: {{ php_uname() }}
Extensions: {{ implode(', ', get_loaded_extensions()) }}</div>

        @elseif ($action === 'env')
            <h2>Environment Configuration</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">APP_NAME: {{ config('app.name') }}
APP_ENV: {{ config('app.env') }}
APP_DEBUG: {{ config('app.debug') ? 'true' : 'false' }}
APP_URL: {{ config('app.url') }}

DB_CONNECTION: {{ config('database.default') }}
DB_HOST: {{ config('database.connections.mysql.host') }}
DB_DATABASE: {{ config('database.connections.mysql.database') }}

PHP Version: {{ PHP_VERSION }}
Laravel Version: {{ app()->version() }}</div>

        @elseif ($action === 'cache')
            <h2>Clear Cache</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">@php
try {
    Artisan::call('view:clear');
    echo "✅ View cache cleared\n";
    Artisan::call('cache:clear');
    echo "✅ Application cache cleared\n";
    Artisan::call('config:clear');
    echo "✅ Config cache cleared\n";
    Artisan::call('route:clear');
    echo "✅ Route cache cleared\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
@endphp</div>

        @elseif ($action === 'logs')
            <h2>Recent Laravel Logs</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">@php
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $lines = explode("\n", $logs);
    $recent = array_slice($lines, -100);
    echo implode("\n", $recent);
} else {
    echo "No log file found";
}
@endphp</div>

        @elseif ($action === 'db')
            <h2>Database Connection</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">@php
try {
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n\n";
    echo "Connection: " . config('database.default') . "\n";
    echo "Host: " . config('database.connections.mysql.host') . "\n";
    echo "Database: " . config('database.connections.mysql.database') . "\n\n";
    
    $tables = ['posts', 'categories', 'states', 'admins', 'authors'];
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "$table: $count records\n";
        } catch (\Exception $e) {
            echo "$table: Error\n";
        }
    }
} catch (\Exception $e) {
    echo "❌ Database connection failed\n";
    echo "Error: " . $e->getMessage();
}
@endphp</div>

        @elseif ($action === 'git')
            <h2>Git Status</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">@php
exec('git branch --show-current 2>&1', $branch);
echo "Current Branch: " . implode("\n", $branch) . "\n\n";

exec('git log --oneline -10 2>&1', $commits);
echo "Recent Commits:\n" . implode("\n", $commits) . "\n\n";

exec('git rev-parse HEAD 2>&1', $hash);
echo "Current Commit: " . implode("\n", $hash);
@endphp</div>

        @elseif ($action === 'routes')
            <h2>Registered Routes</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">@php
$routes = Route::getRoutes();
foreach ($routes as $route) {
    echo $route->methods()[0] . " " . $route->uri() . "\n";
}
@endphp</div>

        @elseif ($action === 'permissions')
            <h2>File Permissions</h2>
            <a href="{{ url('/osog') }}" class="btn">← Back to Menu</a>
            <div class="output">@php
$paths = [
    'storage',
    'storage/logs',
    'storage/framework',
    'storage/framework/cache',
    'bootstrap/cache',
];

foreach ($paths as $path) {
    $fullPath = base_path($path);
    if (file_exists($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $writable = is_writable($fullPath) ? '✅' : '❌';
        echo "$writable $path: $perms\n";
    } else {
        echo "❌ $path: Not found\n";
    }
}
@endphp</div>

        @endif
    </div>
</body>
</html>
