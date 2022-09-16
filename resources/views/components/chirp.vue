<script setup lang="ts">
import axios from 'axios'
import { can } from 'monolikit'

const props = defineProps<{
	chirp: App.Data.ChirpData
}>()

const dynamicCreatedAt = useTimeAgo(props.chirp.created_at)
const authorization = reactive<App.Data.ChirpData['authorization']>({
	comment: props.chirp.authorization.comment,
	like: props.chirp.authorization.like,
	unlike: props.chirp.authorization.unlike,
})

// In the context of infinite scrolling, it is not convenient to use
// monolikit, because we would lose the scroll position and loaded
// pagination. This is a good opportunity to simply use AJAX.
async function toggleLike() {
	const [method, url] = authorization.like
		? ['post', route('chirp.like', { chirp: props.chirp })]
		: ['delete', route('chirp.unlike', { chirp: props.chirp })]

	await axios.request({ url, method }).then(({ status }) => {
		if (status === 204) {
			authorization.like = !authorization.like
			authorization.unlike = !authorization.unlike
		}
	})
}
</script>

<template>
	<base-card as="article" class="flex gap-6 border border-gray-100 p-8 transition hover:shadow-blue-100">
		<!-- Profile picture -->
		<avatar :user="chirp.author" />

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
				<!-- Comment -->
				<chirp-button color="emerald">
					<template #icon>
						<i-ant-design-comment-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span class="ml-5 transition">Comment</span>
					</template>
				</chirp-button>

				<!-- Re-chirp -->
				<chirp-button color="blue">
					<template #icon>
						<i-ant-design-retweet-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span class="ml-5 transition">Re-chirp</span>
					</template>
				</chirp-button>

				<!-- Like/unlike -->
				<chirp-button
					color="pink"
					:class="{ 'text-pink-500': can({ authorization }, 'unlike') }"
					@click="toggleLike"
				>
					<template #icon>
						<i-ant-design-heart-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span v-if="can({ authorization }, 'like')" class="ml-5 transition">Like</span>
						<span v-if="can({ authorization }, 'unlike')" class="ml-5 transition">Unlike</span>
					</template>
				</chirp-button>
			</div>
		</div>
	</base-card>
</template>
