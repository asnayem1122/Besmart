<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-gray-800">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Besmart Shop Catalog</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Browse retail & B2B wholesale pricing across all categories.</p>
      </div>

      <div class="flex items-center gap-3">
        <select v-model="selectedSort" @change="fetchProducts" class="px-3 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-900 dark:text-white">
          <option value="newest">Newest First</option>
          <option value="price_asc">Price: Low to High</option>
          <option value="price_desc">Price: High to Low</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Sidebar Filters -->
      <aside class="lg:col-span-1 glass-card rounded-2xl p-6 h-fit space-y-6">
        <div>
          <h4 class="font-bold text-xs uppercase tracking-wider text-gray-400 mb-3">Category Filter</h4>
          <div class="space-y-2 text-xs">
            <button @click="selectedCategory = null; fetchProducts()" :class="[selectedCategory === null ? 'font-bold text-brand-500' : 'text-gray-600 dark:text-gray-400']" class="block w-full text-left">
              All Categories
            </button>
            <button v-for="cat in categories" :key="cat.id" @click="selectedCategory = cat.id; fetchProducts()" :class="[selectedCategory === cat.id ? 'font-bold text-brand-500' : 'text-gray-600 dark:text-gray-400']" class="block w-full text-left">
              {{ cat.name }}
            </button>
          </div>
        </div>

        <div>
          <h4 class="font-bold text-xs uppercase tracking-wider text-gray-400 mb-3">Price Range (BDT)</h4>
          <div class="flex items-center gap-2 text-xs">
            <input v-model.number="minPrice" type="number" placeholder="Min" class="w-full px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 dark:text-white" />
            <span>-</span>
            <input v-model.number="maxPrice" type="number" placeholder="Max" class="w-full px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 dark:text-white" />
          </div>
          <button @click="fetchProducts" class="w-full mt-3 py-2 bg-brand-600 text-white rounded-xl text-xs font-bold">
            Apply Filters
          </button>
        </div>
      </aside>

      <!-- Products Grid -->
      <main class="lg:col-span-3">
        <div v-if="loading" class="text-center py-12 text-gray-400 text-sm">
          Loading product catalog...
        </div>
        <div v-else-if="products.length === 0" class="glass-card rounded-2xl p-12 text-center text-gray-400">
          No products matched your search criteria.
        </div>
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <ProductCard v-for="p in products" :key="p.id" :product="p" />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import ProductCard from '@/components/storefront/ProductCard.vue';

const route = useRoute();
const products = ref([]);
const categories = ref([]);
const loading = ref(false);

const selectedCategory = ref(null);
const selectedSort = ref('newest');
const minPrice = ref(null);
const maxPrice = ref(null);

async function fetchProducts() {
  loading.value = true;
  try {
    const params = {
      sort: selectedSort.value,
      search: route.query.search || '',
    };
    if (selectedCategory.value) params.category_id = selectedCategory.value;
    if (minPrice.value) params.min_price = minPrice.value;
    if (maxPrice.value) params.max_price = maxPrice.value;

    const res = await axios.get('/api/v1/products', { params });
    products.value = res.data.data.data;
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
}

onMounted(async () => {
  try {
    const catRes = await axios.get('/api/v1/categories');
    categories.value = catRes.data.data;
  } catch (e) {}
  fetchProducts();
});

watch(() => route.query.search, () => fetchProducts());
</script>
