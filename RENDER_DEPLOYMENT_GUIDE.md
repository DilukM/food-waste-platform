# 🚀 Render Deployment Troubleshooting Guide

## 🔍 Common Error 500 Causes on Render

### 1. **Environment Variables Missing**
Render doesn't automatically use your `.env` file. You need to set environment variables in Render dashboard.

### 2. **Database Connection Issues**
The PostgreSQL connection might not be properly configured for the Render environment.

### 3. **Storage Permissions**
Laravel storage directories might not have proper write permissions.

### 4. **Missing APP_KEY**
Laravel needs a proper application key to encrypt data.

### 5. **Caching Issues**
Pre-cached configurations might not work in the deployment environment.

## ✅ Step-by-Step Fix

### **Step 1: Update Dockerfile**
Replace your current `Dockerfile` with the `Dockerfile.render` version for better Render compatibility.

### **Step 2: Set Environment Variables in Render**
Go to your Render service dashboard and add these environment variables:

```bash
# Application
APP_NAME="Food Share"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:lwR6uKyk79sEXIXkzq3/6EjRyPF11jiE4MMZtt+XrOY=
APP_URL=https://your-app-name.onrender.com

# Database (your existing Neon database)
DB_CONNECTION=pgsql
DB_HOST=ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=npg_ScyjL5f7vpBM

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

# Email (your Gmail settings)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=dilukedu@gmail.com
MAIL_PASSWORD=iqawsepqkgsvwvyc
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="dilukedu@gmail.com"
MAIL_FROM_NAME="Food Share"

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=info
```

### **Step 3: Fix Dockerfile Issues**
Create a new Dockerfile optimized for Render:

```dockerfile
FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath gd \
    && a2enmod rewrite headers

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy application
COPY . .

# Set permissions and prepare Laravel
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Configure Apache
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
```

### **Step 4: Database Migration**
Add a script to run migrations on deployment. Create `bin/deploy.sh`:

```bash
#!/bin/bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Step 5: Debug Deployment**
Check Render logs for specific error messages:
1. Go to your Render service dashboard
2. Click on "Logs" tab
3. Look for specific error messages

## 🐛 Common Error Patterns

### **Error: "No application encryption key"**
**Solution**: Set `APP_KEY` in Render environment variables

### **Error: "Database connection failed"**
**Solution**: Verify database credentials in Render environment variables

### **Error: "Permission denied"**
**Solution**: Update Dockerfile to set proper permissions

### **Error: "Class not found"**
**Solution**: Run `composer dump-autoload --optimize` in Dockerfile

## 🔧 Quick Fixes

### **Option 1: Minimal Dockerfile (Recommended for Render)**
```dockerfile
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
CMD php artisan serve --host=0.0.0.0 --port=80
```

### **Option 2: Enable Debug Mode Temporarily**
In Render environment variables, set:
```
APP_DEBUG=true
LOG_LEVEL=debug
```
This will show detailed error messages.

## 📋 Deployment Checklist

- [ ] ✅ Environment variables set in Render dashboard
- [ ] ✅ Database connection tested
- [ ] ✅ APP_KEY generated and set
- [ ] ✅ Storage permissions configured
- [ ] ✅ Dockerfile optimized for Render
- [ ] ✅ Composer dependencies installed correctly
- [ ] ✅ Laravel caches cleared/rebuilt

## 🆘 Emergency Debug Commands

If you can access the Render shell:
```bash
# Check environment
php artisan env

# Test database connection
php artisan tinker
DB::connection()->getPdo();

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Check logs
tail -f storage/logs/laravel.log
```

## 📞 Next Steps

1. **Replace Dockerfile** with the optimized version
2. **Set all environment variables** in Render dashboard
3. **Redeploy** your application
4. **Check logs** for specific error messages
5. **Test database connection** first

Most Error 500 issues on Render are due to missing environment variables or database connection problems!
