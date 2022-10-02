<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full flex flex-col min-h-[110vh]">
	<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="preconnect" href="https://fonts.googleapis.com">
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
			<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
			<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
			<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
			<link rel="manifest" href="/site.webmanifest">
			@vite
	</head>
	<body class="h-full bg-gray-50 antialiased">
			@monolikit(class: 'h-full')
	</body>
</html>
