
<div class="row">
    <input class="form-control"   type="hidden"  id="id_academica" name="id_academica"  value="{{ $academia->id_academia }}"  required>

    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Nombre del profesor</label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="id_profesor" name="id_profesor" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($plantillas as $plantilla)
                    @if($plantilla->id_personal==$academia->id_profesor)
                        <option value="{{$academia->id_profesor}}" selected="selected">{{$plantilla->nombre}}</option>
                    @else
                        <option value="{{$plantilla->id_personal}}">{{$plantilla->nombre}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <div class="dropdown">
                <label for="exampleInputEmail1">Cargos de Academia<b style="color:red; font-size:23px;">*</b></label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="id_cargo" name="id_cargo" value="" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($cargos_academia as $cargos_academia)
                        @if($cargos_academia->id_cargo_academia==$academia->id_cargo_academia)
                            <option value="{{$academia->id_cargo_academia}}" selected="selected">{{$cargos_academia->cargo}}</option>
                        @else
                            <option value="{{$cargos_academia->id_cargo_academia}}">{{$cargos_academia->cargo}}</option>
                        @endif
                    @endforeach

                </select>
            </div>
        </div>
    </div>
    <br>
</div>