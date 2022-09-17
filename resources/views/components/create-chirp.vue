<script setup lang="ts">
const $props = defineProps<{
	placeholder?: string
	replyTo?: string
}>()

const $emit = defineEmits<{
	(e: 'success'): void
}>()

const createChirpForm = useForm<App.Data.CreateChirpData>({
	method: 'POST',
	url: route('chirp.store'),
	reset: true,
	fields: {
		body: '',
		parent_id: $props.replyTo ?? null,
	},
	hooks: {
		success: () => $emit('success'),
	},
})

const error = computed(() => Object.values(createChirpForm.errors ?? {}).at(0))
const { textarea, triggerResize } = useTextareaAutosize({ watch: () => createChirpForm.fields })
const characters = useProperty('security.characters')
const characterCount = computed(() => createChirpForm.fields.body.length)
const charactersLeft = computed(() => characters.value - characterCount.value)
const limitLevel = computed(() => {
	const percentageLeft = (Number(charactersLeft.value) / Number(characters.value)) * 100

	if (percentageLeft > 20) {
		return
	}

	if (percentageLeft <= 0) {
		return 'reached'
	}

	if (percentageLeft <= 10) {
		return 'red'
	}

	return 'orange'
})

const canSubmit = computed(() => characterCount.value >= 1 && limitLevel.value !== 'reached')

function submit() {
	if (!canSubmit.value) {
		return
	}

	createChirpForm.submit()
}

function addNewLine() {
	createChirpForm.fields.body += '\n'
	nextTick(triggerResize)
}
</script>

<template>
	<base-card class="group p-4">
		<form @submit.prevent="submit">
			<textarea
				ref="textarea"
				v-model="createChirpForm.fields.body"
				:row="1"
				:max="200"
				class="mb-2 w-full resize-none border-none font-medium placeholder:text-gray-400 focus:ring-0"
				:placeholder="placeholder ?? `What's on your mind?`"
				@keydown.enter.prevent.exact="submit"
				@keydown.shift.enter.stop.prevent="addNewLine"
			/>

			<!-- Actions -->
			<div class="flex items-end justify-between">
				<!-- Attachment, stats, emoji... -->
				<div class="flex min-w-0 items-center gap-x-5 px-3 text-gray-400">
					<base-button class="transition hover:text-gray-500">
						<i-ic-outline-image class="h-5 w-5" />
					</base-button>
					<base-button class="transition hover:text-gray-500">
						<i-ic-round-insert-chart-outlined class="h-5 w-5" />
					</base-button>
					<span
						v-if="error"
						class="truncate text-xs font-medium text-red-500"
						:title="error"
						v-text="error"
					/>
				</div>

				<!-- Submit -->
				<div class="flex items-center">
					<span
						v-if="limitLevel"
						class="mr-4 text-sm font-medium"
						:class="{
							'text-orange-500': limitLevel === 'orange',
							'text-red-500': limitLevel === 'red',
							'text-red-500 animate-pulse': limitLevel === 'reached',
						}"
						v-text="charactersLeft"
					/>

					<base-button
						type="submit"
						variant="primary"
						size="sm"
						:disabled="!canSubmit"
					>
						Chirp
					</base-button>
				</div>
			</div>
		</form>
	</base-card>
</template>
