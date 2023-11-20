@extends('layouts.app')
@section('title', 'Historial de las requisiciones de los proyectos')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_autorizado/inicio_presupuesto_autorizado_historial")}}">Años de los historiales de los presupuestos autorizados</a>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_autorizado/menu_presupuesto_autorizado_historial/".$id_year)}}">Historial del presupuesto autorizado del {{ $year }} </a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Departamentos o jefaturas con solicitudes autorizadas</span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historial departamentos o jefaturas con solicitudes autorizadas</h3>
                </div>
                <div class="panel-body">

                    <div class="col-md-8 col-md-offset-2">
                        <ul class="nav nav-pills nav-stacked" style="background-color:white;border: 2px solid black; border-radius: 7px; padding-right: 0px">
                            @foreach($departamentos as $departamento)
                                <li style="margin-top: 0px"><a style="border-bottom: 2px solid black;" data-toggle="pill" href="#" onclick="window.location='{{ url('/presupuesto_autorizado/solicitudes_ver_departamento_historial/'.$departamento->id_unidad_admin.'/'.$id_year ) }}'" > {{ $departamento->nom_departamento }}</a></li>

                            @endforeach
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection