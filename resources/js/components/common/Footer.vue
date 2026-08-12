<template>
  <footer class="bg-white dark:bg-gray-950 border-t border-gray-200 dark:border-gray-800 transition-colors py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <div class="flex items-center gap-2 mb-4">
          <div class="w-8 h-8 rounded-lg bg-brand-600 text-white font-bold flex items-center justify-center">B</div>
          <span class="font-bold text-xl text-gray-900 dark:text-white">Besmart</span>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Shop Smart. Buy Better. B2C Retail & B2B Wholesale Import Platform.</p>
      </div>

      <div>
        <h4 class="font-bold text-sm text-gray-900 dark:text-white uppercase tracking-wider mb-4">Storefront</h4>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
          <li><router-link to="/shop" class="hover:text-brand-500">All Products</router-link></li>
          <li><router-link to="/shop?sort=newest" class="hover:text-brand-500">New Arrivals</router-link></li>
          <li><router-link to="/cart" class="hover:text-brand-500">Shopping Cart</router-link></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm text-gray-900 dark:text-white uppercase tracking-wider mb-4">B2B Wholesale</h4>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
          <li><router-link to="/register?role=b2b" class="hover:text-brand-500">Register B2B Account</router-link></li>
          <li><router-link to="/b2b/dashboard" class="hover:text-brand-500">10-Year BI Analytics</router-link></li>
          <li><router-link to="/b2b/dashboard" class="hover:text-brand-500">China Landed Cost Calculator</router-link></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm text-gray-900 dark:text-white uppercase tracking-wider mb-4">Support & Guarantees</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">📞 24/7 Hotline: +880 1700 000 001</p>
        <p class="text-sm text-gray-500 dark:text-gray-400">✉️ Support: support@besmart.com</p>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pt-8 border-t border-gray-100 dark:border-gray-900 text-center text-xs text-gray-500">
      © 2026 Besmart E-Commerce Platform. All rights reserved. Secure Payments by Stripe, SSLCommerz, bKash.
    </div>
  </footer>
</template>
