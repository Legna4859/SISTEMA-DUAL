<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>NO CUENTA: {{$dato_alumno->cuenta}} <br> NOMBRE DEL ESTUDIANTE: {{$dato_alumno->nombre}} {{$dato_alumno->apaterno}}  {{$dato_alumno->amaterno}}</h4>
    </div>
</div>
<div class="row">
    <input class="form-control" type="hidden"  id="id_descuento_alum" name="id_descuento_alum"  value="{{ $dato_alumno->id_descuento_alum }}">
    <input class="form-control" type="hidden"  id="fecha_anterior" name="fecha_anterior"  value="{{ $dato_alumno->fecha_entrego }}">

    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="selectLugar_s">Tipos de descuentos</label>
            <select class="form-control" id="id_tipo_descuento" name="id_tipo_descuento"  required >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($tipos_descuentos as $tipo_descuento)
                    @if($tipo_descuento->id_tipo_desc == $dato_alumno->id_tipo_desc)
                        <option value="{{$tipo_descuento->id_tipo_desc}}" selected="selected" >{{$tipo_descuento->tipo_desc}}</option>
                    @else
                        <option value="{{$tipo_descuento->id_tipo_desc}}"> {{$tipo_descuento->tipo_desc}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="selectLugar_s">Fecha de ultimo dia  de entrega de documentos</label>
            <input class="form-control datepicker fecha_ultimo " type="text" id="fecha_ultimo" name="fecha_ultimo" data-date-format="dd-mm-yyyy" value="{{ $dato_alumno->fecha_entrego }}">
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <label for="exampleInputEmail1">Telefono<b style="color:red; font-size:23px;">*</b></label>
        <input type="tel" class="form-control" id="telefono"  name="telefono" value="{{ $dato_alumno->telefono }}" required>

    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="selectLugar_s">Selecciona Preparatoria</label>
            <select class="form-control" id="id_preparatoria" name="id_preparatoria"  required >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($preparatorias as $preparatoria)
                    @if($preparatoria->id_preparatoria == $dato_alumno->id_preparatoria)
                        <option value="{{$preparatoria->id_preparatoria }}" selected="selected">{{$preparatoria->preparatoria}}  (( Entidad Federativa: {{ $preparatoria->nom_entidad }} ))</option>
                    @else
                        <option value="{{$preparatoria->id_preparatoria }}">{{$preparatoria->preparatoria}}  (( Entidad Federativa: {{ $preparatoria->nom_entidad }} ))</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        $( '.fecha_ultimo').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',
            startDate: '+0d',
        });
    });

</script>