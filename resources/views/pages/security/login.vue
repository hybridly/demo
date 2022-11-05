<script setup lang="ts">
useHead({
	title: 'Sign in to Blue Bird',
})

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
	<section class="grid h-full place-items-center bg-gray-50">
		<div class="grid w-full max-w-md place-items-center">
			<i-bluebird-logo class="h-12 w-12 text-blue-500" />
			<form
				class="mt-5 w-full bg-white p-8 shadow shadow-slate-200 md:rounded-xl"
				@submit.prevent="login.submit"
			>
				<!-- Greeting -->
				<div class="text-center">
					<div class="text-xl font-semibold text-blue-800" v-text="$t('login.welcome_text')" />
					<p class="pt-1 text-sm text-slate-400" v-text="$t('login.welcome_help_text')" />
				</div>

				<!-- Inputs -->
				<div class="mt-6">
					<div class="relative mt-4">
						<input
							v-model="login.fields.email"
							:placeholder="$t('login.email_field_placeholder')"
							class="w-full appearance-none rounded-lg border-slate-300 pl-10 outline-none transition duration-300 placeholder:text-sm
							placeholder:text-slate-400 focus:ring-2 focus:ring-blue-400"
							type="email"
						/>
						<i-ph-user-duotone class="absolute top-3 left-3 text-blue-600" />
					</div>
					<div class="relative mt-4">
						<input
							v-model="login.fields.password"
							:placeholder="$t('login.password_field_placeholder')"
							class="w-full appearance-none rounded-lg border-slate-300 pl-10 outline-none transition duration-300 placeholder:text-sm
							placeholder:text-slate-400 focus:ring-2 focus:ring-blue-400"
							type="password"
						/>
						<i-ph-lock-duotone class="absolute top-3 left-3 text-blue-600" />
					</div>

					<!-- Validation -->
					<div v-auto-animate>
						<span
							v-if="login.errors.email"
							class="block pt-4 text-center text-sm text-rose-400"
							v-text="login.errors.email"
						/>
					</div>

					<!-- Login button -->
					<base-button
						size="md"
						variant="primary"
						:disabled="login.processing"
						class="mx-auto mt-6 w-32"
					>
						{{ $t('login.sign_in_button_text') }}
					</base-button>
				</div>
			</form>

			<!-- Bypass login -->
			<div class="mt-7 text-sm">
				<span class="text-slate-400 mr-1" v-text="$t('login.quick_login_cta_text')" />
				<router-link
					:href="route('login.bypass')"
					class="font-bold text-blue-500 transition duration-300 hover:text-blue-400"
				>
					{{ $t('login.quick_login_link_text') }}
				</router-link>
			</div>
		</div>
	</section>
</template>
