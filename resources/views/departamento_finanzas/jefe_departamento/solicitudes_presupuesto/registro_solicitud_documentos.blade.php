@extends('layouts.app')
@section('title', 'Solicitudes de requisiciones')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Registrar documentos de la solicitud</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p style=""><span class="glyphicon glyphicon-file" style="font-size: 30px;"></span> Solicitud: <b>{{ $solicitud->descripcion_solicitud }}</b></p>
                    <p style="">Proyecto: <b>{{ $solicitud->nombre_proyecto }}</b></p>
                    <p style="">Meta: <b>{{ $solicitud->meta }}</b></p>
                    <p style="">Mes: <b>{{ $solicitud->mes }}</b></p>

                </div>
                <div class="panel-body">
                    @if($estado_solicitud == 0)
                        <div class="row">
                            <div class="col-md-12">

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="7" style="text-align: center; background:  #D6EEEE;">
                                            <b>PARTIDAS PRESUPUESTALES</b>
                                        </th>
                                    </tr>
                                    @foreach($partidas as $partida)
                                        <tr>

                                            <th colspan="7" style="text-align: center; ">
                                                {{ $partida->clave_presupuestal }} {{ $partida->nombre_partida }}..............................................................
                                                <b style="color: red">PRESUPUESTO DADO: {{ "$".number_format($partida->presupuesto_dado, 2, '.', ',') }}</b>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </thead>
                                </table>


                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th colspan="5" style="text-align: center">Documentación en pdf</th>
                                </tr>
                                <tr>
                                    <th>Requisición </th>
                                    <th>Anexo 1</th>
                                    <th>Oficio de suficiencia presupuestal</th>
                                    <th>Justificación para dictamen</th>
                                    <th>Cotización</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="text-align: center">
                                        <button class="btn btn-primary btn-lg agregar_requisicion" title="Agregar requisición pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                    <td style="text-align: center">
                                        <button  class="btn btn-primary btn-lg agregar_anexo1" title="Agregar anexo 1 pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                    </td>
                                    <td style="text-align: center">

                                        <button  class="btn btn-primary btn-lg agregar_suficiencia" title="Agregar oficio de suficiencia presupuestal pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                    </td>
                                    <td style="text-align: center">

                                        <button  class="btn btn-primary btn-lg agregar_justificacion" title="Agregar justificacion pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                    </td>
                                    <td style="text-align: center">
                                        <button  class="btn btn-primary btn-lg agregar_cotizacion" title="Agregar cotización pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>

                    @endif
                        @if($estado_solicitud == 1)
                            @if($solicitud->comentario_solicitud !='')
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading" style="text-align: center;">
                                                Comentario: {{ $solicitud->comentario_solicitud }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th colspan="7" style="text-align: center; background:  #D6EEEE;">
                                                        <b>PARTIDAS PRESUPUESTALES</b>
                                                    </th>
                                                </tr>
                                                @foreach($partidas as $partida)
                                                    <tr>

                                                        <th colspan="7" style="text-align: center; ">
                                                            {{ $partida->clave_presupuestal }} {{ $partida->nombre_partida }}..............................................................
                                                            <b style="color: red">PRESUPUESTO DADO: {{ "$".number_format($partida->presupuesto_dado, 2, '.', ',') }}</b>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                                </thead>
                                            </table>


                                        </div>
                                    </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th colspan="5" style="text-align: center; background:  #D6EEEE;">Documentación en pdf</th>
                                        </tr>
                                        <tr>
                                            <th>Requisición </th>
                                            <th>Anexo 1</th>
                                            <th>Oficio de suficiencia presupuestal</th>
                                            <th>Justificación para dictamen</th>
                                            <th>Cotización</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @if($documentos->requisicion_pdf == '')
                                            <td style="text-align: center">
                                                <button class="btn btn-primary btn-lg agregar_requisicion" title="Agregar requisición pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                            </td>
                                            @else
                                                <td style="text-align: center">
                                                    <a  target="_blank" href="/finanzas/requisicion_pres_aut/{{ $documentos->requisicion_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                                    <button title="Modificar requisicion pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_requisicion" >
                                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                </button>
                                                </td>
                                            @endif
                                                @if($documentos->anexo_1_pdf == '')
                                                <td style="text-align: center">
                                                    <button  class="btn btn-primary btn-lg agregar_anexo1" title="Agregar anexo 1 pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                                </td>
                                                @else
                                                    <td style="text-align: center">
                                                        <a  target="_blank" href="/finanzas/anexo1_pres_aut/{{ $documentos->anexo_1_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                                        <button title="Modificar anexo 1 pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_anexo1" >
                                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                        </button>
                                                    </td>
                                                @endif
                                                @if($documentos->oficio_suficiencia_presupuestal_pdf == '')
                                                <td style="text-align: center">

                                                    <button  class="btn btn-primary btn-lg agregar_suficiencia" title="Agregar oficio de suficiencia presupuestal pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                                </td>
                                                @else
                                                    <td style="text-align: center">
                                                        <a  target="_blank" href="/finanzas/suficiencia_pres_aut/{{ $documentos->oficio_suficiencia_presupuestal_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                                        <button title="Modificar oficio de suficiencia pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_suficiencia" >
                                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                        </button>
                                                    </td>
                                                @endif
                                                @if($documentos->id_estado_justificacion == 0)
                                            <td style="text-align: center">
                                                <button  class="btn btn-primary btn-lg agregar_justificacion" title="Agregar justificacion pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                            </td>
                                                @else
                                                    <td style="text-align: center">
                                                    @if($documentos->id_estado_justificacion == 1)
                                                        No
                                                    @else
                                                        <a  target="_blank" href="/finanzas/justificacion_pres_aut/{{ $documentos->oficio_justificacion }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                    @endif
                                                    <button title="Modificar justificacion pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_justificacion" >
                                                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                    </button>
                                                    </td>
                                                @endif
                                                @if($documentos->cotizacion_pdf == '')
                                                    <td style="text-align: center">
                                                        <button  class="btn btn-primary btn-lg agregar_cotizacion" title="Agregar cotización pdf" id="{{ $solicitud->id_solicitud }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>
                                                    </td>
                                                @else
                                                    <td style="text-align: center">
                                                    <a  target="_blank" href="/finanzas/cotizacion_pres_aut/{{ $documentos->cotizacion_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                                    <button title="Modificar cotización pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_cotizacion" >
                                                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                                    </button>
                                                    </td>

                                                @endif
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                                @if($documentos->cotizacion_pdf != '')
                                    @if($documentos->requisicion_pdf != '')
                                        @if($documentos->anexo_1_pdf !='')
                                            @if($documentos->oficio_suficiencia_presupuestal_pdf !='')
                                                @if($documentos->id_estado_justificacion != 0)
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-4" style="text-align: center">
                                                            <button  id="{{ $id_solicitud }}"  class="btn btn-success btn-lg  enviar_solicitud" >Enviar solicitud
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><br></p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                        @endif
                </div>
            </div>
        </div>
    </div>




    {{-- modal agregar requisicion pdf--}}

    <div class="modal fade" id="modal_agregar_requisicion_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Requisicion pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_requisicion_pdf">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_req"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal agregar agregar_anexo1--}}

    <div class="modal fade" id="modal_agregar_anexo1_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Anexo 1 pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_anexo1_pdf">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_anexo1"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal agregar suficiencia  pdf--}}

    <div class="modal fade" id="modal_agregar_suficiencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Oficio de suficiencia presupuestal pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_suficiencia">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_suficiencia"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal agregar justificacion  pdf--}}

    <div class="modal fade" id="modal_agregar_justificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Justificación pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_justificacion">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_justificacion"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar cotizacion  --}}

    <div class="modal fade" id="modal_agregar_cotizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Cotización pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_cotizacion">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_cotizacion"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal modificar requisicion--}}

    <div class="modal fade" id="modal_modificar_req" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar requisicion  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_req">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_req"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar anexo1--}}

    <div class="modal fade" id="modal_mod_anexo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar requisicion  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mod_anexo1">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_mod_anexo1"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal modificar oficio de suficiencia pdfp--}}

    <div class="modal fade" id="modal_mod_suficiencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar oficio de suficiencia presupuestal  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mod_suficiencia">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_mod_suficiencia"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal modificar justificacion pdf--}}

    <div class="modal fade" id="modal_mod_justificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar justificación  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mod_justificacion">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_mod_justificacion"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal modificar cotizacion  --}}

    <div class="modal fade" id="modal_modificar_cotizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar cotización pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_cotizacion">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_cotizacion"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar material partida  --}}

    <div class="modal fade" id="modal_agregar_material_partida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar material o servicio a la partida</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_material_partida">

                    </div>


                </div>
            </div>
        </div>
    </div>

    {{-- modal enviar solicitud --}}

    <div class="modal fade" id="modal_enviar_solicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Enviar solicitud</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_solicitud" class="form" action="{{url("/presupuesto_autorizado/enviar_solicitud/".$id_solicitud)}}" role="form" method="POST" >
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <h4>¿Deseas enviar tu solicitud?</h4>
                            </div>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_enviar_solicitud"  class="btn btn-primary" >Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar material partida  --}}

    <div class="modal fade" id="modal_modificar_material_partida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar material o servicio a la partida</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_material_partida">

                    </div>


                </div>
            </div>
        </div>
    </div>

    {{-- modal eliminar material o servicio --}}

    <div class="modal fade" id="modal_eliminar_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Notificación.</h4>
                </div>
                <div class="modal-body">
                    <form id="form_eliminar_material" class="form" action="{{url("/presupuesto_autorizado/eliminar_material_solicitud/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <input type="hidden" id="id_material_part" name="id_material_part" value="">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <h4>¿Deseas eliminar material o servicio, etc.?</h4>
                            </div>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_eliminar_material"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_eliminar_material").click(function (){
                $("#guardar_eliminar_material").attr("disabled", true);
                $("#form_eliminar_material").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Eliminaciòn exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });
            });
            $(".eliminar_servicio").click(function (){
                var id_material_partida =$(this).attr('id');
                $("#id_material_part").val(id_material_partida);
                $("#modal_eliminar_material").modal("show");
                });
            $(".editar_servicio").click(function (){
                var id_material_partida =$(this).attr('id');
                $.get("/presupuesto_autorizado/modificar_servicio_solicitud/"+id_material_partida,function (request) {
                    $("#contenedor_modificar_material_partida").html(request);
                    $("#modal_modificar_material_partida").modal('show');
                });
            });
            $("#guardar_enviar_solicitud").click(function (){
                $("#form_enviar_solicitud").submit();
                $("#guardar_enviar_solicitud").attr("disabled", true);
            });
            $(".enviar_solicitud").click(function (){
                $("#modal_enviar_solicitud").modal('show');
            });

            $(".agregar_requisicion").click(function (){
                var id_solicitud =$(this).attr('id');
                $.get("/presupuesto_autorizado/registrar_requisicion/"+id_solicitud,function (request) {
                    $("#contenedor_agregar_requisicion_pdf").html(request);
                    $("#modal_agregar_requisicion_pdf").modal('show');
                });
            });
            $("#guardar_req").click(function (){

                    var requisicion_pdf = $("#requisicion_pdf").val();
                    if( requisicion_pdf != ''){
                        $("#form_guardar_requisicion").submit();
                        $("#guardar_req").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona documento pdf",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
            });
            $(".agregar_anexo1").click(function (){
                var id_solicitud =$(this).attr('id');
                $.get("/presupuesto_autorizado/registrar_agregar_anexo1/"+id_solicitud,function (request) {
                    $("#contenedor_agregar_anexo1_pdf").html(request);
                    $("#modal_agregar_anexo1_pdf").modal('show');
                });
            });
            $("#guardar_anexo1").click(function (){

                var anexo_pdf = $("#anexo_pdf").val();
                if( anexo_pdf != ''){
                    $("#form_guardar_anexo1").submit();
                    $("#guardar_anexo1").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar_suficiencia").click(function (){
                var id_solicitud =$(this).attr('id');
                $.get("/presupuesto_autorizado/registrar_oficio_suficiencia/"+id_solicitud,function (request) {
                    $("#contenedor_agregar_suficiencia").html(request);
                    $("#modal_agregar_suficiencia").modal('show');
                });
            });
            $("#guardar_suficiencia").click(function (){
                var suficiencia_pdf = $("#suficiencia_pdf").val();
                if( suficiencia_pdf != ''){
                    $("#form_guardar_suficiencia").submit();
                    $("#guardar_suficiencia").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar_justificacion").click(function (){
                var id_solicitud =$(this).attr('id');
                $.get("/presupuesto_autorizado/registrar_justificacion/"+id_solicitud,function (request) {
                    $("#contenedor_agregar_justificacion").html(request);
                    $("#modal_agregar_justificacion").modal('show');
                });
            });
            $("#guardar_justificacion").click(function (){
                var justificacion = $("#justificacion").val();

                if(justificacion != null){
                    if(justificacion == 1){
                        $("#form_guardar_justificacion").submit();
                        $("#guardar_justificacion").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                    if(justificacion == 2){
                        var doc_justificacion = $("#doc_justificacion").val();

                        if(doc_justificacion == ''){
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            $("#form_guardar_justificacion").submit();
                            $("#guardar_justificacion").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona una opcion",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar_cotizacion").click(function (){
                var id_solicitud =$(this).attr('id');
                $.get("/presupuesto_autorizado/registrar_cotizacion/"+id_solicitud,function (request) {
                    $("#contenedor_agregar_cotizacion").html(request);
                    $("#modal_agregar_cotizacion").modal('show');
                });
            });
            $("#guardar_cotizacion").click(function (){
                var cotizacion_pdf = $("#cotizacion_pdf").val();
                if( cotizacion_pdf != ''){
                    $("#form_guardar_cotizacion").submit();
                    $("#guardar_cotizacion").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_requisicion").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/modificar_requisicion/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_req").html(request);
                    $("#modal_modificar_req").modal('show');
                });
            });
            $("#guardar_modificar_req").click(function (){

                var requisicion_mod_pdf = $("#requisicion_mod_pdf").val();
                if( requisicion_mod_pdf != ''){
                    $("#form_guardar_mod_requisicion").submit();
                    $("#guardar_modificar_req").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Modificacion exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_anexo1").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_anexo1/"+id_solicitud_documento,function (request) {
                    $("#contenedor_mod_anexo1").html(request);
                    $("#modal_mod_anexo1").modal('show');
                });
            });
            $("#guardar_mod_anexo1").click(function (){

                var anexo_mod_pdf = $("#anexo_mod_pdf").val();

                if( anexo_mod_pdf != ''){
                    $("#form_guardar_mod_anexo1").submit();
                    $("#guardar_mod_anexo1").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Modificacion exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_suficiencia").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_oficio_suficiencia/"+id_solicitud_documento,function (request) {
                    $("#contenedor_mod_suficiencia").html(request);
                    $("#modal_mod_suficiencia").modal('show');
                });
            });
            $("#guardar_mod_suficiencia").click(function (){
                var suficiencia_mod_pdf = $("#suficiencia_mod_pdf").val();

                if( suficiencia_mod_pdf != ''){
                    $("#form_guardar_mod_suficiencia").submit();
                    $("#guardar_mod_suficiencia").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Modificacion exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_justificacion").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_justificacion/"+id_solicitud_documento,function (request) {
                    $("#contenedor_mod_justificacion").html(request);
                    $("#modal_mod_justificacion").modal('show');
                });
            });
            $("#guardar_mod_justificacion").click(function (){
                var justificacion = $("#mod_justificacion").val();

                if(justificacion != null){
                    if(justificacion == 1){
                        $("#form_guardar_mod_justificacion").submit();
                        $("#guardar_mod_justificacion").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                    if(justificacion == 2){
                        var doc_justificacion = $("#doc_justificacion_mod").val();

                        if(doc_justificacion == ''){
                            swal({
                                position: "top",
                                type: "error",
                                title: "Selecciona documento pdf",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }else{
                            $("#form_guardar_mod_justificacion").submit();
                            $("#guardar_mod_justificacion").attr("disabled", true);
                            swal({
                                position: "top",
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona una opcion",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_cotizacion").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_cotizacion_pdf/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_cotizacion").html(request);
                    $("#modal_modificar_cotizacion").modal('show');
                });

            });
            $("#guardar_modificar_cotizacion").click(function (){
                var cotizacion_mod_pdf = $("#cotizacion_mod_pdf").val();

                if( cotizacion_mod_pdf != ''){
                    $("#form_guardar_mod_cotizacion").submit();
                    $("#guardar_modificar_cotizacion").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Modificacion exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona documento pdf",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar_material").click(function (){
              var id_solicitud_partida = $(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_material_partida_solicitud/"+id_solicitud_partida,function (request) {
                    $("#contenedor_material_partida").html(request);
                    $("#modal_agregar_material_partida").modal('show');
                });

            });
        });
    </script>


@endsection