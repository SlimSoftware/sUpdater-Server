import App from './App.vue';
import { createApp } from 'vue';
import axios from './plugins/axios';
import router from './router';
import { createPinia } from 'pinia';

const app = createApp(App);

app.use(axios);
app.use(router);

const pinia = createPinia();
app.use(pinia);

app.mount('#app');
