<script setup lang="ts">
import { route } from 'hybridly/vue'

const $props = defineProps<{
	user: App.Data.UserProfileData
	activeTab: 'chirps' | 'comments' | 'likes'
}>()

useHead({
	title: $props.user.display_name,
})

function formatLargeNumbers(n: number): string {
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
		<!-- Banner -->
		<div class="relative grid h-40 w-full grid-cols-2 rounded-md bg-gray-100">
			<!-- Avatar -->
			<div class="relative left-4 top-10 z-[1] self-end">
				<avatar :user="user" size="2xl" darker-background />
			</div>

			<!-- Edit profile -->
			<div v-if="can(user, 'update')" class="relative self-end justify-self-end px-5 mb-4">
				<base-button variant="primary" size="sm">
					Edit Profile
				</base-button>
			</div>
		</div>

		<div class="px-7 pt-14">
			<!-- Name and join date -->
			<div class="flex items-start justify-between gap-5">
				<!-- Name -->
				<div>
					<div class="flex items-center gap-2">
						<div class="text-xl font-semibold text-blue-900" v-text="user.display_name" />
						<verified-badge :verified="!!user.identity_verified_at" size="md" />
					</div>
					<span class="text-sm text-slate-500" v-text="`@${user.username}`" />
				</div>

				<!-- Join date -->
				<div class="flex items-center gap-1 text-gray-500">
					<i-fluent-calendar-ltr-20-regular class="h-6 w-6" />
					<div class="text-sm" :title="formatDate(user.created_at, { dateStyle: 'long' })">
						Joined {{ useTimeAgo(user.created_at).value }}
					</div>
				</div>
			</div>

			<!-- Bio -->
			<p class="pt-5 text-gray-800" v-text="user.about" />

			<!-- Statistics -->
			<div class="flex flex-wrap gap-10 pt-2">
				<div class="flex items-center gap-2">
					<div class="text-xl font-bold" v-text="formatLargeNumbers(user.chirps_count)" />
					<div class="text-sm text-gray-600">
						Chirps
					</div>
				</div>
				<div class="flex items-center gap-2">
					<div class="text-xl font-bold" v-text="formatLargeNumbers(user.likes_count)" />
					<div class="text-sm text-gray-600">
						Likes
					</div>
				</div>
			</div>
		</div>

		<!-- Tabs -->
		<nav class="flex mt-4 relative">
			<div class="bottom-0 inset-x-0 h-1 border-b absolute" />
			<div
				class="inset-x-0 h-1 w-24 absolute bottom-0 border-b border-blue-500 transition"
				:class="{
					'translate-x-0': activeTab === 'chirps',
					'translate-x-24': activeTab === 'comments',
					'translate-x-48': activeTab === 'likes',
				}"
			/>

			<RouterLink
				:href="route('users.show', { user: user.id })"
				class="w-24 text-center py-3"
				:class="{ 'text-gray-900': activeTab === 'chirps' }"
				text="Chirps"
			/>
			<RouterLink
				:href="route('users.show-comments', { user: user.id })"
				class="w-24 text-center py-3"
				:class="{ 'text-gray-900': activeTab === 'comments' }"
				text="Comments"
			/>
			<RouterLink
				:href="route('users.show-likes', { user: user.id })"
				class="w-24 text-center py-3"
				:class="{ 'text-gray-900': activeTab === 'likes' }"
				text="Likes"
			/>
		</nav>

		<!-- Page -->
		<div class="mt-6">
			<transition
				mode="out-in"
				enter-active-class="duration-200 transition"
				enter-from-class="opacity-0 translate-y-1"
				enter-to-class="opacity-100 translate-y-0"
				leave-active-class="duration-200 transition"
				leave-from-class="opacity-100 translate-y-0"
				leave-to-class="opacity-0 translate-y-1"
			>
				<slot />
			</transition>
		</div>
	</section>
</template>
