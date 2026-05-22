import { createStore } from 'vuex';
import api from '../api/axios';

const cartModule = {
  namespaced: true,
  state: () => ({
    items: [], // { service, quantity }
  }),
  mutations: {
    ADD_ITEM(state, service) {
      const existing = state.items.find(i => i.service.id === service.id);
      if (existing) {
        existing.quantity += 1;
      } else {
        state.items.push({
          service,
          quantity: 1,
        });
      }
    },
    REMOVE_ITEM(state, serviceId) {
      const index = state.items.findIndex(i => i.service.id === serviceId);
      if (index !== -1) {
        state.items.splice(index, 1);
      }
    },
    CLEAR(state) {
      state.items.splice(0, state.items.length);
    },
  },
  getters: {
    items(state) {
      return state.items;
    },
    total(state) {
      return state.items.reduce(
        (sum, i) => sum + i.service.base_price * i.quantity,
        0
      );
    },
  },
};

// Новый модуль auth
const authModule = {
  namespaced: true,
  state: () => ({
    user: null,
    loading: false,
  }),
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_LOADING(state, value) {
      state.loading = value;
    },
  },
  getters: {
    user: state => state.user,
    isAuthenticated: state => !!state.user,
    loading: state => state.loading,
  },
  actions: {
    async fetchMe({ commit }) {
      commit('SET_LOADING', true);
      try {
        const { data } = await api.get('/api/auth/me');
        commit('SET_USER', data);
      } catch (e) {
        // если 401 — просто считаем, что не авторизован
        commit('SET_USER', null);
      } finally {
        commit('SET_LOADING', false);
      }
    },
    async logout({ commit }) {
      try {
        await api.post('/logout'); // если будет маршрут logout
      } catch (_) {
        // ignore
      } finally {
        commit('SET_USER', null);
      }
    },
  },
};

const store = createStore({
  modules: {
    cart: cartModule,
    auth: authModule, // 
  },
});

export default store;

