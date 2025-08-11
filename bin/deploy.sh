#!/bin/bash

echo "🚀 Starting Food Share deployment..."

# Run database migrations
echo "📦 Running database migrations..."
php artisan migrate --force

# Clear and cache configurations
echo "🔧 Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if it doesn't exist
echo "🔗 Creating storage link..."
php artisan storage:link

echo "✅ Deployment completed successfully!"
