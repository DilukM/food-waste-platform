# 🔍 Render Error 500 Debug Steps

## Current Status: Deployment Successful, Laravel Error 500

Your Apache server is running correctly, but Laravel is throwing errors. Here's how to debug:

## 🛠️ Immediate Debug Steps

### 1. **Check Environment Variables**
Visit: `https://food-waste-platform.onrender.com/debug.php`

This will show you:
- PHP Version
- Environment settings
- App Key status
- Database host configuration

### 2. **Check PHP Info**
Visit: `https://food-waste-platform.onrender.com/info.php`

This will show all PHP configuration and loaded extensions.

### 3. **Most Likely Issues**

#### **Missing Environment Variables in Render**
Go to Render Dashboard → Your Service → Environment and add:

```bash
APP_NAME="Food Share"
APP_ENV=production
APP_DEBUG=true
APP_KEY=base64:lwR6uKyk79sEXIXkzq3/6EjRyPF11jiE4MMZtt+XrOY=
APP_URL=https://food-waste-platform.onrender.com

DB_CONNECTION=pgsql
DB_HOST=ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=npg_ScyjL5f7vpBM

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
LOG_LEVEL=debug
```

**⚠️ Important: Set `APP_DEBUG=true` temporarily to see the actual error.**

## 🔧 Updated Files

I've updated your deployment with:

1. **Fixed Dockerfile** - Added startup script and debugging
2. **Startup Script** - Handles Laravel setup properly
3. **Debug Endpoints** - `/debug.php` and `/info.php` for troubleshooting
4. **Apache ServerName Fix** - Removes the warning messages

## 📋 Action Plan

### **Step 1: Add Environment Variables**
- Go to Render Dashboard
- Add ALL the environment variables listed above
- **Important**: Set `APP_DEBUG=true` first

### **Step 2: Redeploy**
```bash
git add .
git commit -m "Add debugging and startup script"
git push origin main
```

### **Step 3: Test Debug Endpoints**
- Visit `/debug.php` to check environment
- Visit `/info.php` to check PHP
- Check main site for detailed error message

### **Step 4: Check Render Logs**
Look for specific Laravel error messages in the deployment logs.

## 🚨 Common Laravel Error 500 Causes

1. **Missing APP_KEY** ← Most likely cause
2. **Database connection failure**
3. **Missing storage permissions**
4. **Composer autoload issues**
5. **Missing required PHP extensions**

## 💡 Quick Test

After setting environment variables, the most likely fix is the APP_KEY. Laravel cannot function without it.

If `/debug.php` shows "App Key: NOT SET", that's your main issue!

## 📞 Next Steps

1. **Set environment variables** in Render (especially APP_KEY)
2. **Enable APP_DEBUG=true** temporarily
3. **Redeploy** with updated files
4. **Visit debug endpoints** to identify specific issue
5. **Check Laravel error message** with debug enabled

The deployment infrastructure is working - we just need to fix the Laravel configuration! 🌱
