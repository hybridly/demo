<script setup lang="ts">
import { route } from 'hybridly/vue'
import axios from 'axios'

const $props = defineProps<{
	chirp: App.Data.ChirpData
	as: 'list-item' | 'comment'
	previous?: string
}>()

const $emit = defineEmits<{
	(e: 'destroy'): void
}>()

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
		class="flex items-start gap-6 border border-gray-100 p-8 transition"
	>
		<!-- Profile picture -->
		<router-link class="block" :href="route('users.show', { user: chirp.author })">
			<avatar :user="chirp.author" class="ring-offset-[3px] hover:ring-1 ring-slate-300 transition" />
		</router-link>

		<div class="w-full">
			<!-- Header -->
			<div class="mb-4 flex flex-wrap items-center justify-between gap-5 border-b border-slate-100 pb-2 md:border-none md:pb-0">
				<!-- Username -->
				<span class="inline-flex items-center gap-2">
					<router-link
						:href="route('users.show', { user: chirp.author })"
						class="font-medium leading-none text-slate-800 hover:underline underline-offset-4 decoration-slate-300"
						v-text="chirp.author?.display_name"
					/>
					<verified-badge :verified="!!chirp.author?.identity_verified_at" />
					<router-link
						:href="route('users.show', { user: chirp.author })"
						class="mb-0.5 ml-3 text-xs font-medium tracking-wide text-slate-500 hover:underline underline-offset-4 decoration-slate-300"
						v-text="'@' + chirp.author?.username"
					/>
				</span>

				<!-- Date posted -->
				<span
					class="mb-0.5 text-xs font-medium tracking-wide text-slate-500"
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
					<div class="relative aspect-square overflow-hidden rounded-3xl border border-blue-50 transition hover:shadow-lg hover:shadow-slate-200">
						<!-- Preview -->
						<a :href="attachment.url" target="_blank" @click.capture.stop>
							<img
								:src="attachment.url"
								class="absolute inset-0 h-full w-full object-cover object-center"
								:alt="attachment.alt"
								:title="attachment.alt"
							/>
						</a>
					</div>
				</template>
			</div>

			<!-- Actions -->
			<div class="flex items-center gap-x-10 text-sm text-gray-600">
				<!-- Comment -->
				<router-link :href="route('chirp.show', { chirp })">
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
				</router-link>

				<!-- Like/unlike -->
				<like-button
					:likes="likes"
					:can-like="can({ authorization }, 'like')"
					:can-unlike="can({ authorization }, 'unlike')"
					@click.stop="toggleLike"
				/>

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
