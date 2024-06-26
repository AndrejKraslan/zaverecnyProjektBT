import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Sponsors from "@/views/Sponsors.vue";
import Schedule from "@/views/Schedule.vue";
import Speakers from "@/views/Speakers.vue";
import AdminPanel from "@/views/AdminPanel.vue";
import AttendeeList from "@/views/AttendeeList.vue";
import Comments from "@/views/Comments.vue";
import Gallery from "@/views/Gallery.vue";

const routes = [
  { path: '/', name: 'home', component: HomeView },
  { path: '/speakers', name: 'speakers', component: Speakers },
  { path: '/sponsors', name: 'sponsors', component: Sponsors },
  { path: '/login', name: 'login', component: Login, meta: { guest: true } },
  { path: '/register', name: 'register', component: Register, meta: { guest: true } },
  { path: '/schedule', name: 'schedule', component: Schedule },
  { path: '/admin', name: 'admin', component: AdminPanel, meta: { requiresAuth: true } },
  { path: '/attendeelist', name: 'attendeelist', component: AttendeeList, meta: { requiresAuth: true } },
  { path: '/gallery', name: 'gallery', component: Gallery},
  { path: '/comments', name: 'comments', component: Comments}
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
