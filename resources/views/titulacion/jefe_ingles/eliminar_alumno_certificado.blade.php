<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$alumno->cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}}  {{$alumno->amaterno}}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <input class="form-control" type="hidden"  id="id_certificado" name="id_certificado"  value="{{ $alumno->id_certificado_acreditacion }}">
            <label>¿ Eliminar registro del estudiante ?</label>

        </div>
    </div>
</div>