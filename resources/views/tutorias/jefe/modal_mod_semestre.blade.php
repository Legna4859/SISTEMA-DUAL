<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <p style="text-align: center">Nombre del tutor: {{ $datos_grupo->nombre }}</p>
        <p style="text-align: center">Generación: {{ $datos_grupo->generacion }}</p>
        <p style="text-align: center">Grupo: {{ $datos_grupo->grupo }}</p>
        <input type="hidden" id="id_grupo_semestre" name="id_grupo_semestre" value="{{ $datos_grupo->id_grupo_semestre }}">
    </div>
</div>
<div class="row">
    <div class="col-md-10 offset-1">
        <label for="exampleInputEmail1">Elige el semestre </label>
        <select class="form-control" id="id_grupo_tutorias" name="id_grupo_tutorias" >
            <option  disabled selected hidden>Selecciona semestre</option>
            @foreach($semestres as $semestre)
                @if($datos_grupo->id_grupo_tutorias == $semestre->id_grupo_tutorias)
                    <option value="{{$semestre->id_grupo_tutorias}}" selected="selected">{{$semestre->descripcion}}</option>
                @else
                    <option value="{{$semestre->id_grupo_tutorias}}" data-esta="{{$semestre->descripcion}}">{{$semestre->descripcion}}</option>
                @endif
            @endforeach

        </select>
        <p><br></p>
    </div>
</div>