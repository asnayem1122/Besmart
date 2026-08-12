<template>
  <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-[#0b0f19] text-gray-900 dark:text-gray-100 font-sans">
    <!-- Main Storefront Navbar -->
    <Navbar @open-wheel="showWheelModal = true" />

    <!-- Main View Content -->
    <main class="flex-grow">
      <router-view />
    </main>

    <!-- Footer -->
    <Footer />

    <!-- Floating Besmart AI Shopping Assistant Widget -->
    <BesmartAIChatbot />

    <!-- Gamified Spinning Discount Wheel Modal -->
    <DiscountWheel v-if="showWheelModal" @close="showWheelModal = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Navbar from '@/components/common/Navbar.vue';
import Footer from '@/components/common/Footer.vue';
import BesmartAIChatbot from '@/components/ai/BesmartAIChatbot.vue';
import DiscountWheel from '@/components/gamification/DiscountWheel.vue';

const showWheelModal = ref(false);
</script>
