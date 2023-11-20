<form  id="form_guardar_mod_contrato" action="{{url("/presupuesto_autorizado/guardar_contrato/".$documentos->id_solicitud_documento)}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="dropdown">
                <label for="exampleInputEmail1">Selecciona tipo de contrato</label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="id_tipo_contrato" name="id_tipo_contrato" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($tipos_contratos as $contrato)
                        @if($documentos->id_tipo_contrato == $contrato->id_tipo_contrato)
                            <option value="{{$contrato->id_tipo_contrato}}" selected="selected" >{{ $contrato->tipo_contrato }}</option>
                        @else
                            <option value="{{$contrato->id_tipo_contrato}}" >{{ $contrato->tipo_contrato }} </option>
                        @endif
                    @endforeach
                </select>
                <br>
            </div>
        </div>
        <br>
    </div>
    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Seleccionar  contrato</label>
                    <input class="form-control"  id="doc_contrato" name="doc_contrato" type="file"   accept="application/pdf" required/>
                </div>
            </div>
        </div>
    </div>
</form>
