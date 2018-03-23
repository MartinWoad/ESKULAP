@extends('layouts.dashboard')

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
   
     @if (session()->get('photoModal'))
        @include('layouts.photoModal', array('id' => session()->get('photoModal')))

        <script>
            $('#getPhotos').modal('show'); 
        </script>
     @endif
        <div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pacjenci
                </div>
                <div class="panel-body">
                    @if (session()->get('message'))
                      <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Sukces!</strong> {{ session()->get('message') }}
                      </div>
                    @endif
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
                                    <td class="text-center">
                                        <form class="form" role="form" action='getPhotos' method="POST">
                                            <input type="hidden" name="id" value="{{ $pacjent->id }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-info">RTG</button>
                                        </form>
                                    </td>
                                    @if($ordynator == true)
                                     <td class="text-center">
                                        @php
                                        if(DB::table('users')->where('id', $pacjent->id_lekarza)->first() == "")
                                        {
                                            echo "Lekarz nie istnieje."; 
                                        } else {
                                            echo DB::table('users')->where('id', $pacjent->id_lekarza)->first()->imie." ";
                                            echo  DB::table('users')->where('id', $pacjent->id_lekarza)->first()->nazwisko;
                                        }
                                        @endphp
                                     </td>
                                    @endif
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <button type="button" data-token="{{ csrf_token() }}" data-id="{{ $pacjent->id }}" data-imie="{{ $pacjent->imie }}" data-nazwisko="{{ $pacjent->nazwisko }}" data-data="{{ $pacjent->data_ur }}" data-pesel="{{ $pacjent->pesel }}" class="btn btn-warning" data-plec="{{ $pacjent->plec }}" data-toggle="modal" onclick="setPatient(this);"  data-target="#editPatient"  @if($ordynator==true) disabled @endif></th>
                                            Edytuj</button>
                                            <button name="delete" data-funkcja="patient" data-token="{{ csrf_token() }}" data-id="{{ $pacjent->id }}" class="btn btn-danger" onclick="setDeleteUser(this);" data-toggle="modal" data-target="#deleteUser">Usuń z bazy</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                    @else
                        {{ "Brak pacjentów przypisanych do lekarza." }}
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