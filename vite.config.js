import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import { defineConfig } from 'vite';
import { run } from 'vite-plugin-run';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        run([
            {
                name: 'ziggy',
                run: ['php', 'artisan', 'ziggy:generate'],
                condition: (file) =>
                    file.includes('/routes/') && file.endsWith('.php'),
            },
        ]),
    ],

    resolve: {
        alias: [
            { find: '@', replacement: resolve(__dirname, './resources/js') },
            {
                find: '@App',
                replacement: resolve(__dirname, './resources/js/App'),
            },
            {
                find: '@Components',
                replacement: resolve(__dirname, './resources/js/Components'),
            },
            {
                find: '@Composables',
                replacement: resolve(__dirname, './resources/js/Composables'),
            },
            {
                find: '@Css',
                replacement: resolve(__dirname, './resources/css'),
            },
            {
                find: '@assets',
                replacement: resolve(__dirname, './resources/assets'),
            },
            {
                find: '@Layouts',
                replacement: resolve(__dirname, './resources/js/Layouts'),
            },
            {
                find: '@Pages',
                replacement: resolve(__dirname, './resources/js/Pages'),
            },
            {
                find: 'ziggy-js',
                replacement: resolve(__dirname, './vendor/tightenco/ziggy'),
            },
        ],
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue'],
    },

    server: {
        https: process.env.NODE_ENV === 'production',
    },

    base: process.env.NODE_ENV === 'production' ? '/public/' : '/',
});
