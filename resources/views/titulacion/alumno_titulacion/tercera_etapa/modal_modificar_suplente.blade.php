<div class="row">
    <input class="form-control" type="hidden" id="id_jurado_alumno" name="id_jurado_alumno"  value="{{ $registro_jurado->id_jurado_alumno }}" />

    <div class="col-md-10 col-md-offset-1">

    </div>
</div>
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <div class="form-group">
            <div class="dropdown">
                <h2 for="hora">Selecciona presidente de tu jurado</h2>
                <select name="suplente" id="suplente" class="form-control " >
                    <option  disabled selected hidden>Selecciona presidente</option>
                    @foreach($personales as $personal)

                        @if($registro_jurado->id_personal == $personal->id_personal)
                            <option value="{{$personal->id_personal}}" selected="selected" >{{$personal->nombre}}</option>
                        @else
                            <option value="{{$personal->id_personal}}"> {{$personal->nombre}}</option>
                        @endif
                    @endforeach
                </select>
                <br>
            </div>
        </div>
    </div>
</div>
