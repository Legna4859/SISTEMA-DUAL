@extends('layouts.app')
@section('title', 'Solicitudes')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Revisión de las solicitudes de requisiciones de los departamentos o jefatura</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-md-11 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#">Revisión de solicitudes de requisiciones de los departamentos</a></li>
            <li>
                <a href="{{ url('/presupuesto_autorizado/proceso_mod_solicitudes/') }}" >En proceso de modificación</a>
            </li>
            {{--
            <li>
                <a href="{{ url('/presupuesto_autorizado/solicitudes_autorizadas_departamentos/' ) }}" >Solicitudes autorizadas</a>
            </li>
            --}}





        </ul>
        <p>
            <br>
        </p>
    </div>
    @foreach($solicitudes as $solicitud)
        <div class="row">
            <div class="col-md-8  col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <p style=""><span class="glyphicon glyphicon-file" style="font-size: 30px;"></span> Solicitud: <b>{{ $solicitud->descripcion_solicitud }}</b></p>
                        <p>Nombre del departamento o jefatura: <b>{{ $solicitud->nom_departamento }}</b></p>
                        <p>Nombre del jefe o  de la jefa del departamento o jefatura: <b>{{ $solicitud->titulo }} {{ $solicitud->nombre_personal }}</b></p>
                           @if($solicitud->comentario_solicitud != '')
                            <div class="row">
                                <div class="col-md-8  col-md-offset-2">
                                    <div class="panel panel-danger">
                                        <div class="panel-body">
                                          <p style="color: red;">Comentario: <b>{{ $solicitud->comentario_solicitud }}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        <p style="">Proyecto: <b>{{ $solicitud->nombre_proyecto }}</b></p>
                        <p style="">Meta: <b>{{ $solicitud->meta }}</b></p>
                        <p style="">Mes: <b>{{ $solicitud->mes }}</b></p>
                        @if($solicitud->id_estado_enviado == 2)
                            <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_autorizado/revisar_documentacion_solicitud/'.$solicitud->id_solicitud)}}')">Revisar documentacion de la solicitud</button></p>

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