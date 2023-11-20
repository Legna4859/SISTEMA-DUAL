<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3> No. Cuenta: {{ $reg->no_cuenta }}</h3>
        <h3> Nombre del estudiante: {{ $reg->nombre_al  }} {{ $reg->apaterno  }} {{ $reg->amaterno  }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Selecciona  el estado del folio del titulo <b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="estados" name="estados" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($estados_folio_titulo as $estado)
                    @if($datos_numero_titulos->id_estado_numero_titulo ==$estado->id_estado_numero_titulo)
                        <option value="{{$estado->id_estado_numero_titulo}}" selected="selected">{{$estado->estado_numero_titulo}}</option>
                    @else
                        <option value="{{$estado->id_estado_numero_titulo}}">{{$estado->estado_numero_titulo}}</option>
                    @endif

                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="descripcion_oficio">Comentario modificación</label>
            <input type="hidden" id="id_numero_titulo" name="id_numero_titulo" value="{{ $datos_numero_titulos->id_numero_titulo }}">
            <textarea class="form-control" id="comentario_modificacion"  name="comentario_modificacion" rows="2"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value=""  required></textarea>

        </div>
    </div>
</div>