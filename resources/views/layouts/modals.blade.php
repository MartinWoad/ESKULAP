
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edytuj dane pracownika</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" role="form" action='funkcje' method="POST">
                    <fieldset>
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" name="action" value="editUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="funkcja">Funkcja</label>
                                    <select class="form-control" name="funkcja" id="funkcja">
                                      <option value="lekarz">Lekarz</option>
                                      <option value="ordynator">Ordynator</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="forename">Imię</label>
                                    <div class="controls">
                                        <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="forename" id="forename" placeholder="" maxlength="16" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="surname">Nazwisko</label>
                                    <div class="controls">
                                        <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="surname" id="surname" placeholder="" maxlength="16" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="dateOfBirth">Data urodzenia</label>
                                    <div class="controls">
                                        <input required type="date" min="1910-01-01" max="{{ date('Y-m-d') }}" name="dateOfBirth" placeholder="" class="form-control" id="dateOfBirth">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="pesel">PESEL</label>
                                    <div class="controls">
                                        <input required pattern="[0-9]+" type="text" name="pesel" placeholder="" id="pesel" minlength="11" title="Proszę wprowadzić poprawny numer PESEL" maxlength="11" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="username">Login</label>
                                    <div class="controls">
                                        <input required type="text" id="login" pattern="[A-Za-z0-9]+" minlength="5" maxlength="16" name="username" placeholder="" class="form-control" id="login">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="password">Hasło</label>
                                    <div class="controls">
                                        <input required  type="password" minlength="5" maxlength="16" id="password" name="password" placeholder="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 text-center">
                            <div class="form-group">
                                <div class="controls">
                                    <button class="btn btn-success" id="send_button"><i class="mdi mdi-content-save"></i>Zapisz zmiany</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="mdi mdi-close"></i>Anuluj</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>



@php
    $lekarze = DB::table('users')->where('funkcja', "lekarz")->get();
@endphp
<div id="editPatient" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edytuj dane pacjenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" role="form" action='funkcje' method="POST">
                    <fieldset>
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" name="action" value="editPatient">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label"  for="forename">Imię</label>
                                    <div class="controls">
                                        <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="forename" id="forename" placeholder="" maxlength="16" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="surname">Nazwisko</label>
                                    <div class="controls">
                                        <input required pattern="[A-Za-ząćęłńóśźż]+" minlength="3" type="text" name="surname" id="surname" placeholder="" maxlength="16" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="dateOfBirth">Data urodzenia</label>
                                    <div class="controls">
                                        <input required type="date" min="1910-01-01" max="{{ date('Y-m-d') }}" name="dateOfBirth" placeholder="" class="form-control" id="dateOfBirth">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Płeć</label>
                                    <select required class="form-control" name="gender" id="gender">
                                        <option value="Kobieta">Kobieta</option>
                                        <option value="Mężczyzna">Mężczyzna</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"  for="pesel">PESEL</label>
                                    <div class="controls">
                                        <input required pattern="[0-9]+" type="text" name="pesel" placeholder="" id="pesel" minlength="11" title="Proszę wprowadzić poprawny numer PESEL" maxlength="11" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label" for="patientsDoctor">Lekarz</label>
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
                        </div>
                        <div class="col-xs-12 text-center">
                            <div class="form-group" >
                                <div class="controls">
                                    <button class="btn btn-success" id="send_button"><i class="mdi mdi-content-save"></i>Zapisz zmiany</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="mdi mdi-close"></i>Anuluj</button>
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
                <h5 class="modal-title">Usuń użytkownika</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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



