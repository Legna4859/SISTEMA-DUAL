@extends('layouts.app')
@section('title', 'Solicitudes de requisiciones')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Registrar documentación a las solicitudes de requisiciones del presupuesto autorizado</h3>
                </div>
            </div>
        </div>
    </div>
    @foreach($solicitudes as $solicitud)
        <div class="row">
            <div class="col-md-8  col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <p style=""><span class="glyphicon glyphicon-file" style="font-size: 30px;"></span> Solicitud: <b>{{ $solicitud->descripcion_solicitud }}</b></p>
                        <p style="">Proyecto: <b>{{ $solicitud->nombre_proyecto }}</b></p>
                        <p style="">Meta: <b>{{ $solicitud->meta }}</b></p>
                        <p style="">Mes: <b>{{ $solicitud->mes }}</b></p>
                        @if($solicitud->id_estado_enviado == 1 )
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <p style="text-align: center;">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading" style="text-align: center;">
                                           Registrar la documentación correspondiente
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_autorizado/registrar_documentacion_solicitud/'.$solicitud->id_solicitud)}}')">Registrar datos en la solicitud</button></p>
                       @elseif($solicitud->id_estado_enviado == 3)
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <p style="text-align: center;">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" style="text-align: center;">
                                            Comentario: {{ $solicitud->comentario_solicitud }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_autorizado/registrar_documentacion_solicitud/'.$solicitud->id_solicitud)}}')">Modificar datos en la solicitud</button></p>

                        @elseif($solicitud->id_estado_enviado == 2)

                            <div class="row">
                                <div class="col-md-6 col-md-offset-2">
                                    <p style="text-align: center;">
                                    <div class="panel panel-success">
                                        <div class="panel-heading" style="text-align: center;">
                                            Se envio correctamente la solicitud
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @elseif($solicitud->id_estado_enviado == 4)
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <p style="text-align: center;">
                                    <div class="panel panel-success">
                                        <div class="panel-heading" style="text-align: center;">
                                      Solicitud autorizada
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_autorizado/ver_documentacion_solicitud_aut/'.$solicitud->id_solicitud)}}')">Ver datos de la solicitud</button></p>

                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endforeach



                                <script type="text/javascript">
                                    $(document).ready( function() {
                                        $("#guardar_envio").click(function (){
                                            $("#form_envio").submit();
                                            $("#guardar_envio").attr("disabled", true);
                                        });
                                    });
                                </script>


@endsection