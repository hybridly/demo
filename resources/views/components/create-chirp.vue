<script setup lang="ts">
const $props = defineProps<{
	placeholder?: string
	replyTo?: string
}>()

const $emit = defineEmits<{
	(e: 'success'): void
}>()

interface CreateChirp extends Omit<App.Data.CreateChirpData, 'attachments'> {
	body: string
	attachments: Array<{
		file?: File
		alt?: string
		preview?: string
	}>
}

const createChirpForm = useForm<CreateChirp>({
	method: 'POST',
	url: route('chirp.store'),
	reset: true,
	transform: (fields) => ({
		...fields,
		attachments: fields.attachments.map(({ file, alt }) => ({ file, alt })),
	}),
	fields: {
		body: '',
		parent_id: $props.replyTo ?? null,
		attachments: [],
	},
	hooks: {
		success: () => {
			$emit('success')
		},
	},
})

const { textarea, triggerResize } = useTextareaAutosize({ watch: () => createChirpForm.fields })
const attachmentInput = ref<HTMLInputElement>()
const error = computed(() => Object.values(createChirpForm.errors ?? {}).at(0))
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

const canSubmit = computed(() => {
	if (characterCount.value >= 1 && charactersLeft.value >= 0) {
		return true
	}

	if (createChirpForm.fields.attachments.length > 0) {
		return true
	}

	return false
})

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

/*
|--------------------------------------------------------------------------
| Attachments
|--------------------------------------------------------------------------
*/

const canAttach = computed(() => createChirpForm.fields.attachments.length < 3)

function newAttachment() {
	if (!canAttach.value) {
		return
	}

	attachmentInput.value?.click()
}

function removeAttachment(index: number) {
	createChirpForm.fields.attachments.splice(index, 1)
}

function onAttachmentSelected(event: Event) {
	for (const file of Array.from((event.target as HTMLInputElement)?.files ?? []).slice(0, 3)) {
		createChirpForm.fields.attachments.push({
			file,
			alt: file.name,
			preview: URL.createObjectURL(file),
		})
	}
}
</script>

<template>
	<base-card class="group p-4">
		<form v-auto-animate @submit.prevent="submit">
			<!-- Attachment input -->
			<input
				ref="attachmentInput"
				type="file"
				accept="image/*"
				class="hidden"
				multiple
				@change="onAttachmentSelected"
			/>

			<!-- Textarea -->
			<textarea
				ref="textarea"
				v-model="createChirpForm.fields.body"
				:row="1"
				:max="200"
				class="mb-2 w-full resize-none border-none font-medium tracking-wide text-zinc-700 placeholder:text-gray-400 focus:ring-0"
				:placeholder="placeholder ?? `What's on your mind?`"
				@keydown.enter.prevent.exact="submit"
				@keydown.shift.enter.stop.prevent="addNewLine"
			/>

			<!-- Attachments -->
			<div
				v-if="createChirpForm.fields.attachments.length > 0"
				v-auto-animate
				class="grid grid-cols-3 gap-4 p-4"
			>
				<template v-for="(attachment, i) in createChirpForm.fields.attachments" :key="i">
					<div v-if="attachment.file" class="relative aspect-square overflow-hidden rounded-3xl border border-blue-50">
						<!-- Preview -->
						<img
							:src="attachment.preview"
							class="absolute inset-0 h-full w-full object-cover object-center"
							:alt="attachment.alt"
							:title="attachment.alt"
							@error="removeAttachment(i)"
						/>
						<!-- Remove -->
						<base-button
							class="absolute top-2 left-2 h-8 w-8 rounded-full bg-white text-blue-600 transition hover:bg-blue-50"
							title="Remove attachment"
							@click.prevent="removeAttachment(i)"
						>
							<i-heroicons-solid-x class="h-4 w-4" />
						</base-button>
					</div>
				</template>
			</div>

			<!-- Actions -->
			<div class="flex items-end justify-between">
				<!-- Attachment, stats, emoji... -->
				<div class="flex min-w-0 items-center gap-x-5 px-3 text-gray-400">
					<base-button
						class="transition"
						:class="{
							'hover:text-blue-500': canAttach,
							'text-gray-300 cursor-not-allowed': !canAttach,
						}"
						:disabled="!canAttach"
						@click.prevent="newAttachment"
					>
						<i-ic-outline-image class="h-6 w-6" />
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
