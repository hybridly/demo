<script setup lang="ts">
useHead({
	title: 'Login',
})

const properties = useProperties()

const login = useForm({
	method: 'POST',
	url: '/login',
	fields: {
		email: 'enzo@innocenzi.dev',
		password: '',
	},
})
</script>

<template>
	<div class="p-6">
		This is the login page -
		<RouterLink href="/">
			Go home
		</RouterLink>

		<pre class="my-6">{{ login }}</pre>

		<form class="space-x-2" @submit.prevent="login.submit()">
			<input v-model="login.fields.email" class="border" type="email" />
			<input v-model="login.fields.password" class="border" type="password" />
			<button :disabled="login.processing" class="disabled:opacity-50">
				ok
			</button>
			<button type="button" class="disabled:opacity-50" :disabled="!login.processing" @click="login.abort()">
				abort
			</button>
		</form>

		<pre class="my-6">{{ properties }}</pre>
	</div>
</template>
