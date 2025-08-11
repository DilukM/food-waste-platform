#!/bin/bash

echo "🚀 Starting Food Share Application..."

# Check if we have required environment variables
if [ -z "$APP_KEY" ]; then
    echo "❌ APP_KEY not set! Laravel will not work properly."
fi

if [ -z "$DB_HOST" ]; then
    echo "❌ Database configuration missing!"
else
    echo "✅ Database host configured: $DB_HOST"
fi

# Try to run migrations if database is available
echo "🔄 Attempting database setup..."
php artisan migrate --force 2>/dev/null || echo "⚠️ Migration failed - database might not be accessible"

# Clear and optimize Laravel
echo "🔧 Optimizing Laravel..."
php artisan config:clear 2>/dev/null || echo "⚠️ Config clear failed"
php artisan cache:clear 2>/dev/null || echo "⚠️ Cache clear failed"

# Only cache if we have proper environment
if [ "$APP_ENV" = "production" ] && [ -n "$APP_KEY" ]; then
    php artisan config:cache 2>/dev/null || echo "⚠️ Config cache failed"
    php artisan route:cache 2>/dev/null || echo "⚠️ Route cache failed"
    php artisan view:cache 2>/dev/null || echo "⚠️ View cache failed"
fi

# Set proper permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "⚠️ Permission setting failed"
chmod -R 775 storage bootstrap/cache 2>/dev/null || echo "⚠️ Chmod failed"

echo "✅ Startup completed!"

# Start Apache
exec apache2-foreground
