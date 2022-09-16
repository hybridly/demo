<script setup lang="ts">
const props = defineProps<{ modelValue: string }>()
const emit = defineEmits<{
	(e: 'update:modelValue', body: string): void
	(e: 'submit'): void
}>()
const chirp = useVModel(props, 'modelValue', emit)

const { textarea } = useTextareaAutosize({ watch: chirp })
const characters = useProperty('security.characters')
const characterCount = computed(() => chirp.value.length)
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

	emit('submit')
	emit('update:modelValue', '')
}
</script>

<template>
	<base-card class="group p-4">
		<form @submit.prevent="submit">
			<textarea
				ref="textarea"
				v-model="chirp"
				:row="1"
				:max="200"
				class="mb-2 w-full resize-none border-none font-medium placeholder:text-gray-400 focus:ring-0"
				placeholder="What's on your mind?"
			/>

			<!-- Actions -->
			<div class="flex items-end justify-between">
				<!-- Attachment, stats, emoji... -->
				<div class="flex gap-x-5 px-3 text-gray-400">
					<base-button class="transition hover:text-gray-500">
						<i-ic-outline-image class="h-5 w-5" />
					</base-button>
					<base-button class="transition hover:text-gray-500">
						<i-ic-round-insert-chart-outlined class="h-5 w-5" />
					</base-button>
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
