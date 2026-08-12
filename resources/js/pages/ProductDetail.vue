<template>
  <div v-if="product" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start mb-12">
      <!-- Gallery -->
      <div class="space-y-4">
        <div class="aspect-square rounded-3xl overflow-hidden glass-card border border-gray-200 dark:border-gray-800">
          <img :src="activeImage || product.primary_image?.image_url || 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800&q=80'" class="w-full h-full object-cover" />
        </div>
        <div class="flex items-center gap-3 overflow-x-auto pb-2">
          <button v-for="img in product.images" :key="img.id" @click="activeImage = img.image_url" class="w-20 h-20 rounded-xl overflow-hidden border-2 transition-all flex-shrink-0" :class="[activeImage === img.image_url ? 'border-brand-500' : 'border-transparent']">
            <img :src="img.image_url" class="w-full h-full object-cover" />
          </button>
        </div>
      </div>

      <!-- Specs & Purchase Matrix -->
      <div>
        <div class="flex items-center gap-2 mb-2">
          <span class="px-2.5 py-0.5 rounded-md bg-brand-500/10 text-brand-500 font-bold text-xs uppercase">{{ product.category?.name }}</span>
          <span class="text-xs text-gray-400">SKU: {{ product.sku }}</span>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">{{ product.name }}</h1>

        <!-- FOMO indicators -->
        <FOMOBadges v-if="fomo" :fomo="fomo" />

        <!-- Price Breakdown -->
        <div class="glass-card rounded-2xl p-6 my-6 border border-gray-200 dark:border-gray-800">
          <div class="flex items-baseline gap-4 mb-2">
            <span class="text-3xl font-black text-gray-900 dark:text-white">৳{{ (product.sale_price || product.price).toLocaleString() }}</span>
            <span v-if="product.sale_price" class="text-lg text-gray-400 line-through">৳{{ product.price.toLocaleString() }}</span>
          </div>

          <!-- B2B Quantity Tier Matrix Table -->
          <div v-if="product.b2b_price_tiers?.length" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
            <h4 class="text-xs font-bold text-amber-500 uppercase tracking-wider mb-2">⚡ Wholesale B2B Volume Pricing Tiers</h4>
            <div class="grid grid-cols-3 gap-2 text-xs">
              <div v-for="tier in product.b2b_price_tiers" :key="tier.id" class="p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-center">
                <span class="block text-gray-400 font-medium">{{ tier.min_quantity }}{{ tier.max_quantity ? ` - ${tier.max_quantity}` : '+' }} units</span>
                <span class="font-extrabold text-amber-400 text-sm">৳{{ tier.unit_price.toLocaleString() }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="flex items-center gap-4 my-6">
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Quantity</label>
            <input v-model.number="quantity" type="number" :min="product.moq || 1" class="w-24 px-3 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-bold text-center dark:text-white" />
          </div>
          <div class="flex-1">
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">&nbsp;</label>
            <button @click="cartStore.addToCart(product.id, quantity)" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-brand-600 to-blue-600 hover:from-brand-700 hover:to-blue-700 text-white font-extrabold text-sm shadow-glow transition-all">
              🛒 Add To Cart (৳{{ (calculatedPrice * quantity).toLocaleString() }})
            </button>
          </div>
        </div>

        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
          <p>✔ Free Shipping on orders over ৳2,000</p>
          <p>✔ 2-Year Replacement Warranty included</p>
          <p v-if="product.moq > 1" class="text-amber-500 font-bold">⚠️ Minimum Order Quantity: {{ product.moq }} units</p>
        </div>
      </div>
    </div>

    <!-- Smart Setup Bundles -->
    <SmartBundles v-if="bundle" :bundle="bundle" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useCartStore } from '@/stores/cart';
import FOMOBadges from '@/components/storefront/FOMOBadges.vue';
import SmartBundles from '@/components/storefront/SmartBundles.vue';

const route = useRoute();
const cartStore = useCartStore();

const product = ref(null);
const bundle = ref(null);
const fomo = ref(null);
const activeImage = ref(null);
const quantity = ref(1);

const calculatedPrice = computed(() => {
  if (!product.value) return 0;
  const tiers = product.value.b2b_price_tiers || [];
  for (const tier of tiers) {
    if (quantity.value >= tier.min_quantity && (!tier.max_quantity || quantity.value <= tier.max_quantity)) {
      return tier.unit_price;
    }
  }
  return product.value.sale_price || product.value.price;
});

onMounted(async () => {
  try {
    const res = await axios.get(`/api/v1/products/${route.params.id}`);
    if (res.data.success) {
      product.value = res.data.data.product;
      bundle.value = res.data.data.bundle;
      fomo.value = res.data.data.fomo;
      quantity.value = product.value.moq || 1;
    }
  } catch (e) {
    console.error(e);
  }
});
</script>
