@extends('layouts.admin')
@section('title')
Zarządzanie
@endsection

@section('head')

    <link rel="stylesheet" href="{{ URL::to("css/jquery.dataTables.min.css") }}">
    
    <!-- DataTables Plugin  -->
    <script type="text/javascript" src="{{ URL::to("js/jquery.dataTables.min.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("js/sum().js") }}"></script>
    
    @include('layouts.modals')

@endsection
@section('content')
    @php
        $pacjenci = DB::table('patients')->get();
    @endphp
    @if (session()->get('photoModal'))
        @include('layouts.photoModal', array('id' => session()->get('photoModal')))

        <script>
            $('#getPhotos').modal('show');
        </script>
        @php
            session()->forget('message');
            session()->forget('error');
        @endphp
     @endif
    @if (session()->get('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Ups!</strong> {{ session()->get('error') }}
        </div>
    @endif
    @if (session()->get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Sukces!</strong> {{ session()->get('success') }}
        </div>
    @endif
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista pacjentów</h4>
                @if(sizeof($pacjenci) != 0)
                <table id="patients" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Imię</th>
                            <th class="text-center">Nazwisko</th>
                            <th class="text-center">PESEL</th>
                            <th class="text-center">Płeć</th>
                            <th class="text-center">Data urodzenia</th>
                            <th class="text-center">Zdjęcia</th>
                            <th class="text-center">Lekarz</th>
                            <th class="text-center">Edycja</th>
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
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-image"></i>RTG</button>
                                    </form>
                                </td>
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
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" data-token="{{ csrf_token() }}" data-id="{{ $pacjent->id }}" data-imie="{{ $pacjent->imie }}" data-nazwisko="{{ $pacjent->nazwisko }}" data-data="{{ $pacjent->data_ur }}" data-pesel="{{ $pacjent->pesel }}" class="btn btn-info" data-plec="{{ $pacjent->plec }}" data-toggle="modal" onclick="setPatient(this);"  data-target="#editPatient"><i class="mdi mdi-account-edit"></i>Edytuj</button>
                                        <button name="delete" data-funkcja="patient" data-token="{{ csrf_token() }}" data-id="{{ $pacjent->id }}" class="btn btn-danger" onclick="setDeleteUser(this);" data-toggle="modal" data-target="#deleteUser"><i class="mdi mdi-delete"></i>Usuń z bazy</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    {{ "Brak pacjentów do wyświetlenia." }}
                @endif
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        var patientsTable   = $('#patients').DataTable( {
            "language": {
                "decimal":        "",
                "emptyTable":     "Brak danych w tabeli",
                "info":           "Strona _PAGE_ z _PAGES_",
                "infoEmpty":      "Brak pacjentów do wyświetlenia.",
                "infoFiltered":   "(odfiltrowane z _MAX_ wyników)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Ilość pacjentów na stronie   _MENU_",
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