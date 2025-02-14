// resources/js/app.js

import { createApp } from 'vue';
import App from './Components/App.vue';
import router from './router';

// If you're not relying on "input" via vite.config.js,
// you might need to explicitly import the CSS here:
// import '../css/app.css';
const app = createApp(App);
app.use(router);
app.mount('#app');
