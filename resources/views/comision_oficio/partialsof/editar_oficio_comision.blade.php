
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="descripcion_oficio">Motivo de la comisión</label>
            <input type="hidden" id="id_oficio" name="id_oficio" value="{{ $oficio->id_oficio }}">
            <textarea class="form-control" id="descripcion_oficio" name="descripcion_oficio" rows="3"  required>{{ $oficio->desc_comision }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1 ">
        <label for="fechadesalida">Horario de salida a la comisión</label><br>
        <div class="col-md-5">
            <div class="form-group">
                <input  id="hora_s" type="text" class="form-control time" name="hora_s"  value="{{ $oficio->hora_s }}"  required />
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <input class="form-control datepicker fecha_salida"   type="text"  id="fecha_s" name="fecha_salida" data-date-format="yyyy/mm/dd" value="{{ $oficio->fecha_salida }}"  required>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1 ">
        <label for="fecha_regreso">Horario de regreso de la comisión</label><br>
        <div class="col-md-5">
            <div class="form-group">
                <input id="hora_r" type="text" class="form-control time" name="hora_r" value="{{ $oficio->hora_r }}"   required />
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <input class="form-control datepicker fecha_regreso " type="text" id="fecha_r" name="fecha_regreso" data-date-format="yyyy/mm/dd" value="{{ $oficio->fecha_regreso }}"  required>
            </div>

        </div>
    </div>
    <div class="row" >
        <div class="col-md-3 col-md-offset-2">
            <div class="dropdown">
                <label for="selectLugar_s">Lugar de salida</label>
                <select class="form-control" id="selectLugar_s" name="selectLugar_s"  required >
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($lugares as $lugar)
                        @if($oficio->id_lugar_salida==$lugar->id_lugar)
                            <option value="{{$lugar->id_lugar}}" selected="selected" >{{$lugar->descripcion}}</option>
                        @else
                            <option value="{{$lugar->id_lugar}}"> {{$lugar->descripcion}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <div class="dropdown">
                <label for="selectLugar_r">Lugar de regreso</label>
                <select name="selectLugar_r" id="selectLugar_r" class="form-control "  required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($lugares as $lugar)
                        @if($oficio->id_lugar_entrada==$lugar->id_lugar)
                            <option value="{{$lugar->id_lugar}}" selected="selected" >{{$lugar->descripcion}}</option>
                        @else
                            <option value="{{$lugar->id_lugar}}"> {{$lugar->descripcion}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {

            var getDate = function (input) {
                return new Date(input.date.valueOf());
            }
            $( '.fecha_salida').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                    $('.fecha_regreso').datepicker('setStartDate', getDate(selected));
                });
            $( '.fecha_regreso' ).datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                    $('.fecha_salida').datepicker('setEndDate', getDate(selected));
                });

            $('#hora_s').pickatime({
                format: 'HH:i',
                container: 'body',
                autoclose: true,
                vibrate: false,

            });
            $('#hora_r').pickatime({

                format: 'HH:i',
                container: 'body',
                autoclose: true,
                vibrate: false,
            });
        });
    </script>