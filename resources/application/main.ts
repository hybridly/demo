import { createApp } from 'vue'
import { initializeMonolikit } from 'monolikit/vue'
import { createHead } from '@vueuse/head'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import 'virtual:monolikit/router'
import './tailwind.css'

initializeMonolikit({
	cleanup: !import.meta.env.DEV,
	pages: import.meta.glob('@/views/pages/**/*.vue', { eager: true }),
	setup: ({ render, element, monolikit }) => createApp({ render })
		.use(createHead())
		.use(autoAnimatePlugin)
		.use(monolikit)
		.mount(element),
})
