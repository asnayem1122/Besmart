<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <!-- Taobao Signature 3-Column Top Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-8">
      <!-- 1. Left Vertical Mega Category Sidebar -->
      <aside class="lg:col-span-3 glass-card rounded-3xl p-4 hidden lg:block border border-gray-200 dark:border-gray-800">
        <h3 class="font-black text-xs uppercase tracking-wider text-brand-500 mb-3 flex items-center gap-1.5">
          <span>☰</span> <span>All Categories</span>
        </h3>
        <ul class="space-y-1 text-xs">
          <li v-for="cat in categories" :key="cat.id" class="group relative">
            <router-link :to="{ name: 'shop', query: { category_id: cat.id } }" class="flex items-center justify-between p-2 rounded-xl hover:bg-brand-500/10 hover:text-brand-500 font-bold transition-colors">
              <div class="flex items-center gap-2">
                <span>📦</span>
                <span>{{ cat.name }}</span>
              </div>
              <span class="text-[10px] text-gray-400 group-hover:text-brand-500">›</span>
            </router-link>
          </li>
        </ul>
      </aside>

      <!-- 2. Center Hero Slider Banner -->
      <main class="lg:col-span-6">
        <div class="relative overflow-hidden rounded-3xl taobao-gradient-orange text-white p-8 md:p-10 shadow-glow min-h-[340px] flex flex-col justify-between border border-brand-400/40">
          <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/20 text-gold-300 text-xs font-black mb-4">
              🔥 TAOBAO STYLE MEGA SALE
            </div>
            <h1 class="text-3xl md:text-4xl font-black leading-tight mb-3">
              Shop Smart. Buy Better. <br />
              <span class="text-gold-400">Direct Wholesale Marketplace</span>
            </h1>
            <p class="text-xs md:text-sm text-orange-100 max-w-md leading-relaxed">
              Discover factory prices, 10-year B2B analytics, and AI shopping assistance.
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-3 mt-6">
            <router-link to="/shop" class="px-6 py-3 rounded-2xl bg-white text-brand-600 hover:bg-orange-50 font-black text-xs shadow-md transition-all">
              Shop Now →
            </router-link>
            <router-link to="/b2b/dashboard" class="px-6 py-3 rounded-2xl bg-black/20 hover:bg-black/30 text-white font-bold text-xs border border-white/20">
              B2B Portal
            </router-link>
          </div>
        </div>
      </main>

      <!-- 3. Right User Welcome & Quick Services Card -->
      <aside class="lg:col-span-3 glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200 dark:border-gray-800">
            <div class="w-11 h-11 rounded-2xl taobao-gradient-orange text-white font-black text-xl flex items-center justify-center shadow-glow">
              {{ authStore.user?.name?.charAt(0) || '👤' }}
            </div>
            <div>
              <h4 class="font-black text-sm text-gray-900 dark:text-white truncate">Hi, {{ authStore.user?.name || 'Welcome Guest' }}</h4>
              <p class="text-[10px] text-brand-500 font-bold">Get Exclusive Coupons</p>
            </div>
          </div>

          <div class="space-y-2 mb-4">
            <div class="p-2.5 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-between text-xs">
              <span class="font-bold text-orange-600 dark:text-orange-400">🎁 ৳200 OFF Coupon</span>
              <router-link to="/shop" class="text-[10px] font-black text-brand-500 underline">Claim</router-link>
            </div>
            <div class="p-2.5 rounded-xl bg-gold-500/10 border border-gold-500/20 flex items-center justify-between text-xs">
              <span class="font-bold text-gold-600 dark:text-gold-400">⚡ Flash Sale Alert</span>
              <span class="text-[10px] font-bold text-gray-400">Active</span>
            </div>
          </div>
        </div>

        <div class="space-y-2 pt-3 border-t border-gray-200 dark:border-gray-800">
          <router-link v-if="!authStore.isAuthenticated" to="/register?role=b2b" class="block w-full text-center py-2.5 rounded-xl taobao-gradient-orange text-white font-black text-xs shadow-glow">
            Register Wholesale Account
          </router-link>
          <router-link v-else to="/b2b/dashboard" class="block w-full text-center py-2.5 rounded-xl bg-gray-900 text-gold-400 font-black text-xs border border-gray-800">
            Enter B2B BI Dashboard
          </router-link>
        </div>
      </aside>
    </div>

    <!-- Section 2: Taobao-Style Flash Deals -->
    <section v-if="flashSales.length" class="my-10 glass-card rounded-3xl p-6 border border-tmall-500/30">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-3">
          <span class="px-3 py-1 rounded-xl bg-tmall-500 text-white font-black text-xs uppercase tracking-wider shadow-md">
            FLASH DEALS
          </span>
          <h2 class="text-xl font-black text-gray-900 dark:text-white">Limited Time Deals</h2>
          <span class="text-xs text-rose-500 font-extrabold animate-pulse">Ends in 02:43:17</span>
        </div>

        <router-link to="/shop" class="text-xs font-bold text-brand-500 hover:underline">
          View All Deals →
        </router-link>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="product in flashSales" :key="product.id" class="space-y-2">
          <ProductCard :product="product" />
          <!-- Taobao Claimed Progress Bar -->
          <div class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between text-[10px] font-bold text-gray-500 mb-1">
              <span>Claimed: 78%</span>
              <span class="text-rose-500">Only 5 Left</span>
            </div>
            <div class="w-full h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
              <div class="h-full bg-tmall-500 rounded-full" style="width: 78%"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 3: Besmart Live Streaming Video Sales Showcase -->
    <section class="my-10 glass-card rounded-3xl p-6 md:p-8 border border-brand-500/30 bg-gradient-to-r from-gray-900 via-gray-950 to-black text-white">
      <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800">
        <div class="flex items-center gap-3">
          <span class="w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
          <h2 class="text-xl font-black text-white">Besmart Live Sales Stream</h2>
          <span class="px-2.5 py-0.5 rounded-md bg-rose-500/20 text-rose-400 font-bold text-xs border border-rose-500/30">LIVE NOW (14.2k Viewers)</span>
        </div>
        <span class="text-xs text-gray-400 hidden sm:block">Interactive Video Streaming & Direct Product Pins</span>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
        <!-- Live Video Card -->
        <div class="relative aspect-video rounded-2xl overflow-hidden bg-gray-800 border border-gray-700 group shadow-2xl">
          <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
          <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
            <div class="w-16 h-16 rounded-full bg-brand-500/90 text-white flex items-center justify-center font-bold text-2xl shadow-glow cursor-pointer hover:scale-110 transition-transform">
              ▶
            </div>
          </div>
          <div class="absolute bottom-3 left-3 right-3 p-3 rounded-xl bg-black/70 backdrop-blur-md flex items-center justify-between text-xs">
            <span class="font-bold text-white">Host: Alex Tech Reviewer</span>
            <span class="text-gold-400 font-extrabold">Pin #1: Gaming Setup</span>
          </div>
        </div>

        <!-- Featured Stream Product Cards -->
        <div v-for="p in featured.slice(0, 2)" :key="p.id" class="bg-gray-900 p-4 rounded-2xl border border-gray-800 flex items-center gap-4">
          <img :src="p.primary_image?.image_url || p.image_url" class="w-20 h-20 rounded-xl object-cover" />
          <div class="flex-1 min-w-0">
            <span class="text-[10px] font-bold text-rose-400 uppercase">Live Stream Special</span>
            <h4 class="font-bold text-xs text-white line-clamp-1 mt-0.5">{{ p.name }}</h4>
            <div class="flex items-center justify-between mt-2">
              <span class="font-black text-brand-500 text-sm">৳{{ (p.sale_price || p.price).toLocaleString() }}</span>
              <button @click="cartStore.addToCart(p.id, 1)" class="px-3 py-1.5 taobao-gradient-orange text-white rounded-xl text-xs font-black">
                + Add
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 4: Recommended Products (Taobao High-Density Grid) -->
    <section class="my-10">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-2xl font-black text-gray-900 dark:text-white">Recommended For You</h2>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">High-density marketplace recommendations based on popularity.</p>
        </div>
        <router-link to="/shop" class="text-xs font-bold text-brand-500 hover:underline">
          View All Items →
        </router-link>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <ProductCard v-for="product in featured" :key="product.id" :product="product" />
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ProductCard from '@/components/storefront/ProductCard.vue';
import { useAuthStore } from '@/stores/auth';
import { useCartStore } from '@/stores/cart';

