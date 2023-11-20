<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <p style="text-align: center">Nombre del tutor: {{ $datos_grupo->nombre }}</p>
        <p style="text-align: center">Generación: {{ $datos_grupo->generacion }}</p>
        <p style="text-align: center">Grupo: {{ $datos_grupo->grupo }}</p>
            <input type="hidden" id="id_asigna_tutor" name="id_asigna_tutor" value="{{ $id_asigna_tutor }}">
               </div>
</div>
<div class="row">
    <div class="col-md-10 offset-1">
        <label for="exampleInputEmail1">Elige el semestre </label>
        <select class="form-control" id="id_grupo_tutorias" name="id_grupo_tutorias" >
            <option  disabled selected hidden>Selecciona semestre</option>
            @foreach($semestres as $semestre)
                <option value="{{$semestre->id_grupo_tutorias}}">{{$semestre->descripcion}}</option>
            @endforeach

        </select>
        <p><br></p>
    </div>
</div>