<template>
  <div class="max-w-md mx-auto my-12 p-8 glass-card rounded-3xl border border-gray-200 dark:border-gray-800 shadow-2xl">
    <div class="text-center mb-6">
      <div class="w-12 h-12 rounded-2xl taobao-gradient-orange text-white font-black text-2xl flex items-center justify-center mx-auto mb-2 shadow-glow">B</div>
      <h2 class="text-2xl font-black text-gray-900 dark:text-white">Sign In to Besmart</h2>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Access B2C Retail & B2B Wholesale Portals</p>
    </div>

    <form @submit.prevent="handleLogin" class="space-y-4">
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email Address</label>
        <input v-model="form.email" type="email" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Password</label>
        <input v-model="form.password" type="password" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
      </div>

      <button type="submit" :disabled="loading" class="w-full py-3.5 rounded-2xl taobao-gradient-orange text-white font-black text-sm shadow-glow disabled:opacity-50">
        {{ loading ? 'Signing In...' : 'Sign In →' }}
      </button>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-800 text-center text-xs space-y-3">
      <div class="text-gray-500 font-bold">Quick Demo One-Click Logins:</div>
      <div class="grid grid-cols-3 gap-2">
        <button type="button" @click="quickLogin('admin@besmart.com')" class="p-2 bg-purple-500/20 text-purple-400 rounded-xl font-bold hover:bg-purple-500/30">
          👑 Admin
        </button>
        <button type="button" @click="quickLogin('b2b@techmart.com')" class="p-2 bg-amber-500/20 text-amber-400 rounded-xl font-bold hover:bg-amber-500/30">
          🏢 B2B Trade
        </button>
        <button type="button" @click="quickLogin('customer@gmail.com')" class="p-2 bg-brand-500/20 text-brand-400 rounded-xl font-bold hover:bg-brand-500/30">
          🛍️ B2C User
        </button>
      </div>
      <p class="text-gray-500 pt-2">Don't have an account? <router-link to="/register" class="text-brand-500 font-bold">Register here</router-link></p>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCartStore } from '@/stores/cart';
import { useNotificationStore } from '@/stores/notification';

const router = useRouter();
const authStore = useAuthStore();
const cartStore = useCartStore();
const notify = useNotificationStore();

const loading = ref(false);
const form = reactive({ email: '', password: '' });

async function quickLogin(email) {
  form.email = email;
  form.password = 'password';
  await handleLogin();
}

async function handleLogin() {
  loading.value = true;
  try {
    const res = await authStore.login(form);
    if (res.success) {
      notify.show(`Welcome back, ${res.data.user.name}!`, 'success');
      await cartStore.fetchCart();
      if (authStore.isAdmin) router.push({ name: 'admin-dashboard' });
      else if (authStore.isB2B) router.push({ name: 'b2b-dashboard' });
      else router.push({ name: 'home' });
    }
  } catch (e) {
    notify.show(e.response?.data?.message || 'Invalid login credentials.', 'error');
  } finally {
    loading.value = false;
  }
}
</script>
