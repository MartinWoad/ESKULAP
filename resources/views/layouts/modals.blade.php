<div id="editUser" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edytuj użytkownika</h4>
            </div>
            <div class="modal-body">
                <form class="form" role="form" action='' method="POST">
                    <fieldset>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="forename">Imię</label>
                                <div class="controls">
                                    <input type="text" name="forename" id="forename" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadź imię</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="surname">Nazwisko</label>
                                <div class="controls">
                                    <input type="text" name="surname" id="surname" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadź nazwisko</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="dateOfBirth">Data urodzenia</label>
                                <div class="controls">
                                    <input type="date" name="dateOfBirth" placeholder="" class="form-control-noborder" id="dateOfBirth">
                                    <p class="help-block">Wprowadź datę urodzenia</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="pesel">PESEL</label>
                                <div class="controls">
                                    <input type="text" name="pesel" placeholder="" id="pesel" class="form-control-noborder">
                                    <p class="help-block">Wprowadź numer PESEL</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="username">Login</label>
                                <div class="controls">
                                    <input type="text" name="username" placeholder="" class="form-control-noborder" id="login">
                                    <p class="help-block">Wprowadź login (bez spacji)</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Hasło</label>
                                <div class="controls">
                                    <input type="password" id="password" name="password" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Hasło powinno się składać z co najmniej 4 znaków</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password_confirm">Potwierdź hasło</label>
                                <div class="controls">
                                    <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadzone hasła muszą być identyczne</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12" style="text-align: center;">
                                <div class="form-group" >
                                    <div class="controls">
                                        <button class="btn btn-success" id="send_button">Zapisz zmiany</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                                    </div>
                                </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</div>

<div id="editPatient" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edytuj dane pacjenta</h4>
            </div>
            <div class="modal-body">
                <form class="form" role="form" action='' method="POST">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="patientsDoctor" value="{{ $profil->id }}">
                        <input type="hidden" name="funkcja" value="pacjent">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"  for="forename">Imię</label>
                                <div class="controls">
                                    <input type="text" name="forename" id="forename" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadź imię</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="surname">Nazwisko</label>
                                <div class="controls">
                                    <input type="text" name="surname" id="surname" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadź nazwisko</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="dateOfBirth">Data urodzenia</label>
                                <div class="controls">
                                    <input type="date" name="dateOfBirth" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadź datę urodzenia</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Płeć</label>
                                <select class="form-control-noborder" name="gender" id="gender">
                                    <option value="Kobieta">Kobieta</option>
                                    <option value="Mężczyzna">Mężczyzna</option>
                                </select>
                                <p class="help-block">Wybierz płeć </p>
                            </div>
                            <div class="form-group">
                                <label class="control-label"  for="pesel">PESEL</label>
                                <div class="controls">
                                    <input type="text" name="pesel" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Wprowadź numer PESEL</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12" style="text-align: center;">
                            <div class="form-group" >
                                <div class="controls">
                                    <button class="btn btn-success" id="send_button">Zapisz zmiany</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</div>

<div id="deleteUser" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Usuń użytkownika</h4>
            </div>
            <div class="modal-body">
                <p>Czy na pewno chcesz usunąć użytkownika -IMIE NAZWISKO-?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Usuń</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
            </div>
        </div>

    </div>
</div>

<div id="getPhotos" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Zdjęcia RTG pacjenta -IMIE NAZWISKO-</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-xs btn-success" style="margin-bottom:15px;">Dodaj zdjęcie</button>
                <table id="patientPhotos" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center" style="min-width: 20%;">Data przesłania</th>
                        <th class="text-center">Zdjęcie oryginalne</th>
                        <th class="text-center">Zdjęcie kolorowe</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">3 marca 2018 r.</td>
                            <td class="text-center">
                                <div class="pic-container" onmouseover ="showDeleteIcon(this);" onmouseout="hideDeleteIcon(this);">
                                    <img src="img/photos/images.jpg" class="img-thumbnail">
                                    <a class="delIcon" style="display:none"></a>
                                </div>
                            </td>
                             <td class="text-center">
                                 <div class="pic-container" onmouseover ="showDeleteIcon(this);" onmouseout="hideDeleteIcon(this);">
                                     <img src="img/photos/images_color.bmp" class="img-thumbnail">
                                     <a class="delIcon" style="display:none"></a>
                                 </div>
                             </td>
                        </tr>
                        <tr>
                            <td class="text-center">14 marca 2018 r.</td>
                            <td class="text-center">
                                <div class="pic-container" onmouseover ="showDeleteIcon(this);" onmouseout="hideDeleteIcon(this);">
                                    <img src="img/photos/images2.jpg" class="img-thumbnail">
                                    <a class="delIcon" style="display:none" href="#"></a>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success">Pokoloruj</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <script>
                $(document).ready(function() {
                    var photosTable   = $('#patientPhotos').DataTable();
                });
            </script>
        </div>

    </div>
</div>

<script>
    function showDeleteIcon(that) {
        var icon = that.getElementsByClassName('delIcon')[0];
        var img = that.getElementsByClassName('img-thumbnail')[0];
        icon.style.display = 'inline-block';
        img.style.filter = 'brightness(120%)';
    }

    function hideDeleteIcon(that){
        var icon = that.getElementsByClassName('delIcon')[0];
        var img = that.getElementsByClassName('img-thumbnail')[0];
        icon.style.display = 'none';
        img.style.filter = 'brightness(100%)';
    }
</script>
