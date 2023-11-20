@extends('layouts.app')
@section('title', 'Revisión de solicitudes')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Revisión de documentos de la solicitud</h3>
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

</div>
</div>
</div>
</div>
    <div class="row">
        <div class="col-md-2 col-md-offset-4" style="text-align: center">
            <button  id="{{ $id_solicitud }}"  class="btn btn-danger btn-lg  enviar_modificaciones_solicitud" >Enviar modificaciones
            </button>
        </div>
        <div class="col-md-2" style="text-align: center">
            <button  id="{{ $id_solicitud }}"  class="btn btn-success btn-lg  enviar_autorizacion_solicitud" >Enviar autorizacion
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p><br></p>
        </div>
    </div>
    {{-- modal enviar solicitud --}}

    <div class="modal fade" id="modal_enviar_modificaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Enviar modificaciones</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_modificaciones" class="form" action="{{url("/presupuesto_autorizado/enviar_modificaciones_departamento/".$id_solicitud)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                    <label>Comentarios de modificaciones</label>
                                    <textarea class="form-control" id="comentario" name="comentario" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_enviar_modoificaciones"  class="btn btn-primary" >Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal enviar autorizacion de la solicitud --}}

    <div class="modal fade" id="modal_enviar_autorizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Enviar autorización</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enviar_autorizacion" class="form" action="{{url("/presupuesto_autorizado/enviar_autorizacion_departamento/".$id_solicitud)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                               <h4>¿Seguro que quiere autorizar la solicitud?</h4>
                            </div>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_enviar_autorizacion"  class="btn btn-primary" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $("#guardar_enviar_autorizacion").click(function (){
                $("#form_enviar_autorizacion").submit();
                $("#guardar_enviar_autorizacion").attr("disabled", true);
            });
            $(".enviar_autorizacion_solicitud").click(function (){
                $("#modal_enviar_autorizacion").modal('show');
            });
            $(".enviar_modificaciones_solicitud").click(function (){
                $("#modal_enviar_modificaciones").modal('show');
            });

            $("#guardar_enviar_modoificaciones").click(function (){
                var comentario = $("#comentario").val();
                if(comentario != ''){
                    $("#form_enviar_modificaciones").submit();
                    $("#guardar_enviar_modoificaciones").attr("disabled", true);
                    swal({
                        position: "top",
                        type: "success",
                        title: "Envío exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresa comentario de modificación",
                        showConfirmButton: false,
                        timer: 3500
                    });

                }
            });
        });
    </script>

@endsection