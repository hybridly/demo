<script setup lang="ts">
const props = defineProps<{
	user: App.Data.UserData
}>()

const initials = computed(() => props.user.display_name
	.split(' ')
	.map((word) => word[0])
	.slice(0, 2)
	.join('').toUpperCase(),
)
</script>

<template>
	<div>
		<div class="text-md flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 font-medium text-slate-600">
			{{ initials }}
		</div>
	</div>
</template>