const authStore = useAuthStore();
const cartStore = useCartStore();

const categories = ref([]);
const featured = ref([]);
const flashSales = ref([]);

const fallbackCategories = [
  { id: 1, name: 'Laptops & Computers' },
  { id: 2, name: 'Smartphones & Accessories' },
  { id: 3, name: 'Audio & Headphones' },
  { id: 4, name: 'Smart Wearables' },
  { id: 5, name: 'Gaming Gear & Components' },
];

const fallbackProducts = [
  {
    id: 1,
    name: 'Pro Ultra Gaming Laptop 16" OLED 240Hz',
    price: 185000,
    sale_price: 169000,
    b2b_price: 145000,
    moq: 1,
    is_flash_sale: true,
    image_url: 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500&q=80',
    category: { name: 'Laptops' },
  },
  {
    id: 2,
    name: 'Wireless ANC Noise-Canceling Headphones',
    price: 12500,
    sale_price: 9900,
    b2b_price: 7800,
    moq: 5,
    is_flash_sale: false,
    image_url: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80',
    category: { name: 'Audio' },
  },
  {
    id: 3,
    name: 'Precision RGB Ergonomic Wireless Mouse',
    price: 4500,
    sale_price: 3200,
    b2b_price: 2400,
    moq: 10,
    is_flash_sale: true,
    image_url: 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500&q=80',
    category: { name: 'Gaming Gear' },
  },
  {
    id: 4,
    name: 'Mechanical RGB Hot-Swappable Keyboard',
    price: 8900,
    sale_price: 7400,
    b2b_price: 5800,
    moq: 3,
    is_flash_sale: false,
    image_url: 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&q=80',
    category: { name: 'Gaming Gear' },
  },
  {
    id: 5,
    name: 'Smart Fitness Watch Series 9 GPS',
    price: 24000,
    sale_price: 19500,
    b2b_price: 16000,
    moq: 2,
    is_flash_sale: true,
    image_url: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80',
    category: { name: 'Smart Wearables' },
  },
];

onMounted(async () => {
  try {
    const catRes = await axios.get('/api/v1/categories');
    categories.value = catRes.data.data?.length ? catRes.data.data : fallbackCategories;
  } catch (e) {
    categories.value = fallbackCategories;
  }

  try {
    const fRes = await axios.get('/api/v1/products/featured');
    featured.value = fRes.data.data?.length ? fRes.data.data : fallbackProducts;
  } catch (e) {
    featured.value = fallbackProducts;
  }

  try {
    const fsRes = await axios.get('/api/v1/products/flash-sales');
    flashSales.value = fsRes.data.data?.length ? fsRes.data.data : fallbackProducts.slice(0, 3);
  } catch (e) {
    flashSales.value = fallbackProducts.slice(0, 3);
  }
});
</script>
