<?php
/**
 * Laravel Environment Debug Script
 * Tests if Laravel can read environment variables and bootstrap properly
 */

echo "<h1>🔍 Laravel Environment Debug</h1>";
echo "<style>body{font-family:Arial;} .success{color:green;} .error{color:red;} .warning{color:orange;}</style>";

echo "<h2>1. Basic Environment Variables</h2>";
echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
echo "<tr><th>Variable</th><th>Value</th><th>Status</th></tr>";

$envVars = [
    'APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_KEY', 'APP_URL',
    'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD',
    'SESSION_DRIVER', 'CACHE_STORE', 'QUEUE_CONNECTION', 'LOG_CHANNEL'
];

foreach ($envVars as $var) {
    $value = $_ENV[$var] ?? getenv($var) ?? 'NOT SET';
    $status = ($value !== 'NOT SET') ? '<span class="success">✅ SET</span>' : '<span class="error">❌ NOT SET</span>';
    $displayValue = ($var === 'DB_PASSWORD' || $var === 'APP_KEY') ? (($value !== 'NOT SET') ? '***HIDDEN***' : 'NOT SET') : $value;
    echo "<tr><td>$var</td><td>$displayValue</td><td>$status</td></tr>";
}
echo "</table>";

echo "<h2>2. Laravel Bootstrap Test</h2>";
try {
    // Check if Laravel files exist
    if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
        throw new Exception("Composer autoload file not found");
    }
    echo "<p class='success'>✅ Composer autoload found</p>";

    if (!file_exists(__DIR__ . '/bootstrap/app.php')) {
        throw new Exception("Laravel bootstrap file not found");
    }
    echo "<p class='success'>✅ Laravel bootstrap file found</p>";

    // Try to load Laravel
    require_once __DIR__ . '/vendor/autoload.php';
    echo "<p class='success'>✅ Composer autoload loaded</p>";

    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "<p class='success'>✅ Laravel app instance created</p>";

    // Bootstrap Laravel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "<p class='success'>✅ Laravel kernel bootstrapped</p>";

    // Test Laravel config
    echo "<h3>Laravel Configuration Test:</h3>";
    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<tr><th>Config Key</th><th>Value</th><th>Status</th></tr>";

    $configTests = [
        'app.name' => 'App Name',
        'app.env' => 'Environment',
        'app.debug' => 'Debug Mode',
        'app.key' => 'App Key',
        'app.url' => 'App URL',
        'database.default' => 'Default DB Connection',
        'database.connections.pgsql.host' => 'Database Host',
        'database.connections.pgsql.database' => 'Database Name',
        'session.driver' => 'Session Driver',
        'cache.default' => 'Cache Driver'
    ];

    foreach ($configTests as $key => $description) {
        try {
            $value = config($key);
            $status = ($value !== null) ? '<span class="success">✅ OK</span>' : '<span class="warning">⚠️ NULL</span>';
            $displayValue = (strpos($key, 'key') !== false && $value) ? '***HIDDEN***' : (string)$value;
            echo "<tr><td>$description ($key)</td><td>$displayValue</td><td>$status</td></tr>";
        } catch (Exception $e) {
            echo "<tr><td>$description ($key)</td><td>ERROR: " . $e->getMessage() . "</td><td><span class='error'>❌ FAILED</span></td></tr>";
        }
    }
    echo "</table>";

    // Test database connection
    echo "<h3>Database Connection Test:</h3>";
    try {
        $pdo = DB::connection()->getPdo();
        echo "<p class='success'>✅ Database connection successful</p>";
        
        // Test a simple query
        $result = DB::select('SELECT 1 as test');
        echo "<p class='success'>✅ Database query test successful</p>";
    } catch (Exception $e) {
        echo "<p class='error'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    }

    // Test Laravel cache
    echo "<h3>Laravel Cache Test:</h3>";
    try {
        Cache::put('test_key', 'test_value', 60);
        $retrieved = Cache::get('test_key');
        if ($retrieved === 'test_value') {
            echo "<p class='success'>✅ Cache system working</p>";
        } else {
            echo "<p class='warning'>⚠️ Cache put/get mismatch</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Cache system failed: " . $e->getMessage() . "</p>";
    }

    // Test Laravel session
    echo "<h3>Laravel Session Test:</h3>";
    try {
        // Start session for testing
        if (!session_id()) {
            session_start();
        }
        echo "<p class='success'>✅ Session system available</p>";
    } catch (Exception $e) {
        echo "<p class='error'>❌ Session system failed: " . $e->getMessage() . "</p>";
    }

} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel Bootstrap Failed: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p><pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>3. File System Test</h2>";
$directories = [
    '/storage/logs',
    '/storage/framework/cache',
    '/storage/framework/sessions',
    '/storage/framework/views',
    '/bootstrap/cache'
];

foreach ($directories as $dir) {
    $fullPath = __DIR__ . $dir;
    $exists = is_dir($fullPath);
    $writable = $exists ? is_writable($fullPath) : false;
    
    if ($exists && $writable) {
        echo "<p class='success'>✅ $dir - exists and writable</p>";
    } elseif ($exists) {
        echo "<p class='warning'>⚠️ $dir - exists but not writable</p>";
    } else {
        echo "<p class='error'>❌ $dir - does not exist</p>";
    }
}

echo "<h2>4. PHP Extensions Test</h2>";
$requiredExtensions = ['pdo', 'pdo_pgsql', 'zip', 'bcmath', 'json', 'mbstring', 'openssl'];
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? '<span class="success">✅ LOADED</span>' : '<span class="error">❌ MISSING</span>';
    echo "<p>$ext: $status</p>";
}

echo "<h2>5. Environment Loading Test</h2>";
echo "<p><strong>Current working directory:</strong> " . getcwd() . "</p>";
echo "<p><strong>Script directory:</strong> " . __DIR__ . "</p>";

// Check if .env file exists (it shouldn't in production, but let's verify)
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "<p class='warning'>⚠️ .env file found (should use environment variables in production)</p>";
} else {
    echo "<p class='success'>✅ No .env file found (using environment variables)</p>";
}

echo "<h2>6. Error Simulation Test</h2>";
echo "<p>Testing what happens when we try to access the main Laravel routes...</p>";

try {
    // Try to create a simple Laravel response
    if (class_exists('Illuminate\Http\Request') && function_exists('route')) {
        echo "<p class='success'>✅ Laravel HTTP classes available</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel HTTP test failed: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>📋 Summary</h2>";
echo "<p>If Laravel bootstrap failed above, that's likely causing your 500 error.</p>";
echo "<p>Common issues:</p>";
echo "<ul>";
echo "<li><strong>Missing APP_KEY:</strong> Laravel cannot function without this</li>";
echo "<li><strong>Database connection:</strong> Check DB credentials</li>";
echo "<li><strong>Storage permissions:</strong> Laravel needs to write to storage directories</li>";
echo "<li><strong>Missing extensions:</strong> Required PHP extensions not loaded</li>";
echo "</ul>";

echo "<p><strong>Generated at:</strong> " . date('Y-m-d H:i:s') . " UTC</p>";
?>
