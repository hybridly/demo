<script setup lang="ts">
const $props = defineProps<{
	chirp: App.Data.ChirpData
	comments: Paginator<App.Data.ChirpData>
	previous: string
}>()

useHead({
	title: () => $props.chirp.body
		? `${$props.chirp.author.display_name} on Blue Bird: ${$props.chirp.body}`
		: `${$props.chirp.author.display_name} on Blue Bird`,
})
</script>

<template layout>
	<div class="mt-12">
		<router-link :href="previous" class="mb-8 flex items-center text-xl text-blue-600 transition duration-300 hover:-translate-x-1 hover:text-blue-500">
			<i-fluent-arrow-left-16-regular class="mr-3.5 h-7 w-7" />
			Go back
		</router-link>

		<div class="mb-24">
			<chirp
				:chirp="chirp"
				:previous="previous"
				as="comment"
			/>
		</div>

		<h1 class="mt-16 mb-8 ml-8 text-lg font-semibold text-gray-700">
			<template v-if="comments.data.length">
				Replies
			</template>
			<template v-else>
				Be the first to reply
			</template>
		</h1>

		<create-chirp
			class="mb-6"
			placeholder="Chirp your reply"
			:reply-to="chirp.id"
		/>

		<div ref="list" v-auto-animate class="flex flex-1 flex-col gap-6 will-change-contents">
			<chirp
				v-for="comment in comments.data"
				:key="comment.id"
				:chirp="comment"
				as="list-item"
			/>
		</div>
	</div>
</template>
