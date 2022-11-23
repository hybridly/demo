<script setup lang="ts">
const $props = defineProps<{
	chirps: Paginator<App.Data.ChirpData>
	user: App.Data.UserProfileData
}>()

const { chirps } = useInfiniteChirpLoading($props.chirps)
</script>

<template layout="default,profile">
	<div ref="list" class="flex flex-1 flex-col gap-8">
		<chirp
			v-for="chirp in chirps"
			:key="chirp.id"
			:chirp="chirp"
			as="list-item"
		/>
		<div v-if="chirps.length === 0" class="text-center text-sm text-gray-400">
			<span class="font-medium">@{{ user.display_name }}</span> has not liked anything yet.
		</div>
	</div>
</template>
