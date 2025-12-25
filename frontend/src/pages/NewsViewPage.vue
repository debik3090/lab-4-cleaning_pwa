<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const item = ref(route.state?.item || null);

const goBack = () => {
  router.back();
};
</script>

<template>
  <div class="page news-view-page">
    <button class="btn-link" @click="goBack">
      ← Назад
    </button>

    <div v-if="!item" class="status-text">
      Новость не найдена
    </div>
    <div v-else class="news-body">
      <h1 class="page-title">{{ item.title }}</h1>
      <p class="news-text">
        {{ item.full_text || item.short_text }}
      </p>
    </div>
  </div>
</template>

<style scoped>
.page {
  padding: 12px 12px 70px;
  max-width: 480px;
  margin: 0 auto;
}
.page-title {
  font-size: 20px;
  font-weight: 600;
  margin: 12px 0;
}
.status-text {
  margin-top: 12px;
  font-size: 14px;
}
.btn-link {
  border: none;
  background: none;
  color: #4b5563;
  font-size: 14px;
}
.news-text {
  font-size: 14px;
  line-height: 1.4;
}
</style>
