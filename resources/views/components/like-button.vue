<script setup lang="ts">
const $props = defineProps<{
	likes: number
	canLike: boolean
	canUnlike: boolean
}>()

const animate = refAutoReset(false, 500)
const likes = computed(() => $props.likes)
const likesBeforeAnimation = refDebounced(likes, 150)

whenever(() => $props.canUnlike, () => animate.value = true)
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
				class="absolute inset-0 z-[1] h-6 w-6 transition will-change-transform"
				:class="{
					'opacity-0': canUnlike,
					'opacity-100': canLike,
				}"
			/>
			<!-- Filled heart -->
			<i-ant-design-heart-filled
				class="absolute inset-0 z-[3] h-6 w-6 text-pink-500 transition"
				:class="{
					'opacity-100': canUnlike,
					'opacity-0': canLike,
				}"
			/>
			<!-- Particles -->
			<div class="absolute inset-0 flex items-center justify-center">
				<!-- Top center -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 -translate-y-5"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-blue-300" />
				</transition>
				<!-- Bottom center -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 translate-y-5"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-emerald-300" />
				</transition>
				<!-- Center right -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 translate-x-5"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-emerald-300" />
				</transition>
				<!-- Center left -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 -translate-x-5"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-emerald-300" />
				</transition>
				<!-- Top left corner -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 -translate-x-4 -translate-y-4"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-pink-300" />
				</transition>
				<!-- Bottom right corner -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 translate-x-4 translate-y-4"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-pink-300" />
				</transition>
				<!-- Top right corner -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 translate-x-4 -translate-y-4"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-pink-300" />
				</transition>
				<!-- Bottom left corner -->
				<transition
					enter-active-class="duration-500 transition ease-out"
					enter-to-class="scale-0 -translate-x-4 translate-y-4"
				>
					<div v-if="animate" class="absolute z-[2] h-1.5 w-1.5 rounded-full bg-pink-300" />
				</transition>
			</div>
			<!-- Background circle -->
			<div class="absolute inset-0 h-6 w-6 rounded-full bg-pink-50 opacity-0 transition duration-200 group-hover:scale-150 group-hover:opacity-100" />
		</div>
		<!-- Likes count -->
		<div class="relative h-5 min-w-[1rem] overflow-hidden text-center font-medium transition">
			<!-- Not liked, will go down -->
			<div
				class="absolute top-0 right-0 min-w-[1rem] transition duration-300"
				:class="{
					'translate-y-full opacity-0': canUnlike,
					'opacity-100': canLike,
				}"
				v-text="likesBeforeAnimation"
			/>
			<!-- Liked, will go up -->
			<div
				class="absolute top-0 right-0 min-w-[1rem] transition duration-300"
				:class="{
					'-translate-y-full opacity-0': canLike,
					'opacity-100': canUnlike,
				}"
				v-text="likesBeforeAnimation"
			/>
		</div>
	</div>
</template>
