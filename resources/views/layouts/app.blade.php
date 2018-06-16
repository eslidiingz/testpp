<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@auth
	<meta name="user-token" content="{{ JWTAuth::fromUser(auth()->user()) }}">
	@endauth

	<title>Simple Image Gallery</title>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	{{-- Lightbox 2 --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('lightbox2-master/dist/css/lightbox.min.css') }}">
</head>
<body>
	<div id="app">
		@include('layouts.navbar')

		<main class="py-4">
			@yield('content')
		</main>
	</div>

	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('lightbox2-master/dist/js/lightbox.min.js') }}"></script>
	<script>
		lightbox.option({
		  'resizeDuration': 200,
		  'wrapAround': true
		})
	</script>
</body>
</html>
