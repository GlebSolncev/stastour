import {start} from './bootstrap.js';
import { createApp } from 'vue';
import './lib/await.js';
import './lib/callback.js';
import TourBooking from './components/booking/TourBooking.vue';

start(document);

new WOW().init();


document.addEventListener('DOMContentLoaded', () => {
    const appEl = document.getElementById('tour-form');

    if (appEl) {
        const app = createApp({});
        app.component('tour-booking', TourBooking);
        app.mount('#tour-form');
    }
});
