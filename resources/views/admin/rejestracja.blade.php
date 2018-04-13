@extends('layouts.admin')

@section('title')
  Rejestracja
@endsection

@section('content')
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
        <h4 class="card-title">Rejestracja nowego użytkownika</h4>
        <form class="form" role="form" action='' method="POST" enctype="multipart/form-data">
          <fieldset>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <p class="card-description pl-4">
              Wybór funkcji użytkownika
            </p>
            <div class="row">
              <div class="col-lg-6 pl-5">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label" for="funkcja">Funkcja</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="funkcja" id="funkcja" onchange="yesnoCheck(this);">
                      <option value="lekarz" selected="selected">Lekarz</option>
                      <option value="ordynator">Ordynator</option>
                      <option value="pacjent">Pacjent</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <p class="card-description pl-4">
              Dane użytkownika
            </p>
            <div class="row">
              <div class="col-md-6 pl-5">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label" for="forename">Imię</label>
                  <div class="col-sm-8">
                    <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="forename" id="forename" placeholder="" maxlength="16" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label" for="surname">Nazwisko</label>
                  <div class="col-sm-8">
                    <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="surname" id="surname" placeholder="" maxlength="16" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label" for="dateOfBirth">Data urodzenia</label>
                  <div class="col-sm-8">
                    <input required type="date" min="1910-01-01" max="{{ date('Y-m-d') }}" name="dateOfBirth" placeholder="" class="form-control" id="dateOfBirth">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label" for="pesel">PESEL</label>
                  <div class="col-sm-8">
                    <input required pattern="[0-9]+" type="text" name="pesel" placeholder="" id="pesel" minlength="11" title="Proszę wprowadzić poprawny numer PESEL" maxlength="11" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-6 pl-5">
                <div class="form-group row" id="gdyPacjent" style="display: none;">
                  <label class="col-sm-4 col-form-label" for="patientsDoctor">Lekarz</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="patientsDoctor" id="patientsDoctor">
                    @if(sizeof($lekarze) == 0)
                      <option value="none">Brak lekarzy</option>
                    @endif
                    @foreach($lekarze as $lekarz)
                      <option value="{{ $lekarz->id }}">{{ $lekarz->imie }} {{ $lekarz->nazwisko }}</option>
                      @endforeach
                      </select>
                  </div>
                </div>
                <div class="form-group row" id="gdyPacjent1" style="display: none;">
                  <label class="col-sm-4 col-form-label" for="gender">Płeć</label>
                  <div class="col-sm-8">
                    <select class="form-control " name="gender" id="gender">
                      <option value="Kobieta">Kobieta</option>
                      <option value="Mężczyzna">Mężczyzna</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row" id="gdyPacjent5" style="display: none;">
                  <label class="col-sm-4 col-form-label">Zdjęcie RTG</label>
                  <input type="file" id="image" name="image" class="file-upload-default">
                  <div class="input-group col-sm-8">
                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="Zamieść zdjęcie rentgenowskie">
                    <span class="input-group-append">
                      <button class="file-upload-browse btn btn-info" type="button"><i class="mdi mdi-folder-image"></i>Wybierz zdjęcie</button>
                    </span>
                  </div>
                </div>
                <div class="form-group row" id="gdyPacjent2">
                  <label class="col-sm-4 col-form-label" for="username">Login</label>
                  <div class="col-sm-8">
                    <input required type="text" id="login" pattern="[A-Za-z0-9]+" minlength="5" maxlength="16" name="username" placeholder="" class="form-control" id="login">
                  </div>
                </div>
                <div class="form-group row" id="gdyPacjent3">
                  <label class="col-sm-4 col-form-label" for="password">Hasło</label>
                  <div class="col-sm-8">
                    <input required  type="password" onchange="form.password_confirm.pattern = this.value;" minlength="5" maxlength="16" id="password" name="password" placeholder="" class="form-control">
                  </div>
                </div>
                <div class="form-group row" id="gdyPacjent4">
                  <label class="col-sm-4 col-form-label" for="password_confirm">Potwierdź hasło</label>
                  <div class="col-sm-8">
                    <input required  type="password" minlength="5" maxlength="16" id="password_confirm" name="password_confirm" placeholder=""
                           class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4 justify-content-md-center">
              <button type="submit" class="btn btn-success mr-2"><i class="mdi mdi-account-plus"></i>Zarejestruj użytkownika</button>
              <button type="reset" value="Reset" name="reset" class="btn btn-light"><i class="mdi mdi-undo"></i>Wyczyść formularz</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <script src="{{ URL::to('js/file-upload.js')}}"></script>
  <script>
    function yesnoCheck(that) {
      if (that.value == 'pacjent') {
        $( "#gdyPacjent" ).show();
        $( "#gdyPacjent1" ).show();
        $( "#gdyPacjent2" ).hide();
        $( "#gdyPacjent3" ).hide();
        $( "#gdyPacjent4" ).hide();
        $( "#gdyPacjent5" ).show();
        $("#image").prop('required',true);
        $("#login").prop('required',false);
        $("#password").prop('required',false);
        $("#password_confirm").prop('required',false);
      } else {
        $( "#gdyPacjent" ).hide();
        $( "#gdyPacjent1" ).hide();
        $( "#gdyPacjent2" ).show();
        $( "#gdyPacjent3" ).show();
        $( "#gdyPacjent4" ).show();
        $( "#gdyPacjent5" ).hide();
        $("#image").prop('required',false);
        $("#login").prop('required',true);
        $("#password").prop('required',true);
        $("#password_confirm").prop('required',true);
      }
    }
  </script>
@endsection