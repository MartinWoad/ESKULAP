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
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editUser">Edytuj</button>
                                            <button name="delete" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser">Usuń z bazy</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                    @else
                        {{ "Brak pacjentów przypisanych do lekarza" }}
                    @endif
                </div>
            </div>
        </div>

    <script>
    $(document).ready(function() {
        var workersTable   = $('#workers').DataTable();
    });
    </script>



@endsection