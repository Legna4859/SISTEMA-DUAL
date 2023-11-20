@extends('layouts.app')
@section('title', 'Solicitudes')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_autorizado/solicitudes_autorizadas_departamentos_historial/".$id_year)}}">Departamentos o jefaturas con solicitudes autorizadas</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Solicitudes de requisiciones del departamento o de la jefatura</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historial de solicitudes de requisiciones del departamento o de la jefatura: {{ $departamento->nom_departamento }}
                        <br>Nombre del jefe o de la jefa del departamento o jefatura: {{ $departamento->titulo }} {{ $departamento->nombre }}</h3>
                </div>
            </div>
        </div>
    </div>

    @foreach($solicitudes as $solicitud)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <p style=""><span class="glyphicon glyphicon-file" style="font-size: 30px;"></span> Solicitud: <b>{{ $solicitud->descripcion_solicitud }}</b></p>
                        <p style="">Proyecto: <b>{{ $solicitud->nombre_proyecto }}</b></p>
                        <p style="">Meta: <b>{{ $solicitud->meta }}</b></p>
                        <p style="">Mes: <b>{{ $solicitud->mes }}</b></p>
                        <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_autorizado/mostrar_doc_solicitud_historial/'.$solicitud->id_solicitud.'/'.$id_unidad_admin)}}')">Ver documentacion de la solicitud</button></p>

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