<label for="fin">Hora de termino</label>
<div class="input-group">
    <select name="fin" id="fin" class="form-control fin">
        <option value="" selected disabled="true">Selecciona...</option>
        @foreach($horario as $hora)
            <option value="{{$hora}}">{{$hora}}</option>
        @endforeach
    </select>
    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
</div>
