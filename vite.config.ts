import { defineConfig } from 'vite'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel, { findPhpPath, callArtisan } from 'vite-plugin-laravel'
import hybridly from 'hybridly/vite'
import hybridlyImports from 'hybridly/auto-imports'
import hybridlyResolver from 'hybridly/resolver'
import iconsResolver from 'unplugin-icons/resolver'
import vue from '@vitejs/plugin-vue'
import autoimport from 'unplugin-auto-import/vite'
import components from 'unplugin-vue-components/vite'
import icons from 'unplugin-icons/vite'

export default defineConfig({
	plugins: [
		laravel({
			postcss: [tailwindcss(), autoprefixer()],
			watch: {
				input: [
					{
						condition: (file) => ['Data.php'].some((kw) => file.includes(kw)),
						handle: () => {
							callArtisan(findPhpPath(), 'typescript:transform')
						},
					},
				],
			},
		}),
		hybridly(),
		vue(),
		icons({
			autoInstall: true,
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
				iconsResolver(),
			],
			directoryAsNamespace: true,
			dts: 'resources/types/components.d.ts',
		}),
	],
})
