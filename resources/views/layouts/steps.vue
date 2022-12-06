<script setup lang="ts">
import { RouteName } from 'hybridly/vue'

const $props = defineProps<{
	stepNumber: 1 | 2 | 3
	previousRouteName?: RouteName
	nextRouteName?: RouteName
}>()
</script>

<template>
	<section class="pt-20 w-full max-w-screen-lg mx-auto">
		<div class="grid grid-cols-3 relative">
			<!-- Step 1 -->
			<div class="grid place-items-center gap-5">
				<div
					class="text-lg"
					:class="{
						'font-bold': stepNumber === 1,
						'text-slate-500': stepNumber !== 1,
					}"
				>
					Choose plan
				</div>
				<div
					class="h-8 w-8 rounded-full grid place-items-center transition duration-500"
					:class="{
						'bg-slate-200': stepNumber < 2,
						'bg-blue-500': stepNumber >= 1,
					}"
				>
					<i-fluent-checkmark-12-regular
						class="w-6 h-6 text-white transition duration-500"
						:class="{
							'opacity-0': stepNumber <= 1,
							'opacity-100': stepNumber > 1,
						}"
					/>
				</div>
			</div>
			<!-- Step 2 -->
			<div class="grid place-items-center gap-5">
				<div
					class="text-lg"
					:class="{
						'font-bold': stepNumber === 2,
						'text-slate-500': stepNumber !== 2,
					}"
				>
					Payment
				</div>
				<div
					class="h-8 w-8 rounded-full grid place-items-center transition duration-500"
					:class="{
						'bg-slate-200': stepNumber < 3,
						'bg-blue-500': stepNumber >= 2,
					}"
				>
					<i-fluent-checkmark-12-regular
						class="w-6 h-6 text-white transition duration-500"
						:class="{
							'opacity-0': stepNumber <= 2,
							'opacity-100': stepNumber > 2,
						}"
					/>
					<div
						class="absolute top-1/2 translate-y-1/2 text-slate-400 font-bold transition duration-500"
						:class="{
							'opacity-0': stepNumber >= 2,
							'opacity-100': stepNumber < 2,
						}"
					>
						2
					</div>
				</div>
			</div>
			<!-- Step 3 -->
			<div class="grid place-items-center gap-5">
				<div
					class="text-lg"
					:class="{
						'font-bold': stepNumber === 3,
						'text-slate-500': stepNumber !== 3,
					}"
				>
					Review
				</div>
				<div
					class="h-8 w-8 rounded-full grid place-items-center transition duration-500"
					:class="{
						'bg-slate-200': stepNumber < 4,
						'bg-blue-500': stepNumber >= 3,
					}"
				>
					<i-fluent-checkmark-12-regular
						class="w-6 h-6 text-white transition duration-500"
						:class="{
							'opacity-0': stepNumber <= 3,
							'opacity-100': stepNumber > 3,
						}"
					/>
					<div
						class="absolute top-1/2 translate-y-1/2 text-slate-400 font-bold transition duration-500"
						:class="{
							'opacity-0': stepNumber >= 3,
							'opacity-100': stepNumber < 3,
						}"
					>
						3
					</div>
				</div>
			</div>
			<div class="bg-slate-200 w-full absolute bottom-3 left-0 h-1.5 -z-20 rounded-full" />
			<div
				class="bg-gradient-to-r from-cyan-400 to-blue-500
                w-full absolute bottom-3 left-0 h-1.5 -z-20 rounded-full
                origin-left
                transition duration-500
                "
				:class="{
					'scale-x-[.18]': stepNumber === 1,
					'scale-x-[.5]': stepNumber === 2,
					'scale-x-1': stepNumber === 3,
				}"
			/>
		</div>
		<div v-auto-animate class="min-h-[34rem]">
			<slot />
		</div>
		<div class="pt-5 mt-5 border-t flex gap-10 justify-between items-center">
			<div class="">
				<span class="text-slate-500 pr-2">Step</span>
				<span class="font-bold text-3xl">{{ stepNumber }}</span>
				<span class="px-0.5">/</span>
				<span>3</span>
			</div>
			<div class="flex gap-3 justify-end">
				<router-link
					v-if="previousRouteName"
					:href="route(previousRouteName)"
					class="bg-slate-400 w-28 text-center py-3 rounded-full text-white transition duration-500
                        active:scale-90"
				>
					Previous
				</router-link>
				<router-link
					v-if="nextRouteName"
					:href="route(nextRouteName)"
					class="bg-blue-500 w-36 py-3 rounded-full text-white transition duration-500
                    flex gap-2 items-center justify-center
                        active:scale-90"
				>
					<div>Next Step</div>
					<i-fluent-arrow-right-28-regular />
				</router-link>
				<div
					v-if="!nextRouteName"
					class="bg-blue-500 w-36 py-3 rounded-full text-white transition duration-500
                    flex gap-2 items-center justify-center
                        active:scale-90"
				>
					<div>Finish</div>
				</div>
			</div>
		</div>
	</section>
</template>
