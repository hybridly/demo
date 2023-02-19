<script setup lang="ts">
import { route } from 'hybridly/vue'

const $props = defineProps<{
	chirp: App.Data.ChirpData
	as: 'list-item' | 'comment' | 'preview'
	highlight?: boolean
}>()

const $emit = defineEmits<{
	(e: 'destroy'): void
}>()

const dynamicCreatedAt = useTimeAgo($props.chirp.created_at)
const authorization = reactive<App.Data.ChirpData['authorization']>({
	comment: $props.chirp.authorization.comment,
	like: $props.chirp.authorization.like,
	unlike: $props.chirp.authorization.unlike,
	delete: $props.chirp.authorization.delete,
	edit: $props.chirp.authorization.edit,
})

const { likes, toggleLike } = useChirpLikes($props.chirp, authorization)

function show() {
	router.get(route('chirp.show', { chirp: $props.chirp }))
}

function comment() {
	router.get(route('chirp.comment', { chirp: $props.chirp }), {
		preserveScroll: true,
		preserveState: true,
	})
}

function deleteChirp() {
	router.delete(route('chirp.destroy', { chirp: $props.chirp }), {
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
		:class="{ highlight }"
		@click="show"
	>
		<!-- Profile picture -->
		<router-link class="block" :href="route('users.show', { user: chirp.author })" @click.stop>
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
						@click.stop
						v-text="chirp.author?.display_name"
					/>
					<verified-badge :verified="!!chirp.author?.identity_verified_at" />
					<router-link
						:href="route('users.show', { user: chirp.author })"
						class="mb-0.5 ml-3 text-xs font-medium tracking-wide text-slate-500 hover:underline underline-offset-4 decoration-slate-300"
						@click.stop
						v-text="'@' + chirp.author?.username"
					/>
				</span>

				<!-- Date posted -->
				<span
					class="mb-0.5 text-xs font-medium tracking-wide text-slate-500"
					:title="chirp.created_at"
					v-text="dynamicCreatedAt"
				/>

				<router-link v-if="can(chirp, 'edit')" :href="route('chirp.edit', { chirp })" @click.stop>
					EDIT
				</router-link>
			</div>

			<!-- Body -->
			<p class="mb-4" @click.stop v-text="chirp.body" />

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
			<div class="flex items-center gap-x-6 text-sm text-gray-600">
				<!-- Comment -->
				<chirp-button v-if="as !== 'preview'" color="emerald" @click.stop="comment">
					<template #icon>
						<i-ant-design-comment-outlined class="relative -m-3 h-9 w-9 p-1.5 transition" />
					</template>
					<template #text>
						<span class="ml-5 transition">
							{{ chirp.comments_count }}
						</span>
					</template>
				</chirp-button>

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

<style scoped style="postcss">
.highlight {
	@apply ring ring-transparent;
  animation: highlight-animation ease-out 10s;
}

@keyframes highlight-animation {
  0% {
		@apply ring ring-blue-200;
	},
  100% {}
}
</style>
