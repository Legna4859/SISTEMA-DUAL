@extends('layouts.app')
@section('title', 'Historial de presupuesto autorizado')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_autorizado/inicio_presupuesto_autorizado_historial")}}">Años de los historiales de los presupuestos autorizados</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Menú del historial del presupuesto autorizado del {{  $year->descripcion }} </span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historial del presupuesto autorizado del {{ $year->descripcion }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h5 class="card-title text-center">Presupuesto autorizado</h5>
                    <p><button class="btn btn-primary presupuesto_autorizado" id="{{ $year->id_year }}">Ver</button></p>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h5 class="card-title">Presupuesto autorizado modificado</h5>
                    <p><button class="btn btn-primary presupuesto_autorizado_mod" id="{{ $year->id_year }}">Ver</button></p>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h5 class="card-title text-center">Solicitudes autorizadas</h5>
                    <p><button class="btn btn-primary solicitudes_autorizadas" id="{{ $year->id_year }}">Ver</button></p>

                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".presupuesto_autorizado").click(function (){
                // alert($("#grupos").val());
                var id_year = $(this).attr('id');

                window.location.href='/presupuesto_autorizado/presupesto_partida_historial/'+id_year;
            });
            $(".presupuesto_autorizado_mod").click(function (){
                // alert($("#grupos").val());
                var id_year = $(this).attr('id');
                window.location.href='/presupuesto_autorizado/presupesto_partida_copia_historial/'+id_year;
            });
            $(".solicitudes_autorizadas").click(function (){
                // alert($("#grupos").val());
                var id_year = $(this).attr('id');
                window.location.href='/presupuesto_autorizado/solicitudes_autorizadas_departamentos_historial/'+id_year;
            });


        });

    </script>
@endsection