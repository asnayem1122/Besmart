# Besmart — Enterprise Full-Stack E-Commerce & B2B Wholesale Platform

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x%20%2F%2011.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue Version](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)](https://vuejs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-blue.style=for-the-badge)](LICENSE)

**Besmart** is a production-ready, high-density full-stack e-commerce mega-marketplace inspired by **Taobao (淘宝)** aesthetics and architecture. It seamlessly unifies B2C retail shopping, a specialized B2B wholesale portal with 10-year business intelligence analytics, a China bulk import landed cost engine, an AI shopping assistant (*Besmart AI*), and gamified customer rewards.

> *"Shop Smart. Buy Better."*

---

## 🔥 Key Features

### 🛒 B2C Retail Storefront
- **High-Density Taobao-Style Layout**: 3-column desktop grid with vertical category tree, promotional hero slider, and quick user welcome card.
- **Smart Setup Bundles ("Complete Your Setup")**: 1-click bundle purchase with 12% dynamic savings.
- **Ju划算 Flash Deals**: Countdown timers, stock urgency alerts (*"Only 5 left"*), and percentage claimed progress bars.
- **Besmart Live Stream Sales**: Interactive video sales stream showcase with live viewer counter and pinned product cards.
- **Multi-Step Checkout**: Server-side price verification preventing price manipulation.

### 🏢 B2B Wholesale Portal & 10-Year BI Analytics
- **10-Year BI Analytics Dashboard**: Aggregates purchase history (`2016 - 2026`), total spending, order frequency, bulk savings, and profit estimates across `1y`, `3y`, `5y`, and `10y` filters with **CSV Report Exporting**.
- **Quantity Volume Pricing Tiers**: Automated unit price discounts based on wholesale order volume.
- **China Bulk Import Cost Calculator**: Computes FOB product price, Air/Sea freight, Customs Duty, VAT, landed unit cost, suggested retail price, and break-even sales volume.
- **MOQ Enforcement**: Strict Minimum Order Quantity gates at cart and checkout.

### 🤖 Besmart AI Shopping Assistant & Gamification
- **Besmart AI**: Natural language query processing searching real database products and returning interactive product cards with direct "Add to Cart" actions.
- **Wheel of Fortune**: Gamified casino SVG wheel with metallic gold LED rim, ruby pointer, and 24-hour server-side anti-abuse rate limits (*win up to 20% OFF or Free Shipping*).

---

## 🛠️ Technology Stack

- **Backend Framework**: Laravel 12 / 11
- **Frontend Framework**: Vue 3 (Composition API) + Vite 6
- **State Management**: Pinia
- **Routing**: Vue Router 4
- **Styling**: Tailwind CSS (Taobao Flame Orange `#FF5000` & Tmall Red `#FF0036`)
- **Authentication**: Laravel Sanctum
- **Database**: SQLite / MySQL (Normalized 24+ schema)
- **Charts Engine**: Vue3 ApexCharts
- **Payment Abstraction**: Pluggable drivers for COD, Stripe, SSLCommerz, bKash

---

## 🔑 Demo Credentials

| Role | Email | Password | Dashboard Route |
|---|---|---|---|
| **Master Admin** | `admin@besmart.com` | `password` | `/admin/dashboard` |
| **B2B Wholesale** | `b2b@techmart.com` | `password` | `/b2b/dashboard` |
| **B2C Customer** | `customer@gmail.com` | `password` | `/customer/dashboard` |

---

## 🚀 Quick Start Guide

### Prerequisites
- PHP >= 8.2 with `pdo_sqlite`, `mbstring`, `fileinfo`, `zip` extensions enabled
- Composer >= 2.0
- Node.js >= 18.0 & NPM

### Setup Instructions

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/YOUR_USERNAME/besmart.git
   cd besmart
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations & Seed Database** *(Seeds 10-year B2B history & catalog)*:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Compile Frontend Assets**:
   ```bash
   npm run build
   ```

6. **Start Application Server**:
   ```bash
   php artisan serve --port=8000
   ```
   *Access the app at `http://localhost:8000`*

---

## 🧪 Running Automated Tests

Run the full PHPUnit feature test suite:
```bash
php artisan test
```

---

## 📄 License
This project is open-sourced software licensed under the [MIT license](LICENSE).
