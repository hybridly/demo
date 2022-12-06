<script setup lang="ts">
import { RouteName } from 'hybridly/vue'
import steps from '@/views/layouts/steps.vue'

defineLayout(steps, {
	stepNumber: 3,
	previousRouteName: 'order.step2' as RouteName,
})

</script>

<template>
	<section class="h-[30rem] grid place-items-center text-center">
		<div class="">
			<div class="grid place-items-center">
				<i-ph:check-circle-duotone class="w-20 h-20 text-indigo-400" />
			</div>
			<div class="pt-5 text-3xl">
				Congratulations!
			</div>
			<div class="pt-3 w-full max-w-xl mx-auto text-lg text-slate-500">
				You have successfully completed the order.
			</div>
		</div>
	</section>
</template>
