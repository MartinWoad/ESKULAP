@extends('layouts.admin')

@section('title')
Panel administratora
@endsection
<?php
    $pracownicy = DB::table('users')->where('funkcja', "not like", "admin")->get();
    $pacjenci = DB::table('patients')->get();
?>

@section('content')

    <?php
    $pracownicy = DB::table('users')->where('funkcja', "not like", "admin")->get();
    $pacjenci = DB::table('patients')->get();
    ?>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <blockquote class="blockquote mb-0">Witaj w Eskulapie.</blockquote>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Liczba lekarzy</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-flex">
                                <h2 class="mb-0 display-4">{{ sizeof($pracownicy) }}</h2>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            <div class="bg-success px-4 py-2 rounded">
                                <i class="mdi mdi-briefcase-outline text-white icon-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Liczba pacjentów</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-flex">
                                <h2 class="mb-0 display-4">{{ sizeof($pacjenci) }}</h2>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            <div class="bg-info px-4 py-2 rounded">
                                <i class="mdi mdi-transit-transfer text-white icon-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Łączna liczba użytkowników</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-flex">
                                <h2 class="mb-0 display-4">{{ sizeof($pracownicy) + sizeof($pacjenci) }}</h2>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            <div class="bg-primary px-4 py-2 rounded">
                                <i class="mdi mdi-human-greeting text-white icon-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Ostatnie logowanie</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-flex">
                                <h2 class="mb-0 display-4">{{ date('d.m') }}</h2>
                                <div class="d-flex align-items-center ml-2 pt-2">
                                    <i class="mdi mdi-clock text-muted"></i>
                                    <small class=" ml-1 mb-0">{{ date('H:i:s') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            <div class="bg-warning px-4 py-2 rounded">
                                <i class="mdi mdi-login-variant text-white icon-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW ENDS -->

@endsection