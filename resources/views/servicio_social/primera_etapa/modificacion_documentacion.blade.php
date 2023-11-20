@extends('layouts.app')
@section('title', 'Servicio social')
@section('content')

    <main class="col-md-12">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Documentos de la primera etapa del Servicio Social</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-body" style="text-align: center">
                            <p><b>No. Cuenta: </b> {{$registro_tipo_empresa[0]->cuenta}}  <b>      Nombre del alumno:</b> {{$registro_tipo_empresa[0]->nombre}} {{$registro_tipo_empresa[0]->apaterno}} {{$registro_tipo_empresa[0]->amaterno}}</p>
                            <p><b>Correo electronico:</b> {{$registro_tipo_empresa[0]->correo_electronico}}  <b>     Tipo de empresa:</b> {{$registro_tipo_empresa[0]->tipo_empresa}}</p>

                        </div>
                    </div>

                </div>
            </div>
        @if($registro_tipo_empresa[0]->id_estado_enviado == 2)
            @if($registro_tipo_empresa[0]->id_tipo_empresa == 1)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-body" style="text-align: center">
                            <p style="color: #FF0000">Hacer las correcciones que se te indican en los comentarios de los documentos rechazados</p>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Nombre del documento</th>
                                    <th>Estado</th>
                                    <th>Comentario</th>
                                    <th>Ver PDF</th>
                                    <th>Modificar</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> Carta de aceptación (solo empresa privada)</td>
                                    @if($datos_empresa[0]->est_carta_aceptacion == 1)
                                    <td style="color: #FF0000;">Rechazado</td>
                                    <td>{{$datos_empresa[0]->coment_carta_aceptacion}}</td>
                                        <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_carta_aceptacion)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                        <td>
                                            <button   id="id_modificar_carta_aceptacion"  class="btn btn-primary" >Modificar</button>

                                        </td>
                                        @else
                                        <td>Aprobado</td>
                                        <td>No cambiar este documento</td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>  Anexo Tecnico (solo empresa privada)</td>
                                    @if($datos_empresa[0]->est_anexo_tecnico == 1)
                                        <td style="color: #FF0000;">Rechazado</td>
                                        <td>{{$datos_empresa[0]->coment_anexo_tecnico }}</td>
                                        <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_anexo_tecnico)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                        <td>
                                            <button   id="id_modificar_anexo_tecnico"  class="btn btn-primary" >Modificar</button>

                                        </td>
                                    @else
                                        <td>Aprobado</td>
                                        <td>No cambiar este documento</td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td> Copia de tu CURP</td>
                                    @if($datos_empresa[0]->est_curp == 1)
                                        <td style="color: #FF0000;">Rechazado</td>
                                        <td>{{$datos_empresa[0]->coment_curp }}</td>
                                        <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_curp)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                        <td>
                                            <button   id="id_modificar_curp"  class="btn btn-primary" >Modificar</button>

                                        </td>
                                    @else
                                        <td>Aprobado</td>
                                        <td>No cambiar este documento</td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td> Copia de tu Carnet</td>
                                    @if($datos_empresa[0]->est_carnet == 1)
                                        <td style="color: #FF0000;">Rechazado</td>
                                        <td>{{$datos_empresa[0]->coment_carnet }}</td>
                                        <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_carnet)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                        <td>
                                            <button   id="id_modificar_carnet"  class="btn btn-primary" >Modificar</button>

                                        </td>
                                    @else
                                        <td>Aprobado</td>
                                        <td>No cambiar este documento</td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td> Constancia original del 50% de creditos</td>
                                    @if($datos_empresa[0]->est_constancia_creditos == 1)
                                        <td style="color: #FF0000;">Rechazado</td>
                                        <td>{{$datos_empresa[0]->coment_costancia_creditos}}</td>
                                        <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_constancia_creditos)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                        <td>
                                            <button   id="id_modificar_costancia_creditos"  class="btn btn-primary" >Modificar</button>

                                        </td>
                                    @else
                                        <td>Aprobado</td>
                                        <td>No cambiar este documento</td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>  Solicitud de registro de autorización</td>
                                    @if($datos_empresa[0]->est_solicitud_reg_autori == 1)
                                        <td style="color: #FF0000;">Rechazado</td>
                                        <td>{{$datos_empresa[0]->coment_solicitud_reg_autori }}</td>
                                        <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                        <td>
                                            <button   id="id_modificar_solicitud_registro"  class="btn btn-primary" >Modificar</button>

                                        </td>
                                    @else
                                        <td>Aprobado</td>
                                        <td>No cambiar este documento</td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-body" style="text-align: center">
                            <div class="row">

                                <div class="col-md-2 col-md-offset-5">
                                    <button   class="btn btn-success  " title="Enviar documentacion" data-toggle="modal" data-target="#enviar_registro_servicio">Enviar documentación</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

          @else
                <div class="row">

                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-success">
                            <div class="panel-body" style="text-align: center">
                                <p style="color: #FF0000">Hacer las correcciones que se te indican en los comentarios de los documentos rechazados</p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nombre del documento</th>
                                        <th>Estado</th>
                                        <th>Comentario</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> Copia de tu CURP</td>
                                        @if($datos_empresa[0]->est_curp == 1)
                                            <td style="color: #FF0000;">Rechazado</td>
                                            <td>{{$datos_empresa[0]->coment_curp }}</td>
                                            <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_curp)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_modificar_curp"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @else
                                            <td>Aprobado</td>
                                            <td>No cambiar este documento</td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td> Copia de tu Carnet</td>
                                        @if($datos_empresa[0]->est_carnet == 1)
                                            <td style="color: #FF0000;">Rechazado</td>
                                            <td>{{$datos_empresa[0]->coment_carnet }}</td>
                                            <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_carnet)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_modificar_carnet"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @else
                                            <td>Aprobado</td>
                                            <td>No cambiar este documento</td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td> Constancia original del 50% de creditos</td>
                                        @if($datos_empresa[0]->est_constancia_creditos  == 1)
                                            <td style="color: #FF0000;">Rechazado</td>
                                            <td>{{$datos_empresa[0]->coment_constancia_creditos}}</td>
                                            <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_constancia_creditos)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_modificar_costancia_creditos"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @else
                                            <td>Aprobado</td>
                                            <td>No cambiar este documento</td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>  Solicitud de registro de autorización</td>
                                        @if($datos_empresa[0]->est_solicitud_reg_autori   == 1)
                                            <td style="color: #FF0000;">Rechazado</td>
                                            <td>{{$datos_empresa[0]->coment_solicitud_reg_autori  }}</td>
                                            <td><a  target="_blank" href="{{asset('/servicio_social_pdf/primera_etapa/'.$datos_empresa[0]->pdf_solicitud_reg_autori)}}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a></td>

                                            <td>
                                                <button   id="id_modificar_solicitud_registro"  class="btn btn-primary" >Modificar</button>

                                            </td>
                                        @else
                                            <td>Aprobado</td>
                                            <td>No cambiar este documento</td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-success">
                            <div class="panel-body" style="text-align: center">

                                <div class="row">

                                    <div class="col-md-2 col-md-offset-5">
                                        <button   class="btn btn-success  " title="Enviar documentacion" data-toggle="modal" data-target="#enviar_registro_servicio">Enviar documentación</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                    @endif
                @elseif($registro_tipo_empresa[0]->id_estado_enviado == 3)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Se envio correctamente  la documentación al Departamento del Servicio Social y Residencia Profesional.</h3>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($registro_tipo_empresa[0]->id_estado_enviado == 4)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tu documentación de la primera etapa fue autorizada por Departamento de Servicio social y Residencia</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{--inicio Enviar registro de empresa  privada--}}
        <div class="modal fade" id="enviar_registro_servicio" role="dialog">

                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Enviar documentos</h4>
                        </div>
                        <form method="POST" id="enviar_doc_mod" action="{{ url("/servicio_social/enviar_registro_servicio/{$registro_tipo_empresa[0]->id_datos_alumnos}") }}">
                            @csrf
                        <div class="modal-body">
                            <p>¿Seguro que quieres, enviar tus documentos  de la primera etapa del Servicio Social con las modificaciones al Departamento de Servicio Social y Recidencia Profesional para su revisión?</p>
                        </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="documentacion_mod" class="btn btn-primary" >Aceptar</button>
                        </div>
                    </div>
                </div>

        </div>

        {{-- fin de Enviar registro de empresa  privada--}}
        {{--modificar carta aceptacion --}}
        <div class="modal fade" id="modal_modificar_carta_aceptacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Carta Aceptación</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                <label for="nombre_proyecto">Ingresar nuevo PDF con la Carta Aceptación.<b style="color:red; font-size:23px;">*</b></label>
                            <form class="form" id="form_modificar_carta_aceptacion" action="{{url("/servicio_social/registrar_carta_aceptacion/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input class="form-control"  id="carta_aceptacion" name="carta_aceptacion" type="file"   accept="application/pdf" required/>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="modificar_carta_aceptacion" class="btn btn-primary" >Modificar</button>

                    </div>
                </div>
            </div>
        </div>
        {{--modificar anexo tecnico --}}
        <div class="modal fade" id="modal_modificar_anexo_tecnico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Anexo Tecnico</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                <label for="nombre_proyecto">Ingresar nuevo PDF con el Anexo Tecnico.<b style="color:red; font-size:23px;">*</b></label>
                            <form class="form" id="form_modificar_anexo_tecnico"action="{{url("/servicio_social/registrar_anexo_tecnico/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input class="form-control"  id="anexo_tecnico" name="anexo_tecnico" type="file"   accept="application/pdf" required/>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="modificar_anexo_tecnico" class="btn btn-primary" >Modificar</button>

                    </div>
                </div>
            </div>
        </div>
        {{--modificar curp --}}
        <div class="modal fade" id="modal_modificar_curp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Curp</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                <label for="nombre_proyecto">Ingresar nuevo PDF con la Curp.<b style="color:red; font-size:23px;">*</b></label>
                            <form class="form" id="form_modificar_curp"action="{{url("/servicio_social/registrar_curp/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input class="form-control"  id="curp" name="curp" type="file"   accept="application/pdf" required/>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="modificar_curp" class="btn btn-primary" >Modificar</button>

                    </div>
                </div>
            </div>
        </div>

        {{--modificar carnet --}}
        <div class="modal fade" id="modal_modificar_carnet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Carnet</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                <label for="nombre_proyecto">Ingresar nuevo PDF con el Carnet.<b style="color:red; font-size:23px;">*</b></label>
                            <form class="form" id="form_modificar_carnet"action="{{url("/servicio_social/registrar_carnet/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input class="form-control"  id="carnet" name="carnet" type="file"   accept="application/pdf" required/>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="modificar_carnet" class="btn btn-primary" >Modificar</button>

                    </div>
                </div>
            </div>
        </div>

        {{--modificar carnet --}}
        <div class="modal fade" id="modal_modificar_costancia_creditos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Costancia de Creditos</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                <label for="nombre_proyecto">Ingresar nuevo PDF con la Constancia de Creditos.<b style="color:red; font-size:23px;">*</b></label>
                            <form class="form" id="form_modificar_costancia_creditos"action="{{url("/servicio_social/registrar_costancia_creditos/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input class="form-control"  id="costancia_creditos" name="costancia_creditos" type="file"   accept="application/pdf" required/>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="modificar_costancia_creditos" class="btn btn-primary" >Modificar</button>

                    </div>
                </div>
            </div>
        </div>
        {{--modificar solicitud_registro --}}
        <div class="modal fade" id="modal_modificar_solicitud_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Solicitud de registro de autorización</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                <label for="nombre_proyecto">Ingresar nuevo PDF con la Solicitud de registro de autorización.<b style="color:red; font-size:23px;">*</b></label>
                            <form class="form" id="form_modificar_solicitud_registro"action="{{url("/servicio_social/registrar_solicitud_registro/".$datos_empresa[0]->id_alumno."/".$registro_tipo_empresa[0]->id_tipo_empresa)}}" role="form" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input class="form-control"  id="solicitud_registro" name="solicitud_registro" type="file"   accept="application/pdf" required/>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="modificar_solicitud_registro" class="btn btn-primary" >Modificar</button>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <script type="text/javascript">
        $(document).ready( function() {

            $(".modificar_privada").click(function (event) {
                var id_empresa_privada=$(this).attr('id');
                $("#modal_modificar_documento").modal('show');
            });

            $(".modificar_publica").click(function (event) {
                var id_empresa_privada=$(this).attr('id');
                $("#modal_modificar_documento_publica").modal('show');
            });
            $("#documentacion_mod").click(function (event) {
                $("#enviar_doc_mod").submit();
                $("#documentacion_mod").attr("disabled", true);
            });
            $("#id_modificar_carta_aceptacion").click(function (event) {
                //alert('hola');
                $("#modal_modificar_carta_aceptacion").modal('show');
            });
            $("#id_modificar_anexo_tecnico").click(function (event) {
                //alert('hola');
                $("#modal_modificar_anexo_tecnico").modal('show');
            });
            $("#id_modificar_curp").click(function (event) {
                //alert('hola');
                $("#modal_modificar_curp").modal('show');
            });
            $("#id_modificar_carnet").click(function (event) {
                //alert('hola');
                $("#modal_modificar_carnet").modal('show');
            });
            $("#id_modificar_costancia_creditos").click(function (event) {
                //alert('hola');
                $("#modal_modificar_costancia_creditos").modal('show');
            });
            $("#id_modificar_solicitud_registro").click(function (event) {
                //alert('hola');
                $("#modal_modificar_solicitud_registro").modal('show');
            });


            $("#modificar_carta_aceptacion").click(function (event) {

                var carta_aceptacion = $("#carta_aceptacion").val();
                if(carta_aceptacion != ""){
                    $("#form_modificar_carta_aceptacion").submit();
                    $("#modificar_carta_aceptacion").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con la Carta de Aceptación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_anexo_tecnico").click(function (event) {

                var anexo_tecnico = $("#anexo_tecnico").val();
                if(anexo_tecnico != ""){
                    $("#form_modificar_anexo_tecnico").submit();
                    $("#modificar_anexo_tecnico").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con anexo_tecnico",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_curp").click(function (event) {

                var curp = $("#curp").val();
                if(curp != ""){
                    $("#form_modificar_curp").submit();
                    $("#modificar_curp").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu curp",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_carnet").click(function (event) {

                var carnet = $("#carnet").val();
                if(carnet != ""){
                    $("#form_modificar_carnet").submit();
                    $("#modificar_carnet").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu carnet",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_costancia_creditos").click(function (event) {

                var costancia_creditos = $("#costancia_creditos").val();
                if(costancia_creditos != ""){
                    $("#form_modificar_costancia_creditos").submit();
                    $("#modificar_costancia_creditos").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu Constancia de creditos ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#modificar_solicitud_registro").click(function (event) {

                var solicitud_registro = $("#solicitud_registro").val();
                if(solicitud_registro != ""){
                    $("#form_modificar_solicitud_registro").submit();
                    $("#modificar_solicitud_registro").attr("disabled", true);
                }else{
                    swal({
                        position: "top",
                        type: "acept",
                        title: "Selecciona el PDF con tu Solicitud de registro de autorización ",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });


        });
    </script>



@endsection