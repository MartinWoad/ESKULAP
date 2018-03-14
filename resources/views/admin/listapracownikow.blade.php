@extends('layouts.admin')

@section('title')
Zarządzanie
@endsection

@section('head')
    <link rel="stylesheet" href="{{ URL::to("css/jquery.dataTables.min.css") }}">

    <!-- DataTables Plugin  -->
    <script type="text/javascript" src="{{ URL::to("js/jquery.dataTables.min.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("js/sum().js") }}"></script>
@endsection

@section('content')
    <?php
        $pracownicy = DB::table('users')->where('funkcja', "not like", "admin")->get();
     ?>       
        <div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pacjenci
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
                                    <input name="delete" onclick="addItem(this);" class="btn btn-xs btn-danger" type="button" value="Usuń z bazy" />
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