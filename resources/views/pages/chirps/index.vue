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
const createChirpForm = useForm<App.Data.CreateChirpData>({
	method: 'POST',
	url: route('chirp.store'),
	fields: {
		body: '',
	},
	hooks: {
		success: () => chirps.value.unshift(props.chirps.data[0]),
	},
})

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

</script>

<template layout>
	<section>
		<create-chirp
			v-model="createChirpForm.fields.body"
			:error="createChirpForm.errors.body"
			@submit="createChirpForm.submit()"
		/>

		<h1 class="mt-16 mb-8 ml-8 text-lg font-semibold text-gray-700">
			Recent chirps
		</h1>

		<div ref="list" class="flex flex-1 flex-col gap-8">
			<chirp
				v-for="chirp in chirps"
				:key="chirp.id"
				:chirp="chirp"
			/>
		</div>

		<div class="mt-16 flex items-center justify-center">
			<base-button variant="primary" size="md" :loading="!canLoad" @click="loadMoreChirps">
				Load more
			</base-button>
		</div>
	</section>
</template>
