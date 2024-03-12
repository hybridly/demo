import path from 'node:path'
import { defineConfig } from 'vite'
import hybridly from 'hybridly/vite'
import i18n from '@intlify/unplugin-vue-i18n/vite'

export default defineConfig({
	plugins: [
		hybridly({
			customIcons: ['bluebird'],
		}),
		i18n({
			include: path.resolve(__dirname, './.hybridly/locales.json'),
		}),
	],
})
