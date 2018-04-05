@extends('layouts.dashboard')

@section('title')
Zarządzanie
@endsection
<?php
    $id = session()->get('user');
    $pacjenci;
    $ordynator = false;
    if(DB::table('users')->where('id', $id)->first()->funkcja == "ordynator")
    {
        $lekarze = DB::table('users')->where('funkcja', 'lekarz')->get();
        $pacjenci = DB::table('patients')->get();
        $ordynator = true;
    } else {
        $pacjenci = DB::table('patients')->where('id_lekarza', $id)->get();
    }
?>

@section('content')

		<div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Panel zarządzania pracowników
                </div>
                <div class="panel-body">
                    <h2>Witaj w eskulapie.</h2>
                    
                    @if($ordynator == true)
                        <p>Liczba lekarzy w systemie: : {{ sizeof($lekarze) }}</p>
                        <p>Ilość zarejstrowanych pacjętów w systemie: {{ sizeof($pacjenci) }}</p>
                    @else
                        <p>Ilość twoich pacjętów: {{ sizeof($pacjenci) }}</p>
                    @endif

                </div>
                <div class="panel-footer">
                    <p class="text-right">Data zalogowania do systemu: {{ date('Y-m-d H:i:s') }}</p>
                </div>
            </div>
		</div>


@endsection