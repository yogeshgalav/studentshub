<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Student's HUB</title>
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="manifest" href="/build/manifest.webmanifest" />
		@vite
		@inertiaHead
	</head>
	<body class="antialiased">
		@inertia
	</body>
</html>
