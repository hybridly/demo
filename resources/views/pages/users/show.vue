<script setup lang="ts">
import { useAutoAnimate } from '@formkit/auto-animate/vue'
import defaultLayout from '@/views/layouts/default.vue'
import profileLayout from '@/views/layouts/profile.vue'

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

useLayout([defaultLayout, profileLayout])
</script>

<template>
	<div ref="list" class="flex flex-1 flex-col gap-8">
		<chirp
			v-for="chirp in chirps"
			:key="chirp.id"
			:chirp="chirp"
			as="list-item"
		/>
		<div v-if="chirps.length === 0" class="text-center text-sm text-gray-400">
			Nothing to see here!
		</div>
	</div>
</template>
