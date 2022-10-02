<script setup lang="ts">
withDefaults(defineProps<{
	as?: string
}>(), {
	as: 'div',
})
</script>

<template>
	<component :is="as" class="overflow-hidden rounded-2xl bg-white shadow shadow-slate-200">
		<slot />
	</component>
</template>
