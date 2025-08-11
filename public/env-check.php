<?php
/**
 * Simple Environment Variables Check for Render Deployment
 * Focuses on identifying missing environment variables
 */

echo "<h1>🌐 Render Environment Variables Check</h1>";
echo "<style>body{font-family:Arial;} .success{color:green;} .error{color:red;} .warning{color:orange;} table{border-collapse:collapse;width:100%;} th,td{border:1px solid #ddd;padding:8px;}</style>";

echo "<h2>🔍 Environment Variables Status</h2>";

// Critical Laravel environment variables
$criticalVars = [
    'APP_NAME' => 'Application Name',
    'APP_ENV' => 'Environment (production/local)',
    'APP_DEBUG' => 'Debug Mode',
    'APP_KEY' => 'Laravel Application Key (CRITICAL)',
    'APP_URL' => 'Application URL',
];

$databaseVars = [
    'DB_CONNECTION' => 'Database Type',
    'DB_HOST' => 'Database Host',
    'DB_PORT' => 'Database Port',
    'DB_DATABASE' => 'Database Name',
    'DB_USERNAME' => 'Database Username',
    'DB_PASSWORD' => 'Database Password',
];

$optionalVars = [
    'SESSION_DRIVER' => 'Session Driver',
    'CACHE_STORE' => 'Cache Store',
    'QUEUE_CONNECTION' => 'Queue Connection',
    'LOG_CHANNEL' => 'Log Channel',
    'MAIL_MAILER' => 'Mail Driver',
];

function checkEnvironmentVariable($varName, $description, $isPassword = false) {
    // Try multiple ways to get environment variable
    $value = $_ENV[$varName] ?? getenv($varName) ?? $_SERVER[$varName] ?? null;
    
    $status = '';
    $displayValue = '';
    
    if ($value === null || $value === '') {
        $status = '<span class="error">❌ NOT SET</span>';
        $displayValue = 'NOT SET';
    } else {
        $status = '<span class="success">✅ SET</span>';
        $displayValue = $isPassword ? '***HIDDEN*** (length: ' . strlen($value) . ')' : htmlspecialchars($value);
    }
    
    return [$displayValue, $status];
}

echo "<h3>🚨 Critical Variables (Laravel won't work without these)</h3>";
echo "<table>";
echo "<tr><th>Variable</th><th>Description</th><th>Value</th><th>Status</th></tr>";

$criticalMissing = 0;
foreach ($criticalVars as $var => $desc) {
    [$value, $status] = checkEnvironmentVariable($var, $desc, $var === 'APP_KEY');
    if (strpos($status, 'NOT SET') !== false) $criticalMissing++;
    echo "<tr><td><strong>$var</strong></td><td>$desc</td><td>$value</td><td>$status</td></tr>";
}
echo "</table>";

echo "<h3>🗃️ Database Variables</h3>";
echo "<table>";
echo "<tr><th>Variable</th><th>Description</th><th>Value</th><th>Status</th></tr>";

$dbMissing = 0;
foreach ($databaseVars as $var => $desc) {
    [$value, $status] = checkEnvironmentVariable($var, $desc, $var === 'DB_PASSWORD');
    if (strpos($status, 'NOT SET') !== false) $dbMissing++;
    echo "<tr><td><strong>$var</strong></td><td>$desc</td><td>$value</td><td>$status</td></tr>";
}
echo "</table>";

echo "<h3>⚙️ Optional Variables</h3>";
echo "<table>";
echo "<tr><th>Variable</th><th>Description</th><th>Value</th><th>Status</th></tr>";

foreach ($optionalVars as $var => $desc) {
    [$value, $status] = checkEnvironmentVariable($var, $desc);
    echo "<tr><td>$var</td><td>$desc</td><td>$value</td><td>$status</td></tr>";
}
echo "</table>";

echo "<hr>";
echo "<h2>📋 Diagnosis</h2>";

if ($criticalMissing > 0) {
    echo "<div style='background:#ffe6e6;padding:15px;border-left:4px solid red;margin:10px 0;'>";
    echo "<h3 style='color:red;margin-top:0;'>🚨 CRITICAL ISSUE FOUND</h3>";
    echo "<p><strong>$criticalMissing critical environment variable(s) are missing!</strong></p>";
    echo "<p>Laravel <strong>CANNOT START</strong> without these variables. This is likely causing your 500 error.</p>";
    echo "</div>";
} else {
    echo "<div style='background:#e6ffe6;padding:15px;border-left:4px solid green;margin:10px 0;'>";
    echo "<h3 style='color:green;margin-top:0;'>✅ Critical Variables OK</h3>";
    echo "<p>All critical Laravel environment variables are set.</p>";
    echo "</div>";
}

if ($dbMissing > 0) {
    echo "<div style='background:#fff3cd;padding:15px;border-left:4px solid orange;margin:10px 0;'>";
    echo "<h3 style='color:orange;margin-top:0;'>⚠️ Database Configuration Issue</h3>";
    echo "<p><strong>$dbMissing database variable(s) are missing!</strong></p>";
    echo "<p>This will prevent Laravel from connecting to the database.</p>";
    echo "</div>";
}

echo "<h2>🔧 How to Fix in Render</h2>";
echo "<ol>";
echo "<li><strong>Go to your Render Dashboard</strong></li>";
echo "<li><strong>Select your web service</strong></li>";
echo "<li><strong>Go to 'Environment' tab</strong></li>";
echo "<li><strong>Add the missing variables listed above</strong></li>";
echo "<li><strong>Click 'Save Changes'</strong> - this will trigger a redeploy</li>";
echo "</ol>";

echo "<h3>🔑 Essential Variables for Render:</h3>";
echo "<pre style='background:#f5f5f5;padding:10px;'>";
echo "APP_NAME=Food Share\n";
echo "APP_ENV=production\n";
echo "APP_DEBUG=false\n";
echo "APP_KEY=base64:YOUR_32_CHARACTER_KEY_HERE\n";
echo "APP_URL=https://your-app-name.onrender.com\n";
echo "\n";
echo "DB_CONNECTION=pgsql\n";
echo "DB_HOST=your-db-host\n";
echo "DB_PORT=5432\n";
echo "DB_DATABASE=your-db-name\n";
echo "DB_USERNAME=your-db-user\n";
echo "DB_PASSWORD=your-db-password\n";
echo "\n";
echo "SESSION_DRIVER=file\n";
echo "CACHE_STORE=file\n";
echo "LOG_CHANNEL=stack\n";
echo "</pre>";

echo "<p><strong>💡 To generate APP_KEY:</strong> Run <code>php artisan key:generate --show</code> locally and copy the result</p>";

echo "<h2>🧪 Next Steps</h2>";
echo "<ol>";
echo "<li>Set all missing environment variables in Render</li>";
echo "<li>Wait for automatic redeploy</li>";
echo "<li>Test this page again: <a href='/laravel-debug.php'>/laravel-debug.php</a></li>";
echo "<li>Test your main site: <a href='/'>/</a></li>";
echo "</ol>";

echo "<p><strong>Generated at:</strong> " . date('Y-m-d H:i:s') . " UTC</p>";
echo "<p><strong>Server:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Unknown') . "</p>";
?>
