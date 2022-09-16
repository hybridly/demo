<script setup lang="ts">
defineProps<{
	color: 'pink' | 'blue' | 'emerald'
}>()
</script>

<template>
	<base-button
		class="group"
		:class="{
			'hover:text-pink-500': color === 'pink',
			'hover:text-blue-500': color === 'blue',
			'hover:text-emerald-500': color === 'emerald',
		}"
	>
		<div class="relative">
			<div
				class="absolute -inset-3.5 scale-50 rounded-full opacity-0 transition duration-200 group-hover:scale-100 group-hover:opacity-100"
				:class="{
					'bg-pink-50': color === 'pink',
					'bg-blue-50': color === 'blue',
					'bg-emerald-50': color === 'emerald',
				}"
			/>
			<slot name="icon" />
		</div>
		<slot name="text" />
	</base-button>
</template>
