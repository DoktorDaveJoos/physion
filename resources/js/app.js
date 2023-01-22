import './bootstrap';
import '../css/tailwind.scss';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import ElementPlus from 'element-plus';
import de from 'element-plus/dist/locale/de';
import 'dayjs/locale/de';
import '../css/element-plus.scss';

const appName =
    window.document.getElementsByTagName('title')[0]?.innerText ||
    'Bauzertifikate';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(ElementPlus, {
                locale: de,
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
