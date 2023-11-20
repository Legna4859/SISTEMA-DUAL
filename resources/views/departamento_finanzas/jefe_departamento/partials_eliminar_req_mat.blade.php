<form id="form_eliminar_requisicion" class="form" action="{{url("/presupuesto_anteproyecto/guardar_eliminacion_requisicion_materiales/".$requisicion->id_actividades_req_ante)}}" role="form" method="POST" >
{{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h4>PARTIDA PRESUPUESTAL: {{ $requisicion->clave_presupuestal }}  {{ $requisicion->nombre_partida }}</h4>
            <h4>MES : {{ $requisicion->mes }}</h4>
            <h4>PROYECTO: {{ $requisicion->nombre_proyecto }}</h4>
            <h5>META: {{ $requisicion->meta }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-danger">
                <strong style="text-align: center">Seguro(a) que quieres eliminar la requisición  de materiales</strong>
            </div>
        </div>
    </div>
</form>