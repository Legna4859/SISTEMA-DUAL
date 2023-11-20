<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>¿Seguro que quiere autorizar la entrega del PDF del su proyecto del estudiante?</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$dato_alumno->no_cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$dato_alumno->nombre_al}} {{$dato_alumno->apaterno}}  {{$dato_alumno->amaterno}}</h4>
    </div>
</div>
<input class="form-control" type="hidden"  id="id_reg_dato_alum" name="id_reg_dato_alum"  value="{{ $dato_alumno->id_reg_dato_alum }}">
<input class="form-control" type="hidden"  id="id_opcion_titulacion" name="id_opcion_titulacion"  value="{{ $dato_alumno->id_opcion_titulacion }}">
<input class="form-control" type="hidden"  id="estado_archivo" name="estado_archivo"  value="{{ $estado_archivo }}">

<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <div class="form-group">
            <div class="dropdown">
                <h2 for="hora">Selecciona  asesor interno</h2>
                <select name="presidente" id="presidente" class="form-control " >
                    <option  disabled selected hidden>Selecciona asesor interno</option>
                    @foreach($personales as $personal)
                        <option value="{{$personal->id_personal}}" >{{$personal->nombre}}</option>
                    @endforeach
                </select>
                <br>
            </div>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">

        <div class="form-group">
            <div class="dropdown">
                <h2 for="hora">Selecciona  revisor interno</h2>
                <select name="secretario" id="secretario" class="form-control " >
                    <option  disabled selected hidden>Selecciona revisor interno</option>
                    @foreach($personas as $personal)
                        <option value="{{$personal->id_personal}}" >{{$personal->nombre}}</option>
                    @endforeach
                </select>
                <br>
            </div>
        </div>
    </div>
      @if($estado_archivo == 1)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="form-group">
                    <h2>Selecciona el PDF del documento</h2>
                    <input class="form-control"  id="file" name="file" type="file"   accept="application/pdf" required/>



                </div>
            </div>
        </div>
    @endif

</div>