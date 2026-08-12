import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';
import { useNotificationStore } from './notification';

export const useCartStore = defineStore('cart', () => {
  const items = ref([]);
  const subtotal = ref(0);
  const discount = ref(0);
  const shipping = ref(0);
  const total = ref(0);
  const couponCode = ref('');
  const isOpen = ref(false);

  const itemCount = computed(() => items.value.reduce((acc, i) => acc + i.quantity, 0));

  async function fetchCart() {
    try {
      const res = await axios.get('/api/v1/cart');
      if (res.data.success) {
        const d = res.data.data;
        items.value = d.items;
        subtotal.value = d.subtotal;
        discount.value = d.discount;
        shipping.value = d.shipping;
        total.value = d.total;
        couponCode.value = d.coupon_code || '';
      }
    } catch (e) {
      console.error('Failed to fetch cart', e);
    }
  }

  async function addToCart(productId, quantity = 1) {
    const notify = useNotificationStore();
    try {
      const res = await axios.post('/api/v1/cart/items', { product_id: productId, quantity });
      if (res.data.success) {
        const d = res.data.data;
        items.value = d.items;
        subtotal.value = d.subtotal;
        discount.value = d.discount;
        shipping.value = d.shipping;
        total.value = d.total;
        isOpen.value = true;
        notify.show('Item added to your cart!', 'success');
      }
    } catch (e) {
      const msg = e.response?.data?.message || 'Error adding product to cart.';
      notify.show(msg, 'error');
    }
  }

  async function updateQuantity(itemId, quantity) {
    if (quantity < 1) return removeItem(itemId);
    try {
      const res = await axios.put(`/api/v1/cart/items/${itemId}`, { quantity });
      if (res.data.success) {
        const d = res.data.data;
        items.value = d.items;
        subtotal.value = d.subtotal;
        discount.value = d.discount;
        shipping.value = d.shipping;
        total.value = d.total;
      }
    } catch (e) {
      console.error(e);
    }
  }

  async function removeItem(itemId) {
    const notify = useNotificationStore();
    try {
      const res = await axios.delete(`/api/v1/cart/items/${itemId}`);
      if (res.data.success) {
        const d = res.data.data;
        items.value = d.items;
        subtotal.value = d.subtotal;
        discount.value = d.discount;
        shipping.value = d.shipping;
        total.value = d.total;
        notify.show('Item removed', 'info');
      }
    } catch (e) {
      console.error(e);
    }
  }

  async function applyCoupon(code) {
    const notify = useNotificationStore();
    try {
      const res = await axios.post('/api/v1/cart/coupon', { code });
      if (res.data.success) {
        const d = res.data.data;
        items.value = d.items;
        subtotal.value = d.subtotal;
        discount.value = d.discount;
        shipping.value = d.shipping;
        total.value = d.total;
        couponCode.value = d.coupon_code;
        notify.show(`Coupon ${code} applied successfully!`, 'success');
      }
    } catch (e) {
      notify.show(e.response?.data?.message || 'Invalid coupon code', 'error');
    }
  }

  return {
    items, subtotal, discount, shipping, total, couponCode, isOpen, itemCount,
    fetchCart, addToCart, updateQuantity, removeItem, applyCoupon
  };
});
