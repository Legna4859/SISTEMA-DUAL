
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <p style="text-align: center"><b>PROFESOR: {{ $profesor->nombre }}</b></p>

    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <input type="hidden" class="form-control" id="id_abreviacion_prof"  name="id_abreviacion_prof" value="{{ $profesor->id_abreviacion_prof }}" required>

            <div class="dropdown">
                <label for="selectLugar_s">Selecciona Titulo</label>
                <select class="form-control" id="id_abreviacion" name="id_abreviacion"  required >
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($abreviaciones as $abreviacion)
                        @if($profesor->id_abreviacion == $abreviacion->id_abreviacion)
                            <option value="{{$abreviacion->id_abreviacion}}" selected="selected" >{{$abreviacion->titulo}}</option>
                        @else
                            <option value="{{$abreviacion->id_abreviacion}}"> {{$abreviacion->titulo}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

        <br>
    </div>

</div>