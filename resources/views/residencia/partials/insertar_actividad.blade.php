<div class="modal-header bg-info">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title text-center" id="myModalLabel">Agregar actividad(es) en la  semana {{ $no_semana }} </h4>
</div>
<div class="row">
    <div class="col-md-5 col-md-offset-1">

        <div class="form-group">
            <label>Fecha inicial de la(s) actividad(es):</label>

                 <input type='text' readonly="readonly" id="fecha_inicial" name="fecha_inicial" class="form-control"placeholder="yyyy/mm/dd" required value="{{  $fecha_semana->fecha }}" />

              <input class="form-control" type="hidden"  id="id_anteproyecto" name="id_anteproyecto"  value="{{ $id_anteproyecto }}">
            <input class="form-control" type="hidden"  id="no_semana" name="no_semana"  value="{{ $no_semana }}">

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
    <div class="col-md-5 ">

        <div class="form-group">
            <br>
            <label for="fecha final">Fecha final de la(s) actividad(es)</label>

            <div id="soli" class="form-group"></div>


        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <div class="form-group">
            <label for="actividad">Ingresa actividad(es)</label>
            <textarea class="form-control" id="actividad" name="actividad"  rows="4" placeholder="Ingresa actividad(es)" style="" required></textarea>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {


            var fech= "<?php  echo $fecha_semana->fecha ?>";
           // alert(fech);
            var TuFecha = new Date(fech);
            var dias = 5;
            //nueva fecha sumada
            TuFecha.setDate(TuFecha.getDate() + dias);
            //formato de salida para la fecha
            var  resultado = TuFecha.getFullYear() + '/' +
                (TuFecha.getMonth() + 1) + '/' + TuFecha.getDate();
            $('#soli').empty();
            $('#soli').append('<input class="form-control" id="fecha_final" readonly="readonly" name="fecha_final" value="'+resultado+'"/>');
            // alert(resultado);



    });
</script>