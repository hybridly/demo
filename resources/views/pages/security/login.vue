<script setup lang="ts">
useHead({
	title: 'Login',
})

const properties = useProperties()

const login = useForm({
	method: 'POST',
	url: route('login'),
	fields: {
		email: '',
		password: '',
	},
})
</script>

<template>
	<section class="grid h-full place-items-center bg-[#f2f5ff]">
		<div class="grid w-full max-w-md place-items-center">
			<logo class="h-12 w-12 text-blue-500" />
			<form
				class="mt-5 w-full rounded-xl bg-white p-8 shadow shadow-slate-200"
				@submit.prevent="login.submit()"
			>
				<div class="text-center">
					<div class="text-xl font-semibold text-blue-800">
						Welcome back!
					</div>
					<div class="pt-1 text-sm text-slate-400">
						Enter your credentials to access the app.
					</div>
				</div>
				<div class="space-y-4 pt-7">
					<div class="relative">
						<input
							v-model="login.fields.email"
							placeholder="Enter your email"
							class="w-full appearance-none rounded-lg border-slate-300 pl-10 outline-none transition duration-300 placeholder:text-sm
							placeholder:text-slate-400 focus:ring-2 focus:ring-blue-400"
							type="email"
						/>
						<i-ph-user-duotone class="absolute top-3 left-3 text-blue-600" />
					</div>
					<div v-auto-animate>
						<div v-if="login.errors.email" class="text-sm text-rose-400">
							{{ login.errors.email }}
						</div>
					</div>
					<div class="relative">
						<input
							v-model="login.fields.password"
							placeholder="Enter your password"
							class="w-full appearance-none rounded-lg border-slate-300 pl-10 outline-none transition duration-300 placeholder:text-sm
							placeholder:text-slate-400 focus:ring-2 focus:ring-blue-400"
							type="password"
						/>
						<i-ph-lock-duotone class="absolute top-3 left-3 text-blue-600" />
					</div>
					<div v-auto-animate>
						<div v-if="login.errors.password" class="text-sm text-rose-400">
							{{ login.errors.password }}
						</div>
					</div>
					<button
						:disabled="login.processing"
						class="w-full rounded-lg bg-blue-500 py-3 text-white
						transition duration-500 hover:bg-blue-600 disabled:opacity-50"
					>
						Sign In
					</button>
				</div>
			</form>
		</div>
	</section>
</template>
