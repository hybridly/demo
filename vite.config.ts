import path from 'node:path'
import { defineConfig, loadEnv } from 'vite'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel from 'laravel-vite-plugin'
import hybridly from 'hybridly/vite'
import hybridlyImports from 'hybridly/auto-imports'
import hybridlyResolver from 'hybridly/resolver'
import iconsResolver from 'unplugin-icons/resolver'
import { FileSystemIconLoader } from 'unplugin-icons/loaders'
import vue from '@vitejs/plugin-vue'
import autoimport from 'unplugin-auto-import/vite'
import components from 'unplugin-vue-components/vite'
import icons from 'unplugin-icons/vite'
import run from 'vite-plugin-run'

export default ({ mode }) => {
	process.env = Object.assign(process.env, loadEnv(mode, process.cwd(), ''))

	return defineConfig({
		plugins: [
			laravel({
				input: 'resources/application/main.ts',
				valetTls: process.env.VITE_VALET_TLS,
			}),
			run({
				name: 'generate typescript',
				run: ['php', 'artisan', 'typescript:transform'],
				condition: (file) => ['Data.php', 'Enums'].some((kw) => file.includes(kw)),
			}),
			hybridly(),
			vue(),
			icons({
				autoInstall: true,
				customCollections: {
					bluebird: FileSystemIconLoader('./resources/icons'),
				},
			}),
			autoimport({
				dts: 'resources/types/auto-imports.d.ts',
				imports: [
					'vue',
					'@vueuse/core',
					'@vueuse/head',
					hybridlyImports,
				],
				vueTemplate: true,
			}),
			components({
				dirs: [
					'./resources/views/components',
				],
				resolvers: [
					hybridlyResolver({
						linkName: 'RouterLink',
					}),
					iconsResolver({
						customCollections: ['bluebird'],
					}),
				],
				directoryAsNamespace: true,
				dts: 'resources/types/components.d.ts',
			}),
		],
		resolve: {
			alias: {
				'@': path.join(process.cwd(), 'resources'),
			},
		},
		css: {
			postcss: {
				plugins: [
					tailwindcss(),
					autoprefixer(),
				],
			},
		},
	})
}
