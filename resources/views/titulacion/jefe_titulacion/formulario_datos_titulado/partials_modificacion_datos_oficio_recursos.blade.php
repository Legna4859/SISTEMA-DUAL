<div class="row">
<div class="col-md-10  col-md-offset-1">
    <div class="form-group">
        <label for="fecha_oficio_recurso">Fecha de registro del oficio de recurso</label>
        <input class="form-control datepicker " readonly  type="text"  id="fecha_oficio_recurso" name="fecha_oficio_recurso" data-date-format="dd/mm/yyyy" placeholder="DD/MM/YYYY" value="{{ $reg_oficio_recursos->fecha_oficio_recursos }}" required>

    </div>
</div>
</div>
<div class="row">
    <div class="col-md-10  col-md-offset-1">
    <div class="form-group">
        <label for="numero_oficio_recurso">Número del oficio de recurso</label>
        <input class="form-control required" id="numero_oficio_recurso" name="numero_oficio_recurso" onkeyup="javascript:this.value=this.value.toUpperCase();"  value="{{ $reg_oficio_recursos->numero_oficio_recursos }}" />
    </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        $( '.fecha_oficio_recur').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',

        });
    });
</script>