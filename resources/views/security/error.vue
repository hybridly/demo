<script setup lang="ts">
const $props = defineProps<{
	status: number
}>()

const title = computed(() => ({
	503: 'Service unavailable',
	404: 'Not found',
	403: 'Forbidden',
})[$props.status] ?? 'Internal server error')

const description = computed(() => ({
	503: 'Sorry, we are doing some maintenance. Please check back soon.',
	404: 'The page your are looking for does not exist.',
	403: 'Sorry, you cannot access this page.',
})[$props.status] ?? 'Sorry, something went wrong.')

useHead({
	title: () => `${title.value} - Blue Bird`,
})
</script>

<template>
	<div class="grid min-h-full place-items-center bg-white px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
		<main class="mx-auto max-w-max">
			<section class="items-center sm:flex">
				<p class="text-4xl font-bold tracking-tight text-blue-400 sm:text-5xl md:text-blue-50" v-text="status" />
				<div class="sm:ml-6">
					<div class="sm:border-l sm:border-gray-200 sm:pl-6">
						<h1 class="text-3xl font-bold tracking-tight text-gray-800 sm:text-5xl" v-text="title" />
						<p class="mt-1 text-gray-500 md:text-xl" v-text="description" />
					</div>
				</div>
			</section>

			<div class="mt-6 flex space-x-3 sm:mt-10 sm:border-l sm:border-transparent sm:pl-6 md:ml-28">
				<router-link
					:href="route('index')"
					class="inline-flex items-center rounded-md border border-transparent bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
				>
					Go back home
				</router-link>
			</div>
		</main>
	</div>
</template>
