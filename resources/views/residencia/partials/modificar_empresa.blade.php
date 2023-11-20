
<div class="row">
    <input type="hidden" id="id_empresa" name="id_empresa" value="{{$empresa->id_empresa}}">

    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="nombre">Nombre de la empresa</label>
            <textarea class="form-control" id="nombre" name="nombre"  rows="2" placeholder="Ingresa nombre de la empresa" required>{{ $empresa->nombre }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="domicilio">Domiclio de la empresa</label>
            <textarea class="form-control" id="domicilio" name="domicilio"  rows="2" placeholder="Ingresa el domicilio de la empresa"  required>{{ $empresa->domicilio }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="telefono">Telefono de la empresa</label>
            <input class="form-control" type="text" id="telefono" name="telefono"  placeholder="Ingresa el telefono" value="{{ $empresa->tel_empresa }}"  required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="correo">Correo</label>
            <input class="form-control"  type="email" id="correo" name="correo"  placeholder="Ingresa correo" value="{{ $empresa->correo }}"  required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="director_general">Director General</label>
            <input class="form-control"  type="text" id="director_general" name="director_general"  placeholder="Ingresa director general" value="{{ $empresa->dir_gral }}"  required>
        </div>
    </div>
</div>
