<script setup lang="ts">
withDefaults(defineProps<{
	verified: boolean | null
	size?: 'sm' | 'md'
}>(), {
	size: 'sm',
})
</script>

<template>
	<div v-if="verified" class="shrink-0" title="This user is verified and did not pay $8 for it.">
		<i-material-symbols:verified-rounded
			class="text-blue-400"
			:class="{
				'h-5 w-5': size === 'sm',
				'h-6 w-6': size === 'md',
			}"
		/>
	</div>
</template>
