<form id="form_mod_observacion" class="form" action="{{url("/tutorias/reportecoordinador/guardar_mod_observacion/".$observacion->id_repcarrera)}}" role ="from" method="POST">
        {{csrf_field()}}

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="">Observación</label>
            <textarea class="form-control" id="observacion_mod" name="observacion_mod" rows="3" placeholder="Ingresa observacion">{{ $observacion->observaciones }}</textarea>
        </div>
    </div>
</div>
</form>