<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="form-group">
            <label>Seleccionar fecha de evaluación</label>

            <input class="form-control datepicker"  type="text"  id="fecha_periodo" name="fecha_periodo"  placeholder="dd/MM/YYYY" required>
            <input class="form-control" type="hidden"  id="id_nivel" name="id_nivel"  value="{{ $id_nivel }}">
            <input class="form-control" type="hidden"  id="id_unidad" name="id_unidad"  value="{{ $id_unidad}}">
            <input  class="form-control" type="hidden"  id="id_grupo" name="id_grupo"  value="{{ $id_grupo }}">
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