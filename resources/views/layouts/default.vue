<script setup lang="ts">
import { route } from 'monolikit/vue'
import BaseButton from '@/views/components/base/button.vue'

useHead({
	titleTemplate: (title) => `${title} - Blue Bird`,
})
</script>

<template>
	<main class="container mx-auto grid h-full w-full grid-cols-6 gap-16 p-12">
		<aside class="flex flex-col items-center">
			<div class="fixed flex flex-col items-center py-10 text-blue-50">
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
		<section class="col-span-5 flex max-w-2xl grow flex-col">
			<slot />
		</section>
	</main>
</template>
