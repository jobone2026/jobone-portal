<?php return array (
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\resources\\views',
    ),
    'compiled' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\framework\\views',
  ),
  'api' => 
  array (
    'token' => 'jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a',
  ),
  'app' => 
  array (
    'name' => 'Government Job Portal',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8000',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:6dzKuHW+NOO8RM3lbcc+BEcEkFmp9uLMoR/P+DRjfWs=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Benchmark' => 'Illuminate\\Support\\Benchmark',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'Uri' => 'Illuminate\\Support\\Uri',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
    'domain_state_map' => 'karnatakajob.online:karnataka,www.karnatakajob.online:karnataka',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'admin' => 
      array (
        'driver' => 'session',
        'provider' => 'admins',
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
      'admins' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Admin',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\framework/cache/data',
        'lock_path' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'government-job-portal-cache-',
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'govt_job_portal',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
        'transaction_mode' => 'DEFERRED',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'govt_job_portal',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'govt_job_portal',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'govt_job_portal',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'govt_job_portal',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'government-job-portal-database-',
        'persistent' => false,
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\app/private',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\app/public',
        'url' => 'http://localhost:8000/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
    ),
    'links' => 
    array (
      'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\public\\storage' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\app/public',
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'handler_with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'formatter' => NULL,
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'log',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '2525',
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'local_domain' => 'localhost',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
        'retry_after' => 60,
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
        'retry_after' => 60,
      ),
    ),
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'Government Job Portal',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'notifications' => 
  array (
    'telegram' => 
    array (
      'bot_token' => '',
      'channel_id' => '',
    ),
    'whatsapp' => 
    array (
      'access_token' => '',
      'phone_number_id' => '',
      'channel_id' => '',
    ),
    'firebase' => 
    array (
      'credentials' => 'storage/app/firebase/jobone-firebase-adminsdk.json',
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
      'background' => 
      array (
        'driver' => 'background',
      ),
    ),
    'batching' => 
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost:8000',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'token_prefix' => '',
    'middleware' => 
    array (
      'authenticate_session' => 'Laravel\\Sanctum\\Http\\Middleware\\AuthenticateSession',
      'encrypt_cookies' => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
      'validate_csrf_token' => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
    ),
  ),
  'seo_keywords' => 
  array (
    'tier_1' => 
    array (
      0 => 
      array (
        'keyword' => 'sarkari naukri 2026',
        'monthly_searches' => 450000,
        'difficulty' => 85,
        'intent' => 'informational',
        'target_page' => 'home',
      ),
      1 => 
      array (
        'keyword' => 'ssc cgl 2026 notification',
        'monthly_searches' => 350000,
        'difficulty' => 75,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      2 => 
      array (
        'keyword' => 'ssc chsl 2026',
        'monthly_searches' => 280000,
        'difficulty' => 72,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      3 => 
      array (
        'keyword' => 'ssc mts 2026',
        'monthly_searches' => 220000,
        'difficulty' => 68,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      4 => 
      array (
        'keyword' => 'ssc gd 2026',
        'monthly_searches' => 200000,
        'difficulty' => 70,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      5 => 
      array (
        'keyword' => 'upsc cse 2026',
        'monthly_searches' => 320000,
        'difficulty' => 78,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      6 => 
      array (
        'keyword' => 'upsc nda 2026',
        'monthly_searches' => 180000,
        'difficulty' => 65,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      7 => 
      array (
        'keyword' => 'upsc cds 2026',
        'monthly_searches' => 150000,
        'difficulty' => 63,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      8 => 
      array (
        'keyword' => 'railway recruitment 2026',
        'monthly_searches' => 400000,
        'difficulty' => 80,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      9 => 
      array (
        'keyword' => 'rrb ntpc 2026',
        'monthly_searches' => 290000,
        'difficulty' => 74,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      10 => 
      array (
        'keyword' => 'rrb group d 2026',
        'monthly_searches' => 270000,
        'difficulty' => 73,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      11 => 
      array (
        'keyword' => 'railway alp 2026',
        'monthly_searches' => 160000,
        'difficulty' => 66,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      12 => 
      array (
        'keyword' => 'ibps po 2026',
        'monthly_searches' => 310000,
        'difficulty' => 76,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      13 => 
      array (
        'keyword' => 'ibps clerk 2026',
        'monthly_searches' => 260000,
        'difficulty' => 71,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      14 => 
      array (
        'keyword' => 'sbi po 2026',
        'monthly_searches' => 280000,
        'difficulty' => 74,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      15 => 
      array (
        'keyword' => 'sbi clerk 2026',
        'monthly_searches' => 240000,
        'difficulty' => 69,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      16 => 
      array (
        'keyword' => 'rbi grade b 2026',
        'monthly_searches' => 140000,
        'difficulty' => 64,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      17 => 
      array (
        'keyword' => 'uppsc 2026',
        'monthly_searches' => 250000,
        'difficulty' => 72,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      18 => 
      array (
        'keyword' => 'bpsc 2026',
        'monthly_searches' => 180000,
        'difficulty' => 67,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      19 => 
      array (
        'keyword' => 'mppsc 2026',
        'monthly_searches' => 160000,
        'difficulty' => 65,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      20 => 
      array (
        'keyword' => 'rpsc 2026',
        'monthly_searches' => 150000,
        'difficulty' => 64,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      21 => 
      array (
        'keyword' => 'up police 2026',
        'monthly_searches' => 300000,
        'difficulty' => 75,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      22 => 
      array (
        'keyword' => 'delhi police 2026',
        'monthly_searches' => 220000,
        'difficulty' => 70,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      23 => 
      array (
        'keyword' => 'bihar police 2026',
        'monthly_searches' => 190000,
        'difficulty' => 68,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      24 => 
      array (
        'keyword' => 'ctet 2026',
        'monthly_searches' => 280000,
        'difficulty' => 73,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      25 => 
      array (
        'keyword' => 'kvs recruitment 2026',
        'monthly_searches' => 200000,
        'difficulty' => 69,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      26 => 
      array (
        'keyword' => 'dsssb 2026',
        'monthly_searches' => 170000,
        'difficulty' => 66,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      27 => 
      array (
        'keyword' => 'indian army recruitment 2026',
        'monthly_searches' => 260000,
        'difficulty' => 71,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      28 => 
      array (
        'keyword' => 'indian navy 2026',
        'monthly_searches' => 180000,
        'difficulty' => 67,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      29 => 
      array (
        'keyword' => 'indian air force 2026',
        'monthly_searches' => 170000,
        'difficulty' => 66,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
    ),
    'tier_2' => 
    array (
      0 => 
      array (
        'keyword' => 'ssc cgl 2026 notification pdf download',
        'monthly_searches' => 85000,
        'difficulty' => 55,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      1 => 
      array (
        'keyword' => 'ssc cgl 2026 eligibility criteria',
        'monthly_searches' => 72000,
        'difficulty' => 52,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      2 => 
      array (
        'keyword' => 'ssc cgl 2026 exam date',
        'monthly_searches' => 95000,
        'difficulty' => 58,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      3 => 
      array (
        'keyword' => 'ssc chsl 2026 last date',
        'monthly_searches' => 68000,
        'difficulty' => 50,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      4 => 
      array (
        'keyword' => 'ssc mts 2026 syllabus pdf',
        'monthly_searches' => 62000,
        'difficulty' => 48,
        'intent' => 'transactional',
        'target_page' => 'syllabus',
      ),
      5 => 
      array (
        'keyword' => 'ssc gd admit card 2026',
        'monthly_searches' => 78000,
        'difficulty' => 54,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      6 => 
      array (
        'keyword' => 'ssc cgl result 2026 cut off marks',
        'monthly_searches' => 82000,
        'difficulty' => 56,
        'intent' => 'informational',
        'target_page' => 'result',
      ),
      7 => 
      array (
        'keyword' => 'upsc cse 2026 notification date',
        'monthly_searches' => 75000,
        'difficulty' => 53,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      8 => 
      array (
        'keyword' => 'upsc prelims 2026 exam date',
        'monthly_searches' => 88000,
        'difficulty' => 57,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      9 => 
      array (
        'keyword' => 'upsc nda 2026 application form',
        'monthly_searches' => 64000,
        'difficulty' => 49,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      10 => 
      array (
        'keyword' => 'upsc cds 2026 syllabus',
        'monthly_searches' => 58000,
        'difficulty' => 47,
        'intent' => 'informational',
        'target_page' => 'syllabus',
      ),
      11 => 
      array (
        'keyword' => 'rrb ntpc 2026 notification pdf',
        'monthly_searches' => 92000,
        'difficulty' => 59,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      12 => 
      array (
        'keyword' => 'rrb group d 2026 exam date',
        'monthly_searches' => 86000,
        'difficulty' => 56,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      13 => 
      array (
        'keyword' => 'railway alp 2026 vacancy details',
        'monthly_searches' => 54000,
        'difficulty' => 46,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      14 => 
      array (
        'keyword' => 'rrb ntpc admit card 2026 download',
        'monthly_searches' => 78000,
        'difficulty' => 54,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      15 => 
      array (
        'keyword' => 'railway group d result 2026',
        'monthly_searches' => 82000,
        'difficulty' => 55,
        'intent' => 'informational',
        'target_page' => 'result',
      ),
      16 => 
      array (
        'keyword' => 'ibps po 2026 notification pdf download',
        'monthly_searches' => 76000,
        'difficulty' => 53,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      17 => 
      array (
        'keyword' => 'ibps clerk 2026 exam date',
        'monthly_searches' => 68000,
        'difficulty' => 51,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      18 => 
      array (
        'keyword' => 'sbi po 2026 eligibility',
        'monthly_searches' => 72000,
        'difficulty' => 52,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      19 => 
      array (
        'keyword' => 'sbi clerk 2026 syllabus pdf',
        'monthly_searches' => 64000,
        'difficulty' => 49,
        'intent' => 'transactional',
        'target_page' => 'syllabus',
      ),
      20 => 
      array (
        'keyword' => 'rbi grade b 2026 notification',
        'monthly_searches' => 52000,
        'difficulty' => 45,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      21 => 
      array (
        'keyword' => 'uppsc pcs 2026 notification',
        'monthly_searches' => 65000,
        'difficulty' => 50,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      22 => 
      array (
        'keyword' => 'bpsc 68th notification 2026',
        'monthly_searches' => 58000,
        'difficulty' => 47,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      23 => 
      array (
        'keyword' => 'mppsc prelims 2026 exam date',
        'monthly_searches' => 54000,
        'difficulty' => 46,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      24 => 
      array (
        'keyword' => 'rpsc ras 2026 notification',
        'monthly_searches' => 52000,
        'difficulty' => 45,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      25 => 
      array (
        'keyword' => 'up police constable 2026 last date',
        'monthly_searches' => 88000,
        'difficulty' => 57,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      26 => 
      array (
        'keyword' => 'delhi police constable 2026 notification',
        'monthly_searches' => 72000,
        'difficulty' => 52,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      27 => 
      array (
        'keyword' => 'bihar police si 2026 vacancy',
        'monthly_searches' => 62000,
        'difficulty' => 48,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      28 => 
      array (
        'keyword' => 'up police admit card 2026',
        'monthly_searches' => 78000,
        'difficulty' => 54,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      29 => 
      array (
        'keyword' => 'delhi police result 2026',
        'monthly_searches' => 68000,
        'difficulty' => 51,
        'intent' => 'informational',
        'target_page' => 'result',
      ),
      30 => 
      array (
        'keyword' => 'ctet 2026 notification pdf',
        'monthly_searches' => 74000,
        'difficulty' => 53,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      31 => 
      array (
        'keyword' => 'kvs pgt 2026 vacancy',
        'monthly_searches' => 58000,
        'difficulty' => 47,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      32 => 
      array (
        'keyword' => 'dsssb tgt 2026 notification',
        'monthly_searches' => 52000,
        'difficulty' => 45,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      33 => 
      array (
        'keyword' => 'ctet admit card 2026 download',
        'monthly_searches' => 68000,
        'difficulty' => 51,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      34 => 
      array (
        'keyword' => 'kvs result 2026',
        'monthly_searches' => 62000,
        'difficulty' => 48,
        'intent' => 'informational',
        'target_page' => 'result',
      ),
      35 => 
      array (
        'keyword' => 'indian army agniveer 2026 notification',
        'monthly_searches' => 82000,
        'difficulty' => 55,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      36 => 
      array (
        'keyword' => 'indian navy ssr 2026 recruitment',
        'monthly_searches' => 58000,
        'difficulty' => 47,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      37 => 
      array (
        'keyword' => 'air force group x 2026',
        'monthly_searches' => 54000,
        'difficulty' => 46,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      38 => 
      array (
        'keyword' => 'indian army admit card 2026',
        'monthly_searches' => 68000,
        'difficulty' => 51,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      39 => 
      array (
        'keyword' => 'government jobs 2026 12th pass',
        'monthly_searches' => 95000,
        'difficulty' => 58,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      40 => 
      array (
        'keyword' => 'latest govt jobs 2026 graduate',
        'monthly_searches' => 88000,
        'difficulty' => 57,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      41 => 
      array (
        'keyword' => 'central government jobs 2026',
        'monthly_searches' => 78000,
        'difficulty' => 54,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      42 => 
      array (
        'keyword' => 'state government jobs 2026',
        'monthly_searches' => 72000,
        'difficulty' => 52,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      43 => 
      array (
        'keyword' => 'upcoming govt exams 2026',
        'monthly_searches' => 85000,
        'difficulty' => 56,
        'intent' => 'informational',
        'target_page' => 'home',
      ),
      44 => 
      array (
        'keyword' => 'govt job admit card 2026',
        'monthly_searches' => 92000,
        'difficulty' => 59,
        'intent' => 'transactional',
        'target_page' => 'admit_cards',
      ),
      45 => 
      array (
        'keyword' => 'sarkari result 2026 latest',
        'monthly_searches' => 98000,
        'difficulty' => 60,
        'intent' => 'informational',
        'target_page' => 'results',
      ),
      46 => 
      array (
        'keyword' => 'govt exam syllabus pdf 2026',
        'monthly_searches' => 68000,
        'difficulty' => 51,
        'intent' => 'transactional',
        'target_page' => 'syllabus',
      ),
    ),
    'tier_3' => 
    array (
      0 => 
      array (
        'keyword' => 'how to apply for ssc cgl 2026',
        'monthly_searches' => 45000,
        'difficulty' => 38,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      1 => 
      array (
        'keyword' => 'what is the age limit for upsc 2026',
        'monthly_searches' => 42000,
        'difficulty' => 36,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      2 => 
      array (
        'keyword' => 'when will rrb ntpc 2026 notification release',
        'monthly_searches' => 38000,
        'difficulty' => 34,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      3 => 
      array (
        'keyword' => 'how to download ssc admit card 2026',
        'monthly_searches' => 52000,
        'difficulty' => 40,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      4 => 
      array (
        'keyword' => 'what is the syllabus for ibps po 2026',
        'monthly_searches' => 36000,
        'difficulty' => 33,
        'intent' => 'informational',
        'target_page' => 'syllabus',
      ),
      5 => 
      array (
        'keyword' => 'how to check railway result 2026',
        'monthly_searches' => 48000,
        'difficulty' => 39,
        'intent' => 'transactional',
        'target_page' => 'result',
      ),
      6 => 
      array (
        'keyword' => 'what is the eligibility for ssc chsl 2026',
        'monthly_searches' => 34000,
        'difficulty' => 32,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      7 => 
      array (
        'keyword' => 'how many posts in ssc cgl 2026',
        'monthly_searches' => 32000,
        'difficulty' => 31,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      8 => 
      array (
        'keyword' => 'when is upsc prelims 2026 exam',
        'monthly_searches' => 44000,
        'difficulty' => 37,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      9 => 
      array (
        'keyword' => 'how to prepare for railway group d 2026',
        'monthly_searches' => 40000,
        'difficulty' => 35,
        'intent' => 'informational',
        'target_page' => 'blog',
      ),
      10 => 
      array (
        'keyword' => 'what is the salary in sbi po 2026',
        'monthly_searches' => 38000,
        'difficulty' => 34,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      11 => 
      array (
        'keyword' => 'how to fill up police form 2026',
        'monthly_searches' => 36000,
        'difficulty' => 33,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      12 => 
      array (
        'keyword' => 'what is the exam pattern for ctet 2026',
        'monthly_searches' => 34000,
        'difficulty' => 32,
        'intent' => 'informational',
        'target_page' => 'syllabus',
      ),
      13 => 
      array (
        'keyword' => 'how to join indian army 2026',
        'monthly_searches' => 46000,
        'difficulty' => 38,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      14 => 
      array (
        'keyword' => 'what is the cut off for ssc cgl 2026',
        'monthly_searches' => 42000,
        'difficulty' => 36,
        'intent' => 'informational',
        'target_page' => 'result',
      ),
      15 => 
      array (
        'keyword' => 'how to download railway admit card 2026',
        'monthly_searches' => 48000,
        'difficulty' => 39,
        'intent' => 'transactional',
        'target_page' => 'admit_card',
      ),
      16 => 
      array (
        'keyword' => 'when will ibps clerk result 2026 come',
        'monthly_searches' => 38000,
        'difficulty' => 34,
        'intent' => 'informational',
        'target_page' => 'result',
      ),
      17 => 
      array (
        'keyword' => 'what is the last date for upsc 2026',
        'monthly_searches' => 40000,
        'difficulty' => 35,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      18 => 
      array (
        'keyword' => 'how to apply for state psc 2026',
        'monthly_searches' => 36000,
        'difficulty' => 33,
        'intent' => 'transactional',
        'target_page' => 'post',
      ),
      19 => 
      array (
        'keyword' => 'what documents required for govt job 2026',
        'monthly_searches' => 34000,
        'difficulty' => 32,
        'intent' => 'informational',
        'target_page' => 'blog',
      ),
      20 => 
      array (
        'keyword' => 'how to check sarkari result 2026',
        'monthly_searches' => 52000,
        'difficulty' => 40,
        'intent' => 'transactional',
        'target_page' => 'results',
      ),
      21 => 
      array (
        'keyword' => 'what is the selection process for ssc 2026',
        'monthly_searches' => 32000,
        'difficulty' => 31,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      22 => 
      array (
        'keyword' => 'how many attempts in upsc 2026',
        'monthly_searches' => 30000,
        'difficulty' => 30,
        'intent' => 'informational',
        'target_page' => 'blog',
      ),
      23 => 
      array (
        'keyword' => 'when will railway recruitment 2026 start',
        'monthly_searches' => 44000,
        'difficulty' => 37,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      24 => 
      array (
        'keyword' => 'what is the fee for ssc exam 2026',
        'monthly_searches' => 28000,
        'difficulty' => 29,
        'intent' => 'informational',
        'target_page' => 'post',
      ),
      25 => 
      array (
        'keyword' => 'how to download govt job notification 2026',
        'monthly_searches' => 42000,
        'difficulty' => 36,
        'intent' => 'transactional',
        'target_page' => 'jobs',
      ),
      26 => 
      array (
        'keyword' => 'what is the qualification for banking jobs 2026',
        'monthly_searches' => 36000,
        'difficulty' => 33,
        'intent' => 'informational',
        'target_page' => 'jobs',
      ),
      27 => 
      array (
        'keyword' => 'how to prepare for police exam 2026',
        'monthly_searches' => 40000,
        'difficulty' => 35,
        'intent' => 'informational',
        'target_page' => 'blog',
      ),
      28 => 
      array (
        'keyword' => 'what is the physical test for army 2026',
        'monthly_searches' => 34000,
        'difficulty' => 32,
        'intent' => 'informational',
        'target_page' => 'blog',
      ),
      29 => 
      array (
        'keyword' => 'how to get govt job after 12th 2026',
        'monthly_searches' => 48000,
        'difficulty' => 39,
        'intent' => 'informational',
        'target_page' => 'blog',
      ),
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'key' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\xampp\\htdocs\\job\\govt-job-portal-new\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'government-job-portal-session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'state_keywords' => 
  array (
    'andhra_pradesh' => 
    array (
      0 => 'appsc group 1 2026',
      1 => 'ap police recruitment 2026',
      2 => 'andhra pradesh govt jobs 2026',
      3 => 'appsc notification 2026',
      4 => 'ap grama sachivalayam 2026',
    ),
    'arunachal_pradesh' => 
    array (
      0 => 'arunachal pradesh psc 2026',
      1 => 'appsc arunachal 2026',
      2 => 'arunachal govt jobs 2026',
      3 => 'arunachal police recruitment 2026',
      4 => 'arunachal pradesh sarkari naukri 2026',
    ),
    'assam' => 
    array (
      0 => 'apsc 2026',
      1 => 'assam police recruitment 2026',
      2 => 'assam govt jobs 2026',
      3 => 'apsc cce 2026',
      4 => 'assam sarkari naukri 2026',
    ),
    'bihar' => 
    array (
      0 => 'bpsc 2026',
      1 => 'bihar police 2026',
      2 => 'bihar sarkari naukri 2026',
      3 => 'bpsc 69th notification 2026',
      4 => 'bihar govt jobs 2026',
    ),
    'chhattisgarh' => 
    array (
      0 => 'cgpsc 2026',
      1 => 'chhattisgarh police 2026',
      2 => 'cg vyapam 2026',
      3 => 'chhattisgarh govt jobs 2026',
      4 => 'cgpsc state service 2026',
    ),
    'goa' => 
    array (
      0 => 'goa psc 2026',
      1 => 'goa govt jobs 2026',
      2 => 'goa police recruitment 2026',
      3 => 'gpsc notification 2026',
      4 => 'goa sarkari naukri 2026',
    ),
    'gujarat' => 
    array (
      0 => 'gpsc 2026',
      1 => 'gujarat police 2026',
      2 => 'gujarat govt jobs 2026',
      3 => 'gpsc class 1-2 2026',
      4 => 'gujarat sarkari naukri 2026',
    ),
    'haryana' => 
    array (
      0 => 'hpsc 2026',
      1 => 'haryana police 2026',
      2 => 'hssc 2026',
      3 => 'haryana govt jobs 2026',
      4 => 'hpsc hcs 2026',
    ),
    'himachal_pradesh' => 
    array (
      0 => 'hppsc 2026',
      1 => 'himachal police 2026',
      2 => 'hp govt jobs 2026',
      3 => 'hpsssb 2026',
      4 => 'himachal pradesh sarkari naukri 2026',
    ),
    'jharkhand' => 
    array (
      0 => 'jpsc 2026',
      1 => 'jharkhand police 2026',
      2 => 'jssc 2026',
      3 => 'jharkhand govt jobs 2026',
      4 => 'jpsc civil judge 2026',
    ),
    'karnataka' => 
    array (
      0 => 'kpsc 2026',
      1 => 'karnataka police 2026',
      2 => 'kpsc gazetted probationers 2026',
      3 => 'karnataka govt jobs 2026',
      4 => 'kpsc fda sda 2026',
    ),
    'kerala' => 
    array (
      0 => 'kerala psc 2026',
      1 => 'kerala police 2026',
      2 => 'kerala govt jobs 2026',
      3 => 'kpsc ldc 2026',
      4 => 'kerala sarkari naukri 2026',
    ),
    'madhya_pradesh' => 
    array (
      0 => 'mppsc 2026',
      1 => 'mp police 2026',
      2 => 'mp govt jobs 2026',
      3 => 'mppsc state service 2026',
      4 => 'mp vyapam 2026',
    ),
    'maharashtra' => 
    array (
      0 => 'mpsc 2026',
      1 => 'maharashtra police 2026',
      2 => 'mpsc rajyaseva 2026',
      3 => 'maharashtra govt jobs 2026',
      4 => 'mpsc psi 2026',
    ),
    'manipur' => 
    array (
      0 => 'manipur psc 2026',
      1 => 'manipur police 2026',
      2 => 'manipur govt jobs 2026',
      3 => 'mpsc manipur 2026',
      4 => 'manipur sarkari naukri 2026',
    ),
    'meghalaya' => 
    array (
      0 => 'meghalaya psc 2026',
      1 => 'meghalaya police 2026',
      2 => 'mpsc meghalaya 2026',
      3 => 'meghalaya govt jobs 2026',
      4 => 'meghalaya sarkari naukri 2026',
    ),
    'mizoram' => 
    array (
      0 => 'mizoram psc 2026',
      1 => 'mizoram police 2026',
      2 => 'mpsc mizoram 2026',
      3 => 'mizoram govt jobs 2026',
      4 => 'mizoram sarkari naukri 2026',
    ),
    'nagaland' => 
    array (
      0 => 'npsc 2026',
      1 => 'nagaland police 2026',
      2 => 'nagaland psc 2026',
      3 => 'nagaland govt jobs 2026',
      4 => 'nagaland sarkari naukri 2026',
    ),
    'odisha' => 
    array (
      0 => 'opsc 2026',
      1 => 'odisha police 2026',
      2 => 'osssc 2026',
      3 => 'odisha govt jobs 2026',
      4 => 'opsc ocs 2026',
    ),
    'punjab' => 
    array (
      0 => 'ppsc 2026',
      1 => 'punjab police 2026',
      2 => 'psssb 2026',
      3 => 'punjab govt jobs 2026',
      4 => 'ppsc civil judge 2026',
    ),
    'rajasthan' => 
    array (
      0 => 'rpsc 2026',
      1 => 'rajasthan police 2026',
      2 => 'rpsc ras 2026',
      3 => 'rajasthan govt jobs 2026',
      4 => 'rsmssb 2026',
    ),
    'sikkim' => 
    array (
      0 => 'spsc 2026',
      1 => 'sikkim police 2026',
      2 => 'sikkim psc 2026',
      3 => 'sikkim govt jobs 2026',
      4 => 'sikkim sarkari naukri 2026',
    ),
    'tamil_nadu' => 
    array (
      0 => 'tnpsc 2026',
      1 => 'tamil nadu police 2026',
      2 => 'tnpsc group 1 2026',
      3 => 'tamil nadu govt jobs 2026',
      4 => 'tnpsc group 4 2026',
    ),
    'telangana' => 
    array (
      0 => 'tspsc 2026',
      1 => 'telangana police 2026',
      2 => 'tspsc group 1 2026',
      3 => 'telangana govt jobs 2026',
      4 => 'tspsc group 2 2026',
    ),
    'tripura' => 
    array (
      0 => 'tpsc 2026',
      1 => 'tripura police 2026',
      2 => 'tripura psc 2026',
      3 => 'tripura govt jobs 2026',
      4 => 'tripura sarkari naukri 2026',
    ),
    'uttar_pradesh' => 
    array (
      0 => 'uppsc 2026',
      1 => 'up police 2026',
      2 => 'uppsc pcs 2026',
      3 => 'up govt jobs 2026',
      4 => 'upsssc 2026',
    ),
    'uttarakhand' => 
    array (
      0 => 'ukpsc 2026',
      1 => 'uttarakhand police 2026',
      2 => 'uksssc 2026',
      3 => 'uttarakhand govt jobs 2026',
      4 => 'ukpsc pre 2026',
    ),
    'west_bengal' => 
    array (
      0 => 'wbpsc 2026',
      1 => 'west bengal police 2026',
      2 => 'wbpsc clerkship 2026',
      3 => 'west bengal govt jobs 2026',
      4 => 'wbssc 2026',
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
    'trust_project' => 'always',
  ),
);
