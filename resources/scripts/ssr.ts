
import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import type { Page } from '@inertiajs/inertia'
import { resolvePageComponent } from 'vite-plugin-laravel/inertia'
import AppLayout from '@/views/layouts/default.vue';

export function render(page: Page) {
  return createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => {
      const page = resolvePageComponent(name, import.meta.glob('../views/pages/**/*.vue'));
      page.then((module) => {
        module.layout =  module.layout || AppLayout;
      });
  
          return page;
    },
    setup: ({ app, props, plugin: inertia }) => createSSRApp({
      render: () => h(app, props),
    }).use(inertia)
  })
}