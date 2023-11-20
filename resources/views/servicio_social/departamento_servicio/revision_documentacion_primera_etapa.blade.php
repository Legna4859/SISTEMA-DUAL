@extends('layouts.app')
@section('title', 'Servicio Social')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Revisión de Documentación Primera Etapa</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">



                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#uno" aria-controls="home" role="tab" data-toggle="tab">Autorizar Documentación</a></li>
                    <li role="presentation"><a href="#dos" aria-controls="dos" role="tab" data-toggle="tab">En proceso de Modificación</a></li>
                  <li role="presentation"><a href="#tres" aria-controls="dos" role="tab" data-toggle="tab">Estudiantes con Documentación Autorizada</a></li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-9 col-md-offset-1">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="autorizar_servicio">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>CARRERA</th>
                                    <th>TIPO DE EMPRESA</th>
                                    <th>FECHA DE REGISTRO</th>
                                    <th>AUTORIZAR</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($autorizaciones as $autorizaciones)
                                    <tr>
                                        <th>{{$autorizaciones->cuenta}}</th>
                                        <td>{{$autorizaciones->nombre}} {{$autorizaciones->apaterno}} {{$autorizaciones->amaterno}}</td>
                                        <td>{{$autorizaciones->correo_electronico}}</td>
                                        <td>{{$autorizaciones->carrera}}</td>
                                        <td>{{$autorizaciones->tipo_empresa}}</td>
                                        <td>{{$autorizaciones->fecha_registro}}</td>
                                        @if($autorizaciones->id_estado_enviado ==1)
                                        <td><button  id="{{ $autorizaciones->id_datos_alumnos }}" class="btn btn-primary btn-lg autorizacion_docuemntos"><i class="glyphicon glyphicon-edit em56"></i></button></td>
                                    @else
                                            <td><button  id="{{ $autorizaciones->id_datos_alumnos }}" class="btn btn-primary btn-lg autorizacion_documentos_modificaciones"><i class="glyphicon glyphicon-edit em56"></i></button></td>

                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="dos">
                        <div class=" col-md-9 col-md-offset-1">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="modificar_servicio">
                                <thead>
                                <tr>
                                    <th>NO. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>CARRERA</th>
                                    <th>TIPO DE EMPRESA</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($modificaciones as $modificaciones)
                                    <tr>
                                        <th>{{$modificaciones->cuenta}}</th>
                                        <td>{{$modificaciones->nombre}} {{$modificaciones->apaterno}} {{$modificaciones->amaterno}}</td>
                                        <td>{{$modificaciones->correo_electronico}}</td>
                                        <td>{{$modificaciones->carrera}}</td>
                                        <td>{{$modificaciones->tipo_empresa}}</td>
                                      </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tres">
                        <div class=" col-md-9 col-md-offset-1">

                            </br></br></br>

                            <table class="table table-bordered " Style="background: white;" id="documentacion_autorizada">
                                <thead>
                                <tr>
                                    <th>NO. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>CARRERA</th>
                                    <th>TIPO DE EMPRESA</th>
                                    <th>FECHA REGISTRO</th>
                                    <th>VER DOCUMENTACIÓN</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($autorizados as $autorizados)
                                    <tr>
                                        <th>{{$autorizados->cuenta}}</th>
                                        <td>{{$autorizados->nombre}} {{$autorizados->apaterno}} {{$autorizados->amaterno}}</td>
                                        <td>{{$autorizados->correo_electronico}}</td>
                                        <td>{{$autorizados->carrera}}</td>
                                        <td>{{$autorizados->tipo_empresa}}</td>
                                        <td>{{$autorizados->fecha_registro}}</td>
                                        <td><button  id="{{ $autorizados->id_datos_alumnos }}" class="btn btn-primary btn-lg documentacion_autorizada">Mostrar</button></td>

                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        {{--autorizar documentos--}}
        <div class="modal fade" id="modal_autorizar_documentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Autorización de Documentación Primera Etapa</h4>
                        </div>
                        <div id="contenedor_autorizar_docuementos">


                        </div>

                </div>

            </div>
        </div>
        {{--fin autorizar--}}

        {{--autorizar documentos con modificaciones--}}
        <div class="modal fade" id="modal_autorizar_documentos_modificaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Autorización de Documentación Primera Etapa</h4>
                    </div>
                    <div id="contenedor_autorizar_docuementos_modificaciones">


                    </div>


                </div>

            </div>
        </div>
        {{--fin autorizar--}}
        {{--autorizado documentos --}}
        <div class="modal fade" id="modal_autorizado_documentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Documentación Primera Etapa</h4>
                    </div>
                    <div id="contenedor_autorizar_documentos">


                    </div>


                </div>

            </div>
        </div>
        {{--fin autorizar--}}

    </main>
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
            $('#autorizar_servicio').DataTable(  );
            $('#modificar_servicio').DataTable(  );
            $('#documentacion_autorizada').DataTable(  );
        });
        $("#autorizar_servicio").on('click','.autorizacion_docuemntos',function(){
            var id_datos_alumnos=$(this).attr('id');
            $.get("/servicio_social/autorizacion_documentacion/"+id_datos_alumnos,function(request){
                $("#contenedor_autorizar_docuementos").html(request);
                $("#modal_autorizar_documentos").modal('show');
            });

        });
        $("#autorizar_servicio").on('click','.autorizacion_documentos_modificaciones',function(){
            var id_datos_alumnos=$(this).attr('id');
            $.get("/servicio_social/autorizacion_documentacion_modifcaciones/"+id_datos_alumnos,function(request){
                $("#contenedor_autorizar_docuementos_modificaciones").html(request);
                $("#modal_autorizar_documentos_modificaciones").modal('show');
            });
        });
        $("#documentacion_autorizada").on('click','.documentacion_autorizada',function(){
            var id_datos_alumnos=$(this).attr('id');
            $.get("/servicio_social/autorizada_documentacion_serv/"+id_datos_alumnos,function(request){
                $("#contenedor_autorizar_documentos").html(request);
                $("#modal_autorizado_documentos").modal('show');
            });
        })

    </script>
@endsection