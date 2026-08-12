<template>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8">Multi-Step Checkout</h1>

    <form @submit.prevent="submitOrder" class="glass-card rounded-3xl p-6 md:p-8 space-y-8 border border-gray-200 dark:border-gray-800">
      <!-- Shipping Address -->
      <div>
        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">1. Delivery Address</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Full Name</label>
            <input v-model="form.shipping_address.name" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Phone Number</label>
            <input v-model="form.shipping_address.phone" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
          </div>
          <div class="md:col-span-2">
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Street Address</label>
            <input v-model="form.shipping_address.address" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">City</label>
            <input v-model="form.shipping_address.city" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
          </div>
        </div>
      </div>

      <!-- Payment Gateway Selection -->
      <div class="pt-6 border-t border-gray-200 dark:border-gray-800">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">2. Select Payment Gateway</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <label v-for="g in gateways" :key="g.id" class="p-4 rounded-2xl border cursor-pointer text-center transition-all" :class="[form.payment_method === g.id ? 'border-brand-500 bg-brand-500/10 font-bold' : 'border-gray-200 dark:border-gray-800']">
            <input type="radio" v-model="form.payment_method" :value="g.id" class="sr-only" />
            <span class="text-xl block mb-1">{{ g.icon }}</span>
            <span class="text-xs text-gray-900 dark:text-white block">{{ g.name }}</span>
          </label>
        </div>
      </div>

      <div class="pt-6 border-t border-gray-200 dark:border-gray-800 flex items-center justify-between">
        <div>
          <span class="text-xs text-gray-400 block">Total Amount:</span>
          <span class="text-2xl font-black text-brand-500">৳{{ cartStore.total.toLocaleString() }}</span>
        </div>
        <button type="submit" :disabled="loading" class="px-8 py-3.5 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-glow disabled:opacity-50">
          {{ loading ? 'Processing Order...' : 'Place Order Now →' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useCartStore } from '@/stores/cart';
import { useAuthStore } from '@/stores/auth';
import { useNotificationStore } from '@/stores/notification';

const router = useRouter();
const cartStore = useCartStore();
const authStore = useAuthStore();
const notify = useNotificationStore();

const loading = ref(false);

const form = reactive({
  shipping_address: {
    name: authStore.user?.name || '',
    phone: authStore.user?.phone || '+8801700000000',
    address: 'House 42, Road 11, Banani',
    city: 'Dhaka',
  },
  payment_method: 'cod',
  notes: '',
});

const gateways = [
  { id: 'cod', name: 'Cash on Delivery', icon: '💵' },
  { id: 'stripe', name: 'Credit Card / Stripe', icon: '💳' },
  { id: 'sslcommerz', name: 'SSLCommerz (Cards/NetBanking)', icon: '🔒' },
  { id: 'bkash', name: 'bKash Mobile Wallet', icon: '📱' },
];

async function submitOrder() {
  loading.value = true;
  try {
    const res = await axios.post('/api/v1/checkout', form);
    if (res.data.success) {
      notify.show('Order placed successfully!', 'success');
      cartStore.fetchCart();
      router.push({ name: 'customer-dashboard' });
    }
  } catch (e) {
    notify.show(e.response?.data?.message || 'Error processing checkout.', 'error');
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  cartStore.fetchCart();
});
</script>
