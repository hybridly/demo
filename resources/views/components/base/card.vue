<script setup lang="ts">
withDefaults(defineProps<{
	as?: string
}>(), {
	as: 'div',
})
</script>

<template>
	<component :is="as" class="overflow-hidden rounded-2xl bg-white shadow">
		<slot />
	</component>
</template>
