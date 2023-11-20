<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>No. cuenta: {{ $datos_alumno->no_cuenta }}</h4>
        <h4>Estudiante: {{ $datos_alumno->nombre_al }} {{ $datos_alumno->apaterno }} {{ $datos_alumno->amaterno }} </h4>
    </div>

</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <h3>Liberar titulado</h3>
        <div class="form-group">
            <input class="form-control required" id="id_alumno" name="id_alumno" type="hidden" value="{{ $datos_alumno->id_alumno }}"/>
        </div>
    </div>
</div>