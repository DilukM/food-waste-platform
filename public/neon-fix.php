<?php
/**
 * Advanced Neon Connection Test
 * Tests multiple connection approaches to fix SNI/project name mismatch
 */

echo "<h1>🔧 Advanced Neon Connection Fix</h1>";
echo "<style>body{font-family:Arial;} .success{color:green;} .error{color:red;} .warning{color:orange;} .info{color:blue;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .method{border:1px solid #ddd;margin:10px 0;padding:15px;}</style>";

// Database configuration
$dbHost = 'ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech';
$dbPort = '5432';
$dbDatabase = 'neondb';
$dbUsername = 'neondb_owner';
$dbPassword = 'npg_ScyjL5f7vpBM';

echo "<h2>🎯 Testing Multiple Connection Methods</h2>";

// Method 1: Standard connection
echo "<div class='method'>";
echo "<h3>Method 1: Standard PostgreSQL Connection</h3>";
try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;sslmode=require";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30,
    ]);
    echo "<p class='success'>✅ Method 1 SUCCESS</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Method 1 FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// Method 2: Connection with options parameter
echo "<div class='method'>";
echo "<h3>Method 2: Connection with Options Parameter</h3>";
try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;sslmode=require;options='--application_name=FoodShare'";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30,
    ]);
    echo "<p class='success'>✅ Method 2 SUCCESS</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Method 2 FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// Method 3: Using direct endpoint (without pooler)
$directHost = str_replace('-pooler', '', $dbHost);
echo "<div class='method'>";
echo "<h3>Method 3: Direct Connection (without pooler)</h3>";
echo "<p><strong>Host:</strong> $directHost</p>";
try {
    $dsn = "pgsql:host=$directHost;port=$dbPort;dbname=$dbDatabase;sslmode=require";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30,
    ]);
    echo "<p class='success'>✅ Method 3 SUCCESS</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Method 3 FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// Method 4: Using full connection URL
echo "<div class='method'>";
echo "<h3>Method 4: Full PostgreSQL URL</h3>";
try {
    $url = "postgresql://$dbUsername:$dbPassword@$dbHost:$dbPort/$dbDatabase?sslmode=require";
    $dsn = "pgsql:$url";
    $pdo = new PDO($dsn);
    echo "<p class='success'>✅ Method 4 SUCCESS</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Method 4 FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// Method 5: With target_session_attrs
echo "<div class='method'>";
echo "<h3>Method 5: With Target Session Attributes</h3>";
try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;sslmode=require;target_session_attrs=read-write";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30,
    ]);
    echo "<p class='success'>✅ Method 5 SUCCESS</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Method 5 FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

// Method 6: Laravel-style with environment override
echo "<div class='method'>";
echo "<h3>Method 6: Laravel Database Test</h3>";
try {
    // Temporarily override environment
    $_ENV['CACHE_DRIVER'] = 'file';
    $_ENV['SESSION_DRIVER'] = 'file';
    
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
        
        if (file_exists(__DIR__ . '/../bootstrap/app.php')) {
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            // Force config refresh
            config(['cache.default' => 'file']);
            config(['session.driver' => 'file']);
            
            // Test connection
            $pdo = DB::connection()->getPdo();
            echo "<p class='success'>✅ Method 6 (Laravel) SUCCESS</p>";
            
            // Test query
            $result = DB::select('SELECT current_database() as db, version() as version');
            echo "<p class='info'>Database: " . $result[0]->db . "</p>";
            echo "<p class='info'>Version: " . substr($result[0]->version, 0, 50) . "...</p>";
            
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Method 6 (Laravel) FAILED: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<h2>🔧 Recommended Actions</h2>";
echo "<div style='background:#e6f3ff;padding:15px;border-left:4px solid blue;margin:10px 0;'>";
echo "<h3 style='color:blue;margin-top:0;'>If any method above succeeded:</h3>";
echo "<ol>";
echo "<li>Note which method worked</li>";
echo "<li>Update your Render environment variables accordingly</li>";
echo "<li>If Method 3 worked, use the direct endpoint (without -pooler)</li>";
echo "<li>If Method 6 worked, ensure CACHE_DRIVER=file and SESSION_DRIVER=file</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background:#ffe6e6;padding:15px;border-left:4px solid red;margin:10px 0;'>";
echo "<h3 style='color:red;margin-top:0;'>If all methods failed:</h3>";
echo "<ol>";
echo "<li>Check your Neon project is active and not suspended</li>";
echo "<li>Verify the database credentials in your Neon dashboard</li>";
echo "<li>Try regenerating the database password</li>";
echo "<li>Contact Neon support about the SNI/project name issue</li>";
echo "</ol>";
echo "</div>";

echo "<h2>📋 Environment Variables for Render</h2>";
echo "<p>Based on the test results, set these in your Render dashboard:</p>";
echo "<pre>";
echo "# If Method 1, 2, or 6 worked:\n";
echo "DB_HOST=ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech\n\n";
echo "# If Method 3 worked:\n";
echo "DB_HOST=ep-small-leaf-aevbx3za.c-2.us-east-2.aws.neon.tech\n\n";
echo "# Always set these:\n";
echo "DB_CONNECTION=pgsql\n";
echo "DB_PORT=5432\n";
echo "DB_DATABASE=neondb\n";
echo "DB_USERNAME=neondb_owner\n";
echo "DB_PASSWORD=npg_ScyjL5f7vpBM\n";
echo "CACHE_DRIVER=file\n";
echo "SESSION_DRIVER=file\n";
echo "</pre>";

echo "<hr>";
echo "<p><strong>Generated at:</strong> " . date('Y-m-d H:i:s') . " UTC</p>";
echo "<p><a href='/env-check.php'>Environment Check</a> | <a href='/db-test.php'>Simple DB Test</a> | <a href='/' target='_blank'>Test Homepage</a></p>";
?>
