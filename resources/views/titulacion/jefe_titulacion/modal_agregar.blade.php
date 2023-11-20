<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$alumno->cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}}  {{$alumno->amaterno}}</h4>
    </div>
</div>
@if($estado_titulacion == 2)
<div class="row">
    <input class="form-control" type="hidden"  id="id_alumno" name="id_alumno"  value="{{ $alumno->id_alumno }}">
    <div class="col-md-10 col-md-offset-1">
    <div class="dropdown">
        <label for="selectLugar_s">Tipos de descuentos</label>
        <select class="form-control" id="id_tipo_descuento" name="id_tipo_descuento"  required >
            <option disabled selected hidden>Selecciona una opción</option>
            @foreach($tipos_descuentos as $tipo_descuento)
                    <option value="{{$tipo_descuento->id_tipo_desc}}"> {{$tipo_descuento->tipo_desc}}</option>
            @endforeach
        </select>
    </div>
</div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <label for="exampleInputEmail1">Telefono<b style="color:red; font-size:23px;">*</b></label>
        <input type="tel" class="form-control" id="telefono"  name="telefono"  required>

    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="selectLugar_s">Selecciona bachillerato o preparatoria cursada</label>
            <select class="form-control" id="id_preparatoria" name="id_preparatoria"  required >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($preparatorias as $preparatoria)
                    <option value="{{$preparatoria->id_preparatoria }}">{{$preparatoria->preparatoria}}  (( Entidad Federativa: {{ $preparatoria->nom_entidad }} ))</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
    @endif
@if($estado_titulacion == 1)
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-danger">
        <div class="panel-heading">No puede ser registrado porque es egresado anterior a 2010</div>

    </div>
        </div>
    </div>
    @endif
