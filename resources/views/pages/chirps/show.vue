<script setup lang="ts">
const props = defineProps<{
	chirp: App.Data.ChirpData
}>()

useHead({
	title: `${props.chirp.author.display_name} on Blue Bird: ${props.chirp.body}`,
})
</script>

<template layout>
	<div class="mt-12">
		<RouterLink href="/" class="mb-8 flex items-center text-xl text-blue-600 transition hover:text-blue-500">
			<i-material-symbols-arrow-circle-left-outline-rounded class="mr-4 h-6 w-6" />
			Go back
		</RouterLink>
		<chirp :chirp="chirp" />
	</div>
</template>
