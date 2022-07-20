import { defineConfig } from 'vite'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel, { findPhpPath, callArtisan } from 'vite-plugin-laravel'
import monolikit from 'monolikit/vite'
import monolikitImports from 'monolikit/auto-imports'
import monolikitResolver from 'monolikit/resolver'
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
		monolikit(),
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
				iconsResolver(),
			],
			directoryAsNamespace: true,
			dts: 'resources/types/components.d.ts',
		}),
	],
})
