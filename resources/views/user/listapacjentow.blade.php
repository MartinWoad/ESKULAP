@extends('layouts.dashboard')

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
        $id = session()->get('user');
        $pacjenci;
        $ordynator = false;
        if(DB::table('users')->where('id', $id)->first()->funkcja == "ordynator")
        {
            $pacjenci = DB::table('patients')->get();
            $ordynator = true;
        } else {
            $pacjenci = DB::table('patients')->where('id_lekarza', $id)->get();
        }
     ?>       
        <div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pacjenci
                </div>
                <div class="panel-body">
                    @if(sizeof($pacjenci) != 0)
                    <table id="patients" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>PESEL</th>
                                <th>Płeć</th>
                                <th>Data urodzenia</th>
                                <th>Zdjęcia</th>
                                @if($ordynator == true)
                                    <th>Lekarz</th>
                                @endif
                                <th>Edycja</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($pacjenci as $pacjent)
                                <tr>
                                    <td class="text-center">{{  $pacjent->imie }}</td>
                                    <td class="text-center">{{  $pacjent->nazwisko }}</td>
                                    <td class="text-center">{{  $pacjent->pesel }}</td>
                                    <td class="text-center">{{  $pacjent->plec }}</td>
                                    <td class="text-center">{{  $pacjent->data_ur }}</td>
                                    <td class="text-center">Zdjęcie</td>
                                    @if($ordynator == true)
                                     <td class="text-center">{{  DB::table('users')->where('id', $pacjent->id_lekarza)->first()->imie }} {{  DB::table('users')->where('id', $pacjent->id_lekarza)->first()->nazwisko }}</td>
                                    @endif
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
        var patientsTable   = $('#patients').DataTable();
    });
    </script>
@endsection