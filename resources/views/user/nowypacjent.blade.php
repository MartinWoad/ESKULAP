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
    $profil = DB::table('users')->where('id', $id)->first();
?>

@section('content')

    <div class="col-sx-12 col-sm-8 col-md-10" >
    <div class="panel panel-default">
       <div class="panel-heading">
                Restracja nowego pacjenta
        </div>
        <div class="panel-body">
            <form class="form" role="form" action='rejestracja' method="POST">
            <fieldset>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="patientsDoctor" value="{{ $profil->id }}">
              <input type="hidden" name="funkcja" value="pacjent">
              <?php
                  // Wyświetlanie błędów
                  $error = session()->get('error');
                echo '<div class="alert alert-danger alert-dismissible fade in error"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$error.'</div>';

                ?>
            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <div class="form-group">
                        <label class="control-label"  for="forename">Imię</label>
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
              <div class="form-group">
                  <label for="gender">Płeć</label>
                  <select class="form-control" name="gender" id="gender">
                      <option value="Kobieta">Kobieta</option>
                      <option value="Mężczyzna">Mężczyzna</option>
                  </select>
                  <p class="help-block">Wybierz płeć </p>
              </div>
                <div class="form-group">
                    <label class="control-label"  for="dateOfBirth">Data urodzenia</label>
                    <div class="controls">
                        <input type="date" name="dateOfBirth" placeholder="" class="form-control">
                        <p class="help-block">Wprowadź datę urodzenia</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"  for="pesel">PESEL</label>
                    <div class="controls">
                        <input type="text" name="pesel" placeholder="" class="form-control">
                        <p class="help-block">Wprowadź numer PESEL</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"  for="photo">Zdjęcie rentgentowskie</label>
                    <div class="controls">
                        <input type="file" name="photo" placeholder=""  class="form-control-file">
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