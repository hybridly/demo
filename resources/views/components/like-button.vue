<script setup lang="ts">
const $props = defineProps<{
	likes: number
	canLike: boolean
	canUnlike: boolean
}>()

const playAnimation = ref(false)

watch(
	() => $props.canUnlike === true,
	() => {
		if ($props.canUnlike) {
			playAnimation.value = true
			setTimeout(() => {
				playAnimation.value = false
			}, 500)
		}
	},
)

const likes = computed(() => $props.likes)
const likesDebounced = refDebounced(likes, 100)
const toggleLikesAnimation = ref(true)
const likesIncreased = ref(true)

watch(likes, () => {
	likesIncreased.value = likes.value > likesDebounced.value
})

watch(likesDebounced, () => {
	toggleLikesAnimation.value = !toggleLikesAnimation.value
})
</script>

<template>
	<div
		class="group flex cursor-pointer items-center gap-3 hover:text-pink-500"
		:class="{
			'text-pink-500': canUnlike,
		}"
	>
		<div class="relative h-6 w-6">
			<!-- Outlined heart -->
			<i-ant-design-heart-outlined
				v-if="canLike"
				class="absolute inset-0 z-[1] h-6 w-6 transition"
			/>
			<!-- Filled heart -->
			<transition
				enter-active-class="duration-300 transition"
				enter-from-class="scale-0"
				enter-to-class="scale-100"

				leave-active-class="duration-150 transition"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
			>
				<i-ant-design-heart-filled
					v-if="canUnlike"
					class="absolute inset-0 z-[3] h-6 w-6 text-pink-500"
				/>
			</transition>
			<!-- Particles -->
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 -translate-y-5"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-blue-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 translate-y-5"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-orange-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 translate-x-5"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-emerald-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 -translate-x-5"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-pink-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 -translate-x-4 -translate-y-4"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-pink-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 translate-x-4 translate-y-4"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-pink-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 translate-x-4 -translate-y-4"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-pink-300"
				/>
			</transition>
			<transition
				enter-active-class="duration-500 transition ease-out"
				enter-to-class="scale-0 -translate-x-4 translate-y-4"
			>
				<div
					v-if="playAnimation"
					class="absolute top-1/3 left-[0.7rem] z-[2] h-1.5 w-1.5 rounded-full bg-pink-300"
				/>
			</transition>
			<!-- Background circle -->
			<div
				class="absolute inset-0 h-6 w-6 rounded-full bg-pink-50
                opacity-0 transition duration-200 group-hover:scale-150 group-hover:opacity-100"
			/>
		</div>
		<!-- Likes count -->
		<div class="relative h-5 min-w-[1rem] overflow-hidden text-center font-medium transition">
			<transition
				v-if="likesIncreased"
				enter-active-class="duration-300 transition"
				enter-from-class="opacity-0 translate-y-2"

				leave-active-class="duration-300 transition"
				leave-to-class="opacity-0 -translate-y-2"
			>
				<div v-if="toggleLikesAnimation" class="absolute top-0 right-0 min-w-[1rem]">
					{{ likesDebounced }}
				</div>
				<div v-else class="absolute top-0 right-0 min-w-[1rem]">
					{{ likesDebounced }}
				</div>
			</transition>
			<transition
				v-if="!likesIncreased"
				enter-active-class="duration-300 transition"
				enter-from-class="opacity-0 -translate-y-2"

				leave-active-class="duration-300 transition"
				leave-to-class="opacity-0 translate-y-2"
			>
				<div v-if="toggleLikesAnimation" class="absolute top-0 right-0 min-w-[1rem]">
					{{ likesDebounced }}
				</div>
				<div v-else class="absolute top-0 right-0 min-w-[1rem]">
					{{ likesDebounced }}
				</div>
			</transition>
		</div>
	</div>
</template>
