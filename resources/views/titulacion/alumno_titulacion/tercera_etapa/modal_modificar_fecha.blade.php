

<div class="row">
    <input class="form-control" type="hidden"  id="id_fecha_jurado_alumn" name="id_fecha_jurado_alumn"  value="{{ $registro_fecha->id_fecha_jurado_alumn }}" />

    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <h2 for="deparamento">Selecciona fecha Titulación</h2>
            <div class='input-group date' style='font-size: 25px; size: 25px;' data-date-format="dd-mm-yyyy" id='datetimepicker11' >
                <input type='text' id="fecha_titulacion" name="fecha_titulacion" class="form-control"  value="{{ $registro_fecha->fecha_titulacion }}" required />
                <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
            </div>

        </div>
    </div>
</div>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

        <div class="form-group">
            <div class="dropdown">
                <h2 for="hora">Selecciona horario de titulación</h2>
                <select name="horario" id="horario" class="form-control " >
                    <option  disabled selected hidden>Selecciona hora de titulación</option>
                    @foreach($horarios as $horario)
                        @if($horario->id_horarios_dias == $registro_fecha->id_horarios_dias)
                            <option value="{{$horario->id_horarios_dias}}" selected="selected" >{{$horario->horario_dia}}</option>
                        @else
                        <option value="{{$horario->id_horarios_dias}}" >{{$horario->horario_dia}}</option>
                        @endif
                    @endforeach
                </select>
                <br>
            </div>
        </div>
    </div>
    </div>



<script>

    $(document).ready(function() {

        $('#datetimepicker11').datepicker({
            daysOfWeekDisabled: [0,6],
            autoclose: true,
            language: 'es',
            startDate: '+0d',
        });
    });

</script>