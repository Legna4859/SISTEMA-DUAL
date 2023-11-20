
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="dependencia">Descripcion de la Accion</label>
            <input type="hidden"  id="id_accion" name="id_accion"  value="{{  $accion->id_accion }}">
            <textarea class="form-control" id="accion" name="accion" rows="2"  required >{{ $accion->nom_accion }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="unidad">Unidad de Medida</label>
            <select class="form-control" id="select_unidad" name="select_unidad" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($unidades as $unidad)
                    @if($accion->id_unimed==$unidad->id_unimed)
                        <option value="{{$unidad->id_unimed}}" selected="selected" >{{$unidad->nom_unimed}}</option>
                    @else
                        <option value="{{$unidad->id_unimed}}"> {{$unidad->nom_unimed}}</option>
                    @endif
                @endforeach
            </select>
            <br>
            <br>
        </div>



    </div>
</div>
