<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	
	
	<title>@yield('title')</title>

    <!-- jQuery -->
	<script src="{{ URL::to('js/jquery-1.12.4.js') }}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">

	<!-- Bootstrap js -->
	<script src="{{ URL::to('js/bootstrap.min.js ')}}"></script>

	@yield('head')

</head>
<body>
	@yield('content')
</body>

</html>