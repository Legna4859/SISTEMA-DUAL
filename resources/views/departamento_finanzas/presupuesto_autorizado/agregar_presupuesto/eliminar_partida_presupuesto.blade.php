<form id="form_eliminar_partida" class="form" action="{{url("/presupuesto_autorizado/guardar_eliminar_presupesto_partida/".$partida_reg->id_presupuesto_aut)}}" role="form" method="POST" >
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 style="text-align: center">{{ $partida_reg->clave_presupuestal }} {{ $partida_reg->nombre_partida }}</h3>
        <h3 style="text-align: center">¿Quieres eliminar la partida seleccionada?</h3>
    </div>
</div>
</form>