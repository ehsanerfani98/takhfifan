# Deployment Guide

## Overview

This document provides comprehensive deployment instructions for the Takhfifan platform across different environments, including production, staging, and development setups.

## Prerequisites

### Server Requirements

**Minimum Requirements:**
- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Redis 6.0+ (recommended for caching and queues)
- Composer 2.0+
- Node.js 16+ and npm/yarn

**Recommended Server Stack:**
- **Web Server**: Nginx 1.18+ or Apache 2.4+
- **PHP-FPM**: PHP 8.2+ with FPM
- **Database**: MySQL 8.0+ or MariaDB 10.6+
- **Cache**: Redis 7.0+
- **Queue**: Redis or database queues

### Required PHP Extensions

```bash
# Essential extensions
php8.2-bcmath
php8.2-curl
php8.2-gd
php8.2-mbstring
php8.2-mysql
php8.2-xml
php8.2-zip
php8.2-fpm
php8.2-redis
```

## Environment Setup

### Production Environment Variables

Create or update your `.env` file with production values:

```env
APP_NAME=Takhfifan
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Generate a secure key
APP_KEY=base64:your_generated_key_here

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=takhfifan_production
DB_USERNAME=secure_username
DB_PASSWORD=secure_password

# Cache and Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis Configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="Takhfifan"

# Real-time Configuration
BROADCAST_DRIVER=reverb
REVERB_APP_ID=takhfifan
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST="0.0.0.0"
REVERB_PORT=8080
REVERB_SCHEME=https

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

# Firebase Configuration (for push notifications)
FIREBASE_CREDENTIALS=/path/to/firebase-service-account.json

# Payment Gateway (ZarinPal)
ZARINPAL_MERCHANT_ID=your-merchant-id
ZARINPAL_SANDBOX=false

# Security
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
```

## Server Configuration

### Nginx Configuration

