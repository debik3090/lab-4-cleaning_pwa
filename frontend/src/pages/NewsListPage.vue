<script setup>
import { ref, onMounted } from 'vue';

const news = ref([]);

const loadNews = () => {
  news.value = [
    {
      id: 1,
      title: 'Скидка 20% на генеральную уборку',
      short_text: 'До конца месяца действует скидка на генеральную уборку.',
    },
    {
      id: 2,
      title: 'Новые услуги химчистки',
      short_text: 'Добавлены услуги химчистки мягкой мебели и ковров.',
    },
  ];
};

onMounted(loadNews);
</script>

<template>
  <div class="page news-page">
    <h1 class="page-title">Новости</h1>

    <div v-if="!news.length" class="status-text">
      Новостей пока нет
    </div>

    <div class="news-list">
      <div
        v-for="item in news"
        :key="item.id"
        class="news-card"
      >
        <h2 class="news-title">{{ item.title }}</h2>
        <p class="news-snippet">
          {{ item.short_text }}
        </p>
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
.news-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.news-card {
  background: #ffffff;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
}
.news-title {
  font-size: 15px;
  font-weight: 600;
  margin-bottom: 4px;
}
.news-snippet {
  font-size: 13px;
  color: #4b5563;
}
</style>
