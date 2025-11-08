# Feature Documentation

## Overview

This document provides detailed information about the core features and functionality of the Takhfifan platform, including implementation details, user flows, and technical specifications.

## Core Modules

### 1. User Management System

#### User Roles and Permissions

**Available Roles:**
- **Admin**: Full system access, user management, content moderation
- **Advisor**: Service provider, chat consultation, car inspection
- **User**: Basic platform access, car listings, subscription purchases

**Permission Structure:**
```php
// Example permission checks
$user->hasRole('admin');
$user->can('manage-users');
$user->can('view-reports');
```

**User Registration Flow:**
1. User provides email, phone, and password
2. Email verification (optional)
3. Phone number verification via SMS
4. Default role assignment (User)
5. Initial wallet creation with zero balance

#### User Profile Management

**Profile Fields:**
- Basic: Name, email, phone, profile picture
- Extended: Address, birth date, preferences
- Professional: Specialization (for advisors), experience

**Document Management:**
- ID verification documents
- Professional certificates (advisors)
- Car ownership documents

### 2. Car Marketplace

#### Car Listing System

**Car Attributes Structure:**
```php
// Dynamic attribute system
$car->attributeValues()->create([
    'attribute_id' => $gearboxAttribute->id,
    'value_string' => 'Automatic'
]);

$car->attributeValues()->create([
    'attribute_id' => $priceAttribute->id,
    'value_number' => 250000000
]);
```

**Supported Car Attributes:**
- Basic: Brand, Model, Year, Color
- Technical: Engine size, Fuel type, Gearbox, Kilometer
- Financial: Price, Insurance, Tax status
- Features: Air conditioning, Navigation, Sunroof

#### Media Management

**File Types:**
- Thumbnail: Primary display image (required)
- Gallery: Multiple additional images (optional)
- Certificate: Ownership/insurance documents (optional)
- Videos: Walkaround videos (optional)

**File Storage:**
- Local storage or cloud storage (configurable)
- Automatic image optimization and resizing
- Secure file access with permission checks

#### Search and Filtering

**Search Capabilities:**
- Full-text search on title and description
- Attribute-based filtering (price range, year, etc.)
- Geographic location filtering
- Advanced sorting options

**Example Search Query:**
```php
Car::whereHas('attributeValues', function($query) {
    $query->where('value_number', '>=', 100000000)
          ->where('value_number', '<=', 500000000);
})
->whereHas('brand', function($query) {
    $query->where('name', 'Toyota');
})
->orderByAttribute('price', 'asc')
->paginate(15);
```

### 3. Subscription & Service Management

#### Subscription Plans

**Plan Structure:**
- **Basic**: Limited features, free tier
- **Premium**: Enhanced features, monthly/yearly billing
- **Professional**: Full platform access, priority support

**Subscription Features:**
- Automatic renewal options
- Prorated upgrades/downgrades
- Usage tracking and limits
- Grace periods for expired subscriptions

#### Service Catalog

**Hierarchical Service Structure:**
```
Car Services (Parent)
├── Car Inspection (Child)
├── Car Valuation (Child)
└── Consultation Services (Child)
    ├── Technical Consultation
    └── Financial Consultation
```

**Service Configuration:**
- Icon and description
- Service rules and requirements
- Pricing models (fixed, hourly, subscription-based)
- Availability scheduling

### 4. Real-time Communication System

#### Chat Architecture

**Conversation Types:**
- **User-to-Advisor**: Service-related consultations
- **User-to-User**: Direct messaging (if enabled)
- **Group Chats**: Multiple participants

**Message Types:**
- Text messages
- Image attachments
- File sharing
- System notifications

**Real-time Features:**
- Online status indicators
- Typing indicators
- Message read receipts
- Push notifications

#### WebSocket Implementation

**Channel Structure:**
```php
// Private conversation channel
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    return $user->conversations()->where('id', $conversationId)->exists();
});
```

**Events:**
- `MessageSent` - New message created
- `ConversationUpdated` - Conversation metadata changed
- `UserTyping` - User is typing indicator
- `UserOnline` / `UserOffline` - Presence updates

### 5. Payment & Wallet System

#### Wallet Management

**Transaction Types:**
- **Deposit**: Adding funds to wallet
- **Withdrawal**: Removing funds from wallet
- **Payment**: Spending on services/subscriptions
- **Refund**: Returning funds for cancelled services

**Wallet Security:**
- Transaction history with audit trails
- Balance verification before transactions
- Fraud detection mechanisms
- Secure payment gateway integration

#### Payment Integration

**Supported Gateways:**
- ZarinPal (Iranian payment gateway)
- Stripe (international)
- PayPal (international)
- Bank transfer (manual verification)

**Payment Flow:**
1. User initiates payment
2. System creates pending transaction
3. Redirect to payment gateway
4. Gateway callback verification
5. Transaction status update
6. Service activation

### 6. Notification System

#### Notification Channels

**Available Channels:**
- In-app notifications
- Email notifications
- SMS notifications
- Push notifications (Firebase)
- WebSocket real-time notifications

