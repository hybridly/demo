import { defineConfig } from 'vite'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel from 'vite-plugin-laravel'
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

export default defineConfig({
	plugins: [
		laravel({
			postcss: [tailwindcss(), autoprefixer()],
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
})
