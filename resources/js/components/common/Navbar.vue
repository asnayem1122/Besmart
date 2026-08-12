<template>
  <header class="sticky top-0 z-40 bg-white/95 dark:bg-[#0c0f17]/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors shadow-sm">
    <!-- Taobao Top Announcement & Shortcut Bar -->
    <div class="taobao-gradient-orange text-white text-xs py-1.5 px-4 font-medium flex items-center justify-between">
      <div class="hidden md:flex items-center gap-3">
        <span class="px-2 py-0.5 bg-black/20 rounded font-extrabold text-[10px] tracking-wider">TAOBAO STYLE</span>
        <span>Shop Smart. Buy Better. Direct Factory Wholesale & B2C Shopping</span>
      </div>
      <div class="flex items-center gap-4 mx-auto md:mx-0">
        <button @click="$emit('open-wheel')" class="font-black underline hover:text-gold-400 transition-colors flex items-center gap-1">
          🎯 Spin Wheel of Fortune (Win up to 20% OFF!)
        </button>
        <span class="text-white/40">|</span>
        <router-link v-if="authStore.isB2B" to="/b2b/dashboard" class="bg-gold-500 text-gray-950 px-2.5 py-0.5 rounded font-black text-[11px] hover:bg-gold-400">
          Wholesale B2B Dashboard →
        </router-link>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-6">
      <!-- Taobao Brand Logo -->
      <router-link to="/" class="flex items-center gap-3 flex-shrink-0">
        <div class="w-11 h-11 rounded-2xl taobao-gradient-orange flex items-center justify-center text-white font-black text-2xl shadow-glow">
          B
        </div>
        <div class="flex flex-col">
          <div class="flex items-center gap-1.5">
            <span class="font-black text-2xl tracking-tight text-brand-500 leading-none">Besmart</span>
            <span class="px-1.5 py-0.5 bg-tmall-500 text-white font-extrabold text-[9px] rounded uppercase">MALL</span>
          </div>
          <span class="text-[10px] text-gray-500 dark:text-gray-400 font-bold tracking-wider uppercase mt-0.5">MEGA MARKETPLACE</span>
        </div>
      </router-link>

      <!-- Taobao Signature Tabbed Mega Search Header -->
      <div class="flex-1 max-w-2xl hidden md:block">
        <!-- Search Category Tabs -->
        <div class="flex items-center gap-4 text-xs font-bold mb-1 pl-1">
          <button @click="searchTab = 'all'" :class="[searchTab === 'all' ? 'text-brand-500 border-b-2 border-brand-500 pb-0.5' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white']">
            All Goods
          </button>
          <button @click="searchTab = 'wholesale'" :class="[searchTab === 'wholesale' ? 'text-brand-500 border-b-2 border-brand-500 pb-0.5' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white']">
            Factory Wholesale Tiers
          </button>
          <button @click="searchTab = 'import'" :class="[searchTab === 'import' ? 'text-brand-500 border-b-2 border-brand-500 pb-0.5' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white']">
            China Landed Cost Import
          </button>
        </div>

        <!-- Search Bar with Camera Icon Placeholder -->
        <div class="relative flex items-center">
          <input
            v-model="searchQuery"
            @keyup.enter="handleSearch"
            type="text"
            placeholder="Search products, SKUs, or type e.g. 'gaming mouse under 3000'..."
            class="w-full pl-4 pr-32 py-2.5 rounded-2xl bg-gray-100 dark:bg-gray-800/90 border-2 border-brand-500 text-sm focus:outline-none dark:text-white"
          />
          <button title="Image Search" class="absolute right-24 text-gray-400 hover:text-brand-500 text-lg">
            📷
          </button>
          <button @click="handleSearch" class="absolute right-1 px-5 py-1.5 taobao-gradient-orange text-white rounded-xl text-xs font-extrabold shadow-md hover:opacity-95">
            Search
          </button>
        </div>

        <!-- Trending Search Quick Tags -->
        <div class="flex items-center gap-3 text-[11px] text-gray-500 dark:text-gray-400 mt-1.5 pl-1 overflow-x-auto">
          <span class="font-bold text-brand-500">Trending:</span>
          <router-link to="/shop?search=Laptop" class="hover:text-brand-500">Gaming Laptops</router-link>
          <router-link to="/shop?search=Headphones" class="hover:text-brand-500">ANC Headphones</router-link>
          <router-link to="/shop?search=Mouse" class="hover:text-brand-500">RGB Mice</router-link>
          <router-link to="/shop?search=Power" class="hover:text-brand-500">Power Banks</router-link>
        </div>
      </div>

      <!-- Quick Action Icons -->
      <div class="flex items-center gap-3">
        <ThemeToggle />

        <!-- Cart Drawer Button -->
        <router-link to="/cart" class="relative p-2.5 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-brand-500/10 transition-colors">
          <span class="text-xl">🛒</span>
          <span v-if="cartStore.itemCount > 0" class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-brand-500 text-white text-[11px] font-black flex items-center justify-center shadow-md animate-pulse">
            {{ cartStore.itemCount }}
          </span>
        </router-link>

        <!-- User Profile Dropdown -->
        <template v-if="authStore.isAuthenticated">
          <div class="relative group">
            <button class="flex items-center gap-2 px-3 py-2 rounded-2xl bg-gray-100 dark:bg-gray-800 text-xs font-bold hover:bg-gray-200 dark:hover:bg-gray-700">
              <div class="w-7 h-7 rounded-full taobao-gradient-orange text-white flex items-center justify-center font-extrabold text-xs">
                {{ authStore.user?.name?.charAt(0) }}
              </div>
              <span class="max-w-[90px] truncate hidden sm:inline">{{ authStore.user?.name }}</span>
            </button>
            <div class="absolute right-0 mt-1 w-48 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 py-2 hidden group-hover:block z-50">
              <router-link v-if="authStore.isAdmin" to="/admin/dashboard" class="block px-4 py-2 text-xs font-bold text-purple-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                Admin Center
              </router-link>
              <router-link v-if="authStore.isB2B" to="/b2b/dashboard" class="block px-4 py-2 text-xs font-bold text-amber-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                B2B BI Dashboard
              </router-link>
              <router-link to="/customer/dashboard" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                My Profile & Orders
              </router-link>
              <button @click="authStore.logout(); $router.push('/')" class="w-full text-left px-4 py-2 text-xs text-rose-500 font-bold hover:bg-gray-100 dark:hover:bg-gray-800">
                Sign Out
              </button>
            </div>
          </div>
        </template>
        <template v-else>
          <router-link to="/login" class="px-3.5 py-2 rounded-xl border border-gray-300 dark:border-gray-700 text-xs font-bold hover:bg-gray-100 dark:hover:bg-gray-800">
            Sign In
          </router-link>
          <router-link to="/register" class="px-4 py-2 rounded-xl taobao-gradient-orange text-white text-xs font-black shadow-glow">
            Register
          </router-link>
        </template>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCartStore } from '@/stores/cart';
import ThemeToggle from '@/components/common/ThemeToggle.vue';

const router = useRouter();
const authStore = useAuthStore();
const cartStore = useCartStore();

const searchQuery = ref('');
const searchTab = ref('all');

function handleSearch() {
  if (searchQuery.value.trim()) {
    router.push({ name: 'shop', query: { search: searchQuery.value } });
  }
}
</script>
