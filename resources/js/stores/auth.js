import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user_info') || 'null'));
  const token = ref(localStorage.getItem('auth_token') || null);

  const isAuthenticated = computed(() => !!token.value);
  const isAdmin = computed(() => user.value?.role === 'admin');
  const isB2B = computed(() => user.value?.role === 'b2b');

  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
  }

  async function login(credentials) {
    const res = await axios.post('/api/v1/auth/login', credentials);
    if (res.data.success) {
      setAuth(res.data.data.user, res.data.data.token);
    }
    return res.data;
  }

  async function register(userData) {
    const res = await axios.post('/api/v1/auth/register', userData);
    if (res.data.success) {
      setAuth(res.data.data.user, res.data.data.token);
    }
    return res.data;
  }

  async function checkAuth() {
    if (!token.value) return;
    try {
      const res = await axios.get('/api/v1/auth/me');
      if (res.data.success) {
        user.value = res.data.data;
        localStorage.setItem('user_info', JSON.stringify(res.data.data));
      }
    } catch (e) {
      logout();
    }
  }

  function logout() {
    user.value = null;
    token.value = null;
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_info');
    delete axios.defaults.headers.common['Authorization'];
  }

  function setAuth(userData, authToken) {
    user.value = userData;
    token.value = authToken;
    localStorage.setItem('auth_token', authToken);
    localStorage.setItem('user_info', JSON.stringify(userData));
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
  }

  return { user, token, isAuthenticated, isAdmin, isB2B, login, register, logout, checkAuth };
});
