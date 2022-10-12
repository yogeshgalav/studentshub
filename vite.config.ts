import { defineConfig } from 'vite'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel from 'vite-plugin-laravel'
import vue from '@vitejs/plugin-vue'
import inertia from './resources/scripts/vite/inertia-layout'
import viteCompression from 'vite-plugin-compression';
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
	plugins: [
		inertia(),
		vue(),
		laravel({
			postcss: [
				tailwindcss(),
				autoprefixer(),
			],
		}),
		viteCompression(),
		VitePWA({
			devOptions: {
				enabled: true
			},
			base: '.',
			registerType: 'autoUpdate',
			minify: true,
			includeAssets: ['/favicon.svg', '/robots.txt'],
			manifest: {
				"name": "Studentshub",
				"short_name": "Sthub",
				"start_url": "/build/",
				"display": "standalone",
				"theme_color": "#0476F2",
				"background_color": "#fff",
				"lang": "en",
				"scope": "/build/",
				"icons": [
					{
						src: '/favicon.svg',
                        sizes: 'any',
                        type: 'image/svg+xml',
                        purpose: 'any'
					}
				]
			}
		})
	],
})
