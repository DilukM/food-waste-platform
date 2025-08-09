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
                    
                    // If this is a Neon connection, add the endpoint parameter
                    if (str_contains($config['host'] ?? '', 'neon.tech')) {
                        // Extract endpoint ID from host (everything before -pooler)
                        $host = $config['host'];
                        if (preg_match('/^([^.]+)/', $host, $matches)) {
                            $fullEndpoint = $matches[1];
                            // Remove -pooler suffix if present
                            $endpointId = str_replace('-pooler', '', $fullEndpoint);
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
