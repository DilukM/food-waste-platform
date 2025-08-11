<?php

// Deployment Health Check Script
echo "=== Food Share Deployment Health Check ===\n\n";

// Check 1: PHP Version
echo "1. PHP Version: " . PHP_VERSION . "\n";

// Check 2: Environment
echo "2. Environment: " . (getenv('APP_ENV') ?: 'NOT SET') . "\n";

// Check 3: App Key
$appKey = getenv('APP_KEY');
echo "3. App Key: " . ($appKey ? '✅ SET' : '❌ NOT SET') . "\n";

// Check 4: Database Connection
echo "4. Database Connection: ";
try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT') ?: 5432;
    $database = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');
    
    if ($host && $database && $username && $password) {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password);
        echo "✅ CONNECTED\n";
    } else {
        echo "❌ MISSING CREDENTIALS\n";
    }
} catch (Exception $e) {
    echo "❌ FAILED: " . $e->getMessage() . "\n";
}

// Check 5: Storage Permissions
echo "5. Storage Permissions: ";
$storageWritable = is_writable(__DIR__ . '/../storage');
echo $storageWritable ? "✅ WRITABLE" : "❌ NOT WRITABLE";
echo "\n";

// Check 6: Required Extensions
echo "6. Required PHP Extensions:\n";
$extensions = ['pdo', 'pdo_pgsql', 'zip', 'bcmath'];
foreach ($extensions as $ext) {
    echo "   - $ext: " . (extension_loaded($ext) ? '✅' : '❌') . "\n";
}

// Check 7: Environment Variables
echo "7. Key Environment Variables:\n";
$envVars = ['APP_NAME', 'APP_URL', 'DB_HOST', 'DB_DATABASE', 'MAIL_MAILER'];
foreach ($envVars as $var) {
    $value = getenv($var);
    echo "   - $var: " . ($value ? '✅ SET' : '❌ NOT SET') . "\n";
}

// Check 8: Laravel Specific
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "8. Laravel Setup:\n";
    echo "   - Composer Dependencies: ✅ INSTALLED\n";
    
    try {
        require_once __DIR__ . '/../vendor/autoload.php';
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        echo "   - Laravel Bootstrap: ✅ SUCCESS\n";
        
        // Test config
        echo "   - Config Access: " . (config('app.name') ? '✅ WORKING' : '❌ FAILED') . "\n";
        
    } catch (Exception $e) {
        echo "   - Laravel Bootstrap: ❌ FAILED - " . $e->getMessage() . "\n";
    }
} else {
    echo "8. Laravel Setup: ❌ Composer dependencies not installed\n";
}

echo "\n=== Health Check Complete ===\n";

// Quick fixes
echo "\n=== Quick Fixes ===\n";
echo "If you see ❌ errors above:\n";
echo "1. Set missing environment variables in Render dashboard\n";
echo "2. Ensure database credentials are correct\n";
echo "3. Check storage directory permissions\n";
echo "4. Run 'composer install' if dependencies missing\n";
echo "5. Generate APP_KEY with 'php artisan key:generate'\n";
