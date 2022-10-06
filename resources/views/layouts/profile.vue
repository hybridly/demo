<script setup lang="ts">
import { route } from 'hybridly/vue'

const props = defineProps<{
	user: App.Data.UserProfileData
	activeTab: 'chirps' | 'comments' | 'likes'
	canEditProfile: boolean
}>()

useHead({
	title: props.user.display_name,
})

const formatLargeNumbers = (n: number): string => {
	const value = n.toFixed().toString()
	if (value.length >= 4 && value.length <= 6) {
		return `${value.slice(0, -3)}K`
	}
	if (value.length >= 7 && value.length <= 9) {
		return `${value.slice(0, -6)}M`
	}
	if (value.length >= 10 && value.length <= 12) {
		return `${value.slice(0, -9)}B`
	}

	return value
}
</script>

<template>
	<section class="w-full max-w-2xl">
		<div class="relative grid h-40 w-full grid-cols-2 rounded-t-md bg-gradient-to-t from-gray-50 to-slate-200">
			<div class="relative left-4 top-10 z-[1] self-end">
				<avatar :user="user" size="2xl" darker-background />
			</div>
			<div v-if="canEditProfile" class="relative self-end justify-self-end px-5">
				<base-button variant="primary" size="sm">
					Edit Profile
				</base-button>
			</div>
		</div>
		<div class="px-7 pt-14">
			<div class="flex items-start justify-between gap-5">
				<div class="">
					<div class="flex items-center gap-2">
						<div class="text-xl font-semibold text-blue-900">
							{{ user.display_name }}
						</div>
						<verified-badge :verified="user.identity_verified_at" size="md" />
					</div>
					<div class="text-sm text-slate-500">
						@{{ user.username }}
					</div>
				</div>
				<div class="flex items-center gap-1 text-gray-500">
					<i-fluent-calendar-ltr-20-regular class="h-6 w-6" />
					<div class="text-sm">
						Joined
						{{ user.created_at }}
					</div>
				</div>
			</div>
			<div class="pt-5 text-gray-800">
				{{ user.bio }}
			</div>
			<div class="flex flex-wrap gap-10 pt-2">
				<div class="flex items-center gap-2">
					<div class="text-xl font-bold">
						{{ formatLargeNumbers(user.chirps_count) }}
					</div>
					<div class="text-sm text-gray-400">
						Chirps
					</div>
				</div>
				<div class="flex items-center gap-2">
					<div class="text-xl font-bold">
						{{ formatLargeNumbers(user.likes_count) }}
					</div>
					<div class="text-sm text-gray-400">
						Likes
					</div>
				</div>
			</div>
		</div>
		<div class="flex gap-14 border-b px-7 pt-10 text-gray-700">
			<RouterLink
				v-auto-animate
				:href="route('users.show', { user: user.id })"
				:class="{
					'font-bold text-black': activeTab === 'chirps'
				}"
			>
				Chirps
				<div v-if="activeTab === 'chirps'" class="mt-2 h-1 w-full rounded-full bg-blue-500" />
			</RouterLink>
			<RouterLink
				v-auto-animate
				:href="route('users.show-comments', { user: user.id })"
				:class="{
					'font-bold text-black': activeTab === 'comments'
				}"
			>
				Comments
				<div v-if="activeTab === 'comments'" class="mt-2 h-1 w-full rounded-full bg-blue-500" />
			</RouterLink>
			<RouterLink
				:href="route('users.show-likes', { user: user.id })"
				:class="{
					'font-bold text-black': activeTab === 'likes'
				}"
			>
				Likes
				<div v-if="activeTab === 'likes'" class="mt-2 h-1 w-full rounded-full bg-blue-500" />
			</RouterLink>
		</div>
		<div class="pt-5">
			<transition
				mode="out-in"
				enter-active-class="duration-200 transition"
				enter-from-class="opacity-0"
				enter-to-class="opacity-100"

				leave-active-class="duration-200 transition"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
			>
				<slot />
			</transition>
		</div>
	</section>
</template>
