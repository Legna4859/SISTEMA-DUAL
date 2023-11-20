<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h4>ESTUDIANTE: {{$nombre_alumno}}<br> UNIDAD: {{$id_unidad}}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-3">

        <div class="form-group">
            <label>Modificar calificación</label>
            <input class="form-control"  type="number" min="0" max="100" id="calificacion" name="calificacion"  value="{{$calificacion}}" required>
            <input class="form-control" type="hidden"  id="id_carga_academica" name="id_carga_academica"  value="{{ $id_carga_academica }}">
            <input class="form-control" type="hidden"  id="id_unidad" name="id_unidad"  value="{{ $id_unidad}}">
            <input  class="form-control" type="hidden"  id="registrada" name="registrada"  value="{{ $cuenta_carga }}">
            <input  class="form-control" type="hidden"  id="calificacion_anterior" name="calificacion_anterior"  value="{{ $calificacion}}">
        </div>
    </div>
</div>
