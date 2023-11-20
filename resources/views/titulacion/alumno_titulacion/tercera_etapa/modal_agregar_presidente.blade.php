
<div class="row">
    <input class="form-control" type="hidden"  id="id_fecha_jurado_alumn" name="id_fecha_jurado_alumn"  value="{{ $registro_fecha->id_fecha_jurado_alumn }}" />

    <div class="col-md-10 col-md-offset-1">

    </div>
</div>
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <div class="form-group">
            <div class="dropdown">
                <h2 for="hora">Selecciona presidente de tu jurado</h2>
                <select name="presidente" id="presidente" class="form-control " >
                    <option  disabled selected hidden>Selecciona presidente</option>
                    @foreach($personales as $personal)
                            <option value="{{$personal->id_personal}}" >{{$personal->nombre}}</option>
                    @endforeach
                </select>
                <br>
            </div>
        </div>
    </div>
</div>
