import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start(); // Alpine を先に初期化

import { createApp } from 'vue';
import CalendarComponent from './components/CalendarComponent.vue';

const app = createApp({});
app.component('calendar-component', CalendarComponent);
app.mount('#app');
