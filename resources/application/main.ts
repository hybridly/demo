import { initializeHybridly } from 'hybridly/vue'
import { createHead } from '@vueuse/head'
import { autoAnimatePlugin as autoAnimate } from '@formkit/auto-animate/vue'
import i18n from './i18n'
import 'virtual:hybridly/router'
import './tailwind.css'
import './fonts'

initializeHybridly({
	pages: import.meta.glob('@/views/pages/**/*.vue', { eager: true }),
	enhanceVue: (vue) => vue
		.use(createHead())
		.use(i18n)
		.use(autoAnimate),
})
