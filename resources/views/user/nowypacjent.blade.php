@extends('layouts.dashboard')

@section('title')
Rejestracja
@endsection


@section('content')
    <?php
    $id = session()->get('user');
    $pacjenci;
    $ordynator = false;
    if(DB::table('users')->where('id', $id)->first()->funkcja == "ordynator")
    {
        $ordynator = true;
    }
    $profil = DB::table('users')->where('id', $id)->first();
    ?>
    @if (session()->get('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Ups!</strong> {{ session()->get('error') }}
        </div>
    @endif
    @if (session()->get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Sukces!</strong> {{ session()->get('success') }}
        </div>
    @endif

    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rejestracja nowego pacjenta</h4>
                <form class="form" role="form" action='rejestracja' method="POST"  enctype="multipart/form-data">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="patientsDoctor" value="{{ $profil->id }}">
                        <input type="hidden" name="funkcja" value="pacjent">
                        @if($ordynator == true)
                            @php
                                $lekarze = DB::table('users')->where('funkcja', 'lekarz')->get();
                            @endphp
                            <p class="card-description pl-4">
                                Wybór lekarza prowadzącego
                            </p>
                            <div class="row">
                                <div class="col-lg-6 pl-5">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Lekarz</label>
                                        <div class="col-sm-8">
                                            <select class="form-control"  name="patientsDoctor" id="patientsDoctor">
                                                @if(sizeof($lekarze) == 0)
                                                    <option value="none">Brak lekarzy</option>
                                                @endif
                                                @foreach($lekarze as $test)
                                                    <option value="{{ $test->id }}">{{ $test->imie }} {{ $test->nazwisko }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="card-description pl-4">
                                Dane pacjenta
                            </p>
                        @endif
                        <div class="row">
                            <div class="col-md-6 pl-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="forename">Imię</label>
                                    <div class="col-sm-8">
                                        <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="forename" id="forename" placeholder="" maxlength="16" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pl-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nazwisko</label>
                                    <div class="col-sm-8">
                                        <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="surname" id="surname" placeholder="" maxlength="16" class="form-control">                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pl-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Płeć</label>
                                    <div class="col-sm-8">
                                        <select required class="form-control" name="gender" id="gender">
                                            <option>Mężczyzna</option>
                                            <option>Kobieta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pl-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Data urodzenia</label>
                                    <div class="col-sm-8">
                                        <input required type="date" min="1910-01-01" max="{{ date('Y-m-d') }}" name="dateOfBirth" placeholder="" class="form-control" id="dateOfBirth">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pl-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">PESEL</label>
                                    <div class="col-sm-8">
                                        <input required pattern="[0-9]+" type="text" name="pesel" placeholder="" id="pesel" minlength="11" title="Proszę wprowadzić poprawny numer PESEL" maxlength="11" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pl-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Zdjęcie RTG</label>
                                    <input required type="file" id="image" name="image" class="file-upload-default">
                                    <div class="input-group col-sm-8">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Zamieść zdjęcie rentgenowskie">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-info" type="button"><i class="mdi mdi-folder-image"></i>Wybierz zdjęcie</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-md-center">
                                <button type="submit" class="btn btn-success mr-2"><i class="mdi mdi-account-plus"></i>Zarejestruj pacjenta</button>
                                <button type="reset" value="Reset" name="reset" class="btn btn-light"><i class="mdi mdi-undo"></i>Wyczyść formularz</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ URL::to('js/file-upload.js')}}"></script>
@endsection