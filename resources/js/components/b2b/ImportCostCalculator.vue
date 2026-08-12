<template>
  <div class="glass-card rounded-3xl p-6 md:p-8 border border-amber-500/30 my-8 shadow-2xl bg-gradient-to-br from-gray-900 to-gray-950 text-white">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800">
      <div>
        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-400 font-extrabold text-xs tracking-wider border border-amber-500/30">
          CHINA BULK IMPORT CALCULATOR
        </span>
        <h3 class="text-2xl font-extrabold text-white mt-1">Landed Cost & Profit Margin Calculator</h3>
      </div>
      <span class="text-xs text-gray-400 max-w-xs text-right hidden sm:block">
        Calculates FOB product cost, air/sea freight, customs duty, VAT, landed unit cost, and break-even sales target.
      </span>
    </div>

    <form @submit.prevent="runCalculation" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div>
        <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Product Name</label>
        <input v-model="form.product_name" type="text" required placeholder="e.g. Wireless RGB Keyboard" class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-sm text-white focus:ring-2 focus:ring-amber-500" />
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Unit Price (USD FOB)</label>
        <input v-model.number="form.unit_price" type="number" step="0.01" min="0.1" required class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-sm text-white focus:ring-2 focus:ring-amber-500" />
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Quantity (Units)</label>
        <input v-model.number="form.quantity" type="number" min="1" required class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-sm text-white focus:ring-2 focus:ring-amber-500" />
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Unit Weight (Kg)</label>
        <input v-model.number="form.weight_kg" type="number" step="0.01" min="0.01" required class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-sm text-white focus:ring-2 focus:ring-amber-500" />
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Shipping Method</label>
        <select v-model="form.shipping_method" class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-sm text-white focus:ring-2 focus:ring-amber-500">
          <option value="air">Air Cargo ($8.50/Kg fast delivery)</option>
          <option value="sea">Sea Freight ($2.50/Kg bulk containers)</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Target Profit Margin (%)</label>
        <input v-model.number="form.desired_margin_rate" type="number" min="5" max="200" required class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-sm text-white focus:ring-2 focus:ring-amber-500" />
      </div>

      <div class="md:col-span-3 flex justify-end">
        <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-gray-950 font-extrabold text-sm shadow-glow transition-all">
          🧮 Compute Complete Landed Cost Breakdown
        </button>
      </div>
    </form>

    <!-- Results Section -->
    <div v-if="result" class="pt-6 border-t border-gray-800">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-800/80 p-4 rounded-2xl border border-gray-700">
          <span class="text-xs text-gray-400 block">Total Investment (Landed)</span>
          <span class="text-xl font-extrabold text-white">৳{{ result.summary.total_investment_bdt.toLocaleString() }}</span>
        </div>

        <div class="bg-gray-800/80 p-4 rounded-2xl border border-amber-500/40">
          <span class="text-xs text-amber-400 block font-bold">Landed Cost / Unit</span>
          <span class="text-xl font-extrabold text-amber-400">৳{{ result.summary.cost_per_unit_bdt.toLocaleString() }}</span>
        </div>

        <div class="bg-gray-800/80 p-4 rounded-2xl border border-emerald-500/40">
          <span class="text-xs text-emerald-400 block font-bold">Suggested Retail Price</span>
          <span class="text-xl font-extrabold text-emerald-400">৳{{ result.summary.suggested_selling_price_bdt.toLocaleString() }}</span>
        </div>

        <div class="bg-gray-800/80 p-4 rounded-2xl border border-blue-500/40">
          <span class="text-xs text-blue-400 block font-bold">Expected Profit</span>
          <span class="text-xl font-extrabold text-blue-400">৳{{ result.summary.expected_profit_bdt.toLocaleString() }}</span>
        </div>
      </div>

      <div class="bg-gray-950 p-4 rounded-2xl border border-gray-800 text-xs text-gray-300 space-y-1">
        <div class="flex justify-between"><span>FOB Product Cost:</span><span class="font-bold">৳{{ result.breakdown.fob_product_cost_bdt.toLocaleString() }}</span></div>
        <div class="flex justify-between"><span>Freight Cost ({{ form.shipping_method.toUpperCase() }}):</span><span class="font-bold">৳{{ result.breakdown.shipping_cost_bdt.toLocaleString() }}</span></div>
        <div class="flex justify-between"><span>Customs Duty (15% Configured):</span><span class="font-bold">৳{{ result.breakdown.customs_duty_bdt.toLocaleString() }}</span></div>
        <div class="flex justify-between"><span>VAT Tax (15% Configured):</span><span class="font-bold">৳{{ result.breakdown.vat_bdt.toLocaleString() }}</span></div>
        <div class="flex justify-between pt-2 border-t border-gray-800 text-amber-300 font-bold">
          <span>Break-Even Sales Volume:</span>
          <span>{{ result.summary.break_even_units }} Units to recover investment</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

const form = reactive({
  product_name: 'Gaming Headset Pro',
  unit_price: 18.50,
  quantity: 100,
  weight_kg: 0.4,
  shipping_method: 'air',
  desired_margin_rate: 35
});

const result = ref(null);

async function runCalculation() {
  try {
    const res = await axios.post('/api/v1/b2b/calculate-import', form);
    if (res.data.success) {
      result.value = res.data.data;
    }
  } catch (e) {
    console.error(e);
  }
}

onMounted(() => {
  runCalculation();
});
</script>
