<script setup lang="ts">
import axios from 'axios'
import { can } from 'hybridly'

const $props = defineProps<{
	chirp: App.Data.ChirpData
	as: 'list-item' | 'comment'
	previous?: string
}>()

const $emit = defineEmits<{
	(e: 'destroy'): void
}>()

const canShowChirp = computed(() => $props.as === 'list-item')
const dynamicCreatedAt = useTimeAgo($props.chirp.created_at)
const likes = ref($props.chirp.likes_count)
const authorization = reactive<App.Data.ChirpData['authorization']>({
	comment: $props.chirp.authorization.comment,
	like: $props.chirp.authorization.like,
	unlike: $props.chirp.authorization.unlike,
	delete: $props.chirp.authorization.delete,
})

// In the context of infinite scrolling, it is not convenient to use
// hybridly, because we would lose the scroll position and loaded
// pagination. This is a good opportunity to simply use AJAX.
async function toggleLike() {
	const [method, url] = authorization.like
		? ['post', route('chirp.like', { chirp: $props.chirp }), likes.value++]
		: ['delete', route('chirp.unlike', { chirp: $props.chirp }), likes.value--]

	await axios.request({ url, method }).then(({ status }) => {
		if (status === 204) {
			authorization.like = !authorization.like
			authorization.unlike = !authorization.unlike
		}
	})
}

function showChirp(mode: 'normal' | 'new-tab') {
	if (!canShowChirp.value) {
		return
	}

	if (mode === 'normal') {
		router.get(route('chirp.show', { chirp: $props.chirp }))
	} else {
		window.open(route('chirp.show', { chirp: $props.chirp }), '_blank')
	}
}

function deleteChirp() {
	router.delete(route('chirp.destroy', { chirp: $props.chirp }), {
		data: {
			redirect_to: $props.previous,
		},
		preserveState: false,
		preserveScroll: true,
		hooks: {
			success: () => $emit('destroy'),
		},
	})
}
</script>

<template>
	<base-card
		as="article"
		class="flex gap-6 border border-gray-100 p-8 transition"
		:class="{
			'cursor-pointer': canShowChirp,
			'hover:shadow-zinc-300': canShowChirp,
			'shadow-blue-50': !canShowChirp
		}"
		@click="showChirp('normal')"
		@click.middle="showChirp('new-tab')"
	>
		<!-- Profile picture -->
		<avatar :user="chirp.author" />

		<div class="w-full">
			<!-- Header -->
			<div class="mb-4 flex items-center justify-between">
				<!-- Username -->
				<span class="inline-flex items-center">
					<span class="font-medium leading-none text-gray-900" v-text="chirp.author?.display_name" />
					<i-material-symbols-verified-outline-rounded v-if="chirp.author?.identity_verified_at" class="ml-1 text-blue-400" />
					<span class="mb-0.5 ml-5 text-sm font-medium tracking-wide text-gray-500" v-text="'@' + chirp.author?.username" />
				</span>

				<!-- Date posted -->
				<span
					class="mb-0.5 text-xs font-medium tracking-wide text-gray-500"
					:title="chirp.created_at"
					v-text="dynamicCreatedAt"
				/>
			</div>

			<!-- Body -->
			<p class="mb-4" v-text="chirp.body" />

			<!-- Attachments -->
			<div
				v-if="chirp.attachments.length > 0"
				class="mb-6 grid grid-cols-3 gap-4"
			>
				<template v-for="(attachment, i) in chirp.attachments" :key="i">
					<div class="relative aspect-square overflow-hidden rounded-3xl border border-blue-50">
						<!-- Preview -->
						<img
							:src="attachment.url"
							class="absolute inset-0 object-contain object-center"
							:alt="attachment.alt"
							:title="attachment.alt"
						/>
					</div>
				</template>
			</div>

			<!-- Actions -->
			<div class="flex items-center gap-x-10 text-sm text-gray-600">
				<!-- Comment -->
				<chirp-button color="emerald">
					<template #icon>
						<i-ant-design-comment-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span class="ml-5 transition">
							Comment
							<template v-if="chirp.comments_count > 0">({{ chirp.comments_count }})</template>
						</span>
					</template>
				</chirp-button>

				<!-- Re-chirp -->
				<!-- <chirp-button color="blue">
					<template #icon>
						<i-ant-design-retweet-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span class="ml-5 transition">Re-chirp</span>
					</template>
				</chirp-button> -->

				<!-- Like/unlike -->
				<chirp-button
					color="pink"
					:class="{ 'text-pink-500': can({ authorization }, 'unlike') }"
					@click.stop="toggleLike"
				>
					<template #icon>
						<i-ant-design-heart-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span class="ml-5 transition">
							<template v-if="can({ authorization }, 'like')">Like</template>
							<template v-if="can({ authorization }, 'unlike')">Unlike</template>
							<template v-if="likes > 0"> ({{ likes }})</template>
						</span>
					</template>
				</chirp-button>

				<!-- Delete -->
				<chirp-button
					v-if="can({ authorization }, 'delete')"
					color="blue"
					@click.stop="deleteChirp"
				>
					<template #icon>
						<i-ant-design:delete-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
				</chirp-button>
			</div>
		</div>
	</base-card>
</template>
