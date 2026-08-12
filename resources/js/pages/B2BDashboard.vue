<template>
  <div v-if="dashboard" class="space-y-8">
    <!-- Top Business Header Card -->
    <div class="glass-card rounded-3xl p-6 border border-gray-800 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center gap-3">
          <h1 class="text-2xl font-black text-white">{{ dashboard.business?.company_name || 'TechMart Electronics Ltd' }}</h1>
          <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold border border-emerald-500/30">
            ✓ APPROVED WHOLESALE ACCOUNT
          </span>
        </div>
        <p class="text-xs text-gray-400 mt-1">Trade License: {{ dashboard.business?.trade_license }} | VAT ID: {{ dashboard.business?.vat_number }}</p>
      </div>

      <div class="bg-gray-900 p-3 rounded-2xl border border-gray-800 text-right">
        <span class="text-xs text-gray-400 block">Available Credit Line</span>
        <span class="text-xl font-extrabold text-amber-400">৳{{ (dashboard.business?.credit_limit || 500000).toLocaleString() }}</span>
      </div>
    </div>

    <!-- 6 KPI Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
      <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Total Spending</span>
        <span class="text-lg font-extrabold text-white">৳{{ (dashboard.analytics.kpis.total_spending || 0).toLocaleString() }}</span>
      </div>
      <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Total Orders</span>
        <span class="text-lg font-extrabold text-brand-400">{{ dashboard.analytics.kpis.total_orders }}</span>
      </div>
      <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Avg Order Value</span>
        <span class="text-lg font-extrabold text-white">৳{{ (dashboard.analytics.kpis.average_order_value || 0).toLocaleString() }}</span>
      </div>
      <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Bulk Savings</span>
        <span class="text-lg font-extrabold text-emerald-400">৳{{ (dashboard.analytics.kpis.total_savings || 0).toLocaleString() }}</span>
      </div>
      <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">Est. Resell Profit</span>
        <span class="text-lg font-extrabold text-amber-400">৳{{ (dashboard.analytics.kpis.estimated_profit || 0).toLocaleString() }}</span>
      </div>
      <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800">
        <span class="text-xs text-gray-400 block">BI History Range</span>
        <span class="text-lg font-extrabold text-purple-400">Up to 10 Yrs</span>
      </div>
    </div>

    <!-- 10-Year BI Analytics Interactive Chart -->
    <B2BAnalyticsChart
      :analytics="dashboard.analytics"
      :active-range="activeRange"
      @change-range="changeRange"
    />

    <!-- China Bulk Import Calculator -->
    <ImportCostCalculator />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import B2BAnalyticsChart from '@/components/b2b/B2BAnalyticsChart.vue';
import ImportCostCalculator from '@/components/b2b/ImportCostCalculator.vue';

const dashboard = ref(null);
const activeRange = ref('10y');

async function fetchDashboard(range = '10y') {
  activeRange.value = range;
  try {
    const res = await axios.get('/api/v1/b2b/dashboard', { params: { range } });
    if (res.data.success) {
      dashboard.value = res.data.data;
    }
  } catch (e) {
    console.error(e);
  }
}

function changeRange(r) {
  fetchDashboard(r);
}

onMounted(() => {
  fetchDashboard();
});
</script>
