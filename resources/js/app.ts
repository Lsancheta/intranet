import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import axios from 'axios';
import route from 'ziggy-js';
//import { Ziggy } from './ziggy_old.js';
//import { ZiggyVue } from 'ziggy-js/dist/vue.m';

//console.log("VITE_APP_URL:", import.meta.env.VITE_APP_URL);

//axios.defaults.baseURL = import.meta.env.VITE_APP_URL || window.location.origin;
//console.log("Axios BASE URL carregado:", axios.defaults.baseURL);


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
declare global{
    var route: typeof import('ziggy-js')['default'];
}
window.route = route;
createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),

    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),

    setup({ el, App, props, plugin }) {
        const vueApp = createApp({
            render: () => h(App, props),
        });

        vueApp.use(plugin);
        //vueApp.use(ZiggyVue, Ziggy);

        vueApp.mixin({
            methods: {
                layout(Component) {
                    return Component.layout || import('@/layouts/AppLayout.vue');
                },
            },
        });

        vueApp.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

initializeTheme();
