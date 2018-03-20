@extends('layouts.admin')

@section('title')
  Rejestracja
@endsection

@section('content')
  <div class="col-sx-12 col-sm-8 col-md-10 registration">
    <div class="panel panel-default">
      <div class="panel-heading">
        Rejestracja nowego profilu
      </div>
      <div class="panel-body">
        
        @if (session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Ups!</strong> {{ session()->get('error') }}
            </div>
        @endif 
        @if (session()->get('success'))
          <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Sukces!</strong> {{ session()->get('success') }}
          </div>
        @endif


        <form class="form" role="form" action='' method="POST">
          <fieldset>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
              <div class="form-group">
                <label for="funkcja">Funkcja</label>
                <select class="form-control-noborder" name="funkcja" id="funkcja" onchange="yesnoCheck(this);">
                  <option value="lekarz">Lekarz</option>
                  <option value="ordynator">Ordynator</option>
                  <option value="pacjent">Pacjent</option>
                </select>
                <p class="help-block">Wybierz jaką funkcję ma spełniać nowy użytkownik</p>
              </div>
              <div class="form-group" id="gdyPacjent" style="display: none;">
                <label for="patientsDoctor">Lekarz</label>
                <select class="form-control-noborder" name="patientsDoctor" id="patientsDoctor">
                  @if(sizeof($lekarze) == 0)
                    <option value="none">Brak lekarzy</option>
                  @endif
                  @foreach($lekarze as $test)
                    <option value="{{ $test->id }}">{{ $test->imie }} {{ $test->nazwisko }}</option>
                  @endforeach
                </select>
                <p class="help-block">Wybierz lekarza, do którego przypisany będzie nowy pacjent</p>
              </div>

              <div class="form-group">
                <label class="control-label" for="forename">Imię</label>
                <div class="controls">
                  <input required pattern="[A-Za-z]+" minlength="3" type="text" name="forename" id="forename" placeholder="" maxlength="16" class="form-control-noborder">
                  <p class="help-block">Wprowadź imię</p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="surname">Nazwisko</label>
                <div class="controls">
                  <input required pattern="[A-Za-z]+" minlength="3" type="text" name="surname" id="surname" placeholder="" maxlength="16" class="form-control-noborder">
                  <p class="help-block">Wprowadź nazwisko</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent1" style="display: none;">
                <label for="gender">Płeć</label>
                <select required class="form-control" name="gender" id="gender">
                  <option value="Kobieta">Kobieta</option>
                  <option value="Mężczyzna">Mężczyzna</option>
                </select>
                <p class="help-block">Wybierz płeć </p>
              </div>
              <div class="form-group">
                <label class="control-label" for="dateOfBirth">Data urodzenia</label>
                <div class="controls">
                  <input required type="date" min="1910-01-01" max="{{ date('Y-m-d') }}" name="dateOfBirth" placeholder="" class="form-control-noborder" id="dateOfBirth">
                  <p class="help-block">Wprowadź datę urodzenia </p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="pesel">PESEL</label>
                <div class="controls">
                  <input required pattern="[0-9]+" type="text" name="pesel" placeholder="" id="pesel" minlength="11" title="Proszę wprowadzić poprawny numer PESEL" maxlength="11" class="form-control-noborder">
                  <p class="help-block">Wprowadź numer PESEL</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent5" style="display: none;">
                <label class="control-label" for="photo">Zdjęcie rentgentowskie</label>
                <div class="controls">
                  <input type="file" id="image" name="image" placeholder=""  class="form-control-file">
                  <p class="help-block">Wybierz zdjęcie rentgentowskie pacjenta</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent2">
                <label class="control-label" for="username">Login</label>
                <div class="controls">
                  <input required type="text" id="login" pattern="[A-Za-z0-9]+" minlength="5" maxlength="16" name="username" placeholder="" class="form-control-noborder" id="login">
                  <p class="help-block">Wprowadź login - minimum 5 znaków (bez spacji)</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent3">
                <label class="control-label" for="password">Hasło</label>
                <div class="controls">
                  <input required  type="password" onchange="form.password_confirm.pattern = this.value;" minlength="5" maxlength="16" id="password" name="password" placeholder="" class="form-control-noborder">
                  <p class="help-block">Hasło powinno się składać z co najmniej 5 znaków</p>
                </div>
              </div>

              <div class="form-group" id="gdyPacjent4">
                <label class="control-label" for="password_confirm">Potwierdź hasło</label>
                <div class="controls">
                  <input required  type="password" minlength="5" maxlength="16" id="password_confirm" name="password_confirm" placeholder=""
                         class="form-control-noborder">
                  <p class="help-block">Wprowadzone hasła muszą być identyczne</p>
                </div>
              </div>
              <div class="form-group">
                <div class="controls">
                  <button class="btn btn-success" onclick="test();" id="send_button">Zarejestruj</button>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>



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