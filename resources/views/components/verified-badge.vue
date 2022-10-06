<script setup lang="ts">
withDefaults(defineProps<{
	verified: string | null
	size?: 'sm' | 'md'
}>(), {
	size: 'sm',
})
</script>

<template>
	<div v-if="verified" class="shrink-0">
		<i-ic-baseline-verified
			class="text-blue-400"
			:class="{
				'h-5 w-5': size === 'sm',
				'h-6 w-6': size === 'md',
			}"
		/>
	</div>
</template>
