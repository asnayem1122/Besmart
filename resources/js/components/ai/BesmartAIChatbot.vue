<template>
  <div>
    <!-- Floating Launcher Trigger Button -->
    <button @click="isOpen = !isOpen" class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full bg-gradient-to-tr from-brand-600 via-blue-600 to-indigo-600 text-white font-bold text-2xl shadow-glow flex items-center justify-center hover:scale-110 transition-transform">
      <span v-if="!isOpen">🤖</span>
      <span v-else>✕</span>
    </button>

    <!-- Floating Chat Drawer -->
    <div v-if="isOpen" class="fixed bottom-24 right-6 z-50 w-96 max-w-[90vw] h-[520px] bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col overflow-hidden">
      <!-- Drawer Header -->
      <div class="p-4 bg-gradient-to-r from-brand-600 to-blue-700 text-white flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-bold">🤖</div>
          <div>
            <h3 class="font-bold text-sm">Besmart AI Assistant</h3>
            <p class="text-[10px] text-blue-200">Real DB Product Recommendations</p>
          </div>
        </div>
        <button @click="isOpen = false" class="text-white hover:opacity-80">✕</button>
      </div>

      <!-- Messages Stream -->
      <div class="flex-1 p-4 overflow-y-auto space-y-4 text-xs">
        <div v-for="(msg, index) in messages" :key="index" :class="[msg.sender === 'user' ? 'text-right' : 'text-left']">
          <div :class="[msg.sender === 'user' ? 'bg-brand-600 text-white ml-auto' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200']" class="inline-block p-3 rounded-2xl max-w-[85%]">
            <p class="whitespace-pre-line leading-relaxed">{{ msg.text }}</p>

            <!-- Product Cards Array from DB -->
            <div v-if="msg.products && msg.products.length" class="mt-3 space-y-2">
              <div v-for="p in msg.products" :key="p.id" class="p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-left flex items-center gap-3">
                <img :src="p.image_url" class="w-12 h-12 rounded-lg object-cover" />
                <div class="flex-1 min-w-0">
                  <h5 class="font-bold text-xs text-gray-900 dark:text-white truncate">{{ p.name }}</h5>
                  <div class="flex items-center justify-between mt-1">
                    <span class="font-extrabold text-brand-500">৳{{ p.price.toLocaleString() }}</span>
                    <button @click="cartStore.addToCart(p.id, 1)" class="px-2 py-1 bg-brand-600 text-white text-[10px] font-bold rounded-md">
                      + Add
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="loading" class="text-left text-gray-400 italic text-xs">
          Besmart AI searching product database...
        </div>
      </div>

      <!-- Input Bar -->
      <form @submit.prevent="sendMessage" class="p-3 border-t border-gray-200 dark:border-gray-800 flex items-center gap-2">
        <input
          v-model="inputQuery"
          type="text"
          placeholder="Ask e.g. 'gaming mouse under 3000'..."
          class="flex-1 px-3 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs text-gray-900 dark:text-white focus:outline-none"
        />
        <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-xl font-bold text-xs">
          Send
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useCartStore } from '@/stores/cart';

const cartStore = useCartStore();
const isOpen = ref(false);
const loading = ref(false);
const inputQuery = ref('');

const messages = ref([
  {
    sender: 'bot',
    text: "Hello! I am Besmart AI. I search our real inventory database. Try asking:\n• 'Gaming mouse under 3000 taka'\n• 'Show me laptops for office'",
    products: []
  }
]);

async function sendMessage() {
  if (!inputQuery.value.trim()) return;

  const userText = inputQuery.value;
  messages.value.push({ sender: 'user', text: userText });
  inputQuery.value = '';
  loading.value = true;

  try {
    const res = await axios.post('/api/v1/ai/chat', { prompt: userText });
    if (res.data.success) {
      messages.value.push({
        sender: 'bot',
        text: res.data.data.reply,
        products: res.data.data.products
      });
    }
  } catch (e) {
    messages.value.push({ sender: 'bot', text: 'Error connecting to AI service.' });
  } finally {
    loading.value = false;
  }
}
</script>
