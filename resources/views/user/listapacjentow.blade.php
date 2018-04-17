@extends('layouts.dashboard')

@section('title')
Zarządzanie
@endsection

@section('head')

    <link rel="stylesheet" href="{{ URL::to("css/dataTables.bootstrap4.css") }}">
    <link rel="stylesheet" href="{{ URL::to("modules/lightbox/dist/css/lightbox.min.css") }}">
    <!-- DataTables Plugin  -->
    <script type="text/javascript" src="{{ URL::to("js/jquery.dataTables.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("js/dataTables.bootstrap4.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("js/data-table.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("js/sum().js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("modules/lightbox/dist/js/lightbox.min.js") }}"></script>

    @include('layouts.modals')
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
        @php
            session()->forget('message');
            session()->forget('error');
        @endphp
    @endif




    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                @if (session()->get('message'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Sukces!</strong> {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->get('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Ups!</strong> {{ session()->get('error') }}
                    </div>
                @endif
                <h4 class="card-title">Lista pacjentów</h4>
                @if(sizeof($pacjenci) != 0)
                    <table id="patients" class="table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">Imię</th>
                            <th class="text-center">Nazwisko</th>
                            <th class="text-center">PESEL</th>
                            <th class="text-center">Płeć</th>
                            <th class="text-center">Data urodzenia</th>
                            <th class="text-center">Zdjęcia</th>
                            @if($ordynator == true)
                                <th>Lekarz</th>
                            @endif
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
                                        <div class="btn-group">
                                            <button type="button" data-token="{{ csrf_token() }}" data-id="{{ $pacjent->id }}" data-imie="{{ $pacjent->imie }}" data-nazwisko="{{ $pacjent->nazwisko }}" data-data="{{ $pacjent->data_ur }}" data-pesel="{{ $pacjent->pesel }}" class="btn btn-info" data-plec="{{ $pacjent->plec }}" data-toggle="modal" onclick="setPatient(this);"  data-target="#editPatient"  @if($ordynator==true) disabled @endif><i class="mdi mdi-account-edit"></i>Edytuj</button>
                                            <button name="delete" data-funkcja="patient" data-token="{{ csrf_token() }}" data-id="{{ $pacjent->id }}" class="btn btn-danger" onclick="setDeleteUser(this);" data-toggle="modal" data-target="#deleteUser"><i class="mdi mdi-delete"></i>Usuń z bazy</button>
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