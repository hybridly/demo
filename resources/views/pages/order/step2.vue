<script setup lang="ts">
import { RouteName } from 'hybridly/vue'
import steps from '@/views/layouts/steps.vue'

defineLayout(steps, {
	stepNumber: 2,
	previousRouteName: 'order.step1' as RouteName,
	nextRouteName: 'order.step3' as RouteName,
})

const payment = ref<'' | 'card' | 'paypal' | 'bank' | 'cash'>('')
</script>

<template>
	<section class="pt-20">
		<div class="text-center text-3xl">
			Choose a payment method
		</div>
		<div class="pt-10 flex flex-wrap gap-10 justify-center">
			<div
				class="rounded-lg flex w-96 gap-3 items-center p-4 transition duration-500 cursor-pointer"
				:class="{
					'bg-white ring-slate-300 ring-1 hover:bg-indigo-100 hover:text-indigo-800': payment !== 'card',
					'bg-indigo-100 ring-indigo-500 ring-1 text-indigo-800 hover:bg-indigo-200': payment === 'card',
				}"
				@click="payment = 'card'"
			>
				<div class="">
					<i-fluent-wallet-credit-card-16-regular class="w-11 h-11" />
				</div>
				<div class="">
					<div class="font-semibold text-lg">
						Credit Card
					</div>
					<div class="text-slate-500 text-sm">
						Master Card, Visa, American Express
					</div>
				</div>
			</div>
			<div
				class="rounded-lg flex w-96 gap-3 items-center p-4 transition duration-500 cursor-pointer"
				:class="{
					'bg-white ring-slate-300 ring-1 hover:bg-indigo-100 hover:text-indigo-800': payment !== 'paypal',
					'bg-indigo-100 ring-indigo-500 ring-1 text-indigo-800 hover:bg-indigo-200': payment === 'paypal',
				}"
				@click="payment = 'paypal'"
			>
				<div class="">
					<i-gg-paypal class="w-11 h-11" />
				</div>
				<div class="">
					<div class="font-semibold text-lg">
						Paypal
					</div>
					<div class="text-slate-500 text-sm">
						You will be redirected to paypal
					</div>
				</div>
			</div>
			<div
				class="rounded-lg flex w-96 gap-3 items-center p-4 transition duration-500 cursor-pointer"
				:class="{
					'bg-white ring-slate-300 ring-1 hover:bg-indigo-100 hover:text-indigo-800': payment !== 'bank',
					'bg-indigo-100 ring-indigo-500 ring-1 text-indigo-800 hover:bg-indigo-200': payment === 'bank',
				}"
				@click="payment = 'bank'"
			>
				<div class="">
					<i-ph-bank class="w-11 h-11" />
				</div>
				<div class="">
					<div class="font-semibold text-lg">
						Bank Transfer
					</div>
					<div class="text-slate-500 text-sm">
						Simple bank transfer
					</div>
				</div>
			</div>
			<div
				class="rounded-lg flex w-96 gap-3 items-center p-4 transition duration-500 cursor-pointer"
				:class="{
					'bg-white ring-slate-300 ring-1 hover:bg-indigo-100 hover:text-indigo-800': payment !== 'cash',
					'bg-indigo-100 ring-indigo-500 ring-1 text-indigo-800 hover:bg-indigo-200': payment === 'cash',
				}"
				@click="payment = 'cash'"
			>
				<div class="">
					<i-ph-currency-circle-dollar class="w-11 h-11" />
				</div>
				<div class="">
					<div class="font-semibold text-lg">
						Cash
					</div>
					<div class="text-slate-500 text-sm">
						Pay in person by visiting our HQ
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
