<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const user = computed(() => store.getters['auth/user']);
const isAuthenticated = computed(() => store.getters['auth/isAuthenticated']);
</script>

<template>
  <div class="app-wrapper">
    <header class="app-header">
      <!-- твоя шапка из Affan/верстки -->
      <div class="app-header-inner">
        <div class="logo">
          Cleaning PWA
        </div>
        <div class="auth-info">
          <span v-if="isAuthenticated">
            {{ user.name }}
          </span>
          <router-link v-else to="/profile">
            Войти
          </router-link>
        </div>
      </div>
    </header>

    <main class="app-content">
      <router-view />
    </main>

    <nav class="app-footer-nav">
      <router-link to="/" class="nav-item"> Главная </router-link>
      <router-link to="/services" class="nav-item"> Услуги </router-link>
      <router-link to="/cart" class="nav-item"> Корзина </router-link>
      <router-link to="/profile" class="nav-item"> Профиль </router-link>
      <router-link to="/news" class="nav-item"> Новости </router-link>
    </nav>
  </div>
</template>
