<?php

namespace App\Providers;

use Illuminate\Database\Connectors\PostgresConnector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;

class NeonDatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('db.connector.pgsql', function () {
            return new class extends PostgresConnector {
                protected function getDsn(array $config)
                {
                    // Get the base DSN
                    $dsn = parent::getDsn($config);
                    
                    // For Neon connections, add endpoint parameter for SNI support
                    if (str_contains($config['host'] ?? '', 'neon.tech')) {
                        // Extract endpoint ID from host (first part before first dot)
                        $host = $config['host'];
                        if (preg_match('/^([^.]+)/', $host, $matches)) {
                            $endpointId = $matches[1];
                            $dsn .= ";options=endpoint=$endpointId";
                        }
                    }
                    
                    return $dsn;
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
