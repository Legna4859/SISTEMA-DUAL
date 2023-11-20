<div class="row">
    <div class="col-md-10 col-md-offset-1">
     <p><b>Número de cuenta:</b> {{ $alumno->cuenta }}</p>
        <p><b>Nombre del estudiante:</b> {{ $alumno->nombre }} {{$alumno->apaterno}} {{$alumno->amaterno}}</p>
        <p><b>Carrera: </b>{{$alumno->carrera}}</p>
        <input type="hidden" id="id_promedio_general" name="id_promedio_general" value="{{$alumno->id_promedio_general}}">
        <p>Autorizar la impresión de acta de residencia</p>
    </div>
</div>
