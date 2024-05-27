import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import AboutView from "@/views/AboutView.vue";
import Schedule from "@/views/Schedule.vue";

const routes = [
  { path: '/', name: 'home', component: HomeView },
  { path: '/speakers', name: 'speakers', component: AboutView, meta: {requiresAuth : true } },
  { path: '/login', name: 'login', component: Login, meta: { guest: true } },
  { path: '/register', name: 'register', component: Register, meta: { guest: true } },
  { path: '/schedule', name: 'schedule', component: Schedule },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token');

  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    next({ name: 'login' });
  } else if (to.matched.some(record => record.meta.guest) && isAuthenticated) {
    next({ name: 'home' });
  } else {
    next();
  }
});

export default router;
