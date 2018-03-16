@extends('layouts.master')

@section('title')
Logowanie
@endsection
@section('head')
    <link rel="stylesheet" href="{{ URL::to("css/login.css") }}"/>
@endsection
@section('content')



<div class="container logo">
    <div class="col-sm-12">
        <img src="img/logo.png"></img>
    </div>
</div>
<div class="container">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Logowanie</h3>
            </div>
            <div class="panel-body">
                <?php
                $message = session()->get('message');
                echo $message;

                ?>
                <form role="form" method="POST">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input class="form-control" placeholder=" Login" name="username" type="text" autofocus="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder=" Hasło" name="password" type="password" value="">
                        </div>
                        <button class="btn btn-success">Zaloguj się</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection