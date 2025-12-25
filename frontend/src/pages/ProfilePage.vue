<script setup>
import { onMounted, computed, ref } from 'vue';
import { useStore } from 'vuex';
import api from '../api/axios';

const store = useStore();

const user = computed(() => store.getters['auth/user']);
const isAuthenticated = computed(() => store.getters['auth/isAuthenticated']);
const loadingUser = computed(() => store.getters['auth/loading']);

const addresses = ref([]);
const addressForm = ref({
  label: '',
  city: '',
  street: '',
  house: '',
  apartment: '',
});

const loadAddresses = async () => {
  try {
    const { data } = await api.get('/api/addresses');
    addresses.value = data.data ?? data;
  } catch (e) {
    console.error(e);
  }
};

const createAddress = async () => {
  try {
    await api.post('/api/addresses', addressForm.value);
    await loadAddresses();
    addressForm.value = {
      label: '',
      city: '',
      street: '',
      house: '',
      apartment: '',
    };
  } catch (e) {
    console.error(e);
  }
};

// КНОПКА СОЦЛОГИНА: прямой переход на Laravel без axios (чтобы не было CORS)
const loginWithProvider = (provider) => {
  window.location.href = `http://127.0.0.1:8000/api/auth/social/${provider}/redirect`;
};

// ПОДПИСКА НА PUSH
const subscribeToPush = async () => {
  if (!isAuthenticated.value) {
    alert('Сначала войдите через соцсеть');
    return;
  }

  if (!('Notification' in window) || !('serviceWorker' in navigator)) {
    alert('Ваш браузер не поддерживает push-уведомления');
    return;
  }

  const permission = await Notification.requestPermission();
  if (permission !== 'granted') {
    alert('Разрешение на уведомления не выдано');
    return;
  }

  try {
    const registration = await navigator.serviceWorker.ready;

    const subscription = await registration.pushManager.subscribe({
      userVisibleOnly: true,
      // applicationServerKey можно добавить позже при настройке VAPID
      // applicationServerKey: '<ВАШ_VAPID_PUBLIC_KEY_в_base64url>',
    });

    const json = subscription.toJSON();
    const endpoint = subscription.endpoint;
    const publicKey = json.keys?.p256dh || null;
    const authToken = json.keys?.auth || null;

    await api.post('/api/push-subscriptions', {
      endpoint,
      public_key: publicKey,
      auth_token: authToken,
    });

    alert('Подписка на уведомления успешно сохранена');
  } catch (e) {
    console.error('Ошибка при подписке на push', e);
    alert('Не удалось подписаться на push-уведомления');
  }
};

onMounted(async () => {
  await store.dispatch('auth/fetchMe');
  if (isAuthenticated.value) {
    await loadAddresses();
  }
});
</script>

<template>
  <div class="profile-page">
    <div v-if="loadingUser">
      Загрузка профиля...
    </div>

    <div v-else-if="!isAuthenticated">
      <h2>Вы не авторизованы</h2>
      <p>Войдите через одну из соцсетей:</p>
      <button @click="loginWithProvider('github')">Войти через GitHub</button>
      <button @click="loginWithProvider('google')">Войти через Google</button>
      <button @click="loginWithProvider('vkontakte')">Войти через VK</button>
    </div>

    <div v-else>
      <h2>Профиль</h2>
      <p>{{ user.name }} ({{ user.email }})</p>

      <button @click="subscribeToPush">
        Включить уведомления
      </button>

      <!-- Здесь можно позже вывести адреса и форму создания адреса -->
    </div>
  </div>
</template>