Create an Nginx configuration file at `/etc/nginx/sites-available/takhfifan`:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    
    root /var/www/takhfifan/public;
    index index.php index.html index.htm;
    
    # SSL Configuration
    ssl_certificate /etc/ssl/certs/your-domain.com.crt;
    ssl_certificate_key /etc/ssl/private/your-domain.com.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
    
    # Laravel Specific Configuration
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Security
        fastcgi_hide_header X-Powered-By;
    }
    
    # Deny access to .htaccess and other sensitive files
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~ /\.ht {
        deny all;
    }
    
    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|txt)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # WebSocket proxy for Reverb
    location /ws {
        proxy_pass http://127.0.0.1:8080;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/takhfifan /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### PHP-FPM Configuration

Update PHP-FPM pool configuration at `/etc/php/8.2/fpm/pool.d/takhfifan.conf`:

```ini
[takhfifan]
user = www-data
group = www-data
listen = /var/run/php/php8.2-fpm-takhfifan.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 2
pm.max_spare_servers = 8
pm.max_requests = 500
php_admin_value[upload_max_filesize] = 50M
php_admin_value[post_max_size] = 50M
php_admin_value[max_execution_time] = 300
php_admin_value[memory_limit] = 256M
```

## Deployment Process

### Manual Deployment

1. **Prepare the Server**
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx mysql-server redis-server php8.2-fpm php8.2-common \
php8.2-mysql php8.2-xml php8.2-curl php8.2-gd php8.2-mbstring \
php8.2-zip php8.2-bcmath php8.2-redis composer nodejs npm

# Create application directory
sudo mkdir -p /var/www/takhfifan
sudo chown -R $USER:$USER /var/www/takhfifan
```

2. **Deploy Application Code**
```bash
# Clone or upload code
cd /var/www/takhfifan
git clone https://github.com/ehsanerfani98/switch.git .
# OR upload your code via FTP/SFTP

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install frontend dependencies and build
npm install
npm run build

# Set proper permissions
sudo chown -R www-data:www-data /var/www/takhfifan
sudo chmod -R 755 /var/www/takhfifan/storage
sudo chmod -R 755 /var/www/takhfifan/bootstrap/cache
```

3. **Environment Setup**
```bash
# Copy and configure environment file
cp .env.example .env
nano .env  # Edit with production values

# Generate application key
php artisan key:generate

# Generate JWT secret (if using JWT)
php artisan jwt:secret
```

4. **Database Setup**
```bash
# Run migrations
php artisan migrate --force

# Seed database (optional)
php artisan db:seed --force

# Create storage link
php artisan storage:link
```

5. **Optimize Application**
```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### Automated Deployment with Script

Create a deployment script `deploy.sh`:

```bash
#!/bin/bash

# Deployment script for Takhfifan

APP_DIR="/var/www/takhfifan"
BACKUP_DIR="/var/backups/takhfifan"
DATE=$(date +%Y%m%d_%H%M%S)

echo "Starting deployment..."

# Backup current version
echo "Backing up current version..."
tar -czf "$BACKUP_DIR/takhfifan_$DATE.tar.gz" "$APP_DIR"

# Navigate to application directory
cd "$APP_DIR"

# Pull latest code
echo "Pulling latest code..."
git pull origin main

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Install frontend dependencies
echo "Installing frontend dependencies..."
npm install --silent

# Build frontend assets
echo "Building frontend assets..."
npm run build

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data "$APP_DIR"
chmod -R 755 storage bootstrap/cache

# Restart services
echo "Restarting services..."
systemctl reload php8.2-fpm
systemctl reload nginx

echo "Deployment completed successfully!"
```

Make it executable and run:
```bash
chmod +x deploy.sh
./deploy.sh
```

## Queue and Scheduler Setup

### Queue Worker

Create a systemd service for queue workers at `/etc/systemd/system/takhfifan-worker.service`:

```ini
[Unit]
Description=Takhfifan Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/takhfifan
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3 --max-time=3600
Restart=always
RestartSec=3

[Install]
WantedBy=multi-user.target
```

Enable and start the service:
```bash
sudo systemctl enable takhfifan-worker.service
sudo systemctl start takhfifan-worker.service
```

### Task Scheduler

Set up cron job for Laravel scheduler:

```bash
# Edit crontab
crontab -e

# Add the following line:
* * * * * cd /var/www/takhfifan && php artisan schedule:run >> /dev/null 2>&1
```

## Real-time Features Setup

### Laravel Reverb Configuration

Start Reverb as a service. Create `/etc/systemd/system/takhfifan-reverb.service`:

```ini
[Unit]
Description=Takhfifan Reverb WebSocket Server
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/takhfifan
ExecStart=/usr/bin/php artisan reverb:start --host=0.0.0.0 --port=8080
Restart=always
RestartSec=3

[Install]
WantedBy=multi-user.target
```

Enable and start the service:
```bash
sudo systemctl enable takhfifan-reverb.service
sudo systemctl start takhfifan-reverb.service
```

## SSL Certificate Setup

### Let's Encrypt with Certbot

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Set up auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

## Monitoring and Logging

### Application Logs

Configure log rotation at `/etc/logrotate.d/takhfifan`:

```
/var/www/takhfifan/storage/logs/laravel.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    copytruncate
}
```

### Server Monitoring

Install and configure monitoring tools:

```bash
# Install htop for process monitoring
sudo apt install htop

# Install and configure fail2ban for security
sudo apt install fail2ban

# Monitor disk space with a cron job
echo "0 2 * * * df -h >> /var/log/disk-usage.log" | sudo crontab -
```

## Backup Strategy

### Database Backups

Create a backup script at `/usr/local/bin/backup-takhfifan.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/var/backups/takhfifan"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="takhfifan_production"

# Create backup directory
mkdir -p "$BACKUP_DIR"

# Backup database
mysqldump -u your_db_user -p'your_db_password' "$DB_NAME" | gzip > "$BACKUP_DIR/db_$DATE.sql.gz"

# Backup application files (excluding vendor and node_modules)
tar -czf "$BACKUP_DIR/app_$DATE.tar.gz" --exclude=vendor --exclude=node_modules /var/www/takhfifan

# Remove backups older than 30 days
find "$BACKUP_DIR" -name "*.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

Make it executable and set up daily backups:
```bash
chmod +x /usr/local/bin/backup-takhfifan.sh
echo "0 2 * * * /usr/local/bin/backup-takhfifan.sh" | sudo crontab -
```

## Security Hardening

### Server Security

```bash
# Update firewall rules
sudo ufw enable
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw allow 8080  # For Reverb

# Secure SSH
sudo nano /etc/ssh/sshd_config
# Set: PermitRootLogin no, PasswordAuthentication no

# Install and configure fail2ban
sudo apt install fail2ban
sudo systemctl enable fail2ban
```

### Application Security

```bash
# Generate application key (if not done)
php artisan key:generate

# Set secure permissions
find /var/www/takhfifan -type f -exec chmod 644 {} \;
find /var/www/takhfifan -type d -exec chmod 755 {} \;
chmod -R 775 /var/www/takhfifan/storage
chmod -R 775 /var/www/takhfifan/bootstrap/cache
```

## Troubleshooting

### Common Issues and Solutions

1. **Permission Errors**
```bash
sudo chown -R www-data:www-data /var/www/takhfifan
sudo chmod -R 775 storage bootstrap/cache
```

2. **Queue Worker Not Running**
```bash
sudo systemctl status takhfifan-worker
sudo systemctl restart takhfifan-worker
```

3. **Reverb Connection Issues**
```bash
sudo systemctl status takhfifan-reverb
sudo netstat -tulpn | grep 8080
```

4. **Application Caching Issues**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Log Files Location

- Application logs: `/var/www/takhfifan/storage/logs/laravel.log`
- Nginx logs: `/var/log/nginx/error.log` and `/var/log/nginx/access.log`
- PHP-FPM logs: `/var/log/php8.2-fpm.log`
- System logs: `/var/log/syslog`

## Performance Optimization

### Database Optimization

```sql
-- Optimize tables regularly
OPTIMIZE TABLE users, cars, conversations, payments;

-- Check and add indexes for slow queries
EXPLAIN SELECT * FROM cars WHERE status = 'active' AND vip = 1;
```

### PHP Optimization

Update `/etc/php/8.2/fpm/php.ini`:

```ini
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 50M
post_max_size = 50M
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0  # Set to 1 in development
```

### Nginx Optimization

Update `/etc/nginx/nginx.conf`:

```nginx
worker_processes auto;
worker_connections 1024;
keepalive_timeout 65;
gzip on;
gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
```

This deployment guide provides comprehensive instructions for deploying the Takhfifan platform in a production environment. Follow these steps carefully to ensure a secure and performant deployment.