**Notification Types:**
- System alerts
- Payment confirmations
- Chat messages
- Service updates
- Subscription reminders

#### Firebase Integration

**Configuration:**
```php
// Firebase service configuration
'firebase' => [
    'credentials' => env('FIREBASE_CREDENTIALS'),
    'database_url' => env('FIREBASE_DATABASE_URL'),
],
```

**Push Notification Flow:**
1. User registers device token
2. System creates notification
3. Firebase Cloud Messaging delivery
4. Mobile app displays notification
5. User interaction tracking

## Business Logic Implementation

### 1. Car Valuation System

**Valuation Factors:**
- Market price trends
- Vehicle condition assessment
- Mileage and age depreciation
- Regional market differences
- Seasonal demand variations

**Valuation Process:**
1. Basic vehicle information collection
2. Condition assessment (via file ratings)
3. Market data analysis
4. Price recommendation generation
5. Advisor review and adjustment

### 2. Service Request Workflow

**Service Request States:**
```php
class ServiceRequestStatusEnum
{
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
}
```

**Workflow Steps:**
1. User submits service request
2. System notifies available advisors
3. Advisor accepts request
4. Service execution and updates
5. User confirmation and rating
6. Payment processing

### 3. Subscription Management

**Subscription Lifecycle:**
- **Active**: Subscription is valid and services are accessible
- **Expired**: Subscription ended, grace period may apply
- **Cancelled**: User manually cancelled, runs until period end
- **Suspended**: Payment issues or policy violations

**Automatic Renewal:**
```php
public function hasActiveSubscription(): bool
{
    return $this->subscriptions()
        ->where('ends_at', '>', now())
        ->whereHas('payment', function ($query) {
            $query->where('status', 'paid');
        })
        ->exists();
}
```

## Data Models & Relationships

### Core Entity Relationships

**User Relationships:**
```php
// User has many subscriptions
public function subscriptions()

// User has one wallet
public function wallet()

// User has many service requests
public function serviceRequests()

// User has many conversations (as user or advisor)
public function conversationsAsUser()
public function conversationsAsAdvisor()
```

**Car Relationships:**
```php
// Car belongs to user and brand
public function user()
public function brand()
public function car_model()

// Car has many attribute values
public function attributeValues()

// Car has file ratings
public function fileRatings()
```

### Database Optimization

**Indexed Fields:**
- User: email, phone, is_online
- Car: status, vip, user_id, brand_id
- Conversation: user_id, advisor_id, updated_at
- Payment: status, user_id, created_at

**Query Optimization:**
- Eager loading for related data
- Database query caching
- Pagination for large datasets
- Selective field retrieval

## Security Features

### 1. Authentication Security

- Laravel Sanctum token-based authentication
- Token expiration and refresh mechanisms
- Secure password hashing (bcrypt)
- Two-factor authentication (optional)

### 2. Data Protection

- Input validation and sanitization
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade templating)
- CSRF protection for web forms

### 3. API Security

- Rate limiting on API endpoints
- CORS configuration for cross-origin requests
- Request validation with form requests
- Secure headers middleware

## Performance Considerations

### 1. Caching Strategy

**Cache Layers:**
- Configuration caching
- Route caching
- View caching
- Query result caching
- Full-page caching for static content

**Cache Implementation:**
```php
// Example cached query
$cars = Cache::remember('featured_cars', 3600, function () {
    return Car::where('vip', true)
              ->with('brand', 'user')
              ->take(10)
              ->get();
});
```

### 2. Asset Optimization

- Vite for frontend asset compilation
- Image optimization and lazy loading
- CSS and JavaScript minification
- CDN integration for static assets

### 3. Database Optimization

- Proper indexing strategy
- Query optimization with Laravel Debugbar
- Database connection pooling
- Read/write database separation (if needed)

## Monitoring & Analytics

### 1. Application Monitoring

- Laravel Telescope for development
- Error tracking with Laravel Ignition
- Performance monitoring with Blackfire/New Relic
- Log aggregation and analysis

### 2. Business Analytics

- User engagement metrics
- Service utilization rates
- Revenue and payment analytics
- Car listing performance

### 3. Health Checks

- Database connection status
- Cache server availability
- External service connectivity
- Storage disk space monitoring

## Integration Points

### 1. Third-party Services

- **SMS Gateway**: IPPanel for Persian SMS
- **Payment Gateway**: ZarinPal for Iranian payments
- **Push Notifications**: Firebase Cloud Messaging
- **Real-time Communication**: Pusher/Laravel Reverb

### 2. External APIs

- Car valuation data sources
- Geographic location services
- Market price trend APIs
- Vehicle history reports

## Customization & Extensibility

### 1. Configuration Options

- Multi-language support (Persian/English)
- Theme customization
- Payment gateway selection
- Notification channel preferences

### 2. Plugin Architecture

- Service provider registration
- Event listener system
- Middleware pipeline
- Package development support

This comprehensive feature documentation provides developers with the necessary information to understand, extend, and maintain the Takhfifan platform effectively.
