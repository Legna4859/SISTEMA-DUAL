@extends('layouts.app')
@section('title', 'Anteproyectos autorizados')
@section('content')

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Anteproyectos  Autorizados por Carrera del Periodo {{ $nombre_periodo }}</h3>
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
    @endif
    @if($mostrar == 1)
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
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">

                        <table id="table_enviado" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Nombre del proyecto</th>
                                <th>Ver documentación</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($anteproyectos as $anteproyecto)

                                <tr>
                                    <td>{{$anteproyecto->cuenta}}</td>
                                    <td>{{$anteproyecto->alumno}} {{$anteproyecto->apaterno}}  {{$anteproyecto->amaterno}}</td>
                                    <td>{{$anteproyecto->nom_proyecto}}</td>
                                    <td>
                                        <button class="btn btn-primary ver_doc_alta" id="{{ $anteproyecto->id_anteproyecto }}">Ver</button>
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

    <div class="modal fade" id="modal_autorizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar anteproyecto</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_autorizar">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fullscreen-modal fade" id="modal_doc_alta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Documentación Autorizada  de Alta de Residencia Profesional</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_doc_alta">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( );
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
                window.location.href='/residencia/anteproyectos_autorizados_carrera/'+carrera ;
            });
            $("#table_enviado").on('click','.ver_doc_alta',function(){
                var id_anteproyecto=$(this).attr('id');

                $.get("/residencia/ver_doc_aceptada_alta/"+id_anteproyecto,function (request) {
                    $("#contenedor_doc_alta").html(request);
                    $("#modal_doc_alta").modal('show');
                });
            });
        });
    </script>
@endsection