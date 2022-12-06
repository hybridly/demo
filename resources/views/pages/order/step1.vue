<script setup lang="ts">
import { RouteName } from 'hybridly/vue'
import steps from '@/views/layouts/steps.vue'

const plan = ref<'' | 'basic' | 'pro'>('')

defineLayout(steps, {
	stepNumber: 1,
	nextRouteName: 'order.step2' as RouteName,
})
</script>

<template>
	<section class="pt-10 text-center">
		<div class="grid place-items-center">
			<i-bluebird-logo class="h-16 w-16 text-blue-500" />
		</div>
		<div class="pt-3 text-3xl">
			Get a <span class="font-bold text-blue-500">blue bird</span> checkmark
		</div>
		<div class="pt-3 w-full max-w-xl mx-auto text-lg text-slate-500">
			Claim a verified badge to show the world you're the real deal.
			Just like the cool dudes on Twitter.
		</div>
		<div class="pt-10 flex gap-10 justify-center text-left">
			<div
				class="border-2 rounded-xl p-5 w-60 transition duration-500"
				:class="{
					'border-indigo-500': plan === 'basic'
				}"
			>
				<div class="text-2xl font-bold">
					Basic
				</div>
				<div class="text-slate-500 text-sm">
					Just essentials
				</div>
				<div
					class="w-full py-2 text-center rounded-full mx-auto my-3 cursor-pointer
					transition duration-500"
					:class="{
						'bg-indigo-100 ring-indigo-100 ring-1 text-indigo-800 hover:bg-indigo-200': plan !== 'basic',
						'bg-indigo-400 ring-indigo-500 ring-1 text-white hover:bg-indigo-500': plan === 'basic',
					}"
					@click="plan = 'basic'"
				>
					Select
				</div>
				<div class="font-bold text-2xl">
					<span class="">
						$8
					</span>
					<span class="text-slate-400">
						<span class="text-sm">/</span>
						mo
					</span>
				</div>
				<ul class="text-sm list-disc p-4 space-y-2">
					<li>
						Get a verified badge
					</li>
					<li>
						See 50% less ads
					</li>
				</ul>
			</div>
			<div
				class="border-2 rounded-xl p-5 w-60 transition duration-500"
				:class="{
					'border-indigo-500': plan === 'pro'
				}"
			>
				<div class="text-2xl font-bold">
					Pro
				</div>
				<div class="text-slate-500 text-sm">
					Extra features
				</div>
				<div
					class="w-full py-2 text-center rounded-full mx-auto my-3 cursor-pointer
					transition duration-500"
					:class="{
						'bg-indigo-100 ring-indigo-100 ring-1 text-indigo-800 hover:bg-indigo-200': plan !== 'pro',
						'bg-indigo-400 ring-indigo-500 ring-1 text-white hover:bg-indigo-500': plan === 'pro',
					}"
					@click="plan = 'pro'"
				>
					Select
				</div>
				<div class="font-bold text-2xl">
					<span class="">
						$20
					</span>
					<span class="text-slate-400">
						<span class="text-sm">/</span>
						mo
					</span>
				</div>
				<ul class="text-sm list-disc p-4 space-y-2">
					<li>
						All basic features
					</li>
					<li>
						No ads
					</li>
				</ul>
			</div>
		</div>
	</section>
</template>
