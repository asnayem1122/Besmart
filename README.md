# 🛍️ Besmart — Enterprise Full-Stack E-Commerce & B2B Wholesale Platform

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)](https://vuejs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vite.dev)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

> *"Shop Smart. Buy Better."*

**Besmart** is a production-ready, high-density full-stack e-commerce mega-marketplace inspired by **Taobao** aesthetics and architecture. It seamlessly unifies B2C retail shopping, a specialized B2B wholesale portal with 10-year business intelligence analytics, a China bulk import landed cost engine, an AI shopping assistant, and gamified customer rewards — all in one platform.

---

## 🌐 Live Demo

| Link | Description |
|---|---|
| **[Live App (GitHub Pages)](https://asnayem1122.github.io/Besmart/)** | Static frontend demo — browse the UI, explore pages |
| **[GitHub Repository](https://github.com/asnayem1122/Besmart)** | Full source code |

> **Note:** GitHub Pages hosts the static Vue 3 frontend. For full functionality (login, cart, checkout, AI, database), run the Laravel backend locally — see [Quick Start](#-quick-start-guide) below.

---

## 🔥 Key Features

### 🛒 B2C Retail Storefront
- **Taobao-Inspired High-Density Layout** — 3-column desktop grid with vertical category tree, promotional hero slider, and user welcome card
- **Smart Setup Bundles** — "Complete Your Setup" with 1-click bundle purchase & 12% dynamic savings
- **Flash Deals** — Countdown timers, stock urgency alerts (*"Only 5 left"*), and claimed progress bars (*"78% Claimed"*)
- **Besmart Live Stream Sales** — Video sales stream showcase with live viewer counter and pinned product cards
- **Multi-Step Checkout** — Server-side price verification preventing frontend manipulation

### 🏢 B2B Wholesale Portal & 10-Year BI Analytics
- **10-Year BI Analytics Dashboard** — Aggregates purchase history (2016–2026), spending trends, order frequency, bulk savings, and profit estimates across 1y / 3y / 5y / 10y filters with **CSV Export**
- **Quantity Volume Pricing Tiers** — Automated unit price discounts based on wholesale order volume
- **China Bulk Import Cost Calculator** — FOB price, Air/Sea freight ($8.50/kg vs $2.50/kg), Customs Duty (15%), VAT (15%), landed unit cost, suggested retail price, expected profit, and break-even volume
- **MOQ Enforcement** — Strict Minimum Order Quantity gates at cart and checkout

### 🤖 AI Shopping Assistant & Gamification
- **Besmart AI** — Natural language queries (e.g. *"gaming mouse under 3000 taka"*) searching real database products, returning interactive cards with direct Add-to-Cart
- **Wheel of Fortune** — Casino-style SVG wheel with metallic gold LED rim, ruby pointer, server-side probability calculation, and 24-hour anti-abuse rate limiting

### 💳 Payment & Security
- **Payment Gateway Abstraction** — Pluggable driver architecture supporting Cash on Delivery, Stripe, SSLCommerz, and bKash
- **Laravel Sanctum Authentication** — Token-based API auth with role-based access control (Admin / B2B / B2C)
- **Server-Side Price Integrity** — All prices, discounts, and totals recalculated inside database transactions

---

## 🛠️ Technology Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Vue 3 (Composition API) |
| **Build Tool** | Vite 6 |
| **Styling** | Tailwind CSS 3.4 |
| **State Management** | Pinia |
| **Routing** | Vue Router 4 |
| **Authentication** | Laravel Sanctum |
| **Database** | SQLite / MySQL |
| **Charts** | Vue3 ApexCharts |
| **Icons** | Lucide Vue |
| **Deployment** | GitHub Actions → GitHub Pages |

---

## 🔑 Demo Credentials

| Role | Email | Password | Dashboard |
|---|---|---|---|
| 👑 **Admin** | `admin@besmart.com` | `password` | `/admin/dashboard` |
| 🏢 **B2B Wholesale** | `b2b@techmart.com` | `password` | `/b2b/dashboard` |
| 🛍️ **B2C Customer** | `customer@gmail.com` | `password` | `/customer/dashboard` |

---

## 🚀 Quick Start Guide

### Prerequisites
- PHP >= 8.2 with `pdo_sqlite`, `mbstring`, `fileinfo`, `zip` extensions
- Composer >= 2.0
- Node.js >= 18 & NPM

### Setup

```bash
# 1. Clone
git clone https://github.com/asnayem1122/Besmart.git
cd Besmart

# 2. Install dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Database setup (seeds 10-year B2B history & product catalog)
php artisan migrate:fresh --seed

# 5. Build frontend
npm run build

# 6. Start server
php artisan serve --port=8000
```

Open **http://localhost:8000** and use the demo credentials above to explore!

---

## 🧪 Automated Tests

```bash
php artisan test
```

```
Tests:    11 passed (37 assertions)
Duration: 1.57s
```

Covers: B2B pricing tiers, China import calculations, AI search, discount wheel anti-abuse, 10-year analytics aggregations, payment gateway abstraction, auth flow, cart & checkout pipeline.

---

## 📁 Project Structure

```
Besmart/
├── app/
│   ├── Http/Controllers/Api/v1/   # REST API controllers
│   ├── Models/                     # 24 Eloquent models
│   ├── Services/                   # AI, Analytics, Import Calculator, Payment, Wheel
│   └── Enums/                      # RoleEnum, OrderStatus
├── database/
│   ├── migrations/                 # 24+ normalized schema migrations
│   └── seeders/                    # 10-year historical B2B dataset
├── resources/js/
│   ├── components/                 # Vue 3 components (Navbar, ProductCard, Wheel, AI Chat...)
│   ├── pages/                      # SPA pages (Home, Shop, Cart, Dashboards...)
│   ├── stores/                     # Pinia stores (auth, cart, theme, notification)
│   ├── layouts/                    # Main, B2B, Admin, Customer layouts
│   └── router/                     # Vue Router with auth guards
├── routes/
│   ├── api.php                     # 30 RESTful API endpoints
│   └── web.php                     # SPA fallback route
└── tests/Feature/                  # PHPUnit feature tests
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

---

**Built with ❤️ using Laravel 12 + Vue 3 + Tailwind CSS**
