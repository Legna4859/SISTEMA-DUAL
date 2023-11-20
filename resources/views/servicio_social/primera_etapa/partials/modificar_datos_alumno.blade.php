<div class="row">
    <input class="form-control"  id="id_datos_alumnos" name="id_datos_alumnos" type="hidden"  value="{{$registro_tipo_empresa[0]->id_datos_alumnos  }}" required/>

    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="nombre_proyecto">Ingresa tu correo electronico. (En el se te notificará, el estado que se encuentra tu documentación, si tienes que corregir o se encuentra autorizada).<b style="color:red; font-size:23px;">*</b></label>
            <input class="form-control"  id="correo_electronico" name="correo_electronico" type="email"  placeholder="Ingresa tu correo electronico" style="" value="{{$registro_tipo_empresa[0]->correo_electronico  }}" required/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1" >
        <div class="dropdown">
            <label for="exampleInputEmail1">La empresa donde llevaras a cabo tu servicio social es:<b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="tipo_empresa" name="tipo_empresa" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($tipos_empresas as $tipo_empresa)
                    @if($tipo_empresa->id_tipo_empresa==$registro_tipo_empresa[0]->id_tipo_empresa)
                        <option value="{{$tipo_empresa->id_tipo_empresa}}" selected="selected" >{{$tipo_empresa->tipo_empresa}}</option>
                    @else
                        <option value="{{$tipo_empresa->id_tipo_empresa}}"> {{$tipo_empresa->tipo_empresa}}</option>
                    @endif
                   @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>