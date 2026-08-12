<template>
  <div v-if="adminData" class="space-y-8">
    <h1 class="text-3xl font-extrabold text-white">Platform Administration Center</h1>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-gray-900 p-5 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Total Revenue</span>
        <span class="text-2xl font-black text-emerald-400">৳{{ adminData.stats.total_revenue.toLocaleString() }}</span>
      </div>
      <div class="bg-gray-900 p-5 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Total Orders</span>
        <span class="text-2xl font-black text-white">{{ adminData.stats.total_orders }}</span>
      </div>
      <div class="bg-gray-900 p-5 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">B2B Retail Accounts</span>
        <span class="text-2xl font-black text-amber-400">{{ adminData.stats.total_b2b_users }}</span>
      </div>
      <div class="bg-gray-900 p-5 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Catalog Products</span>
        <span class="text-2xl font-black text-purple-400">{{ adminData.stats.total_products }}</span>
      </div>
    </div>

    <!-- Low Stock Urgency Table -->
    <div class="bg-gray-900 p-6 rounded-3xl border border-gray-800">
      <h3 class="text-lg font-bold text-white mb-4">Inventory Alert - Low Stock Threshold</h3>
      <div class="space-y-2 text-xs text-gray-300">
        <div v-for="p in adminData.low_stock_products" :key="p.id" class="p-3 rounded-xl bg-rose-950/40 border border-rose-500/30 flex justify-between items-center">
          <div>
            <span class="font-bold text-white block">{{ p.name }}</span>
            <span class="text-[10px] text-gray-400">SKU: {{ p.sku }}</span>
          </div>
          <span class="px-3 py-1 bg-rose-600 text-white font-extrabold rounded-lg">
            Stock: {{ p.stock }} left
          </span>
        </div>
      </div>
    </div>

    <!-- Recent Orders Status Workflow -->
    <div class="bg-gray-900 p-6 rounded-3xl border border-gray-800">
      <h3 class="text-lg font-bold text-white mb-4">Order Management & Fulfillment Status</h3>
      <div class="space-y-3">
        <div v-for="order in adminData.recent_orders" :key="order.id" class="p-4 rounded-2xl bg-gray-950 border border-gray-800 flex items-center justify-between">
          <div>
            <span class="font-bold text-sm text-white block">{{ order.order_number }}</span>
            <span class="text-xs text-gray-400">Total: ৳{{ order.total_amount.toLocaleString() }} | Customer: {{ order.user?.name }}</span>
          </div>

          <select :value="order.status" @change="updateStatus(order.id, $event.target.value)" class="px-3 py-1.5 rounded-xl bg-gray-800 border border-gray-700 text-xs font-bold text-white">
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useNotificationStore } from '@/stores/notification';

const adminData = ref(null);
const notify = useNotificationStore();

async function fetchAdminData() {
  try {
    const res = await axios.get('/api/v1/admin/dashboard');
    if (res.data.success) {
      adminData.value = res.data.data;
    }
  } catch (e) {}
}

async function updateStatus(orderId, status) {
  try {
    const res = await axios.post(`/api/v1/admin/orders/${orderId}/status`, { status });
    if (res.data.success) {
      notify.show(`Order updated to ${status}`, 'success');
      fetchAdminData();
    }
  } catch (e) {
    notify.show('Failed to update order status', 'error');
  }
}

onMounted(() => {
  fetchAdminData();
});
</script>
