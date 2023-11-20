@extends('layouts.app')
@section('title', 'Revisión de solicitudes')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_autorizado/solicitudes_autorizadas_departamentos_historial/".$id_year)}}">Departamentos o jefaturas con solicitudes autorizadas</a>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_autorizado/solicitudes_ver_departamento_historial/".$id_unidad_admin."/".$id_year)}}">Solicitudes de requisiciones del departamento o de la jefatura</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Solicitud</span>
            </p>
            <br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historial de la documentacion de la solicitud del departamento o jefatura: {{ $departamento->nom_departamento }}
                        <br>Nombre del jefe o de la jefa del departamento o jefatura: {{ $departamento->titulo }} {{ $departamento->nombre }}</h3>
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
                                    <th colspan="5" style="text-align: center; background:  #D6EEEE;">Documentación enviada por el departamento pdf</th>
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
                                            No hay documento
                                        </td>
                                    @else
                                        <td style="text-align: center">
                                            <a  target="_blank" href="/finanzas/requisicion_pres_aut/{{ $documentos->requisicion_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                        </td>
                                    @endif
                                    @if($documentos->anexo_1_pdf == '')
                                        <td style="text-align: center">
                                            No hay documento
                                        </td>
                                    @else
                                        <td style="text-align: center">
                                            <a  target="_blank" href="/finanzas/anexo1_pres_aut/{{ $documentos->anexo_1_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                        </td>
                                    @endif
                                    @if($documentos->oficio_suficiencia_presupuestal_pdf == '')
                                        <td style="text-align: center">
                                            No hay documento
                                        </td>
                                    @else
                                        <td style="text-align: center">
                                            <a  target="_blank" href="/finanzas/suficiencia_pres_aut/{{ $documentos->oficio_suficiencia_presupuestal_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                        </td>
                                    @endif
                                    @if($documentos->id_estado_justificacion == 0)
                                        <td style="text-align: center">
                                            Sin justificacion de dictamen
                                        </td>
                                    @else
                                        <td style="text-align: center">
                                            @if($documentos->id_estado_justificacion == 1)
                                                Sin justificacion de dictamen
                                            @else
                                                <a  target="_blank" href="/finanzas/justificacion_pres_aut/{{ $documentos->oficio_justificacion }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                            @endif

                                        </td>
                                    @endif
                                    @if($documentos->cotizacion_pdf == '')
                                        <td style="text-align: center">
                                            No hay documento
                                        </td>
                                    @else
                                        <td style="text-align: center">
                                            <a  target="_blank" href="/finanzas/cotizacion_pres_aut/{{ $documentos->cotizacion_pdf }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>
                                        </td>

                                    @endif
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th colspan="5" style="text-align: center; background:  #D6EEEE;">Registrar documentación</th>
                                </tr>
                                <tr>
                                    <th>Contrato</th>
                                    <th>Factura</th>
                                    <th>Pago</th>
                                    <th>Oficio de entrega</th>
                                    <th>Solicitud de pago</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if($documentos->id_tipo_contrato == 0)
                                    <td style="text-align: center">
                                        <button class="btn btn-primary  agregar_contrato" title="Agregar contrato pdf" id="{{ $documentos->id_solicitud_documento }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                @else
                                    <td style="text-align: center">
                                        @if($documentos->id_tipo_contrato == 1)
                                            CONTRATO ADMINISTRATIVO
                                        @elseif($documentos->id_tipo_contrato == 2)
                                            CONTRATO PEDIDO
                                        @elseif($documentos->id_tipo_contrato == 3)
                                            ORDEN DE PEDIDO
                                        @elseif($documentos->id_tipo_contrato == 4)
                                            NOTA INFORMATIVA
                                        @endif
                                        <br>
                                        <a  target="_blank" href="/finanzas/contrato_pres_aut/{{ $documentos->pdf_tipo_contrato }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                        <button title="Modificar tipo de contrato pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_contrato" >
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                @endif
                                @if($documentos->pdf_factura_comprado == '')
                                    <td style="text-align: center">
                                        <button class="btn btn-primary  agregar_factura" title="Agregar factura pdf" id="{{ $documentos->id_solicitud_documento }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                @else
                                    <td style="text-align: center">
                                        <br>
                                        <a  target="_blank" href="/finanzas/factura_pres_aut/{{ $documentos->pdf_factura_comprado }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                        <button title="Modificar factura pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_factura" >
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                @endif
                                @if($documentos->pdf_pago_material_comprado == '')
                                    <td style="text-align: center">
                                        <button class="btn btn-primary  agregar_pago" title="Agregar factura pdf" id="{{ $documentos->id_solicitud_documento }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                @else
                                    <td style="text-align: center">
                                        <br>
                                        <a  target="_blank" href="/finanzas/pago_pres_aut/{{ $documentos->pdf_pago_material_comprado }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                        <button title="Modificar pago pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_pago" >
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                @endif
                                @if($documentos->pdf_oficio_entrega == '')
                                    <td style="text-align: center">
                                        <button class="btn btn-primary  agregar_oficio" title="Agregar oficio de entrega pdf" id="{{ $documentos->id_solicitud_documento }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                @else
                                    <td style="text-align: center">
                                        <br>
                                        <a  target="_blank" href="/finanzas/oficio_pres_aut/{{ $documentos->pdf_oficio_entrega }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                        <button title="Modificar oficio de  pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_oficio" >
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                @endif
                                @if($documentos->pdf_solicitud_pago == '')
                                    <td style="text-align: center">
                                        <button class="btn btn-primary  agregar_solicitud_pago" title="Agregar solicitud de pago pdf" id="{{ $documentos->id_solicitud_documento }}" ><span     class="glyphicon glyphicon-plus " aria-hidden="true"></span></button>

                                    </td>
                                @else
                                    <td style="text-align: center">
                                        <br>
                                        <a  target="_blank" href="/finanzas/solicitud_pago_pres_aut/{{ $documentos->pdf_solicitud_pago }}" class="btn btn-success "><i class="glyphicon glyphicon-book em56" title="Ver PDF"></i></a>

                                        <button title="Modificar solicitud de pago de  pdf" id="{{ $documentos->id_solicitud_documento }}"  class="btn btn-primary editar_solicitud_pago" >
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                @endif



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><br></p>
        </div>
    </div>

    {{-- modal agregar contrato--}}

    <div class="modal fade" id="modal_agregar_contrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_contrato">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_contrato"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar contrato--}}

    <div class="modal fade" id="modal_modificar_contrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_contrato">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_contrato"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar factura--}}

    <div class="modal fade" id="modal_agregar_factura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_factura">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_factura"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar factura--}}

    <div class="modal fade" id="modal_modificar_factura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_factura">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_factura"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar pago--}}

    <div class="modal fade" id="modal_agregar_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_pago">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_pago"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar pago--}}

    <div class="modal fade" id="modal_modificar_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_pago">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_pago"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal agregar oficio--}}

    <div class="modal fade" id="modal_agregar_oficio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_oficio">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_oficio"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar oficio--}}

    <div class="modal fade" id="modal_modificar_oficio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_oficio">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_oficio"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal agregar solicitud de pago--}}

    <div class="modal fade" id="modal_agregar_solicitud_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar_solicitud_pago">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_agregar_solicitud_pago"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal modificar solicitud de pago--}}

    <div class="modal fade" id="modal_modificar_solicitud_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar documento  pdf</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_solicitud_pago">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificar_solicitud_pago"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $(".agregar_solicitud_pago").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_solicitud_pago/"+id_solicitud_documento,function (request) {
                    $("#contenedor_agregar_solicitud_pago").html(request);
                    $("#modal_agregar_solicitud_pago").modal('show');
                });
            });
            $("#guardar_agregar_solicitud_pago").click(function (){
                var doc_solicitud_pago = $("#doc_solicitud_pago").val();

                if(doc_solicitud_pago != ''){
                    $("#form_guardar_solicitud_pago").submit();
                    $("#guardar_agregar_solicitud_pago").attr("disabled", true);
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
                        title: "Selecciona  documento pdf de la solicitud de pago",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_solicitud_pago").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_solicitud_pago/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_solicitud_pago").html(request);
                    $("#modal_modificar_solicitud_pago").modal('show');
                });
            });
            $("#guardar_modificar_solicitud_pago").click(function (){
                var doc_solicitud_pago = $("#doc_solicitud_pago").val();


                if(doc_solicitud_pago != ''){
                    $("#form_guardar_mod_solicitud_pago").submit();
                    $("#guardar_modificar_solicitud_pago").attr("disabled", true);
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
                        title: "Selecciona  documento pdf de la solicitud de pago",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_oficio").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/modificar_oficio_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_oficio").html(request);
                    $("#modal_modificar_oficio").modal('show');
                });
            });
            $("#guardar_modificar_oficio").click(function (){
                var doc_oficio = $("#doc_oficio").val();

                if(doc_oficio != ''){
                    $("#form_guardar_mod_oficio").submit();
                    $("#guardar_modificar_oficio").attr("disabled", true);
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
                        title: "Selecciona  documento pdf del oficio de entrega",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $(".agregar_oficio").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_oficio_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_agregar_oficio").html(request);
                    $("#modal_agregar_oficio").modal('show');
                });
            });
            $("#guardar_agregar_oficio").click(function (){
                var doc_oficio = $("#doc_oficio").val();

                if(doc_oficio != ''){
                    $("#form_guardar_oficio").submit();
                    $("#guardar_agregar_oficio").attr("disabled", true);
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
                        title: "Selecciona  documento pdf del oficio de entrega",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_pago").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/modificar_pago_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_pago").html(request);
                    $("#modal_modificar_pago").modal('show');
                });
            });
            $("#guardar_modificar_pago").click(function (){
                var doc_pago = $("#doc_pago").val();

                if(doc_pago != ''){
                    $("#form_guardar_mod_pago").submit();
                    $("#guardar_modificar_pago").attr("disabled", true);
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
                        title: "Selecciona  documento pdf del pago",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar_pago").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_pago_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_agregar_pago").html(request);
                    $("#modal_agregar_pago").modal('show');
                });
            });
            $("#guardar_agregar_pago").click(function (){
                var doc_pago = $("#doc_pago").val();

                if(doc_pago != ''){
                    $("#form_guardar_pago").submit();
                    $("#guardar_agregar_pago").attr("disabled", true);
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
                        title: "Selecciona  documento pdf del pago",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".agregar_factura").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_factura_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_agregar_factura").html(request);
                    $("#modal_agregar_factura").modal('show');
                });
            });
            $("#guardar_agregar_factura").click(function (){
                var doc_factura = $("#doc_factura").val();
                if(doc_factura != ''){
                    $("#form_guardar_factura").submit();
                    $("#guardar_agregar_factura").attr("disabled", true);
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
                        title: "Selecciona documento pdf de la factura",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_factura").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_factura_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_factura").html(request);
                    $("#modal_modificar_factura").modal('show');
                });
            });
            $("#guardar_modificar_factura").click(function (){
                var doc_factura = $("#doc_factura").val();
                if(doc_factura != ''){
                    $("#form_guardar_mod_factura").submit();
                    $("#guardar_modificar_factura").attr("disabled", true);
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
                        title: "Selecciona  factura",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

            $(".editar_contrato").click(function (){
                var id_solicitud_documento =$(this).attr('id');

                $.get("/presupuesto_autorizado/modificar_contrato_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_modificar_contrato").html(request);
                    $("#modal_modificar_contrato").modal('show');
                });
            });
            $(".agregar_contrato").click(function (){
                var id_solicitud_documento =$(this).attr('id');
                $.get("/presupuesto_autorizado/agregar_contrato_solicitud/"+id_solicitud_documento,function (request) {
                    $("#contenedor_agregar_contrato").html(request);
                    $("#modal_agregar_contrato").modal('show');
                });
            });
            $("#guardar_agregar_contrato").click(function (){
                var id_tipo_contrato = $("#id_tipo_contrato").val();
                if(id_tipo_contrato == null){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona tipo de contrato",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    var doc_contrato = $("#doc_contrato").val();
                    if(doc_contrato == ''){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona  contrato",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                    else{
                        $("#form_guardar_contrato").submit();
                        $("#guardar_agregar_contrato").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }
            });
            $("#guardar_modificar_contrato").click(function (){
                var id_tipo_contrato = $("#id_tipo_contrato").val();
                if(id_tipo_contrato == null){
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona tipo de contrato",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    var doc_contrato = $("#doc_contrato").val();
                    if(doc_contrato == ''){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona  contrato",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                    else{
                        $("#form_guardar_mod_contrato").submit();
                        $("#guardar_modificar_contrato").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }
            });

        });
    </script>

@endsection