import App from './App.vue';
import { createApp } from 'vue';
import axios from './plugins/axios';
import router from './router';

const app = createApp(App);

app.use(axios);
app.use(router);

app.mount('#app');
