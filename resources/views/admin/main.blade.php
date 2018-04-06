@extends('layouts.admin')

@section('title')
Admin
@endsection
<?php
    $pracownicy = DB::table('users')->where('funkcja', "not like", "admin")->get();
    $pacjenci = DB::table('patients')->get();
?>

@section('content')

		<div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Panel administratora
                </div>
                <div class="panel-body">
                    <h2>Witaj w Eskulapie.</h2>

                    <p>Ilość zarejstrowanych pracowników w systemie: {{ sizeof($pracownicy) }}</p>
                    <p>Ilość zarejstrowanych pacjętów w systemie: {{ sizeof($pacjenci) }}</p>
                    <p>Ogółem liczba osób w systemie: {{ sizeof($pracownicy) + sizeof($pacjenci) }}</p>
                </div>
                <div class="panel-footer">
                    <p class="text-right">Data zalogowania do systemu: {{ date('Y-m-d H:i:s') }}</p>
                </div>
            </div>
		</div>


@endsection