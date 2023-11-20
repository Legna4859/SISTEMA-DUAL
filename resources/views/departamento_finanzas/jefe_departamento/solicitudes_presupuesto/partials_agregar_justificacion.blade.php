<form  id="form_guardar_justificacion" action="{{url("/presupuesto_autorizado/guardar_justificacion/".$id_solicitud)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <input class="form-control" id="estado_solicitud" name="estado_solicitud" type="hidden"  value="{{ $estado_solicitud }}" required>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="dropdown">
                <label for="exampleInputEmail1">Va ingresar justificación para dictamen pdf</label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="justificacion" name="justififcacion" required>
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
                    <input class="form-control"  id="doc_justificacion" name="doc_justificacion" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#justificacion").change(function (e) {

            var justificacion = e.target.value;
            if(justificacion == 1){
                $("#ver_opciones").css("display", "none");
            }
            if(justificacion == 2){
                $("#ver_opciones").css("display", "inline");
            }
        });
    });
</script>