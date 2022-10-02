<script setup lang="ts">
withDefaults(defineProps<{
	variant?: 'primary'
	size?: 'xs' | 'sm' | 'md' | 'lg'
	loading?: boolean
	text?: string
}>(), {
	size: undefined,
	variant: undefined,
	loading: false,
	text: undefined,
})
</script>

<template>
	<button
		class="relative flex items-center justify-center font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed"
		:class="{
			'px-4 h-[35px] text-xs rounded-3xl': size === 'xs',
			'px-4 h-[38px] text-sm rounded-3xl': size === 'sm',
			'px-4 h-[42px] text-md rounded-3xl': size === 'md',
			'px-4 h-[45px] text-lg rounded-3xl': size === 'lg',
			'text-white bg-blue-500 hover:bg-blue-400 disabled:hover:bg-blue-500 focus-visible:ring-offset-blue-100 focus-visible:ring-blue-100 disabled:opacity-30': variant === 'primary',
		}"
	>
		<slot v-if="!loading">
			{{ text }}
		</slot>

		<i-gg-spinner v-if="loading" class="h-5 w-5 animate-spin" />
	</button>
</template>
