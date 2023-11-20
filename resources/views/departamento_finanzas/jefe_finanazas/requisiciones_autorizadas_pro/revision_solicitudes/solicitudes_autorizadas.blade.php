@extends('layouts.app')
@section('title', 'Solicitudes')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Solicitudes de requisiciones de los departamentos</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-md-11 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li>
                <a href="{{ url('/presupuesto_autorizado/revisar_solicitudes') }}" > Revisión de solicitudes de requisiciones de los departamentos</a>
            </li>
            <li><a href="{{ url('/presupuesto_autorizado/solicitudes_autorizadas_departamentos/' ) }}" >En proceso de modificación</a>
            </li>
            <li class="active"><a href="#">
                Solicitudes autorizadas</a>
            </li>





        </ul>
        <p>
            <br>
        </p>
    </div>
    @foreach($solicitudes as $solicitud)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <p>Nombre del departamento: <b>{{ $solicitud->nom_departamento }}</b></p>
                        <p>Jefe(a) del departamento o de la jefatura: <b>{{ $solicitud->titulo }} {{ $solicitud->nombre_personal }}</b></p>
                        <p style=""><span class="glyphicon glyphicon-file" style="font-size: 30px;"></span> Solicitud: <b>{{ $solicitud->descripcion_solicitud }}</b></p>
                        <p style="">Proyecto: <b>{{ $solicitud->nombre_proyecto }}</b></p>
                        <p style="">Meta: <b>{{ $solicitud->meta }}</b></p>
                        <p style="">Mes: <b>{{ $solicitud->mes }}</b></p>

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