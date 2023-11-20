<form id="form_eliminar_partida_solicitud" class="form" action="{{url("/presupuesto_autorizado/guardar_eliminacion_partida/".$partida->id_solicitud_partida)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 style="text-align: center">{{ $partida->clave_presupuestal }} {{ $partida->nombre_partida }}</h3>
            <h3 style="text-align: center">¿Quieres eliminar la partida presupuestal de la solicitud?</h3>
        </div>
    </div>
</form>