<form id="form_guardar_presupuesto_dado" class="form" action="{{url("/presupuesto_autorizado/guardar_presupuesto_dado/".$partida->id_solicitud_partida)}}" role="form" method="POST" >
    {{ csrf_field() }}

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <p><b>PARTIDA PRESUPUESTAL: </b>{{ $partida->clave_presupuestal }}  {{ $partida->nombre_partida }}</p>
    </div>
</div>
@if($partida->id_tipo_requisicion == 1)
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p><b>TIPO DE SOLICITUD:  </b>ANTEPROYECTO</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p><b>PRESUPUESTO PEDIDO: </b>${{ number_format($partida->importe_total, 2, '.', ',')  }}</p>
        </div>
    </div>
@endif
@if($partida->id_tipo_requisicion == 2)
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p><b>TIPO DE SOLICITUD:  </b>PROYECTO AUTORIZADO</p>
        </div>
    </div>
@endif
@if($resto_presupuesto <= 0)
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="alert alert-danger">
                <strong>No hay presupuesto en este mes en esta partida</strong> .
            </div>
        </div>
    </div>
    <input class="form-control" id="estado_pre" name="estado_pre" type="hidden"  value="1" required>
@else
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="alert alert-success">
                <strong>PRESUPUESTO RESTANTE AUTORIZADO: {{ $resto_presupuesto }}</strong> .
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <label for="pres_dar">Ingresar presupuesto a dar</label>
        <input class="form-control" id="pres_dar" name="pres_dar" type="number" step=".01" value="{{ $partida->presupuesto_dado }}" required>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div id="pesos_mod">
            <h2> {{ "$".number_format($partida->presupuesto_dado, 2, '.', ',') }}</h2>
        </div>
    </div>
</div>
    <input class="form-control" id="estado_pre" name="estado_pre" type="hidden"  value="2" required>
    <input class="form-control" id="resto_pres" name="resto_pres" type="hidden"  value="{{ $resto_presupuesto }}" required>

    <script>
        $(document).ready(function() {
            $("#pres_dar").change(function (event) {
                var p_dar = event.target.value;

                if (isNaN(p_dar)) {
                    alert("el presupuesto debe ser un numero");
                    $('#pesos_mod').empty();

                } else {
                    var p_dar1 = new Intl.NumberFormat("es-MX", {
                        style: "currency",
                        currency: "MXN"
                    }).format(p_dar);
                    $('#pesos_mod').empty();
                    $('#pesos_mod').append('<h2>' + p_dar1 + '</option>');
                }
            });
        });
    </script>
    @endif