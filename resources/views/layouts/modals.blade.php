
    <!-- Funkcje do obsługi Modali-->
    <script>

    function setPatient(element) {
        var id = $(element).data('id');
        var imie = $(element).data('imie');
        var nazwisko = $(element).data('nazwisko');
        var plec = $(element).data('plec');
        var dataUrodzenia = $(element).data('data');
        var pesel = $(element).data('pesel');
        var token = $(element).data('token');
        $("#editPatient [name='id']").first().val( id );
        $("#editPatient [name='forename']").first().val( imie );
        $("#editPatient [name='surname']").first().val( nazwisko );
        $("#editPatient [name='gender']").first().val( plec );
        $("#editPatient [name='dateOfBirth']").first().val( dataUrodzenia );
        $("#editPatient [name='pesel']").first().val( pesel );
        $("#editPatient [name='_token']").first().val( token );
    }

    function setUser(element) {
        var id = $(element).data('id');
        var imie = $(element).data('imie');
        var nazwisko = $(element).data('nazwisko');
        var dataUrodzenia = $(element).data('data');
        var pesel = $(element).data('pesel');
        var login = $(element).data('login');
        var token = $(element).data('token');
        var funkcja = $(element).data('funkcja');
        $("#editUser [name='id']").first().val( id );
        $("#editUser [name='forename']").first().val( imie );
        $("#editUser [name='surname']").first().val( nazwisko );
        $("#editUser [name='dateOfBirth']").first().val( dataUrodzenia );
        $("#editUser [name='pesel']").first().val( pesel );
        $("#editUser [name='login']").first().val( login );
        $("#editUser [name='_token']").first().val( token );
        $("#editUser [name='funkcja']").first().val( funkcja );
    }

    function setDeleteUser(element){
        var id    = $(element).data('id');
        var token = $(element).data('token');
        var funkcja = $(element).data('funkcja');
        $("#deleteUser [name='id']").first().val(id);
        $("#deleteUser [name='_token']").first().val(token);
        $("#deleteUser [name='funkcja']").first().val(funkcja);
    }



    </script>   


<div id="editUser" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edytuj użytkownika</h4>
            </div>
            <div class="modal-body">
                <form class="form" role="form" action='funkcje' method="POST">
                    <fieldset>
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" name="action" value="editUser">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="funkcja">Funkcja</label>
                                <select class="form-control-noborder" name="funkcja" id="funkcja">
                                  <option value="lekarz">Lekarz</option>
                                  <option value="ordynator">Ordynator</option>
                                </select>
                                <p class="help-block">Wybierz jaką funkcję ma spełniać użytkownik</p>
                            </div>
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
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="control-label" for="pesel">PESEL</label>
                                <div class="controls">
                                    <input type="text" name="pesel" placeholder="" id="pesel" class="form-control-noborder">
                                    <p class="help-block">Wprowadź numer PESEL</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="username">Login</label>
                                <div class="controls">
                                    <input type="text" name="login" placeholder="" class="form-control-noborder" id="login">
                                    <p class="help-block">Wprowadź login (bez spacji)</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="password">Hasło</label>
                                <div class="controls">
                                    <input type="password" id="password" name="password" placeholder="" class="form-control-noborder">
                                    <p class="help-block">Nowe hasło powinno się składać z co najmniej 5 znaków</p>
                                </div>
                            </div>
                        </div>
                    
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="send_button">Zapisz zmiany</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
            </div>
            </fieldset>
          </form>
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
                <form class="form" role="form" action='funkcje' method="POST">
                    <fieldset>
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" name="action" value="editPatient">
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
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Usuń użytkownika</h4>
            </div>
            <div class="modal-body">
                <p>Czy na pewno chcesz usunąć użytkownika?</p>
            </div>
            <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                        <fieldset>
                        <form action="funkcje" method="post">
                            <input type="hidden" name="_token" value="">
                            <input type="hidden" name="id" value=""/>
                            <input type="hidden" name="funkcja" value=""/>
                            <input type="hidden" name="action" value="delete"/>
                            <button type="submit" class="btn btn-danger btn-ok btn-sm">Usuń</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Anuluj</button>
                        </form>
                    </fieldset>
                    </div>
            </div>
        </div>

    </div>
</div>



