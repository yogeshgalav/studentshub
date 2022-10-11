import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'vite-plugin-laravel/inertia'
import AppLayout from '@/views/layouts/default.vue';

createInertiaApp({
	resolve: (name) => {
		const page = resolvePageComponent(name, import.meta.glob('../views/pages/**/*.vue'));
		page.then((module) => {
            module.layout =  module.layout || AppLayout;
        });

        return page;
	},
	setup({ el, app, props, plugin }) {
		createApp({ render: () => h(app, props) })
			.use(plugin)
			.mount(el)
	},
})
