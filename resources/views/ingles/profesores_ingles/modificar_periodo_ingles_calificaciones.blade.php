<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="form-group">
            <label>Seleccionar fecha de evaluación</label>
            <?php  $fecha=date("d/m/Y ",strtotime($periodo_calificacion[0]->fecha)) ?>
            <input class="form-control datepicker"  type="text"  id="fecha_periodo" name="fecha_periodo"  placeholder="dd/MM/YYYY" value="{{$fecha}}" required>
            <input class="form-control" type="hidden"  id="id_nivel" name="id_nivel"  value="{{ $periodo_calificacion[0]->id_nivel }}">
            <input class="form-control" type="hidden"  id="id_unidad" name="id_unidad"  value="{{ $periodo_calificacion[0]->id_unidad}}">
            <input  class="form-control" type="hidden"  id="id_grupo" name="id_grupo"  value="{{ $periodo_calificacion[0]->id_grupo }}">
            <input  class="form-control" type="hidden"  id="fecha_anterior" name="fecha_anterior"  value="{{ $periodo_calificacion[0]->fecha }}">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        $('#fecha_periodo').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',
            startDate: '+0d',
        });
    });
</script>