@extends('layouts.admin')
@section('title')
Zarządzanie
@endsection

@section('head')
    <link rel="stylesheet" href="{{ URL::to("css/jquery.dataTables.min.css") }}">

    <!-- DataTables Plugin  -->
    <script type="text/javascript" src="{{ URL::to("js/jquery.dataTables.min.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("js/sum().js") }}"></script>
    <?php
        require_once('..\resources\views\layouts\modals.blade.php');
    ?>
@endsection

@section('content')
    <?php
        $pracownicy = DB::table('users')->where('funkcja', "not like", "admin")->get();
     ?>       
        <div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pracownicy
                </div>
                <div class="panel-body">
                    @if (session()->get('message'))
                      <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Sukces!</strong> {{ session()->get('message') }}
                      </div>
                    @endif
                    @if (session()->get('error'))
                      <div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Ups!</strong> {{ session()->get('error') }}
                      </div>
                    @endif
                    @if(sizeof($pracownicy) != 0)
                    <table id="workers" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>PESEL</th>
                                <th>Data urodzenia</th>
                                <th>Funkcja</th>
                                <th>Edycja</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($pracownicy as $pracownik)
                                <tr>
                                    <td class="text-center">{{  $pracownik->imie }}</td>
                                    <td class="text-center">{{  $pracownik->nazwisko }}</td>
                                    <td class="text-center">{{  $pracownik->pesel }}</td>
                                    <td class="text-center">{{  $pracownik->data_ur }}</td>
                                    <td class="text-center">{{  $pracownik->funkcja }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <button type="button" data-token="{{ csrf_token() }}" data-funkcja="{{ $pracownik->funkcja }}" data-id="{{ $pracownik->id }}" data-imie="{{ $pracownik->imie }}" data-nazwisko="{{ $pracownik->nazwisko }}" data-data="{{ $pracownik->data_ur }}" data-pesel="{{ $pracownik->pesel }}" data-login="{{ $pracownik->login }}" class="btn btn-warning" data-toggle="modal" onclick="setUser(this);"  data-target="#editUser">Edytuj</button>
                                            <button name="delete" data-funkcja="{{ $pracownik->funkcja }}" data-token="{{ csrf_token() }}" data-id="{{ $pracownik->id }}" class="btn btn-danger" onclick="setDeleteUser(this);" data-toggle="modal" data-target="#deleteUser">Usuń z bazy</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                    @else
                        {{ "Brak pracowników do wyświetlenia." }}
                    @endif
                </div>
            </div>
        </div>

    <script>
    $(document).ready(function() {
        var workersTable   = $('#workers').DataTable( {
                                                "language": {
                                                    "decimal":        "",
                                                    "emptyTable":     "Brak danych w tabeli",
                                                    "info":           "Strona _PAGE_ z _PAGES_",
                                                    "infoEmpty":      "Brak pracowników do wyświetlenia.",
                                                    "infoFiltered":   "(odfiltrowane z _MAX_ wyników)",
                                                    "infoPostFix":    "",
                                                    "thousands":      ",",
                                                    "lengthMenu":     "Ilość pracowników na stronie   _MENU_",
                                                    "loadingRecords": "Ładuję...",
                                                    "processing":     "Przetwarzanie...",
                                                    "search":         "Wyszukaj:",
                                                    "zeroRecords":    "Brak wyników odpowiadających Twoim kryteriom",
                                                    "paginate": {
                                                        "first":      "Pierwsza",
                                                        "last":       "Ostatnia",
                                                        "next":       "Następna",
                                                        "previous":   "Poprzednia"
                                                    },
                                                    "aria": {
                                                        "sortAscending":  ": posortuj tabelę rosnąco",
                                                        "sortDescending": ": posortuj tabelę malejąco"
                                                    }
                                                }
                                            } );
    });
    </script>



@endsection