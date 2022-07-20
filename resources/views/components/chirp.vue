<script setup lang="ts">
const props = defineProps<{
	chirp: App.Data.ChirpData
}>()

const dynamicCreatedAt = useTimeAgo(props.chirp.created_at)
</script>

<template>
	<base-card as="article" class="flex gap-6 p-8">
		<!-- Profile picture -->
		<avatar :user="chirp.author!" />

		<div class="w-full">
			<!-- Header -->
			<div class="mb-4 flex items-center justify-between">
				<!-- Username -->
				<span class="inline-flex items-center space-x-5">
					<span class="font-medium leading-none text-gray-900" v-text="chirp.author?.display_name" />
					<span class="mb-0.5 text-sm font-medium tracking-wide text-gray-500" v-text="'@' + chirp.author?.username" />
				</span>

				<!-- Date posted -->
				<span
					class="mb-0.5 text-xs font-medium tracking-wide text-gray-500"
					:title="chirp.created_at"
					v-text="dynamicCreatedAt"
				/>
			</div>

			<!-- Body -->
			<p class="mt" v-text="chirp.body" />

			<!-- Actions -->
			<div class="mt-6 flex items-center gap-x-10 text-sm text-gray-600">
				<base-button class="group hover:text-emerald-500">
					<i-ant-design-comment-outlined class="-m-3 h-9 w-9 rounded-full p-1.5 transition group-hover:bg-emerald-50" />
					<span class="ml-5 transition">Comment</span>
				</base-button>
				<base-button class="group hover:text-blue-500">
					<i-ant-design-retweet-outlined class="-m-3 h-9 w-9 rounded-full p-1.5 transition group-hover:bg-blue-50" />
					<span class="ml-5 transition">Re-chirp</span>
				</base-button>
				<base-button class="group hover:text-pink-500">
					<i-ant-design-heart-outlined class="-m-3 h-9 w-9 rounded-full p-1.5 transition group-hover:bg-pink-50" />
					<span class="ml-5 transition">Like</span>
				</base-button>
			</div>
		</div>
	</base-card>
</template>
