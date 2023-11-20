<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$alumno->cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}}  {{$alumno->amaterno}}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label>Selecciona el Certificado de Acreditación del Idioma Ingles</label>
            <input class="form-control" type="hidden"  id="id_alumno" name="id_alumno"  value="{{ $alumno->id_alumno }}">
            <input type="file" id="documento" name="documento"  class="form-control" accept="application/pdf"/>
        </div>
    </div>
</div>