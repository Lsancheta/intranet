import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import axios from 'axios';

axios.defaults.baseURL = import.meta.env.VITE_APP_URL ?? window.location.origin;
axios.defaults.withCredentials = true;

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

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

        // 🌟 Layout global automático
        vueApp.mixin({
            methods: {
                layout(Component) {
                    return Component.layout || import('@/layouts/AppLayout.vue');
                },
            },
        });

        vueApp.use(plugin).mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});

// 🌙 Define tema claro/escuro ao carregar a página
initializeTheme();
