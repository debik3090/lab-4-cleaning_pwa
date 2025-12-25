<script setup>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const items = computed(() => store.getters['cart/items']);
const total = computed(() => store.getters['cart/total']);
const isAuthenticated = computed(() => store.getters['auth/isAuthenticated']);

const isSubmitting = ref(false);
const message = ref('');

const clearCart = () => {
  store.commit('cart/CLEAR');
};

const removeFromCart = (serviceId) => {
  store.commit('cart/REMOVE_ITEM', serviceId);
};

const submitOrder = async () => {
  if (!isAuthenticated.value) {
    message.value = 'Нужно войти через соцсеть перед оформлением заказа';
    return;
  }

  if (!items.value.length) {
    message.value = 'Корзина пуста';
    return;
  }

  isSubmitting.value = true;
  message.value = '';

  // Здесь можно имитировать заказ без реального запроса
  setTimeout(() => {
    clearCart();
    message.value = 'Заказ успешно оформлен (оплата имитирована)';
    isSubmitting.value = false;
  }, 500);
};
</script>

<template>
  <div class="page cart-page">
    <h1 class="page-title">Корзина</h1>

    <div v-if="!items.length" class="status-text">
      Корзина пуста
    </div>

    <div v-else class="cart-list">
      <div
        v-for="item in items"
        :key="item.service.id"
        class="cart-item"
      >
        <div class="cart-item-main">
          <div class="cart-item-title">
            {{ item.service.name }}
          </div>
          <div class="cart-item-meta">
            {{ item.quantity }} × {{ item.service.base_price }} ₽
          </div>
        </div>
        <button
          class="btn-link"
          @click="removeFromCart(item.service.id)"
        >
          Удалить
        </button>
      </div>

      <div class="cart-total">
        Итого: <span>{{ total }} ₽</span>
      </div>

      <button
        class="btn-primary full"
        @click="submitOrder"
        :disabled="isSubmitting"
      >
        {{ isSubmitting ? 'Оформление...' : 'Оформить заказ' }}
      </button>

      <button
        class="btn-secondary full"
        @click="clearCart"
      >
        Очистить корзину
      </button>

      <div v-if="message" class="status-text">
        {{ message }}
      </div>
    </div>
  </div>
</template>

<style scoped>
.page {
  padding: 12px 12px 70px;
}
.page-title {
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 12px;
}
.status-text {
  margin-top: 12px;
  font-size: 14px;
}
.cart-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.cart-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 10px;
  border-radius: 8px;
  background: #ffffff;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
}
.cart-item-title {
  font-size: 14px;
  font-weight: 500;
}
.cart-item-meta {
  font-size: 13px;
  color: #4b5563;
}
.btn-link {
  border: none;
  background: none;
  color: #ef4444;
  font-size: 13px;
}
.cart-total {
  display: flex;
  justify-content: space-between;
  margin-top: 8px;
  font-size: 15px;
  font-weight: 600;
}
.cart-total span {
  color: #111827;
}
.btn-primary.full,
.btn-secondary.full {
  width: 100%;
  margin-top: 8px;
}
.btn-primary {
  background: #10b981;
  color: #ffffff;
  border-radius: 999px;
  border: none;
  padding: 8px 12px;
  font-size: 14px;
}
.btn-secondary {
  background: #e5e7eb;
  color: #111827;
  border-radius: 999px;
  border: none;
  padding: 8px 12px;
  font-size: 14px;
}
</style>
