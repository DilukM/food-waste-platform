<?php
/**
 * Startup Log Viewer
 * Shows Laravel startup logs from the Docker container
 */

echo "<h1>📋 Laravel Startup Logs</h1>";
echo "<style>body{font-family:Arial;} .log{background:#f5f5f5;padding:10px;border:1px solid #ddd;font-family:monospace;white-space:pre-wrap;} .error{color:red;} .success{color:green;} .warning{color:orange;}</style>";

echo "<h2>🔍 Startup Log</h2>";

$logFile = __DIR__ . '/../storage/logs/startup.log';

if (file_exists($logFile)) {
    echo "<div class='log'>";
    $logContent = file_get_contents($logFile);
    
    // Color code the log output
    $logContent = str_replace('❌ ERROR:', '<span class="error">❌ ERROR:</span>', $logContent);
    $logContent = str_replace('⚠️ WARNING:', '<span class="warning">⚠️ WARNING:</span>', $logContent);
    $logContent = str_replace('✅', '<span class="success">✅</span>', $logContent);
    
    echo htmlspecialchars($logContent, ENT_QUOTES, 'UTF-8');
    echo "</div>";
    
    echo "<p><strong>Log file size:</strong> " . filesize($logFile) . " bytes</p>";
    echo "<p><strong>Last modified:</strong> " . date('Y-m-d H:i:s', filemtime($logFile)) . "</p>";
} else {
    echo "<p class='error'>❌ Startup log file not found at: $logFile</p>";
    echo "<p>This means either:</p>";
    echo "<ul>";
    echo "<li>The startup script hasn't run yet</li>";
    echo "<li>There's a permission issue with the storage directory</li>";
    echo "<li>The Docker container isn't using the startup script</li>";
    echo "</ul>";
}

echo "<h2>📁 Storage Directory Check</h2>";
$storageDir = __DIR__ . '/../storage';
$logsDir = __DIR__ . '/../storage/logs';

if (is_dir($storageDir)) {
    echo "<p class='success'>✅ Storage directory exists</p>";
    echo "<p><strong>Permissions:</strong> " . substr(sprintf('%o', fileperms($storageDir)), -4) . "</p>";
    
    if (is_dir($logsDir)) {
        echo "<p class='success'>✅ Logs directory exists</p>";
        echo "<p><strong>Permissions:</strong> " . substr(sprintf('%o', fileperms($logsDir)), -4) . "</p>";
        
        // List log files
        $logFiles = glob($logsDir . '/*.log');
        if (!empty($logFiles)) {
            echo "<h3>📄 Available Log Files:</h3>";
            foreach ($logFiles as $file) {
                $filename = basename($file);
                $size = filesize($file);
                $modified = date('Y-m-d H:i:s', filemtime($file));
                echo "<p>📄 <strong>$filename</strong> - Size: $size bytes - Modified: $modified</p>";
            }
        } else {
            echo "<p class='warning'>⚠️ No log files found in logs directory</p>";
        }
    } else {
        echo "<p class='error'>❌ Logs directory does not exist</p>";
    }
} else {
    echo "<p class='error'>❌ Storage directory does not exist</p>";
}

echo "<h2>🔄 Laravel Log (if available)</h2>";
$laravelLog = __DIR__ . '/../storage/logs/laravel.log';

if (file_exists($laravelLog)) {
    echo "<p class='success'>✅ Laravel log found</p>";
    echo "<p><strong>Size:</strong> " . filesize($laravelLog) . " bytes</p>";
    
    // Show last 50 lines of Laravel log
    echo "<h3>📜 Last 50 lines of Laravel log:</h3>";
    echo "<div class='log'>";
    $lines = file($laravelLog);
    $lastLines = array_slice($lines, -50);
    
    foreach ($lastLines as $line) {
        $line = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
        
        // Color code log levels
        if (strpos($line, '[ERROR]') !== false || strpos($line, 'ERROR:') !== false) {
            $line = '<span class="error">' . $line . '</span>';
        } elseif (strpos($line, '[WARNING]') !== false || strpos($line, 'WARNING:') !== false) {
            $line = '<span class="warning">' . $line . '</span>';
        }
        
        echo $line;
    }
    echo "</div>";
} else {
    echo "<p class='warning'>⚠️ Laravel log file not found</p>";
}

echo "<hr>";
echo "<p><strong>🔄 Refresh this page to see updated logs</strong></p>";
echo "<p><a href='/env-check.php'>Check Environment Variables</a> | <a href='/laravel-debug.php'>Laravel Debug</a> | <a href='/debug.php'>System Debug</a></p>";
echo "<p><strong>Generated at:</strong> " . date('Y-m-d H:i:s') . " UTC</p>";
?>
