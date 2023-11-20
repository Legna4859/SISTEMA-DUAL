<form id="form_modificar_periodo" class="form" action="{{url("/presupuesto_anteproyecto/guardar_modificacion_periodos_anteproyecto/".$periodo->id_peri_anteproyecto)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Seleccionar fecha inicial del periodo</label>
                <input class="form-control datepicker fecha_inicio_mod"   type="text"  id="fecha_inicial_mod" name="fecha_inicial_mod" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"  value="{{ $fecha_i }}" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Seleccionar fecha final del periodo</label>
                <input class="form-control datepicker fecha_final_mod " type="text" id="fecha_final_mod" name="fecha_final_mod" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="{{ $fecha_f }}">

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Año actual</label>
                <input class="form-control " type="text" id="year_actual_mod" name="year_actual_mod" readonly value="{{ $periodo->year }}" >

            </div>
        </div>
    </div>

</form>

<script type="text/javascript">
    $(document).ready( function() {
        $( '.fecha_inicio_mod').datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',
            startDate: '+0d',

        });
        $( '.fecha_final_mod' ).datepicker({
            pickTime: false,
            autoclose: true,
            language: 'es',
            startDate: '+0d',
        });
    });
</script>