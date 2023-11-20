@extends('layouts.app')
@section('title', 'Status de los Anteproyectos de los Alumnos')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Status de los Anteproyectos de los Alumnos del Periodo {{ $nombre_periodo }}</h3>
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
                <li class="active"><a href="#">Anteproyectos Autorizados por los Revisores</a></li>
                <li>
                    <a href="{{ url('/residencia/proceso_mod_anteproyecto/'.$id_carrera ) }}" >En proceso de Modificación</a>
                </li>
                <li>
                    <a href="{{ url('/residencia/proceso_revision_anteproyecto/'.$id_carrera ) }}" >En Proceso de Revisión</a>
                </li>




            </ul>
            <p>
                <br>
            </p>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">

                        <table id="table_autorizar_doc_final" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Nombre del anteproyecto</th>
                                <th>Imprimir documento</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($array_anteproyecto as $anteproyecto)

                                <tr>
                                    <td>{{$anteproyecto['cuenta']}}</td>
                                    <td>{{$anteproyecto['nombre']}}</td>
                                    <td>{{ $anteproyecto['nom_proyecto']}}</td>

                                    @if($anteproyecto['estado_empresa']== 2)
                                        <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/pdf_documento_presentacion_residencia/'.$anteproyecto['id_anteproyecto'])}}')">Imprimir</button></td>
                                    @elseif($anteproyecto['estado_empresa']== 1)
                                        <td>
                                            No se le ha asignado asesor interno
                                        </td>

                                    @elseif($anteproyecto['estado_empresa']== 0)
                                        <td>
                                           No ha registrado el alumno su empresa
                                        </td>
                                    @endif

                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fullscreen-modal fade" id="autorizar_doc_finales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Autorización de documentación</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_doc_finales">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fullscreen-modal fade" id="autorizar_doc_finales_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Autorización de documentación modificada</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_doc_finales_mod">
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
            $('#table_autorizar_doc_final').DataTable( );
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/residencia/ver_estados_alumnos/'+id_carrera ;
            });
            $("#table_autorizar_doc_final").on('click','.autorizar_documentos',function(){
                var id_liberacion_documentos=$(this).attr('id');
                $.get("/residencia/alumno_liberacion_final/doc/"+id_liberacion_documentos,function (request) {
                    $("#contenedor_doc_finales").html(request);
                    $("#autorizar_doc_finales").modal('show');
                });

            });

        });
    </script>
@endsection