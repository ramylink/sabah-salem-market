# Sabah Al-Salem Market - Food Retail E-Commerce Platform

## جمعية صباح السالم التعاونية - منصة التجارة الإلكترونية

A high-performance, mobile-first food retail e-commerce platform built with Laravel 11, Livewire 3, and Filament Admin.

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- SQLite (for quick demo) or MySQL/PostgreSQL

### Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node dependencies
npm install

# 3. Build assets
npm run build

# 4. Create SQLite database (for quick demo)
touch database/database.sqlite

# 5. Run migrations and seeders
php artisan migrate --seed

# 6. Start the server
php artisan serve

# 7. (Optional) Create public tunnel with ngrok
ngrok http 8000
```

### Demo Credentials
| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@sabah-salem.com | admin123 |
| Manager | manager@sabah-salem.com | manager123 |
| Staff | staff@sabah-salem.com | staff123 |
| Customer | customer@demo.com | customer123 |

### Admin Panel
Access the admin panel at: `/admin`

---

## 🏗️ Architecture

### Tech Stack
- **Backend**: Laravel 11 (Clean Architecture)
- **Frontend**: Livewire 3 + Alpine.js + Tailwind CSS
- **Admin**: Filament 3
- **Database**: MySQL/PostgreSQL with advanced indexing
- **Caching**: Redis/File (configurable)
- **Queue**: Redis/Sync (configurable)
- **Search**: Full-text search + Algolia-ready
- **PWA**: Vite PWA Plugin

### Design Patterns
- **Service Layer**: Business logic separation
- **Repository Pattern**: Data access abstraction
- **DTOs**: Clean data transfer
- **Observers**: Event-driven updates
- **Caching Strategy**: Multi-level caching

---

## 🛒 Core Features

### Storefront
- ⚡ Instant Search (Typeahead)
- 🛍️ Sliding Cart Drawer
- 📱 100% Mobile-First Design
- 🔄 One-Click Reorder
- 🎯 Smart Product Recommendations
- 💰 Dynamic Offers & Discounts
- 🔔 Real-time Stock Updates

### Checkout
- 📄 One-Page Checkout
- 💵 Cash on Delivery
- 🎟️ Coupon System
- 📍 Address Management
- 📅 Scheduled Delivery

### Admin (Filament)
- 📦 Product Management
- 📋 Order Management with Status Tracking
- 📊 Sales Reports
- 🏷️ Coupon Management
- 👥 User Management
- 📈 Analytics Dashboard

---

## 📱 PWA Features
- Install as mobile app
- Offline support
- Push notifications ready
- Optimized assets

---

## 🔐 Security
- CSRF Protection
- Rate Limiting (API, Search, Cart)
- Role-based Access Control (Spatie Permission)
- Input Validation
- Secure API Structure (Sanctum)

---

## 📊 Performance Optimizations
- Lazy Loading Images
- Full Page Caching
- Query Optimization + Eager Loading
- Asset Minification (Vite)
- Database Indexing
- Redis Caching

---

## 🌐 Localization
- Arabic (Primary)
- English (Secondary)
- RTL Support
- Kuwaiti Dinar (KWD) Currency

---

## 📦 API Endpoints (REST)

### Public
- `GET /api/v1/products` - List products
- `GET /api/v1/products/featured` - Featured products
- `GET /api/v1/products/search?q={query}` - Search
- `GET /api/v1/categories` - Categories

### Authenticated
- `GET /api/v1/cart` - View cart
- `POST /api/v1/cart` - Add to cart
- `POST /api/v1/orders` - Create order
- `GET /api/v1/orders` - List orders

---

## 🧪 Testing
```bash
php artisan test
```

---

## 📝 License
Proprietary - Sabah Al-Salem Cooperative Society

---

## 👨‍💻 Development Team
Built with ❤️ for Sabah Al-Salem Cooperative Society
