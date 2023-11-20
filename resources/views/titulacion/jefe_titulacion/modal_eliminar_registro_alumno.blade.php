<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>¿Seguro que quiere eliminar el registro del estudiante?</h4>
        </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$dato_alumno->cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$dato_alumno->nombre}} {{$dato_alumno->apaterno}}  {{$dato_alumno->amaterno}}</h4>
    </div>
</div>
    <input class="form-control" type="hidden"  id="id_descuento_alum" name="id_descuento_alum"  value="{{ $dato_alumno->id_descuento_alum }}">