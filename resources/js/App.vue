<template>
  <div :class="{ 'dark': themeStore.isDark }" class="min-h-screen">
    <router-view />
    <Toast />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useThemeStore } from '@/stores/theme';
import { useAuthStore } from '@/stores/auth';
import Toast from '@/components/common/Toast.vue';

const themeStore = useThemeStore();
const authStore = useAuthStore();

onMounted(() => {
  themeStore.initTheme();
  authStore.checkAuth();
});
</script>
