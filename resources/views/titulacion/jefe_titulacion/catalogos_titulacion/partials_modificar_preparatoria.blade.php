<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="descripcion_oficio">Nombre del comisionado</label>
            <input type="hidden" id="id_preparatoria" name="id_preparatoria" value="{{ $preparatoria->id_preparatoria }}">
            <textarea class="form-control" id="nombre_preparatoria"  name="nombre_preparatoria" rows="2"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value=""  required>{{ $preparatoria->preparatoria }}</textarea>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Estado de la  dependencia de la comisión<b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="estados" name="estados" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($estados as $estados)
                    @if($preparatoria->id_entidad_federativa ==$estados->id_entidad_federativa)
                        <option value="{{$estados->id_entidad_federativa}}" selected="selected">{{$estados->nom_entidad}}</option>
                    @else
                        <option value="{{$estados->id_entidad_federativa}}">{{$estados->nom_entidad}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Selecciona tipo de estudio de antecedente<b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="id_tipo_estudio_antecedente" name="id_tipo_estudio_antecedente" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($tipo_estudio_antecedente as $tipo)
                    @if($tipo->id_tipo_estudio_antecedente ==$preparatoria->id_tipo_estudio_antecedente)
                        <option value="{{$tipo->id_tipo_estudio_antecedente}}" selected="selected">{{$tipo->tipo_estudio_antecedente }} (tipo educativo: {{$tipo->tipo_educativo_atecedente }})</option>
                    @else
                        <option value="{{$tipo->id_tipo_estudio_antecedente}}">{{$tipo->tipo_estudio_antecedente }} (tipo educativo: {{$tipo->tipo_educativo_atecedente }})</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>