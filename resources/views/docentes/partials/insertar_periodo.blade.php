


<div class="row">
    <div class="col-md-8 col-md-offset-2">

    <div class="form-group">
        <label>Seleccionar fecha de evaluación:</label>

        <input class="form-control datepicker"  type="text"  id="fecha_s" name="fecha_s"  placeholder="dd/MM/YYYY" required>
        <input class="form-control" type="hidden"  id="id_materia" name="id_materia"  value="{{ $id_materia }}">
        <input class="form-control" type="hidden"  id="id_unidad" name="id_unidad"  value="{{ $id_unidad }}">
        <input  class="form-control" type="hidden"  id="id_grupo" name="id_grupo"  value="{{ $id_grupo }}">
    </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        var dia="<?php  echo $di;?>";
        if(dia== 1){
            var fec="<?php  echo $dias;?>";
            var fecha='+'+fec+'d';
            $('#fecha_s').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: fecha,
            });

        }
        if(dia== 2){
            var fec="<?php  echo $dias;?>";
            var fecha='+'+fec+'d';
            $('#fecha_s').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: fecha,
            });

        }
        if(dia== 3){
            //var fec="<?php  echo $dias;?>";
            var fecha='+'+0+'d';
            $('#fecha_s').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: fecha,
            });

        }

    });
</script>