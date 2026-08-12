<template>
  <div class="space-y-6">
    <div class="glass-card rounded-3xl p-6 border border-gray-200 dark:border-gray-800">
      <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Welcome, {{ authStore.user?.name }}</h2>
      <p class="text-xs text-gray-500 dark:text-gray-400">Account Type: <span class="font-bold uppercase text-brand-500">{{ authStore.user?.role }}</span></p>
    </div>

    <div class="glass-card rounded-3xl p-6 border border-gray-200 dark:border-gray-800">
      <h3 class="font-bold text-base text-gray-900 dark:text-white mb-4">My Orders</h3>
      <div v-if="orders.length === 0" class="text-xs text-gray-400">No orders placed yet.</div>
      <div v-else class="space-y-3">
        <div v-for="order in orders" :key="order.id" class="p-4 rounded-2xl bg-gray-100 dark:bg-gray-800/80 flex items-center justify-between text-xs">
          <div>
            <span class="font-bold text-gray-900 dark:text-white block">{{ order.order_number }}</span>
            <span class="text-gray-500">Total: ৳{{ order.total_amount?.toLocaleString() }}</span>
          </div>
          <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-500 font-bold uppercase">
            {{ order.status }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const orders = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/v1/auth/me');
    if (res.data.data?.orders) {
      orders.value = res.data.data.orders;
    }
  } catch (e) {}
});
</script>
