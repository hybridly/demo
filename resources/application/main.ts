import { initializeHybridly } from 'virtual:hybridly/config'
import { createHead } from '@vueuse/head'
import { autoAnimatePlugin as autoAnimate } from '@formkit/auto-animate/vue'
import i18n from './i18n'
import './tailwind.css'
import './fonts'

initializeHybridly({
	enhanceVue: (vue) => vue
		.use(createHead())
		.use(i18n)
		.use(autoAnimate),
})
