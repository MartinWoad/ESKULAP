@extends('layouts.dashboard')

@section('title')
Zarządzanie
@endsection

@section('content')

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
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <blockquote class="blockquote mb-0">Witaj w Eskulapie.</blockquote>
                </div>
            </div>
        </div>

        @if($ordynator == true)
            <div class="col-md-6 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-0">Liczba lekarzy</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-inline-block pt-3">
                                <div class="d-flex">
                                    <h2 class="mb-0 display-4">{{ sizeof($lekarze) }}</h2>
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
        @else

            <div class="col-md-6 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-0">Liczba Twoich pacjentów</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-inline-block pt-3">
                                <div class="d-flex">
                                    <h2 class="mb-0 display-4">{{ sizeof($pacjenci) }}</h2>
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
        @endif

        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Ostatnie logowanie</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-flex">
                                <h2 class="mb-0 display-4">{{ explode(" ",DB::table('users')->where("id", $id)->first()->lastLogin)[0] }}</h2>
                                <div class="d-flex align-items-center ml-2 pt-2">
                                    <i class="mdi mdi-clock text-muted"></i>
                                    <small class=" ml-1 mb-0">{{ explode(" ",DB::table('users')->where("id", $id)->first()->lastLogin)[1] }}</small>
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
@endsection