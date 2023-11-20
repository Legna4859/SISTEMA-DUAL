<div class="col-md-6" id="h_inicio">
    <label for="inicio">Hora de inicio</label>
    <div class="input-group">
        <select name="inicio" id="inicio" class="form-control inicio">
            <option value="" selected disabled="true">Selecciona...</option>

            @foreach($horario as $hora)
                @if(in_array($hora,$horas_ocupadas))
                    <option value="{{$hora}}" disabled="true">{{$hora}}&nbsp;(Hora ocupada)</option>
                @else
                    <option value="{{$hora}}">{{$hora}}</option>
                @endif

            @endforeach
        </select>
        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    </div>
</div>
<div class="col-md-6 h_fin" id="h_fin">
    <label for="fin">Hora de Fin</label>
    <div class="input-group">
        <select name="fin" id="fin" class="form-control fin" disabled="true">
            <option value="" selected disabled="true">Selecciona...</option>
        </select>
        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    </div>
</div>

