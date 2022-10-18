<script setup lang="ts">
import { useAutoAnimate } from '@formkit/auto-animate/vue'

useHead({
	title: 'Recent chirps',
})

const props = defineProps<{
	chirps: Paginator<App.Data.ChirpData>
}>()

const [list, enableChirpAnimations] = useAutoAnimate()
const canLoad = computed(() => !!props.chirps.meta?.next_page_url)
const chirps = ref<App.Data.ChirpData[]>([...props.chirps.data])

function loadMoreChirps() {
	if (!canLoad.value) {
		return
	}

	router.get(props.chirps.meta!.next_page_url!, {
		preserveState: true,
		preserveScroll: true,
		preserveUrl: true,
		only: ['chirps'],
		hooks: {
			before: () => enableChirpAnimations(false),
			success: () => chirps.value.push(...props.chirps.data),
			after: () => enableChirpAnimations(true),
		},
	})
}

useInfiniteScroll(window, loadMoreChirps, {
	offset: { bottom: 300 },
})

function updateChirps() {
	chirps.value.unshift(props.chirps.data[0])
}

function onDestroy(chirp: App.Data.ChirpData) {
	chirps.value.splice(chirps.value.indexOf(chirp), 1)
}
</script>

<template layout>
	<section class="relative">
		<create-chirp @success="updateChirps" />

		<h1 class="sticky top-0 left-0 z-10 -mx-8 mt-10 flex items-center gap-5 bg-gray-50 py-5 backdrop-blur-xl md:px-10 lg:px-12">
			<div class="pl-2 text-blue-500 transition hover:text-blue-600 sm:hidden">
				<i-bluebird-logo class="h-9 w-9" />
			</div>
			<div class="text-xl font-semibold text-gray-700 sm:text-2xl">
				Recent chirps
			</div>
		</h1>

		<div ref="list" class="flex flex-1 flex-col gap-8 pt-3">
			<chirp
				v-for="chirp in chirps"
				:key="chirp.id"
				:chirp="chirp"
				as="list-item"
				@destroy="onDestroy(chirp)"
			/>
		</div>

		<div class="mt-16 flex items-center justify-center">
			<base-button variant="primary" size="md" :loading="!canLoad" @click="loadMoreChirps">
				Load more
			</base-button>
		</div>
	</section>
</template>
