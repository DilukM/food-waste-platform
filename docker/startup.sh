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
echo "🔧 Setting up Laravel application..."

# Set proper permissions
echo "📁 Setting storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create a startup log
LOG_FILE="/var/www/html/storage/logs/startup.log"
echo "$(date): Starting Laravel setup..." > "$LOG_FILE"

# Check critical environment variables
echo "🔍 Checking environment variables..."
if [ -z "$APP_KEY" ]; then
    echo "❌ ERROR: APP_KEY not set!" | tee -a "$LOG_FILE"
    echo "Laravel will not start without APP_KEY" | tee -a "$LOG_FILE"
else
    echo "✅ APP_KEY is set" | tee -a "$LOG_FILE"
fi

if [ -z "$DB_HOST" ]; then
    echo "⚠️ WARNING: DB_HOST not set!" | tee -a "$LOG_FILE"
else
    echo "✅ DB_HOST is set: $DB_HOST" | tee -a "$LOG_FILE"
fi

# Clear and cache Laravel configuration
echo "⚙️ Optimizing Laravel..."
echo "$(date): Clearing Laravel caches..." >> "$LOG_FILE"

# Set cache driver to file temporarily to avoid database dependency during startup
export CACHE_DRIVER=file
export SESSION_DRIVER=file

php artisan config:clear 2>&1 | tee -a "$LOG_FILE" || echo "⚠️ Config clear failed (may be expected)"
php artisan cache:clear 2>&1 | tee -a "$LOG_FILE" || echo "⚠️ Cache clear failed (may be expected)"
php artisan view:clear 2>&1 | tee -a "$LOG_FILE" || echo "⚠️ View clear failed (may be expected)"

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
