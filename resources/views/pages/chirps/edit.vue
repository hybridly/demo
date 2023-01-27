<script setup lang="ts">
const $props = defineProps<{
	chirp: App.Data.ChirpData
}>()

const form = useForm<App.Data.UpdateChirpData>({
	url: route('chirp.update', $props),
	method: 'POST',
	fields: {
		body: $props.chirp.body!,
	},
	hooks: {
		success: () => router.dialog.close({
			preserveState: false,
		}),
	},
})
</script>

<template>
	<base-dialog :title="`Edit chirp`">
		<form class="flex flex-col" @submit.prevent="form.submit">
			<span v-if="form.errors.body">{{ form.errors.body }}</span>
			<input v-model="form.fields.body" type="text" />
			<button class="mt-4 underline">
				Update
			</button>
		</form>
	</base-dialog>
</template>
