import '@/bootstrap';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SvgIcon from '@/Plugins/svg-icon';
import { resolvePage } from '@/resolvePage';
import { Ziggy } from '@/ziggy';
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';
import '@fontsource/inter/700.css';
import { createInertiaApp } from '@inertiajs/vue3';
import '@softzino/st-uikit/dist/style.css';
import { createApp, h } from 'vue';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { ZiggyVue } from 'ziggy-js';
import '../css/app.css';
import '../css/common.css';

const appName = import.meta.env.VITE_APP_NAME || 'HRMS';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name: string) => {
        const page = resolvePage(name);

        if (page.default.layout === undefined) {
            page.default.layout = AuthenticatedLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueToast)
            .use(SvgIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
