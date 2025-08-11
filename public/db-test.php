<?php
/**
 * Neon Database Connection Tester
 * Specifically designed to debug Neon PostgreSQL connection issues
 */

echo "<h1>🗃️ Neon Database Connection Test</h1>";
echo "<style>body{font-family:Arial;} .success{color:green;} .error{color:red;} .warning{color:orange;} .info{color:blue;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;}</style>";

// Get database configuration from environment
$dbHost = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'NOT SET';
$dbPort = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? '5432';
$dbDatabase = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?? 'NOT SET';
$dbUsername = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?? 'NOT SET';
$dbPassword = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? 'NOT SET';

echo "<h2>📋 Database Configuration</h2>";
echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
echo "<tr><th>Setting</th><th>Value</th><th>Status</th></tr>";
echo "<tr><td>DB_HOST</td><td>" . htmlspecialchars($dbHost) . "</td><td>" . (($dbHost !== 'NOT SET') ? '<span class="success">✅ SET</span>' : '<span class="error">❌ NOT SET</span>') . "</td></tr>";
echo "<tr><td>DB_PORT</td><td>$dbPort</td><td><span class='success'>✅</span></td></tr>";
echo "<tr><td>DB_DATABASE</td><td>" . htmlspecialchars($dbDatabase) . "</td><td>" . (($dbDatabase !== 'NOT SET') ? '<span class="success">✅ SET</span>' : '<span class="error">❌ NOT SET</span>') . "</td></tr>";
echo "<tr><td>DB_USERNAME</td><td>" . htmlspecialchars($dbUsername) . "</td><td>" . (($dbUsername !== 'NOT SET') ? '<span class="success">✅ SET</span>' : '<span class="error">❌ NOT SET</span>') . "</td></tr>";
echo "<tr><td>DB_PASSWORD</td><td>" . (($dbPassword !== 'NOT SET') ? '***SET*** (length: ' . strlen($dbPassword) . ')' : 'NOT SET') . "</td><td>" . (($dbPassword !== 'NOT SET') ? '<span class="success">✅ SET</span>' : '<span class="error">❌ NOT SET</span>') . "</td></tr>";
echo "</table>";

if ($dbHost === 'NOT SET' || $dbDatabase === 'NOT SET' || $dbUsername === 'NOT SET' || $dbPassword === 'NOT SET') {
    echo "<div style='background:#ffe6e6;padding:15px;border-left:4px solid red;margin:10px 0;'>";
    echo "<h3 style='color:red;margin-top:0;'>🚨 Missing Database Configuration</h3>";
    echo "<p>Cannot test database connection - missing required environment variables.</p>";
    echo "</div>";
    exit;
}

echo "<h2>🔍 Neon Connection Analysis</h2>";

// Check if this looks like a Neon connection
$isNeon = strpos($dbHost, 'neon.tech') !== false;
if ($isNeon) {
    echo "<p class='success'>✅ Detected Neon database connection</p>";
    
    // Extract project information from Neon hostname
    $hostParts = explode('.', $dbHost);
    if (count($hostParts) > 0) {
        $endpoint = $hostParts[0];
        echo "<p><strong>Neon Endpoint:</strong> $endpoint</p>";
        
        // Check for pooler vs direct connection
        if (strpos($endpoint, 'pooler') !== false) {
            echo "<p class='info'>ℹ️ Using connection pooler (recommended for production)</p>";
            $projectFromHost = str_replace('-pooler', '', $endpoint);
        } else {
            echo "<p class='warning'>⚠️ Using direct connection (not recommended for production)</p>";
            $projectFromHost = $endpoint;
        }
        
        echo "<p><strong>Project ID from hostname:</strong> $projectFromHost</p>";
    }
} else {
    echo "<p class='warning'>⚠️ This doesn't appear to be a Neon database</p>";
}

echo "<h2>🧪 Connection Tests</h2>";

// Test 1: Basic PDO connection
echo "<h3>Test 1: Basic PDO Connection</h3>";
try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;sslmode=require";
    echo "<p><strong>DSN:</strong> $dsn</p>";
    
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 30,
    ]);
    
    echo "<p class='success'>✅ Basic PDO connection successful</p>";
    
    // Test query
    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "<p class='success'>✅ Database query successful</p>";
    echo "<p><strong>PostgreSQL Version:</strong> " . htmlspecialchars($version) . "</p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Basic PDO connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 2: Connection with application_name
echo "<h3>Test 2: Connection with Application Name</h3>";
try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;sslmode=require;application_name=FoodShare";
    echo "<p><strong>DSN with app name:</strong> $dsn</p>";
    
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 30,
    ]);
    
    echo "<p class='success'>✅ Connection with application name successful</p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Connection with application name failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 3: Laravel-style connection
echo "<h3>Test 3: Laravel Database Connection</h3>";
try {
    // Try to load Laravel
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
        
        if (file_exists(__DIR__ . '/../bootstrap/app.php')) {
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            // Test Laravel DB connection
            $pdo = DB::connection()->getPdo();
            echo "<p class='success'>✅ Laravel database connection successful</p>";
            
            // Test a simple query
            $result = DB::select('SELECT current_database() as db, current_user as user');
            echo "<p class='success'>✅ Laravel database query successful</p>";
            echo "<p><strong>Connected to database:</strong> " . $result[0]->db . "</p>";
            echo "<p><strong>Connected as user:</strong> " . $result[0]->user . "</p>";
            
        } else {
            echo "<p class='error'>❌ Laravel bootstrap file not found</p>";
        }
    } else {
        echo "<p class='error'>❌ Laravel vendor/autoload.php not found</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Laravel database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "<h2>🔧 Neon-Specific Recommendations</h2>";

if ($isNeon) {
    echo "<div style='background:#e6f3ff;padding:15px;border-left:4px solid blue;margin:10px 0;'>";
    echo "<h3 style='color:blue;margin-top:0;'>💡 Neon Database Tips</h3>";
    echo "<ul>";
    echo "<li><strong>Use the pooler connection string</strong> for production (ends with -pooler)</li>";
    echo "<li><strong>Ensure SSL is enabled</strong> (sslmode=require)</li>";
    echo "<li><strong>Check your Neon project is not suspended</strong></li>";
    echo "<li><strong>Verify the database name matches exactly</strong></li>";
    echo "<li><strong>Make sure your IP/region is not blocked</strong></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h3>🔗 Correct Neon Connection Format:</h3>";
    echo "<pre>";
    echo "DB_CONNECTION=pgsql\n";
    echo "DB_HOST=your-endpoint-pooler.region.aws.neon.tech\n";
    echo "DB_PORT=5432\n";
    echo "DB_DATABASE=your-database-name\n";
    echo "DB_USERNAME=your-username\n";
    echo "DB_PASSWORD=your-password\n";
    echo "</pre>";
}

echo "<hr>";
echo "<p><strong>Generated at:</strong> " . date('Y-m-d H:i:s') . " UTC</p>";
echo "<p><a href='/env-check.php'>Environment Check</a> | <a href='/logs.php'>View Logs</a> | <a href='/debug.php'>System Debug</a></p>";
?>
