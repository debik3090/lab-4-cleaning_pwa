<script setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router';

const store = useStore();
const router = useRouter();
const route = useRoute();

const isDesktop = () => {
  const width = window.innerWidth || screen.width;
  // условно считаем десктопом всё шире 1024px
  return width >= 1024;
};

onMounted(async () => {
  // подтягиваем авторизацию
  await store.dispatch('auth/fetchMe');

  // если десктоп и мы НЕ на /desktop — перенаправляем
  if (isDesktop() && route.path !== '/desktop') {
    router.replace('/desktop');
  }
});
</script>

<template>
  <router-view />
</template>
