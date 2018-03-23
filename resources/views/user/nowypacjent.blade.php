@extends('layouts.dashboard')

@section('title')
Rejestracja
@endsection


@section('head')
<style  type="text/css">
.control-group
{
      text-align: center;
}
.form-group
{
    text-align: center;
    margin-bottom: 0px;
}
.form-group select
{
    margin: 0 auto;
}
.container
{
    margin-bottom: 10px;
}
</style>
@endsection
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

@section('content')

    <div class="col-sx-12 col-sm-8 col-md-10" >
    <div class="panel panel-default">
       <div class="panel-heading">
                Restracja nowego pacjenta
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

          <form class="form" role="form" action='rejestracja' method="POST"  enctype="multipart/form-data">
            <fieldset>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="patientsDoctor" value="{{ $profil->id }}">
              <input type="hidden" name="funkcja" value="pacjent">
             
            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
              @if($ordynator == true)
              @php
                $lekarze = DB::table('users')->where('funkcja', 'lekarz')->get();
              @endphp
              <div class="form-group">
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
              @endif
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
              <div class="form-group">
                  <label for="gender">Płeć</label>
                  <select required class="form-control-noborder" name="gender" id="gender">
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
                <div class="form-group">
                    <label class="control-label"  for="photo">Zdjęcie rentgentowskie</label>
                    <div class="controls">
                        <input required type="file" id="image" name="image" placeholder=""  class="form-control-file">
                        <p class="help-block">Wybierz zdjęcie rentgentowskie pacjenta</p>
                    </div>
                </div>
              <div class="form-group">
                <div class="controls">
                  <button class="btn btn-success">Zarejestruj pacjenta</button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
        </div>
    </div>



@endsection