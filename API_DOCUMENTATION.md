# API Documentation

## Overview

The Takhfifan platform provides a comprehensive REST API built with Laravel Sanctum for authentication. This documentation covers all available API endpoints, request/response formats, and authentication methods.

## Authentication

### Sanctum Token Authentication

All protected endpoints require a Bearer token in the Authorization header:

```http
Authorization: Bearer {sanctum_token}
```

### Obtaining Authentication Token

**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "token": "1|abcdef123456",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "phone": "+989123456789"
  }
}
```

## API Endpoints

### Authentication Endpoints

#### Register User
- **Method:** `POST /api/register`
- **Description:** Create a new user account
- **Request Body:**
  ```json
  {
    "name": "John Doe",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password",
    "phone": "+989123456789"
  }
  ```

#### Logout
- **Method:** `POST /api/logout`
- **Description:** Invalidate current authentication token
- **Headers:** `Authorization: Bearer {token}`

### User Management

#### Get Current User
- **Method:** `GET /api/user`
- **Description:** Get authenticated user information
- **Headers:** `Authorization: Bearer {token}`
- **Response:**
  ```json
  {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "phone": "+989123456789",
    "is_online": true,
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
  ```

### Real-time Features

#### Get Online Advisors
- **Method:** `GET /api/online-advisors`
- **Description:** Get list of currently online advisors
- **Response:**
  ```json
  {
    "data": [
      {
        "id": 2,
        "name": "Advisor Name",
        "email": "advisor@example.com",
        "is_online": true,
        "specialization": "Car Consultation"
      }
    ]
  }
  ```

#### Get Online Users
- **Method:** `GET /api/online-users`
- **Description:** Get list of currently online users
- **Headers:** `Authorization: Bearer {token}` (Advisor role required)

### Car Management

#### List Cars
- **Method:** `GET /api/cars`
- **Description:** Get paginated list of cars with filtering options
- **Query Parameters:**
  - `page` (optional): Page number
  - `per_page` (optional): Items per page (default: 15)
  - `brand` (optional): Filter by brand ID
  - `model` (optional): Filter by model ID
  - `min_price` (optional): Minimum price filter
  - `max_price` (optional): Maximum price filter
  - `gearbox` (optional): Filter by gearbox type
  - `sort_by` (optional): Sort field (price, kilometer, created_at)
  - `sort_order` (optional): Sort direction (asc, desc)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Toyota Camry 2023",
      "slug": "toyota-camry-2023",
      "thumbnail": "/storage/cars/thumbnail.jpg",
      "description": "Excellent condition...",
      "status": "active",
      "vip": false,
      "price": 250000000,
      "gearbox": "automatic",
      "kilometer": 15000,
      "brand": {
        "id": 1,
        "name": "Toyota"
      },
      "car_model": {
        "id": 1,
        "name": "Camry"
      },
      "user": {
        "id": 1,
        "name": "Seller Name"
      },
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "links": {
    "first": "/api/cars?page=1",
    "last": "/api/cars?page=5",
    "prev": null,
    "next": "/api/cars?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "links": [...],
    "path": "/api/cars",
    "per_page": 15,
    "to": 15,
    "total": 75
  }
}
```

#### Get Car Details
- **Method:** `GET /api/cars/{id}`
- **Description:** Get detailed information about a specific car
- **Response:**
  ```json
  {
    "data": {
      "id": 1,
      "title": "Toyota Camry 2023",
      "slug": "toyota-camry-2023",
      "thumbnail": "/storage/cars/thumbnail.jpg",
      "gallery": [
        "/storage/cars/gallery1.jpg",
        "/storage/cars/gallery2.jpg"
      ],
      "certificate": "/storage/cars/certificate.pdf",
      "description": "Full description...",
      "status": "active",
      "vip": false,
      "keyword": "toyota,camry,2023",
      "attribute_values": [
        {
          "attribute": {
            "name": "Gearbox",
            "slug": "gearbox"
          },
          "value_string": "Automatic"
        },
        {
          "attribute": {
            "name": "Kilometer",
            "slug": "kilometer"
          },
          "value_number": 15000
        }
      ],
      "file_ratings": [
        {
          "file_item": {
            "name": "Engine Condition"
          },
          "rating": 4.5
        }
      ],
      "brand": {
        "id": 1,
        "name": "Toyota"
      },
      "car_model": {
        "id": 1,
        "name": "Camry"
      },
      "user": {
        "id": 1,
        "name": "Seller Name"
      }
    }
  }
  ```

#### Create Car
- **Method:** `POST /api/cars`
- **Description:** Create a new car listing
- **Headers:** `Authorization: Bearer {token}`
- **Request Body:** (multipart/form-data)
  - `title` (string, required): Car title
  - `description` (string, required): Car description
  - `brand_id` (integer, required): Brand ID
  - `car_model_id` (integer, required): Model ID
  - `thumbnail` (file, required): Main thumbnail image
  - `gallery[]` (files, optional): Gallery images
  - `certificate` (file, optional): Certificate document
  - `attributes` (json, optional): Car attributes in JSON format

### Service Management

#### List Services
- **Method:** `GET /api/services`
- **Description:** Get hierarchical list of services
- **Response:**
  ```json
  {
    "data": [
      {
        "id": 1,
        "parent_id": null,
        "icon": "car-icon",
        "name": "Car Services",
        "description": "Automotive services",
        "rules": "Service rules...",
        "is_active": true,
        "children": [
          {
            "id": 2,
            "parent_id": 1,
            "icon": "inspection-icon",
            "name": "Car Inspection",
            "description": "Professional car inspection",
            "rules": "Inspection rules...",
            "is_active": true
          }
        ]
      }
    ]
  }
  ```

### Subscription Management

#### List Subscriptions
- **Method:** `GET /api/subscriptions`
- **Description:** Get available subscription plans
- **Response:**
  ```json
  {
    "data": [
      {
        "id": 1,
        "name": "Basic Plan",
        "description": "Basic subscription features",
        "price": 100000,
        "duration_days": 30,
        "features": ["Feature 1", "Feature 2"],
        "is_active": true
      }
    ]
  }
  ```

#### Subscribe to Plan
- **Method:** `POST /api/subscriptions/{id}/subscribe`
- **Description:** Subscribe to a subscription plan
- **Headers:** `Authorization: Bearer {token}`
- **Response:**
  ```json
  {
    "message": "Subscription successful",
    "payment_url": "https://payment-gateway.com/checkout/abc123"
  }
  ```

### Chat & Messaging

#### Start Conversation
- **Method:** `POST /api/conversations`
- **Description:** Start a new conversation with an advisor
- **Headers:** `Authorization: Bearer {token}`
- **Request Body:**
  ```json
  {
    "advisor_id": 2,
    "message": "Hello, I need help with..."
  }
  ```

#### Send Message
- **Method:** `POST /api/conversations/{id}/messages`
- **Description:** Send a message in a conversation
- **Headers:** `Authorization: Bearer {token}`
- **Request Body:**
  ```json
  {
    "content": "Message content",
    "type": "text" // text, image, file
  }
  ```

#### Get Conversation Messages
- **Method:** `GET /api/conversations/{id}/messages`
- **Description:** Get messages in a conversation
- **Headers:** `Authorization: Bearer {token}`
- **Query Parameters:**
  - `page` (optional): Page number
  - `per_page` (optional): Messages per page

### Wallet & Payments

#### Get Wallet Balance
- **Method:** `GET /api/wallet`
- **Description:** Get user's wallet information
- **Headers:** `Authorization: Bearer {token}`
- **Response:**
  ```json
  {
    "data": {
      "id": 1,
      "balance": 500000,
      "user_id": 1,
      "transactions": [
        {
          "id": 1,
          "amount": 100000,
          "type": "deposit",
          "description": "Wallet top-up",
          "created_at": "2024-01-01T00:00:00.000000Z"
        }
      ]
    }
  }
  ```

#### Wallet Top-up
- **Method:** `POST /api/wallet/top-up`
- **Description:** Add funds to wallet
- **Headers:** `Authorization: Bearer {token}`
- **Request Body:**
  ```json
  {
    "amount": 100000
  }
  ```

## Error Responses

### Common Error Codes

- `400` - Bad Request (Validation errors)
- `401` - Unauthorized (Invalid or missing token)
- `403` - Forbidden (Insufficient permissions)
- `404` - Not Found (Resource not found)
- `422` - Unprocessable Entity (Validation failed)
- `500` - Internal Server Error

### Error Response Format

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

## Rate Limiting

API endpoints are rate-limited to prevent abuse:
- 60 requests per minute for authenticated users
- 10 requests per minute for unauthenticated endpoints

## WebSocket Events

### Available Events

- `UserOnline` - User comes online
- `UserOffline` - User goes offline
- `NewMessage` - New message in conversation
- `ConversationUpdated` - Conversation status changed

### Listening to Events

```javascript
// Example using Laravel Echo
Echo.private(`conversation.{conversationId}`)
    .listen('NewMessage', (e) => {
        console.log('New message:', e.message);
    });
```

## Testing the API

### Using Postman

1. Import the Postman collection (if available)
2. Set base URL: `http://your-domain.com/api`
3. For protected endpoints, obtain token via login endpoint and set in Authorization header

### Using cURL

```bash
# Login and get token
curl -X POST http://your-domain.com/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Use token for protected endpoint
curl -X GET http://your-domain.com/api/user \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json"
```

## Versioning

The API is currently on version 1. All endpoints are prefixed with `/api/`. Future versions will use path-based versioning (`/api/v2/`).
