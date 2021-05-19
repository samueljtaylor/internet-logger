

require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import helpers from "@/plugins/helpers";

const el = document.getElementById('app');

const helpersPlugin = {
    install(app) {
        app.config.globalProperties.$helpers = helpers;
    }
}

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(helpersPlugin)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
