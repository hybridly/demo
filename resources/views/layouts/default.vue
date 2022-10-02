<script setup lang="ts">
import { route, useContext } from 'monolikit/vue'
import BaseButton from '@/views/components/base/button.vue'

useHead({
	titleTemplate: (title) => `${title} - Blue Bird`,
})

console.log(useContext().value?.url)
</script>

<template>
	<main class="relative flex items-start justify-center gap-10 p-5">
		<aside class="sticky top-5 left-0 flex flex-col items-center">
			<div class="grid place-items-center py-5 text-blue-50">
				<RouterLink href="/" class="text-blue-500 transition hover:text-blue-600">
					<logo class="h-12 w-12" />
				</RouterLink>
				<menu class="mt-16 grid w-full gap-8 rounded-3xl bg-blue-500 p-8">
					<base-button class="h-12 w-12 rounded-xl bg-white/25 text-white">
						<i-fluent-home-16-filled class="h-6 w-7" />
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
						<div class="grid place-items-center space-y-2 pt-5 transition duration-300 hover:text-white">
							<i-material-symbols-logout-rounded class="scale-[-1] text-2xl" />
							<div class="text-xs uppercase tracking-wide">
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
