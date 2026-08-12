<template>
  <div class="max-w-md mx-auto my-12 p-8 glass-card rounded-3xl border border-gray-200 dark:border-gray-800 shadow-2xl">
    <div class="text-center mb-6">
      <h2 class="text-2xl font-black text-gray-900 dark:text-white">Create Besmart Account</h2>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Select B2C Customer or B2B Wholesale Retailer</p>
    </div>

    <form @submit.prevent="handleRegister" class="space-y-4">
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Role</label>
        <div class="grid grid-cols-2 gap-2">
          <button type="button" @click="form.role = 'b2c'" :class="[form.role === 'b2c' ? 'bg-brand-600 text-white font-bold' : 'bg-gray-100 dark:bg-gray-800 text-gray-400']" class="py-2.5 rounded-xl text-xs">
            B2C Customer
          </button>
          <button type="button" @click="form.role = 'b2b'" :class="[form.role === 'b2b' ? 'bg-amber-500 text-gray-950 font-bold' : 'bg-gray-100 dark:bg-gray-800 text-gray-400']" class="py-2.5 rounded-xl text-xs">
            B2B Retailer
          </button>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Full Name</label>
        <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email Address</label>
        <input v-model="form.email" type="email" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Password</label>
        <input v-model="form.password" type="password" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm dark:text-white" />
      </div>

      <template v-if="form.role === 'b2b'">
        <div>
          <label class="block text-xs font-bold text-amber-400 uppercase mb-1">Company / Store Name</label>
          <input v-model="form.company_name" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-amber-500/40 text-sm dark:text-white" />
        </div>
        <div>
          <label class="block text-xs font-bold text-amber-400 uppercase mb-1">Trade License Number</label>
          <input v-model="form.trade_license" type="text" class="w-full px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-amber-500/40 text-sm dark:text-white" />
        </div>
      </template>

      <button type="submit" :disabled="loading" class="w-full py-3.5 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-glow disabled:opacity-50">
        {{ loading ? 'Registering...' : 'Complete Registration →' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useNotificationStore } from '@/stores/notification';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();
const notify = useNotificationStore();

const loading = ref(false);
const form = reactive({
  name: '',
  email: '',
  password: '',
  role: 'b2c',
  company_name: '',
  trade_license: '',
});

onMounted(() => {
  if (route.query.role === 'b2b') {
    form.role = 'b2b';
  }
});

async function handleRegister() {
  loading.value = true;
  try {
    const res = await authStore.register(form);
    if (res.success) {
      notify.show('Account created successfully!', 'success');
      if (form.role === 'b2b') router.push({ name: 'b2b-dashboard' });
      else router.push({ name: 'home' });
    }
  } catch (e) {
    notify.show(e.response?.data?.message || 'Error registering account.', 'error');
  } finally {
    loading.value = false;
  }
}
</script>
