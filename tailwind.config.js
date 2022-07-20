/* eslint-disable @typescript-eslint/no-var-requires */
const theme = require('tailwindcss/defaultTheme')

/** @type import('tailwindcss').Config */
module.exports = {
	content: [
		'./resources/**/*.blade.php',
		'./resources/**/*.ts',
		'./resources/**/*.vue',
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Poppins', ...theme.fontFamily.sans],
			},
			colors: {
				blue: {
					DEFAULT: '#2BA1F1',
					50: '#D7EDFC',
					100: '#C4E5FB',
					200: '#9ED4F9',
					300: '#78C3F6',
					400: '#51B2F4',
					500: '#2BA1F1',
					600: '#0E85D6',
					700: '#0B64A1',
					800: '#07446D',
					900: '#042338',
				},
			},
			boxShadow: {
				DEFAULT: '0px 16px 46px -14px rgba(0,0,0,0.1)',
			},
		},
	},
	plugins: [
		require('@tailwindcss/forms'),
	],
}
