<script setup lang="ts">
import { useAutoAnimate } from '@formkit/auto-animate/vue'

const props = defineProps<{
	user: App.Data.UserProfileData
	chirps: Paginator<App.Data.ChirpData>
}>()

useHead({
	title: props.user.display_name,
})

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
</script>

<template layout>
	<section class="w-full max-w-2xl rounded-lg">
		<div class="grid h-40 w-full rounded-t-lg bg-slate-200">
			<div class="relative left-3 top-10 self-end">
				<avatar :user="user" size="2xl" />
			</div>
		</div>
		<div class="px-4 pt-12">
			<div class="flex items-start justify-between gap-5">
				<div class="">
					<div class="text-xl font-semibold text-blue-900">
						{{ user.display_name }}
					</div>
					<div class="text-sm text-slate-500">
						@{{ user.username }}
					</div>
				</div>
				<div class="relative -left-1 flex items-center gap-1 pt-5 text-gray-500">
					<i-fluent-calendar-ltr-20-regular class="h-6 w-6" />
					<div class="text-sm">
						Joined
						{{ user.created_at }}
					</div>
				</div>
			</div>
			<div class="flex flex-wrap gap-10 pt-5">
				<div class="flex items-center gap-2">
					<div class="text-xl font-bold">
						{{ user.chirps_count }}
					</div>
					<div class="text-sm text-gray-400">
						Chirps
					</div>
				</div>
				<div class="flex items-center gap-2">
					<div class="text-xl font-bold">
						{{ user.likes_count }}
					</div>
					<div class="text-sm text-gray-400">
						Likes
					</div>
				</div>
			</div>
		</div>
		<div class="flex gap-14 px-5 pt-10 text-gray-700">
			<div class="font-bold text-black">
				Chirps
				<div class="mt-2 h-1 w-full rounded-full bg-blue-500" />
			</div>
			<div class="">
				Comments
			</div>
			<div class="">
				Likes
			</div>
		</div>
		<div ref="list" class="flex flex-1 flex-col gap-8 pt-5">
			<chirp
				v-for="chirp in chirps"
				:key="chirp.id"
				:chirp="chirp"
				as="list-item"
			/>
		</div>
	</section>
</template>
