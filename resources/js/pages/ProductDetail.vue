<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" v-if="product">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
      <!-- Left: Image Gallery -->
      <div class="lg:col-span-6 space-y-4">
        <div class="aspect-square rounded-3xl overflow-hidden glass-card p-4 border border-gray-200 dark:border-gray-800">
          <img :src="activeImage || product.primary_image?.image_url || product.image_url" :alt="product.name" class="w-full h-full object-cover rounded-2xl" />
        </div>
        <div v-if="product.images?.length" class="flex items-center gap-3 overflow-x-auto">
          <button
            v-for="img in product.images"
            :key="img.id"
            @click="activeImage = img.image_url"
            class="w-16 h-16 rounded-xl overflow-hidden border-2 transition-all flex-shrink-0"
            :class="[activeImage === img.image_url ? 'border-brand-500 scale-105' : 'border-transparent opacity-70']"
          >
            <img :src="img.image_url" class="w-full h-full object-cover" />
          </button>
        </div>
      </div>

      <!-- Right: Details & Tier Pricing -->
      <div class="lg:col-span-6 space-y-6">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <span class="px-2.5 py-0.5 rounded-full bg-brand-500/10 text-brand-500 font-extrabold text-[10px] uppercase">
              {{ product.category?.name || 'Electronics' }}
            </span>
            <span v-if="product.is_flash_sale" class="px-2.5 py-0.5 rounded-full bg-tmall-500 text-white font-extrabold text-[10px] uppercase">
              FLASH DEAL
            </span>
          </div>
          <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white leading-tight mb-2">
            {{ product.name }}
          </h1>
          <p class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ product.sku || 'SKU-BESMART-01' }} | Verified Supplier</p>
        </div>

        <!-- Rating & Sales -->
        <div class="flex items-center gap-4 text-xs">
          <div class="flex items-center gap-1 text-gold-500 font-bold">
            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            <span class="text-gray-500 dark:text-gray-400 ml-1">(4.9 / 128 Reviews)</span>
          </div>
          <span class="text-gray-300">|</span>
          <span class="font-bold text-gray-700 dark:text-gray-300">12,400+ Sold</span>
        </div>

        <!-- Pricing Card -->
        <div class="glass-card rounded-2xl p-5 border border-brand-500/30 bg-gradient-to-r from-orange-50/50 to-amber-50/50 dark:from-brand-950/20 dark:to-gray-900">
          <div class="flex items-baseline justify-between">
            <span class="text-xs text-gray-500 font-bold">B2C Retail Price:</span>
            <div class="text-right">
              <span class="text-3xl font-black text-brand-500">৳{{ (product.sale_price || product.price).toLocaleString() }}</span>
              <span v-if="product.sale_price" class="text-xs text-gray-400 line-through ml-2">৳{{ product.price.toLocaleString() }}</span>
            </div>
          </div>

          <!-- B2B Wholesale Tier Pricing Matrix -->
          <div v-if="product.b2b_price || product.b2b_price_tiers?.length" class="mt-4 pt-4 border-t border-brand-500/20">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs font-black text-gold-600 dark:text-gold-400 flex items-center gap-1">
                <span>🏢</span> Wholesale Volume Tiers:
              </span>
              <span class="text-[10px] font-bold text-gray-400">MOQ: {{ product.moq || 1 }} Pcs</span>
            </div>
            <div class="grid grid-cols-3 gap-2 text-center text-xs">
              <div class="p-2 rounded-xl bg-white/80 dark:bg-gray-800 border border-gold-500/30">
                <div class="text-[10px] text-gray-400 font-bold">1 - 4 Pcs</div>
                <div class="font-black text-brand-500">৳{{ (product.sale_price || product.price).toLocaleString() }}</div>
              </div>
              <div class="p-2 rounded-xl bg-white/80 dark:bg-gray-800 border border-gold-500/30">
                <div class="text-[10px] text-gray-400 font-bold">5 - 19 Pcs</div>
                <div class="font-black text-gold-500">৳{{ Math.round((product.sale_price || product.price) * 0.9).toLocaleString() }}</div>
              </div>
              <div class="p-2 rounded-xl bg-white/80 dark:bg-gray-800 border border-gold-500/30">
                <div class="text-[10px] text-gray-400 font-bold">20+ Pcs</div>
                <div class="font-black text-emerald-500">৳{{ Math.round((product.sale_price || product.price) * 0.8).toLocaleString() }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="flex items-center gap-4 pt-2">
          <div class="flex items-center rounded-2xl border border-gray-300 dark:border-gray-700 overflow-hidden bg-gray-100 dark:bg-gray-800">
            <button @click="quantity = Math.max(product.moq || 1, quantity - 1)" class="px-3.5 py-2.5 font-black text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">-</button>
            <span class="px-4 py-2.5 font-black text-sm text-gray-900 dark:text-white">{{ quantity }}</span>
            <button @click="quantity++" class="px-3.5 py-2.5 font-black text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">+</button>
          </div>

          <button @click="cartStore.addToCart(product.id, quantity)" class="flex-1 py-3.5 rounded-2xl taobao-gradient-orange text-white font-black text-sm shadow-glow hover:opacity-95 transition-opacity flex items-center justify-center gap-2">
            <span>🛒</span> <span>Add to Cart (৳{{ calculatedPrice.toLocaleString() }})</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useCartStore } from '@/stores/cart';

const route = useRoute();
const cartStore = useCartStore();

const product = ref(null);
const activeImage = ref('');
const quantity = ref(1);

const fallbackProducts = [
  {
    id: 1,
    name: 'Pro Ultra Gaming Laptop 16" OLED 240Hz',
    price: 185000,
    sale_price: 169000,
    b2b_price: 145000,
    moq: 1,
    sku: 'LAP-PRO-16',
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
    sku: 'AUD-ANC-02',
    is_flash_sale: false,
    image_url: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80',
    category: { name: 'Audio' },
  },
];

const calculatedPrice = computed(() => {
  if (!product.value) return 0;
  const unitPrice = product.value.sale_price || product.value.price;
  return unitPrice * quantity.value;
});

onMounted(async () => {
  const productId = Number(route.params.id) || 1;
  try {
    const res = await axios.get(`/api/v1/products/${productId}`);
    if (res.data.success) {
      product.value = res.data.data;
    } else {
      throw new Error('Fallback product');
    }
  } catch (e) {
    product.value = fallbackProducts.find(p => p.id === productId) || fallbackProducts[0];
  }
  quantity.value = product.value.moq || 1;
});
</script>
