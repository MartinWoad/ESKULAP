<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    <title>ESKULAP - @yield('title')</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::to('modules/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('modules/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ URL::to('css/admin.css') }}">
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
	<?php
	    $sesja = session()->get('admin');

	    if($sesja != "true")
	    {
	        header("Location: ".URL::to('/'));
	        die();
	    }

	?>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper">
            <a class="navbar-brand logo" href="dashboard"><img src="img/logo-admin.png" alt="logo"></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item dropdown">
                    <p class="page-name d-none d-md-block">Zalogowano jako <strong>Administrator</strong></p>
                </li>
                <li class="nav-item dropdown lang-dropdown notification-dropdown d-block">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="icon-user icons"></i>
                    </a>
                    <div class="dropdown-menu navbar-dropdown preview-list notification-drop-down dropdownAnimation" aria-labelledby="notificationDropdown">
                        <a class="dropdown-item preview-item" href="logout">
                            <div class="preview-thumbnail">
                                <div class="preview-icon">
                                    <i class="icon-logout mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject font-weight-medium">Wyloguj się</p>
                                <p class="font-weight-light small-text">
                                    Opuść system
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
                <span class="icon-menu icons"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-category">
                        <span class="nav-link">NAWIGACJA</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard">
                            <span class="menu-title">Strona główna</span>
                            <i class="icon-globe menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-category">
                        <span class="nav-link">REJESTRACJA</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rejestracja">
                            <span class="menu-title">Dodaj użytkownika</span>
                            <i class="icon-user-follow menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-category">
                        <span class="nav-link">ZARZĄDZANIE</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listapracownikow">
                            <span class="menu-title">Lista pracowników</span>
                            <i class="icon-people menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listapacjentow">
                            <span class="menu-title">Lista pacjentów</span>
                            <i class="icon-people menu-icon"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <footer class="footer">
                <div class="container-fluid clearfix">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018  <span class="text-primary">ESKULAP</span>. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>