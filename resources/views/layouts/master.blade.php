<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<title>ESKULAP - @yield('title')</title>

	<!-- plugins:css -->
	<link rel="stylesheet" href="{{ URL::to('modules/mdi/css/materialdesignicons.min.css') }}">
	<link rel="stylesheet" href="{{ URL::to('modules/simple-line-icons/css/simple-line-icons.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
	<!-- endinject -->
	<!-- plugins:js -->
	<script src="{{ URL::to('js/jquery.min.js')}}"></script>
	<script src="{{ URL::to('js/bootstrap.min.js')}}"></script>
	<script src="{{ URL::to('js/misc.js')}}"></script>
	<script src="{{ URL::to('js/off-canvas.js')}}"></script>

	<!-- endinject -->
	<!-- favicon -->
	<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">
	<!-- endinject -->
	@yield('head')

</head>
<body>
	@yield('content')
</body>

</html>