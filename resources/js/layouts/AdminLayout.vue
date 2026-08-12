<template>
  <div class="min-h-screen flex bg-gray-950 text-gray-100 font-sans">
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col justify-between hidden md:flex">
      <div>
        <div class="p-5 border-b border-gray-800 flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-600 to-brand-500 flex items-center justify-center text-white font-bold text-xl shadow-glow">
            A
          </div>
          <div>
            <h1 class="font-bold text-lg text-white">Besmart Admin</h1>
            <p class="text-xs text-purple-400 font-medium">Control Center</p>
          </div>
        </div>

        <nav class="p-4 space-y-1">
          <router-link to="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-purple-600/80 text-white shadow-glow">
            <span>Control Panel & Stats</span>
          </router-link>
          <router-link to="/shop" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
            <span>View Catalog</span>
          </router-link>
        </nav>
      </div>

      <div class="p-4 border-t border-gray-800">
        <button @click="authStore.logout(); $router.push('/')" class="w-full text-left text-xs font-semibold text-rose-400 hover:text-rose-300 py-2 px-3">
          Logout Admin →
        </button>
      </div>
    </aside>

    <!-- Main Workspace -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="h-16 bg-gray-900/80 backdrop-blur-md border-b border-gray-800 px-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <router-link to="/" class="text-sm text-gray-400 hover:text-white">← Storefront</router-link>
          <span class="text-gray-700">|</span>
          <h2 class="font-bold text-lg text-white">Platform Administration</h2>
        </div>
        <ThemeToggle />
      </header>

      <main class="flex-1 p-6 overflow-y-auto">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth';
import ThemeToggle from '@/components/common/ThemeToggle.vue';

const authStore = useAuthStore();
</script>
