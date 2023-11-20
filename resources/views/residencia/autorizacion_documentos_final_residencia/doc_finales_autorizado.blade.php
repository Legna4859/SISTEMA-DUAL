@extends('layouts.app')
@section('title', 'Autorizar Documentos de Liberación de Residencia')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Documentos de Liberación de Residencia Autorizados por Carreras del Periodo {{ $nombre_periodo }}</h3>
                </div>
            </div>
        </div>
    </div>
    @if($mostrar == 0)
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($carreras as $carrera)
                            <option value="{{$carrera->id_carrera}}" data-esta="{{$carrera->nombre}}">{{$carrera->nombre}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <br>
        </div>
    @elseif($mostrar == 1)
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($carreras as $carrera)
                            @if($carrera->id_carrera==$id_carrera)
                                <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                            @else
                                <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <br>
        </div>
        <div class="row col-md-11 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li>
                    <a href="{{ url('/residencia/revision_doc_finales/'.$id_carrera ) }}" >Autorizar Documentación</a>
                </li>
                <li>
                    <a href="{{ url('/residencia/proceso_mod_doc_finales/'.$id_carrera ) }}" >En proceso de Modificación</a>
                </li>
                <li class="active"><a href="#">Documentación Autorizada</a></li>





            </ul>
            <p>
                <br>
            </p>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">

                        <table id="table_doc_autorizados" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Ver documentación</th>



                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($alumnos as $alumno)

                                <tr>
                                    <td>{{$alumno->cuenta}}</td>
                                    <td>{{ $alumno->alumno }} {{$alumno->apaterno}}  {{$alumno->amaterno}}</td>
                                    <td>
                                        <button class="btn btn-primary ver_documentos" id="{{ $alumno->id_liberacion_documentos }}">Ver documentación</button>
                                    </td>


                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fullscreen-modal fade" id="doc_autorizados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Documentación Autorizada</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_doc_autorizados">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>
        /*
Full screen Modal
*/
        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }
        @media (min-width: 768px) {
            .fullscreen-modal .modal-dialog {
                width: 768px;
            }
        }
        @media (min-width: 992px) {
            .fullscreen-modal .modal-dialog {
                width: 999px;
            }
        }
        @media (min-width: 1200px) {
            .fullscreen-modal .modal-dialog {
                width: 1200px;
            }
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_doc_autorizados').DataTable( );
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/residencia/proceso_mod_doc_finales/'+id_carrera ;
            });
            $("#table_doc_autorizados").on('click','.ver_documentos',function(){
                var id_liberacion_documentos=$(this).attr('id');
                $.get("/residencia/ver_doc_finales_aut/doc/"+id_liberacion_documentos,function (request) {
                    $("#contenedor_doc_autorizados").html(request);
                    $("#doc_autorizados").modal('show');
                });

            });
        });
    </script>
@endsection