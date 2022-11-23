<script setup lang="ts">
const props = withDefaults(defineProps<{
	user: App.Data.UserData | App.Data.UserProfileData
	size?: 'xs' | 'sm' | 'lg' | 'xl' | '2xl'
	darkerBackground?: boolean
}>(), {
	size: 'sm',
	darkerBackground: false,
})

const initials = computed(() => props.user.display_name
	.split(' ')
	.map((word) => word[0])
	.slice(0, 2)
	.join('').toUpperCase(),
)
</script>

<template>
	<div
		class="grid shrink-0 place-items-center overflow-hidden rounded-full"
		:class="{
			'h-10 w-10': size === 'xs',
			'h-12 w-12': size === 'sm',
			'h-16 w-16': size === 'lg',
			'h-24 w-24': size === 'xl',
			'h-32 w-32': size === '2xl',

			'bg-slate-100 text-slate-600': darkerBackground === false,
			'bg-slate-200 text-slate-700': darkerBackground === true,
		}"
	>
		<div
			v-if="!user.profile_picture_url"
			class="font-medium"
			:class="{
				'text-xs': size === 'xs',
				'text-sm': size === 'sm',
				'text-lg': size === 'lg',
				'text-2xl': size === 'xl',
				'text-3xl': size === '2xl',
			}"
		>
			{{ initials }}
		</div>
		<img
			v-else
			class="h-full w-full object-cover"
			:src="user.profile_picture_url"
		/>
	</div>
</template>
