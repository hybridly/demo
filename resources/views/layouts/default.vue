<script setup lang="ts">
import { route, useContext } from 'hybridly/vue'
import BaseButton from '@/views/components/base/button.vue'

useHead({
	titleTemplate: (title) => `${title} - Blue Bird`,
})
</script>

<template>
	<main class="relative flex items-start justify-center gap-10 p-5 lg:mt-24 lg:gap-x-20">
		<aside class="fixed bottom-0 left-0 z-20 w-full items-center sm:sticky sm:top-5 sm:bottom-auto sm:flex sm:w-auto sm:flex-col">
			<div class="grid place-items-center text-blue-50 sm:py-5">
				<RouterLink href="/" class="hidden text-blue-500 transition hover:text-blue-600 sm:block">
					<i-bluebird-logo class="h-12 w-12" />
				</RouterLink>
				<menu class="flex w-full justify-between gap-5 overflow-hidden bg-blue-500 p-5 sm:mt-16 sm:grid sm:gap-8 sm:rounded-3xl sm:p-8">
					<base-button class="h-12 w-12 rounded-xl hover:text-white">
						<RouterLink href="/">
							<i-fluent-home-16-filled class="h-6 w-7" />
						</RouterLink>
					</base-button>
					<base-button class="h-12 w-12 rounded-xl hover:text-white">
						<i-ion-notifications class="h-6 w-7" />
					</base-button>
					<base-button class="h-12 w-12 rounded-xl hover:text-white">
						<i-material-symbols-android-messages class="h-6 w-7" />
					</base-button>
					<base-button class="h-12 w-12 rounded-xl hover:text-white">
						<i-material-symbols-bookmark class="h-6 w-7" />
					</base-button>
					<base-button class="h-12 w-12 rounded-xl hover:text-white">
						<i-fa6-solid-user class="text-lg" />
					</base-button>
					<RouterLink :href="route('logout')" method="POST" :as="BaseButton">
						<div class="grid place-items-center transition duration-300 hover:text-white sm:pt-5">
							<div class="grid h-12 w-12 place-items-center">
								<i-material-symbols-logout-rounded class="mr-1.5 scale-[-1] text-2xl" />
							</div>
							<div class="hidden text-xs font-semibold uppercase tracking-wide sm:block">
								Logout
							</div>
						</div>
					</RouterLink>
				</menu>
			</div>
		</aside>

		<!-- Main content -->
		<section class="max-w-2xl flex-1">
			<transition
				mode="out-in"
				enter-active-class="duration-200 transition"
				enter-from-class="-translate-x-1 opacity-0"
				enter-to-class="opacity-100"

				leave-active-class="duration-200 transition"
				leave-from-class="opacity-100"
				leave-to-class="translate-x-0 opacity-0"
			>
				<slot />
			</transition>
		</section>
	</main>
</template>
