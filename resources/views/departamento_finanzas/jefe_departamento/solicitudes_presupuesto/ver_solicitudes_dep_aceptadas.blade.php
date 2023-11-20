@extends('layouts.app')
@section('title', 'Solicitudes autorizadas liberadas')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Solicitudes de requisiciones del presupuesto autorizado ya liberadas</h3>
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
                            <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.location=('{{url('/presupuesto_autorizado/ver_docu_solicitud_aut_departamento/'.$solicitud->id_solicitud)}}')">Ver datos de la solicitud</button></p>
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