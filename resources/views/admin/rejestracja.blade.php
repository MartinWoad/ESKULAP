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
        <form class="form" role="form" action='' method="POST">
          <fieldset>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @if (session()->get('error'))
              <div class="alert alert-danger alert-dismissible fade in error">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session()->get('error') }}
              </div>';
            @endif
            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
              <div class="form-group">
                <label for="funkcja">Funkcja</label>
                <select class="form-control" name="funkcja" id="funkcja" onchange="yesnoCheck(this);">
                  <option value="lekarz">Lekarz</option>
                  <option value="ordynator">Ordynator</option>
                  <option value="pacjent">Pacjent</option>
                </select>
                <p class="help-block">Wybierz jaką funkcję ma spełniać nowy użytkownik</p>
              </div>
              <div class="form-group" id="gdyPacjent" style="display: none;">
                <label for="patientsDoctor">Lekarz</label>
                <select class="form-control" name="patientsDoctor" id="patientsDoctor">
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
                  <input type="text" name="forename" id="forename" placeholder="" class="form-control">
                  <p class="help-block">Wprowadź imię</p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="surname">Nazwisko</label>
                <div class="controls">
                  <input type="text" name="surname" id="surname" placeholder="" class="form-control">
                  <p class="help-block">Wprowadź nazwisko</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent1" style="display: none;">
                <label for="gender">Płeć</label>
                <select class="form-control" name="gender" id="gender">
                  <option value="Kobieta">Kobieta</option>
                  <option value="Mężczyzna">Mężczyzna</option>
                </select>
                <p class="help-block">Wybierz płeć </p>
              </div>
              <div class="form-group">
                <label class="control-label" for="dateOfBirth">Data urodzenia</label>
                <div class="controls">
                  <input type="date" name="dateOfBirth" placeholder="" class="form-control" id="dateOfBirth">
                  <p class="help-block">Wprowadź datę urodzenia</p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="pesel">PESEL</label>
                <div class="controls">
                  <input type="text" name="pesel" placeholder="" id="pesel" class="form-control">
                  <p class="help-block">Wprowadź numer PESEL</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent5" style="display: none;">
                <label class="control-label" for="photo">Zdjęcie rentgentowskie</label>
                <div class="controls">
                  <input type="file" name="photo" placeholder="" class="form-control-file">
                  <p class="help-block">Wybierz zdjęcie rentgentowskie pacjenta</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent2">
                <label class="control-label" for="username">Login</label>
                <div class="controls">
                  <input type="text" name="username" placeholder="" class="form-control" id="login">
                  <p class="help-block">Wprowadź login (bez spacji)</p>
                </div>
              </div>
              <div class="form-group" id="gdyPacjent3">
                <label class="control-label" for="password">Hasło</label>
                <div class="controls">
                  <input type="password" id="password" name="password" placeholder="" class="form-control">
                  <p class="help-block">Hasło powinno się składać z co najmniej 4 znaków</p>
                </div>
              </div>

              <div class="form-group" id="gdyPacjent4">
                <label class="control-label" for="password_confirm">Potwierdź hasło</label>
                <div class="controls">
                  <input type="password" id="password_confirm" name="password_confirm" placeholder=""
                         class="form-control">
                  <p class="help-block">Wprowadzone hasła muszą być identyczne</p>
                </div>
              </div>
              <div class="form-group">
                <div class="controls">
                  <button class="btn btn-success" id="send_button">Zarejestruj</button>
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
        document.getElementById('gdyPacjent').style.display = 'block';
        document.getElementById('gdyPacjent1').style.display = 'block';
        document.getElementById('gdyPacjent2').style.display = 'none';
        document.getElementById('gdyPacjent3').style.display = 'none';
        document.getElementById('gdyPacjent4').style.display = 'none';
        document.getElementById('gdyPacjent5').style.display = 'block';

      } else {
        document.getElementById('gdyPacjent').style.display = 'none';
        document.getElementById('gdyPacjent1').style.display = 'none';
        document.getElementById('gdyPacjent2').style.display = 'block';
        document.getElementById('gdyPacjent3').style.display = 'block';
        document.getElementById('gdyPacjent4').style.display = 'block';
        document.getElementById('gdyPacjent5').style.display = 'none';
      }
    }

    $('#forename').change(function () {
      const name = $('#forename').val();
      const regex = /^[a-zA-Z]+$/;
      toggleInvalidInput('#forename', regex.test(name));
    });

    $('#surname').change(function () {
      const name = $('#surname').val();
      const regex = /^[a-zA-Z]+$/;
      toggleInvalidInput('#surname', regex.test(name));
    });

    $('#pesel').change(function () {
      const pesel = $('#pesel').val();
      const regex = /^[0-9]{11}$/.test(pesel);

      const isBadDate = (parseInt(pesel.substring(4, 6)) > 31) || (parseInt(pesel.substring(2, 4)) % 20) > 12;
      let checksum = (parseInt(pesel[0]) + 3 * parseInt(pesel[1]) + 7 * parseInt(pesel[2]) + 9 * parseInt(pesel[3]) + parseInt(pesel[4]) + 3 * parseInt(pesel[5]) + 7 * parseInt(pesel[6]) + 9 * parseInt(pesel[7]) + parseInt(pesel[8]) + 3 * parseInt(pesel[9])) % 10;
      if (checksum === 0) {
        checksum = 10;
      }
      checksum = 10 - checksum;
      const condition = parseInt(pesel[10]) === checksum && !isBadDate && regex;
      toggleInvalidInput('#pesel', condition);
    });

    $('#password').change(function () {
      const password = $('#password').val();
      toggleInvalidInput('#password', password.length >= 4);
    });

    $('#login').change(function () {
      const password = $('#login').val();
      toggleInvalidInput('#password', password.length >= 4);
    });

    $('#password, #password_confirm').change(function () {
      const password = $('#password').val();
      const passwordConfirm = $('#password_confirm').val();
      toggleInvalidInput('#password_confirm', password === passwordConfirm);
    });

    $('#pesel, #dateOfBirth').change(function () {
      const pesel = $('#pesel').val();
      const dateOfBirth = $('#dateOfBirth').val();

      const isDay = pesel.substring(4, 6) === dateOfBirth.substring(8, 10);
      const isMonth = parseInt(pesel.substring(2, 4)) % 20 === parseInt(dateOfBirth.substring(5, 7));
      const isYear = pesel.substring(0, 2) === dateOfBirth.substring(2, 4);
      const condition = isDay && isMonth && isYear;
      toggleInvalidInput('#dateOfBirth', condition);
      toggleInvalidInput('#pesel', condition);
    });


    /**
     * Append invalid-input class and disable send button, when condition is false.
     * Remove that restrictions, when passed condition is true
     *
     * @param input - input id name
     * @param condition - true, when everything is ok, else otherwise
     */
    function toggleInvalidInput(input, condition) {
      condition ? $(input).removeClass('invalid-input') : $(input).addClass('invalid-input');
      $('#send_button').attr('disabled', !condition);
    }
  </script>
@endsection