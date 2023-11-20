<?php setlocale(LC_MONETARY, 'es_MX');

?>


<form id="form_mod_bien" class="form" action="{{url("/presupuesto_anteproyecto/guardar_mod_bien/".$servicio->id_reg_material_ant)}}" role="form" method="POST" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresar el nombre del bien o servicio, etc.</label>
                <textarea class="form-control" id="bien_servicio_mod" name="bien_servicio_mod" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required>{{ $servicio->descripcion }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa unidad de medida</label>
                <input class="form-control" id="unidad_medida_mod" name="unidad_medida_mod" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{ $servicio->unidad_medida }}" required></input>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa cantidad del bien o servicio, etc.</label>
                <input class="form-control" id="cantidad_mod" name="cantidad_mod" type="number" pattern="[0-9]+" value="{{ $servicio->cantidad }}" required></input>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa precio unitario de referencia con iva incluido</label>
                <input class="form-control" id="precio_mod" name="precio_mod" type="number" step=".01" value="{{ $servicio->precio_unitario }}" required></input>
            </div>
            <?php
            $precio_unitario_p=$servicio->precio_unitario;
            $precio_unitario_p= "$".number_format($precio_unitario_p, 2, '.', ',');
            ?>
            <div id="pesos_precio_mod">
                <h2> {{ $precio_unitario_p }}</h2>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#precio_mod").change(function (event) {
            var precio = event.target.value;
            if (isNaN(precio)) {
                alert("el precio debe ser un numero");
                $('#pesos_precio_mod').empty();

            } else {
                var p_precio = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(precio);
                $('#pesos_precio_mod').empty();
                $('#pesos_precio_mod').append('<h2>' + p_precio + '</option>');
            }
        });
    });
</script>