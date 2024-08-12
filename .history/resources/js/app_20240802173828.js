import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

import './bootstrap';
import 'tailwindcss/tailwind.css';
import 'toastr/build/toastr.min.css';

const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app');
