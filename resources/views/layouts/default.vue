<script setup lang="ts">
import { route } from 'monolikit/vue'
import BaseButton from '@/views/components/base/button.vue'

useHead({
	titleTemplate: (title) => `${title} - Blue Bird`,
})
</script>

<template>
	<main class="relative flex items-start justify-center gap-10 p-5">
		<aside class="sticky top-5 left-0 flex flex-col items-center">
			<div class="flex flex-col items-center py-5 text-blue-50">
				<RouterLink href="/" class="text-blue-500 transition hover:text-blue-600">
					<logo class="h-12 w-12" />
				</RouterLink>
				<menu class="mt-16 flex w-full flex-col items-center gap-12 rounded-3xl bg-blue-500 p-10">
					<base-button class="hover:text-white">
						<i-fluent-home-16-filled class="h-6 w-7" />
					</base-button>
					<base-button class="hover:text-white">
						<i-ion-notifications class="h-6 w-7" />
					</base-button>
					<base-button class="hover:text-white">
						<i-material-symbols-android-messages class="h-6 w-7" />
					</base-button>
					<base-button class="hover:text-white">
						<i-material-symbols-bookmark class="h-6 w-7" />
					</base-button>
					<base-button class="hover:text-white">
						<i-fa6-solid-user class="h-6 w-7" />
					</base-button>
					<RouterLink :href="route('logout')" method="POST" :as="BaseButton">
						<i-material-symbols-logout-rounded class="text-2xl" />
					</RouterLink>
				</menu>
			</div>
		</aside>

		<!-- Main content -->
		<section class="max-w-2xl">
			<slot />
		</section>
	</main>
</template>
