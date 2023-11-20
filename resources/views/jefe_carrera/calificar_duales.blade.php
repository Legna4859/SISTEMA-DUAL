@foreach( $array_cali as $carga)
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="form-group">
             <label>Unidad {{$carga['id_unidad']}}</label>
            <input class="form-control"  type="number" max="100" min="0" id="unidad_{{$carga['id_unidad']}}" name="unidad_{{$carga['id_unidad']}}" value="{{$carga['calificacion']}}" required>
              </div>
    </div>

</div>
@endforeach
<input class="form-control"  type="hidden"  id="unidades" name="unidades" value="{{$unidades}}" required>
<input class="form-control"  type="hidden"  id="id_carga_academica" name="id_carga_academica" value="{{$id_carga_academica}}" required>


