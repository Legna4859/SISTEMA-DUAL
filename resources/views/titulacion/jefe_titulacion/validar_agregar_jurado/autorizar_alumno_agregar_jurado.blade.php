
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$alumno->no_cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$alumno->nombre_al}} {{$alumno->apaterno}}  {{$alumno->amaterno}}</h4>
    </div>
</div>
<input class="form-control" type="hidden"  id="id_fecha_jurado_alumn" name="id_fecha_jurado_alumn"  value="{{ $alumno->id_fecha_jurado_alumn }}"/>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>¿ Seguro que quiere autorizar, para que el estudiante agregue su jurado de titulación? </h4>
    </div>
</div>