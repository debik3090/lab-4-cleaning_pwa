<script setup>
import { onMounted, ref, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const services = ref([]);
const loading = ref(false);
const error = ref('');

const cartTotal = computed(() => store.getters['cart/total']);

const loadServices = async () => {
  loading.value = true;
  error.value = '';

  try {
    services.value = [
      {
        id: 1,
        name: 'Генеральная уборка квартиры',
        description: 'Полная уборка всех помещений: полы, пыль, санузлы, кухня.',
        base_price: 2500,
      },
      {
        id: 2,
        name: 'Поддерживающая уборка',
        description: 'Регулярная уборка раз в неделю: полы, пыль, ванная, кухня.',
        base_price: 1800,
      },
      {
        id: 3,
        name: 'Мытьё окон',
        description: 'Мытьё окон внутри квартиры.',
        base_price: 1500,
      },
      {
        id: 4,
        name: 'Химчистка мягкой мебели',
        description: 'Химчистка дивана и кресел профессиональными средствами.',
        base_price: 3000,
      },
    ];
  } catch (e) {
    console.error(e);
    error.value = 'Не удалось загрузить услуги';
  } finally {
    loading.value = false;
  }
};

const addToCart = (service) => {
  store.commit('cart/ADD_ITEM', service);
};

onMounted(loadServices);
</script>

<template>
  <div class="page services-page">
    <h1 class="page-title">Услуги клининга</h1>

    <div v-if="loading" class="status-text">
      Загрузка услуг...
    </div>
    <div v-else-if="error" class="status-text error">
      {{ error }}
    </div>
    <div v-else-if="!services.length" class="status-text">
      Услуг пока нет
    </div>

    <div class="services-list">
      <div
        v-for="service in services"
        :key="service.id"
        class="service-card"
      >
        <h2 class="service-title">{{ service.name }}</h2>
        <p class="service-description">
          {{ service.description }}
        </p>
        <div class="service-footer">
          <span class="service-price">
            {{ service.base_price }} ₽
          </span>
          <button class="btn-primary" @click="addToCart(service)">
            В корзину
          </button>
        </div>
      </div>
    </div>

    <div class="cart-summary" v-if="cartTotal > 0">
      В корзине товаров на {{ cartTotal }} ₽
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
  margin: 12px 0;
  font-size: 14px;
}
.status-text.error {
  color: #b91c1c;
}
.services-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.service-card {
  background: #ffffff;
  border-radius: 8px;
  padding: 12px;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
}
.service-title {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 6px;
}
.service-description {
  font-size: 13px;
  color: #4b5563;
  margin-bottom: 8px;
}
.service-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.service-price {
  font-weight: 600;
  color: #111827;
}
.btn-primary {
  background: #4f46e5;
  color: #ffffff;
  border: none;
  border-radius: 999px;
  padding: 6px 12px;
  font-size: 13px;
}
.cart-summary {
  position: sticky;
  bottom: 60px;
  margin-top: 12px;
  padding: 8px 12px;
  background: #eef2ff;
  border-radius: 999px;
  font-size: 13px;
  text-align: center;
}
</style>
