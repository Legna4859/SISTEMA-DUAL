
<div class="modal-header bg-info">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title text-center" id="myModalLabel">Modificar actividad en la semana {{$cronograma->no_semana}}</h4>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1 ">
        <div class="col-md-5">
            <div class="form-group">
                <label for="fechadesalida">Fecha inicial de la(s) actividad(es):</label><br>
                     <input type='text' id="fecha_inicial" readonly="readonly" name="fecha_inicial" class="form-control"placeholder="yyyy/mm/dd"  value="{{ $cronograma->f_inicio }}"   required />
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <input class="form-control" type="hidden"  id="id_cronograma" name="id_cronograma"  value="{{ $cronograma->id_cronograma }}">
                <br>
                <label for="fechadesalida">Fecha final de la(s) actividad(es)</label><br>
                <div id="actividad">
                    <input class="form-control datepicker "   type="text" readonly="readonly" id="fecha_s" name="fecha_s" data-date-format="yyyy/mm/dd" value="{{ $cronograma->f_termino }}"  required>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="actividad">Ingresa actividad(es)</label>
            <textarea class="form-control" id="actividades" name="actividades"  rows="4" placeholder="Ingresa actividad(es)" style="" required>{{ $cronograma->actividad }}</textarea>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker11').datepicker({
            daysOfWeekDisabled: [0,2,3,4,5,6],
            startDate: '+0d',
            autoclose: true,
            language: 'es'
        });
    });

</script>
<script type="text/javascript">
    $(document).ready( function() {

        $("#datetimepicker11").change(function(e){
            console.log(e);
            var fech= e.target.value;
            var TuFecha = new Date(fech);
            var dias = 4;
            //nueva fecha sumada
            TuFecha.setDate(TuFecha.getDate() + dias);
            //formato de salida para la fecha
            var  resultado = TuFecha.getFullYear() + '/' +
                (TuFecha.getMonth() + 1) + '/' + TuFecha.getDate();
            $('#actividad').empty();
            $('#actividad').append('<input class="form-control" id="fecha_s" readonly="readonly" name="fecha_s" value="'+resultado+'"/>');
            // alert(resultado);

        });


    });
</script>