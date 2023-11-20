<form id="form_activar_periodo" class="form" action="{{url("/presupuesto_anteproyecto/guardar_activacion_periodo_anteproyecto/".$periodo->id_peri_anteproyecto )}}" role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-10 col-md-offset-1">
       <h3 style="text-align: center">Activar periodo</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-warning">
                <h3 style="text-align: center;">{{ $fecha_i }} al {{ $fecha_f }} </h3>
                <h3 style="text-align: center;">Año: {{ $periodo->year }} </h3>
        </div>
    </div>
</div>
</form>