@extends('layouts.admin')

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

@section('content')

	<?php
	    $sesja = session()->get('admin');
	    
	    if($sesja != "true")
	    {
	        header("Location: ".URL::to('/'));
	        die();
	    }
	?>

<div class="col-sm-10" >
    <div class="panel panel-default">
       <div class="panel-heading">
                Rejestracja nowego profilu
        </div>
        <div class="panel-body">
		<form class="form-horizontal" action='' method="POST">
		  <fieldset >
		  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		    <?php
		    	// Wyświetlanie błędów
				$error = session()->get('error');
				echo $error;
			?>
		    <div class="form-group">
			    <label>Funkcja</label>
			    <select class="form-control" name="funkcja" onchange="yesnoCheck(this);">
			      <option value="lekarz">Lekarz</option>
			      <option value="ordynator">Ordynator</option>
			      <option value="pacjent">Pacjent</option>
			    </select>
			    <p class="help-block">Wybierz jaką funkcję ma spełniać nowy użytkownik</p>
			</div>			
			<div class="form-group" id="gdyPacjent" style="display: none;">
			    <label for="exampleFormControlSelect1">Lekarz</label>
			    <select class="form-control" name="patientsDoctor" id="exampleFormControlSelect1">
			      @if(sizeof($lekarze) == 0)
			      	<option value="none">Brak lekarzy</option>
			      @endif
			      @foreach($lekarze as $test)
					 <option value="{{ $test->id }}">{{ $test->imie }} {{ $test->nazwisko }}</option>
				  @endforeach
			    </select>
			    <p class="help-block">Wybierz lekarza którego podwładnym ma być nowy pacjent</p>
			</div>

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
		    <div class="form-group" id="gdyPacjent1" style="display: none;">
			    <label for="exampleFormControlSelect1">Płeć</label>
			    <select class="form-control" name="gender" id="exampleFormControlSelect1">
			      <option value="Kobieta">Kobieta</option>
			      <option value="Mężczyzna">Mężczyzna</option>
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
		    <div class="control-group" id="gdyPacjent5" style="display: none;">
		      <label class="control-label"  for="username">Zdjęcie rentgentowskie</label>
		      <div class="controls">
		          <input type="text" name="pesel" placeholder="" class="input-xlarge">
		        <p class="help-block">Wybierz zdjęcie rentgentowskie pacjenta</p>
		      </div>
		    </div>
		    <div class="control-group" id="gdyPacjent2">
		      <label class="control-label"  for="username">Login</label>
		      <div class="controls">
		        <input type="text" name="username" placeholder="" class="input-xlarge">
		        <p class="help-block">Wprowadź login (bez spacji)</p>
		      </div>
		    </div>
		    <div class="control-group" id="gdyPacjent3">
		      <label class="control-label" for="password">Hasło</label>
		      <div class="controls">
		        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
		        <p class="help-block">Hasło powinno się składać z co najmniej 4 znaków</p>
		      </div>
		    </div>
		 
		    <div class="control-group" id="gdyPacjent4">
		      <label class="control-label"  for="password_confirm">Potwierdź hasło</label>
		      <div class="controls">
		        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
		        <p class="help-block">Wprowadzone hasła muszą być identyczne</p>
		      </div>
		    </div>
		    <div class="control-group">
		      <div class="controls">
		        <button class="btn btn-success">Zarejestruj</button>
		      </div>
		    </div>
		  </fieldset>
		</form>
		</div>
	</div>
</div>
    


<script>
	function yesnoCheck(that) {
        if (that.value == "pacjent") {
            document.getElementById("gdyPacjent").style.display = "block";
            document.getElementById("gdyPacjent1").style.display = "block";
            document.getElementById("gdyPacjent2").style.display = "none";
            document.getElementById("gdyPacjent3").style.display = "none";
            document.getElementById("gdyPacjent4").style.display = "none";
            document.getElementById("gdyPacjent5").style.display = "block";

        } else {
            document.getElementById("gdyPacjent").style.display = "none";
            document.getElementById("gdyPacjent1").style.display = "none";
            document.getElementById("gdyPacjent2").style.display = "block";
            document.getElementById("gdyPacjent3").style.display = "block";
            document.getElementById("gdyPacjent4").style.display = "block";
            document.getElementById("gdyPacjent5").style.display = "none";
        }
    }

</script>
@endsection