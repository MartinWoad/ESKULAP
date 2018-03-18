<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	
	
	<title>ESKULAP - @yield('title')</title>

	<!-- favicon -->
	<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">

    <!-- jQuery -->
	<script src="{{ URL::to('js/jquery-1.12.4.js') }}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">

	<!-- Bootstrap js -->
	<script src="{{ URL::to('js/bootstrap.min.js ')}}"></script>

	<!-- FontAwesome (źródło zamiast pliku, bo i tak ikony są hostowane u nich) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- CSS -->
	<link rel="stylesheet" href="{{ URL::to('css/admin.css') }}">
	<?php
		require app_path().'/helpers.php';
	?>

	@yield('head')

</head>
<body>
	<?php
	    $sesja = session()->get('admin');
	    
	    if($sesja != "true")
	    {
	        header("Location: ".URL::to('/'));
	        die();
	    }

	?>

	<nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<img src="img/logo-admin.png" class="logo"></img>
			<p class="navbar-brand" >
				Panel administratora
			</p>

		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Konto
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="logout">Wyloguj</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-fluid main-container">
		<div class="col-sm-4 col-md-2 sidebar">
			<ul class="nav nav-pills nav-stacked">
				<li class="{{ set_active(['admin']) }}"><a href="admin">Strona główna</a></li>
				<li class="{{ set_active(['rejestracja']) }}"><a href="rejestracja">Stwórz profil</a></li>
				<li class="{{ set_active(['listapracownikow']) }}"><a href="listapracownikow">Lista pracowników</a></li>
				<li class="{{ set_active(['listapacjentow']) }}"><a href="listapacjentow">Lista pacjentów</a></li>
			</ul>
		</div>
	@yield('content')
</body>

</html>