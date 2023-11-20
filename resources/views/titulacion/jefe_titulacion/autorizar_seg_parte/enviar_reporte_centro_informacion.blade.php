<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4> ¿Seguro que quiere autorizar los datos registrados del estudiante?</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$reg_alumno->no_cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$reg_alumno->nombre_al}} {{$reg_alumno->apaterno}}  {{$reg_alumno->amaterno}}</h4>
    </div>
</div>
<input class="form-control" type="hidden"  id="id_reg_dato_alum" name="id_reg_dato_alum"  value="{{ $reg_alumno->id_reg_dato_alum }}">

