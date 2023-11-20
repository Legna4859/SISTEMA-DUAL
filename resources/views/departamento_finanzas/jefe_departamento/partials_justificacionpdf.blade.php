<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h4>PARTIDA PRESUPUESTAL: {{ $requisicion->clave_presupuestal }}  {{ $requisicion->nombre_partida }}</h4>
        <h4>MES Y AÑO DE ADQUISICIÓN: {{ $requisicion->mes }}</h4>
        <h4>PROYECTO: {{ $requisicion->nombre_proyecto }}</h4>
        <h5>META: {{ $requisicion->meta }}</h5>
    </div>
</div>
<form  id="form_guardar_justificacion_pdf" action="{{url("/presupuesto_anteproyecto/guardar_justificacion_pdf/".$requisicion->id_actividades_req_ante)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="dropdown">
                <label for="exampleInputEmail1">Va ingresar justificación para dictamen pdf </label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="justificacion_pdf" name="justififcacion_pdf" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($respuestas as $respuesta)
                        <option value="{{$respuesta->id_respuesta}}" data-esta="{{$respuesta->respuesta }}">{{ $respuesta->respuesta }} </option>
                    @endforeach
                </select>
                <br>
            </div>
        </div>
        <br>
    </div>
    <div class="row" style="display: none" id="ver_opciones">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar  justificacion para dictamen pdf</label>
                    <input class="form-control"  id="doc_justificacion_pdf" name="doc_justificacion_pdf" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#justificacion_pdf").change(function (e) {

            var justificacion_pdf = e.target.value;
            if(justificacion_pdf == 1){
                $("#ver_opciones").css("display", "none");
            }
            if(justificacion_pdf == 2){
                $("#ver_opciones").css("display", "inline");
            }
        });
    });
</script>
