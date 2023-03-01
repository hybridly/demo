import path from 'node:path'
import { defineConfig } from 'vite'
import hybridly from 'hybridly/vite'
import i18n from '@intlify/unplugin-vue-i18n/vite'

export default defineConfig({
	plugins: [
		hybridly({
			laravel: {
				valetTls: true,
			},
			customIcons: ['bluebird'],
		}),
		i18n({
			include: path.resolve(__dirname, './.hybridly/locales.json'),
		}),
	],
	resolve: {
		alias: {
			// Fix for local development, not useful in real apps. When symlinking Hybridly,
			// different Vue instances are used and it crashes the application
			vue: path.join(process.cwd(), '/node_modules/vue/dist/vue.esm-bundler.js'),
		},
	},
})
