import { defineConfig } from 'vite'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel from 'vite-plugin-laravel'
import monolikit from 'monolikit/vite'
import monolikitImports from 'monolikit/auto-imports'
import monolikitResolver from 'monolikit/resolver'
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
		monolikit(),
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
				monolikitImports,
			],
		}),
		components({
			dirs: [
				'./resources/views/components',
			],
			resolvers: [
				monolikitResolver({
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
