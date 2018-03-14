@extends('layouts.master')

@section('title')
Logowanie
@endsection

@section('head')

<link ref="stylesheet" href="{{ URL::to("css/test.css") }}"/>
<style type="text/css" >
.panel-body
{
      text-align: center;
}
</style>
@endsection
@section('content')

<div class="container" style="margin-top:30px">

<div class="col-sm-4 col-sm-offset-4">
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
                                    <input class="form-control" placeholder="Login" name="username" type="text" autofocus="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Hasło" name="password" type="password" value="">
                                </div>
                                <button class="btn btn-success">Zaloguj się</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
</div>


</div>
@endsection