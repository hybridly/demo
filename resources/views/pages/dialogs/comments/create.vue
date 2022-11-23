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
	<router-dialog :title="`Chirp your reply to @${chirp.author.display_name}`">
		<div class="mt-2 flex flex-col">
			<chirp
				:chirp="chirp"
				as="preview"
			/>
			{{ str }} <br />
			<button @click="reload">
				reload
			</button>
			<create-chirp
				class="w-full mt-6"
				placeholder="Chirp your reply"
				:reply-to="chirp.id"
			/>
		</div>
	</router-dialog>
</template>
