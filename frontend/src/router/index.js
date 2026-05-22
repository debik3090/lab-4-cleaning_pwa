import { createRouter, createWebHistory } from 'vue-router';
import MainLayout from '../layouts/MainLayout.vue';
import HomePage from '../pages/HomePage.vue';
import ServicesPage from '../pages/ServicesPage.vue';
import CartPage from '../pages/CartPage.vue';
import ProfilePage from '../pages/ProfilePage.vue';
import NewsListPage from '../pages/NewsListPage.vue';
import NewsViewPage from '../pages/NewsViewPage.vue';
import DesktopPage from '../pages/DesktopPage.vue';

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', name: 'home', component: HomePage },
      { path: 'services', name: 'services', component: ServicesPage },
      { path: 'cart', name: 'cart', component: CartPage },
      { path: 'profile', name: 'profile', component: ProfilePage },
      { path: 'news', name: 'news', component: NewsListPage },
      { path: 'news/:id', name: 'news.view', component: NewsViewPage, props: true },
    ],
  },

  // отдельный маршрут для десктоп-страницы с iframe
  {
    path: '/desktop',
    name: 'desktop',
    component: DesktopPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

