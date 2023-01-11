<script setup lang="ts">
defineProps<{
	chirp: App.Data.ChirpData
	str: string
}>()

function reload() {
	router.reload()
}
</script>

<template>
	<base-dialog :title="`Chirp your reply to @${chirp.author.display_name}`">
		<div class="mt-2 flex flex-col">
			<chirp
				:chirp="chirp"
				as="preview"
			/>
			<create-chirp
				class="w-full mt-6"
				placeholder="Chirp your reply"
				:reply-to="chirp.id"
			/>
		</div>
	</base-dialog>
</template>
