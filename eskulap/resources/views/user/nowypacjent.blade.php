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
    width: 15%;
}
.container
{
    margin-bottom: 10px;
}
</style>
@endsection
<?php     
    $id = session()->get('user');
    $profil = DB::table('users')->where('id', $id)->first();
?>

@section('content')

<div class="col-sm-10 content" >
    <div class="panel panel-default">
       <div class="panel-heading">
                Restracja nowego pacjenta
        </div>
        <div class="panel-body">
          <form class="form-horizontal" action='rejestracja' method="POST">
            <fieldset >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="patientsDoctor" value="{{ $profil->id }}">
              <input type="hidden" name="funkcja" value="pacjent">
              <?php
                  // Wyświetlanie błędów
                  $error = session()->get('error');
                  echo $error;
              ?>
              <div class="control-group">
                <label class="control-label"  for="username">Imię</label>
                <div class="controls">
                  <input type="text" name="forename" placeholder="" class="input-xlarge">
                  <p class="help-block">Wprowadź imię</p>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"  for="username">Nazwisko</label>
                <div class="controls">
                  <input type="text" name="surname" placeholder="" class="input-xlarge">
                  <p class="help-block">Wprowadź nazwisko</p>
                </div>
              </div>
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Płeć</label>
                  <select class="form-control" name="gender" id="exampleFormControlSelect1">
                    <option value="kobieta">Kobieta</option>
                    <option value="mezczyzna">Mężczyzna</option>
                  </select>
                  <p class="help-block">Wybierz płeć </p>
              </div>
              <div class="control-group">
                <label class="control-label"  for="username">Data urodzenia</label>
                <div class="controls">
                    <input type="date" name="dateOfBirth" placeholder="" class="input-xlarge">
                  <p class="help-block">Wprowadź datę urodzenia</p>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"  for="username">PESEL</label>
                <div class="controls">
                    <input type="text" name="pesel" placeholder="" class="input-xlarge">
                  <p class="help-block">Wprowadź numer PESEL</p>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"  for="username">Zdjęcie rentgenowskie</label>
                <div class="controls">
                    <input type="text" name="pesel" placeholder="" class="input-xlarge">
                  <p class="help-block">Wybierz zdjęcie rentgenowskie pacjenta</p>
                </div>
              </div>
              <div class="control-group">
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