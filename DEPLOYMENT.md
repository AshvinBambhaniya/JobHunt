# Deployment Guide: Reminder System & Push Notifications

This document outlines the steps required to deploy the new Reminder System and Push Notification features to the production environment.

## 1. Server Configuration

### A. Scheduler Setup (CRITICAL)
The reminder system relies on Laravel's scheduler to send notifications and generate auto-follow-ups. You must ensure the cron job is active.

1.  **SSH into your server**.
2.  Open the crontab:
    ```bash
    crontab -e
    ```
3.  Add the following line (if not already present):
    ```bash
    * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
    ```

### B. HTTPS Requirement
The Browser Push Notification API (`new Notification()`) requires a secure context.
*   **Requirement**: The application must be served over **HTTPS**.
*   **Verify**: Ensure your SSL certificate (Let's Encrypt, etc.) is valid.

## 2. Deployment Command Sequence

Run the following commands during your deployment pipeline or manually on the server:

```bash
# 1. Pull the latest code
git pull origin main

# 2. Install dependencies
composer install --optimize-autoloader --no-dev

# 3. Run Migrations (creates 'reminders' and 'notifications' tables)
php artisan migrate --force

# 4. Clear and Cache Configuration
# This ensures the new 'Asia/Kolkata' timezone setting is applied
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 3. Configuration Checks

### A. Timezone
The application is configured to use **Asia/Kolkata** (IST) in `config/app.php`.
*   *Verification*: `php artisan tinker --execute="echo config('app.timezone');"` should output `Asia/Kolkata`.

### B. Queue Configuration
Check your `.env` file for `QUEUE_CONNECTION`.
*   **If `sync`**: No extra action needed.
*   **If `database`/`redis`/`sqs`**: Ensure your queue worker is running:
    ```bash
    php artisan queue:restart
    # Ensure your supervisor config is running: php artisan queue:work
    ```

## 4. Verification

After deployment, verify the system is working:
1.  Log in to the application.
2.  Create a reminder for 2 minutes from now.
3.  Wait for the scheduled time.
4.  Verify you receive a **Browser Notification** (if permissions granted) and the **Notification Bell** badge updates.
