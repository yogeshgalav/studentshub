// import { createSSRApp, h } from 'vue'
// import { renderToString } from '@vue/server-renderer'
// import { createInertiaApp } from '@inertiajs/inertia-vue3'
// import { withVite } from './inertia/with-vite'
// import createServer from '@inertiajs/server'

// createServer((page) => createInertiaApp({
//   page,
//   render: renderToString,
// 	resolve: (name) => withVite(import.meta.glob('../../views/pages/**/*.vue'), name),
//   setup({ app, props, plugin }) {
//     return createSSRApp({
//       render: () => h(app, props),
//     }).use(plugin)
//   },
// }))

import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { withVite } from '@/scripts/inertia/with-vite'
import type { Page } from '@inertiajs/inertia'

export function render(page: Page) {
  return createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => withVite(import.meta.globEager('../views/pages/**/*.vue'), name),
    setup: ({ app, props, plugin: inertia }) => createSSRApp({
      render: () => h(app, props),
    }).use(inertia)
  })
}