<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="cct">CCT de la Institución educativa</label>
            <input type="hidden" id="id_institucion" name="id_institucion" value="{{ $institucion->id_institucion }}">
            <textarea class="form-control" id="cct" name="cct" rows="3"  required>{{ $institucion->cct }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="nombre_escuela">Nombre de la Institución educativa</label>
            <textarea class="form-control" id="nombre_escuela" name="nombre_escuela" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required>{{ $institucion->nombre_escuela }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="domicilio">Domiclio de la Institución educativa</label>
            <textarea class="form-control" id="domicilio" name="domicilio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required>{{ $institucion->domicilio }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="municipio">Municipio de la Institución educativa</label>
            <textarea class="form-control" id="municipio" name="municipio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required>{{ $institucion->municipio }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="localidad">Localidad de la Institución educativa</label>
            <textarea class="form-control" id="localidad" name="localidad" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required>{{ $institucion->localidad }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="turno">Turno de la Institución educativa</label>
            <textarea class="form-control" id="turno" name="turno" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required>{{ $institucion->turno }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="servicio">Servicio de la Institución educativa</label>
            <textarea class="form-control" id="servicio" name="servicio" onkeyup="javascript:this.value=this.value.toUpperCase();" rows="3"  required>{{ $institucion->servicio }}</textarea>
        </div>
    </div>
</div>
