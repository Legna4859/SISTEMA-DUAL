<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <input type="hidden" id="id_profesor_ingles" name="id_profesor_ingles" value="{{ $profesor->id_profesores }}">

            <label for="nombre">Nombre del facilitador: {{ $profesor->nombre }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="horas">Horas asignadas: </label>
            @if($profesor->horas_maximas == 0)
                    <input class="form-control" type="number" min="0" max="49" id="horas_profesor" name="horas_profesor" placeholder="Asignar horas"  required />
                @else
                <input class="form-control" type="number" min="0" max="49" id="horas_profesor" name="horas_profesor"  value="{{ $profesor->horas_maximas }}" required />
            @endif
            </div>
        </div>
    </div>
</div>