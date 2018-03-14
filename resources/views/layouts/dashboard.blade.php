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
	

	<?php
		require app_path().'/helpers.php';
	?>

	@yield('head')

</head>
<body>
	<?php
	    $sesja = session()->get('logged');
	    
	    if($sesja != "true")
	    {
	        header("Location: ".URL::to('/'));
	        die();
	    }

	    $id = session()->get('user');

	    $profil = DB::table('users')->where('id', $id)->first();
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
			<a class="navbar-brand" >
				Eskulap - Panel zarządzania <small> ({{ $profil->funkcja }}) </small>
			</a>

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
		<div class="col-md-2 sidebar">
			<ul class="nav nav-pills nav-stacked">
				<li class="{{ set_active(['dashboard']) }}"><a href="dashboard">Strona główna</a></li>
				<li class="{{ set_active(['listapacjentow']) }}"><a href="listapacjentow">Lista pacjentów</a></li>
				<li class="{{ set_active(['nowypacjent']) }}"><a href="nowypacjent">Zarejestruj pacjenta</a></li>
			</ul>
		</div>
	@yield('content')
</body>

</html>