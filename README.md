# Takhfifan Platform

A sophisticated multi-service Laravel platform for car marketplace, subscription management, and real-time communication.

## 🚀 Project Overview

Takhfifan (meaning "discount" in Persian) is a comprehensive Laravel-based platform that provides:

- **Car Marketplace**: Complete vehicle listing and management system
- **Subscription Services**: Tiered subscription plans with payment processing
- **Real-time Chat**: Live communication between users and advisors
- **Service Management**: Hierarchical service catalog and user service assignments

## 🛠 Technical Stack

- **Backend**: Laravel 11, PHP 8.1+
- **Frontend**: Vite, Bootstrap 5, CKEditor 4
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Real-time**: Laravel Reverb, Pusher
- **Permissions**: Spatie Laravel Permission
- **PWA**: Progressive Web App support
- **Localization**: Persian (Farsi) language

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm/yarn
- MySQL 5.7+ or MariaDB
- Redis (optional, for caching and queues)

## ⚡ Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/ehsanerfani98/switch.git
cd takhfifan
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install

# Frontend dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Update `.env` with your database and service configurations:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=takhfifan
DB_USERNAME=your_username
DB_PASSWORD=your_password

# For real-time features
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1

# For Firebase notifications
FIREBASE_CREDENTIALS=path/to/firebase_credentials.json
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed initial data (if available)
php artisan db:seed
```

### 5. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Start Development Server

```bash
# Start Laravel development server
php artisan serve

# Start Reverb for real-time features (in separate terminal)
php artisan reverb:start
```

## 🗄 Database Schema

The application uses a comprehensive database structure with the following key tables:

- `users` - User accounts and authentication
- `cars` - Vehicle listings
- `services` - Service catalog
- `subscriptions` - Subscription plans
- `user_subscriptions` - User subscription assignments
- `conversations` - Chat conversations
- `messages` - Chat messages
- `payments` - Payment transactions
- `wallets` - User wallet balances

## 🔐 Authentication & Authorization

- **Authentication**: Laravel Sanctum for API authentication
- **Authorization**: Role-based permissions using Spatie Laravel Permission
- **User Roles**: Admin, Advisor, User

## 🔄 Real-time Features

- Live chat between users and advisors
- Online user status tracking
- Push notifications via Firebase
- Real-time updates using Laravel Reverb and Pusher

## 📱 PWA Features

- Service Worker for offline functionality
- Web App Manifest for mobile installation
- Push notifications support

## 🚗 Car Marketplace Features

- Vehicle listings with detailed attributes
- Brand and model management
- File upload and document management
- Advanced search and filtering
- Rating and review system

## 💳 Subscription & Payment System

- Tiered subscription plans
- Wallet system with transaction history
- Payment processing integration
- Service usage tracking

## 📁 Project Structure

```
app/
├── Models/          # Eloquent models
├── Http/
│   ├── Controllers/ # Application controllers
│   └── Middleware/  # Custom middleware
├── Services/        # Business logic services
├── Events/         # Event classes
├── Mail/           # Email templates
└── Traits/         # Reusable traits

config/             # Configuration files
database/
├── migrations/     # Database migrations
└── seeders/        # Data seeders

resources/
├── views/          # Blade templates
├── js/             # JavaScript assets
└── css/            # Stylesheets

routes/
├── web.php         # Web routes
├── api.php         # API routes
└── channels.php    # Broadcast channels
```

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

## 🚀 Deployment

### Production Build

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build frontend assets
npm run build
```

### Environment Variables for Production

Ensure these are set in your production environment:

```env
APP_ENV=production
APP_DEBUG=false

# Cache and session drivers
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Secure cookies
SESSION_SECURE_COOKIE=true
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is licensed under the MIT License.

## 📞 Support

For support and questions, please contact the development team or create an issue in the repository.
