<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3> Folio del titulo:{{ $datos_folio->abreviatura_folio_titulo }}</h3>
        <input type="hidden" id="id_numero_titulo" name="id_numero_titulo" value="{{ $datos_folio->id_numero_titulo }}">
    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Selecciona  tipo de titulación<b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="id_tipo_titulacion" name="id_tipo_titulacion" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($tipos_titulacion as $tipo_titulacion)

                        <option value="{{$tipo_titulacion->id_tipo_titulacion}}">{{$tipo_titulacion->tipo_titulacion}} </option>

                @endforeach
            </select>
        </div>

    </div>
</div>


<div class="row" id="selecciona_alumno_integral" style="display: none">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="id_decision">Selecciona estudiante</label>
            <select class="form-control  " placeholder="selecciona una Opcion" id="id_alumno_integral" name="id_alumno_integral" value="" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($estudiantes_integrales as $estudiante)
                    <option value="{{$estudiante->id_alumno}}">{{$estudiante->apaterno }} {{$estudiante->amaterno }} {{$estudiante->nombre_al }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row" id="selecciona_alumno_anterior" style="display: none">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="id_decision">Selecciona estudiante</label>
            <select class="form-control  " placeholder="selecciona una Opcion" id="id_alumno_anterior" name="id_alumno_anterior" value="" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($array_alumnos as $alumno)
                    <option value="{{ $alumno['id_alumno'] }}">{{ $alumno['nombre'] }} {{ $alumno['cuenta'] }} </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <p><br></p>
</div>
<script>

    $(document).ready(function() {
        $("#id_tipo_titulacion").change(function(){
            //$("#aceptar").css("display", "inline");
           // $("#siguiente").css("display", "none");
            var id_tipo_titulacion = $( this ).val();
            if(id_tipo_titulacion == 1){
                $("#selecciona_alumno_integral").css("display", "inline");
                $("#selecciona_alumno_anterior").css("display", "none");
            }else{
                $("#selecciona_alumno_integral").css("display", "none");
                $("#selecciona_alumno_anterior").css("display", "inline");
            }




        });
    });
</script>