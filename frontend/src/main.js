import { createApp } from 'vue';
import App from './App.vue'; // Use relative path
import router from './router/index.js'; // Use relative path
import axios from './plugins/axios.js'; // Use relative path
import store from './store';

import BootstrapVue3 from 'bootstrap-vue-3';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

const app = createApp(App);

app.use(router);
app.use(store);
app.use(BootstrapVue3);
app.mount('#app');
