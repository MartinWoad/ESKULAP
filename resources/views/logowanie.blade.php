@extends('layouts.master')

@section('title')
Logowanie
@endsection
@section('head')
    <link rel="stylesheet" href="{{ URL::to("css/login.css") }}"/>
@endsection
@section('content')

    <?php
    $message = session()->get('message');
    if ($message != '')
        echo '<div class="alert alert-danger alert-dismissible fade show error"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$message.'</div>';
    ?>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <div class="row">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-full-bg">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-dark text-left pt-5 pr-5 pl-5">
                            <img class="mx-auto d-block" src="img/logo.png" alt="logo">
                            <form class="pt-5" role="form" method="POST">
                                <fieldset>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label for="username">Login</label>
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Wprowadź login">
                                        <i class="mdi mdi-account"></i>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Hasło</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Wprowadź hasło">
                                        <i class="mdi mdi-eye"></i>
                                    </div>
                                    <div class="mt-5">
                                        <button class="btn btn-block btn-primary btn-lg font-weight-medium">Zaloguj się</button>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="row mt-5">
                                <div class="col-12 mt-xl-2">
                                    <hr/>
                                    <p class="text-white font-weight-normal text-center pb-1">Copyright &copy; <script>document.write(new Date().getFullYear())</script>
                                        <span class="text-primary">ESKULAP</span>. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection