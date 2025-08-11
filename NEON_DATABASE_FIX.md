# 🔧 Neon Database Connection Fix

## 🚨 The Problem
Your deployment logs show this error:
```
ERROR: Inconsistent project name inferred from SNI ('ep-small-leaf-aevbx3za-pooler') and project option ('ep-small-leaf-aevbx3za')
```

This is a **Neon PostgreSQL connection configuration issue**.

## 🎯 The Solution

### Step 1: Get the Correct Neon Connection String

1. **Go to your Neon Dashboard**: https://console.neon.tech/
2. **Select your project**
3. **Go to "Connection Details"**
4. **Copy the "Pooled connection" string** (recommended for production)

The connection string should look like:
```
postgresql://username:password@ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech/dbname?sslmode=require
```

### Step 2: Extract Individual Components

From the connection string above, extract:

- **Host**: `ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech`
- **Database**: `dbname` (your actual database name)
- **Username**: `username` (your actual username)
- **Password**: `password` (your actual password)
- **Port**: `5432` (standard PostgreSQL port)

### Step 3: Set Environment Variables in Render

Go to your Render service → **Environment** tab and set:

```
DB_CONNECTION=pgsql
DB_HOST=ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech
DB_PORT=5432
DB_DATABASE=your_actual_database_name
DB_USERNAME=your_actual_username
DB_PASSWORD=your_actual_password
```

**⚠️ Important**: Make sure the `DB_HOST` includes `-pooler` in the hostname!

### Step 4: Additional Required Environment Variables

Also set these in Render:

```
APP_NAME=Food Share
APP_ENV=production
APP_DEBUG=false
APP_URL=https://food-waste-platform.onrender.com
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

CACHE_DRIVER=file
SESSION_DRIVER=file
LOG_CHANNEL=stack
```

### Step 5: Generate APP_KEY

Run this locally and copy the result:
```bash
php artisan key:generate --show
```

## 🧪 Testing After Changes

1. **Save environment variables** in Render (this triggers automatic redeploy)
2. **Wait for deployment to complete**
3. **Test the database connection**: https://food-waste-platform.onrender.com/db-test.php
4. **Check environment variables**: https://food-waste-platform.onrender.com/env-check.php
5. **Test your main site**: https://food-waste-platform.onrender.com/

## 🔍 Common Neon Issues

### Issue 1: Wrong Host Format
❌ **Wrong**: `ep-small-leaf-aevbx3za.c-2.us-east-2.aws.neon.tech`
✅ **Correct**: `ep-small-leaf-aevbx3za-pooler.c-2.us-east-2.aws.neon.tech`

### Issue 2: Database Name Mismatch
- Make sure `DB_DATABASE` matches exactly what's in your Neon project
- It's usually your project name or `main`

### Issue 3: User Permissions
- Ensure your Neon user has proper permissions
- Try using the default database owner user

### Issue 4: Project Suspended
- Check if your Neon project is active
- Free tier projects can be suspended

## 📋 Checklist

- [ ] Got correct connection string from Neon dashboard
- [ ] Set DB_HOST with `-pooler` suffix
- [ ] Set correct DB_DATABASE name
- [ ] Set DB_USERNAME and DB_PASSWORD
- [ ] Generated and set APP_KEY
- [ ] Set CACHE_DRIVER=file
- [ ] Saved changes in Render (triggers redeploy)
- [ ] Tested /db-test.php endpoint
- [ ] Confirmed main site works

## 🆘 If Still Not Working

1. **Check Neon project status** in dashboard
2. **Verify database exists** and user has access
3. **Try direct connection** (remove `-pooler` temporarily)
4. **Check Neon logs** for connection attempts
5. **Contact Neon support** if project issues persist

---

**The key fix**: Use the `-pooler` hostname and ensure all environment variables are correctly set in Render.
