<script>
    function getPhotos(element){
        var id = $(element).data('id');
        var imie = $(element).data('imie');
        var nazwisko = $(element).data('nazwisko');
    }
</script>

@php
    $zdjecia = DB::table('photos')->where('id_pacjenta', $id)->get();
    $ord = false;
    if(isset($ordynator))
    {
        if($ordynator)
        {
            $ord = true;
        }
    }
@endphp

<div id="getPhotos" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content col-12">
            <div class="modal-header">
                <h5 class="modal-title">Zdjęcia RTG pacjenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                    <p class="card-description">
                        Dodaj zdjęcie rentgenowskie
                    </p>
                <form class="form col-12" role="form" action='funkcje' method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="action" value="addPhoto">
                        <div class="form-group row">
                            <div class="controls col-9">
                                <input required type="file" id="image" name="image" class="file-upload-default">
                                <div class="input-group">
                                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="Zamieść zdjęcie rentgenowskie">
                                    <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-info" type="button"><i class="mdi mdi-folder-image"></i>Wybierz zdjęcie</button>
                                </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-success form-control"><i class="mdi mdi-plus-circle-outline"></i>Dodaj</button>
                            </div>
                        </div>
                </form>
                    <hr/>
            <table id="patientPhotos" class="display " cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="text-center" style="min-width: 20%;">Data przesłania</th>
                    <th class="text-center">Zdjęcie oryginalne</th>
                    <th class="text-center">Zdjęcie kolorowe</th>
                </tr>
                </thead>
                <tbody>
                @if(sizeof($zdjecia) != 0)
                    @foreach($zdjecia as $zdjecie)
                    <tr>
                        <td class="text-center">{{ $zdjecie->data }}</td>
                        <td class="text-center">
                            <div class="pic-container" onmouseover ="showDeleteIcon(this);" onmouseout="hideDeleteIcon(this);">

                            <form class="form" role="form" action='funkcje' method="POST">
                                        <input type="hidden" name="id" value="{{ $zdjecie->id }}">
                                        <input type="hidden" name="patientId" value="{{ $zdjecie->id_pacjenta }}">
                                        <input type="hidden" name="coloured" value="1">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="deletePhoto">
                                        <img src="{{ $zdjecie->directory }}" class="img-thumbnail">
                                        @if(session()->get('admin') == "true")
                                        <a class="delIcon"><i class="mdi mdi-close" style="color:red;"></i></a>
                                        <button class="delIcon"></button>
                                        @endif
                            </form>
                              
                                </div>
                            </td>
                            @if(DB::table('coloured')->where('original_id', $zdjecie->id)->first() != "")
                                <td class="text-center">
                                    <div class="pic-container" onmouseover="showDeleteIcon(this);" onmouseout="hideDeleteIcon(this);">
                                        <form class="form" role="form" action='funkcje' method="POST">
                                            <input type="hidden" name="id" value="{{ DB::table('coloured')->where('original_id', $zdjecie->id)->first()->id }}">
                                            <input type="hidden" name="patientId" value="{{ $zdjecie->id_pacjenta }}">
                                            <input type="hidden" name="coloured" value="0">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="action" value="deletePhoto">
                                            <img src="{{ DB::table('coloured')->where('original_id', $zdjecie->id)->first()->directory }}" class="img-thumbnail">
                                            <a class="delIcon"><i class="mdi mdi-close" style="color:red;"></i></a>
                                            <button class="delIcon"></button>
                                        </form>
                                         
                                    </div>
                                </td>
                            @else
                                <td class="text-center">
                                    <form class="form" role="form" action='funkcje' method="POST">
                                            <input type="hidden" name="id" value="{{ $zdjecie->id }}">
                                            <input type="hidden" name="patientId" value="{{ $zdjecie->id_pacjenta }}">
                                            <input type="hidden" name="coloured" value="{{ $zdjecie->oryginal }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="action" value="colorPhoto">
                                            
                                            <button @if($ord) disabled @endif type="submit" class="btn btn-light"><i class="mdi mdi-format-color-fill"></i>Pokoloruj</button>
                                            
                                    </form>
                                    
                                </td>
                                
                            @endif
                             
                        </tr>
                        @endforeach
                        
                        @endif
                    </tbody>
                </table>
            </div>
            <script>
                $(document).ready(function() {
                    var photosTable   = $('#patientPhotos').DataTable( {
                                                "iDisplayLength": 4,
                                                "bLengthChange": false,
                                                "language": {
                                                    "decimal":        "",
                                                    "emptyTable":     "Brak zdjęć do wyświetlenia.",
                                                    "info":           "Strona _PAGE_ z _PAGES_",
                                                    "infoEmpty":      "Brak zdjęć do wyświetlenia.",
                                                    "infoFiltered":   "(odfiltrowane z _MAX_ wyników)",
                                                    "infoPostFix":    "",
                                                    "thousands":      ",",
                                                    "lengthMenu":     "Ilość zdjęć na stronie   _MENU_",
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
        </div>

    </div>
</div>

<script src="{{ URL::to('js/file-upload.js')}}"></script>
<script>
    function showDeleteIcon(that) {
        var icon = that.getElementsByClassName('delIcon')[0];
        var img = that.getElementsByClassName('img-thumbnail')[0];
        icon.style.opacity = '1';
        img.style.filter = 'brightness(120%)';
    }

    function hideDeleteIcon(that){
        var icon = that.getElementsByClassName('delIcon')[0];
        var img = that.getElementsByClassName('img-thumbnail')[0];
        icon.style.opacity = '0';
        img.style.filter = 'brightness(100%)';
    }
</script>