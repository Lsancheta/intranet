import route from '../../vendor/tightenco/ziggy/dist/js/route.js';
window.route = route;

import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

createInertiaApp({
    resolve: name => import(`./pages/${name}.vue`),
    setup({ el, App, props }) {
        createApp({ render: () => h(App, props) }).mount(el);
    },
});
