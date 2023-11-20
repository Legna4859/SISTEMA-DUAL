<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="dependencia">Dependencia de la comisión</label>
            <input type="hidden"  id="id_oficio" name="id_oficio"  value="{{  $dependencias->id_oficio }}">
            <input type="hidden"  id="id_dependencia_domicilio" name="id_dependecia_domicilio"  value="{{  $dependencias->id_depend_domicilio }}">
            <textarea class="form-control" id="dependencia" name="dependencia" rows="2"  required >{{ $dependencias->dependencia }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="dependencia">Domicilio de la dependencia de la comisión</label>
             <textarea class="form-control" id="domiclio" name="domicilio" rows="2"  required >{{ $dependencias->domicilio }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Estado de la  dependencia de la comisión<b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="estadss" name="estadss" >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($estados as $estados)
                    @if($dependencias->id_estado==$estados->id_estado)
                        <option value="{{$estados->id_estado}}" selected="selected">{{$estados->nombre_estado}}</option>
                    @else
                        <option value="{{$estados->id_estado}}">{{$estados->nombre_estado}}</option>
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
                <label for="exampleInputEmail1">Municipio o Ciudad de la comisión<b style="color:red; font-size:23px;">*</b></label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="municipios" name="municipios" value="" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($municipios as $municipios)
                        @if($dependencias->id_municipio==$municipios->id_municipio)
                            <option value="{{$municipios->id_municipio}}" selected="selected">{{$municipios->nombre_municipio}}</option>
                        @else
                            <option value="{{$municipios->id_municipio}}">{{$municipios->nombre_municipio}}</option>
                        @endif
                    @endforeach

                </select>
            </div>
        </div>
    </div>
    <br>
</div>
<script type="text/javascript">
    $(document).ready( function() {

        $("#estadss").change(function (e) {
            console.log(e);
            var id_estado = e.target.value;
            $.get('/ajax-subcat?id_estado=' + id_estado, function (data) {

                $('#municipios').empty();
                $.each(data, function (datos_alumno, subcatObj) {
                    //  alert(subcatObj);
                    $('#municipios').append('<option value="' + subcatObj.id_municipio + '" data-muni="' + subcatObj.nombre_municipio + '" >' + subcatObj.nombre_municipio + '</option>');
                });
            });
        });
    });
</script>