<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<title>ESKULAP - @yield('title')</title>

	<!-- favicon -->
	<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">

	<!-- jQuery -->
	<script src="{{ URL::to('js/jquery-1.12.4.js') }}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">

	<!-- Bootstrap js -->
	<script src="{{ URL::to('js/bootstrap.min.js')}}"></script>

	<!-- FontAwesome (źródło zamiast pliku, bo i tak ikony są hostowane u nich) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	@yield('head')

</head>
<body>
	@yield('content')
</body>

</html>