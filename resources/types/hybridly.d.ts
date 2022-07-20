interface GlobalHybridlyProperties {
	security: {
		user: App.Data.UserData
		characters: {
			minimum: number
			maximum: number
		}
	}
	flash: {
		success?: string
		error?: string
		warning?: string
		info?: string
	}
}
