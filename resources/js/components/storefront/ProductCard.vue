<template>
  <div class="glass-card rounded-2xl p-3.5 flex flex-col justify-between group hover:shadow-2xl hover:border-brand-500/50 transition-all duration-300 transform hover:-translate-y-1 relative">
    <!-- Badges -->
    <div class="absolute top-5 left-5 z-10 flex flex-col gap-1">
      <span v-if="product.is_flash_sale" class="px-2 py-0.5 rounded bg-tmall-500 text-white text-[9px] font-black tracking-wider uppercase shadow-md">
        FLASH DEAL
      </span>
      <span v-if="product.moq > 1" class="px-2 py-0.5 rounded bg-amber-400 text-gray-950 text-[9px] font-black shadow-md">
        MOQ: {{ product.moq }} Pcs
      </span>
    </div>

    <!-- Product Image -->
    <router-link :to="{ name: 'product-detail', params: { id: product.id } }" class="block aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 mb-3 relative">
      <img
        :src="product.primary_image?.image_url || product.image_url || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80'"
        :alt="product.name"
        class="w-full h-full object-cover object-center group-hover:scale-108 transition-transform duration-500"
      />
    </router-link>

    <!-- Details -->
    <div>
      <div class="flex items-center justify-between text-[10px] text-gray-400 mb-1">
        <span class="font-bold text-brand-500 uppercase">{{ product.category?.name || 'Electronics' }}</span>
        <!-- Taobao Sales Volume Counter -->
        <span class="font-semibold text-gray-500 dark:text-gray-400">{{ (1200 + product.id * 850).toLocaleString() }}+ Sold</span>
      </div>

      <router-link :to="{ name: 'product-detail', params: { id: product.id } }" class="font-bold text-xs text-gray-900 dark:text-white line-clamp-2 hover:text-brand-500 transition-colors mb-2 leading-snug">
        {{ product.name }}
      </router-link>

      <!-- Rating & Buyer Protection -->
      <div class="flex items-center justify-between text-[11px] mb-2.5">
        <div class="flex items-center gap-1 text-gold-500">
          <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
          <span class="text-gray-400 text-[10px] ml-0.5">(4.9)</span>
        </div>
        <span class="text-[9px] px-1.5 py-0.5 bg-emerald-500/10 text-emerald-500 font-extrabold rounded">Verified</span>
      </div>

      <!-- Price Block in Taobao Flame Orange -->
      <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-brand-950/30 dark:to-gray-800/80 rounded-xl p-2 mb-3 border border-brand-500/20">
        <div class="flex items-baseline justify-between">
          <span class="text-[10px] text-gray-500 dark:text-gray-400">Retail Price:</span>
          <div class="text-right">
            <span class="font-black text-lg text-brand-500">৳{{ (product.sale_price || product.price).toLocaleString() }}</span>
            <span v-if="product.sale_price" class="text-[10px] text-gray-400 line-through ml-1">৳{{ product.price.toLocaleString() }}</span>
          </div>
        </div>

        <div v-if="product.b2b_price" class="flex items-baseline justify-between mt-1 pt-1 border-t border-brand-500/10">
          <span class="text-[10px] font-bold text-gold-600 dark:text-gold-400">Factory Wholesale:</span>
          <span class="font-black text-xs text-gold-600 dark:text-gold-400">৳{{ product.b2b_price.toLocaleString() }}</span>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-1.5">
      <button @click="cartStore.addToCart(product.id, product.moq || 1)" class="flex-1 py-2 rounded-xl taobao-gradient-orange text-white font-extrabold text-[11px] shadow-glow hover:opacity-95 transition-opacity">
        Buy Now
      </button>
      <router-link :to="{ name: 'product-detail', params: { id: product.id } }" class="px-2.5 py-2 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-[11px] font-bold hover:bg-gray-100 dark:hover:bg-gray-800">
        View
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '@/stores/cart';

const props = defineProps({
  product: { type: Object, required: true }
});

const cartStore = useCartStore();
</script>
