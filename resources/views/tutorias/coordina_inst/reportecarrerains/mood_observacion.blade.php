<form id="form_mod_observacion" class="form" action="{{url("/tutorias/reporteinstitucional/guardar_mod_observacion/".$observaciones->id_repinstitucional)}}" role ="from" method="POST">
        {{csrf_field()}}

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="">Observación</label>
            <textarea class="form-control" id="observacion_mod" name="observacion_mod" rows="3" placeholder="Ingresa observacion">{{ $observaciones->observaciones }}</textarea>
        </div>
    </div>
</div>
</form>