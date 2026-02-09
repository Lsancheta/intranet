import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
        wayfinder({
            output: 'resources/js/wayfinder.js',
            include: ['app/Http/Controllers/**/*.php'],
        }),
    ],
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
    },
});
