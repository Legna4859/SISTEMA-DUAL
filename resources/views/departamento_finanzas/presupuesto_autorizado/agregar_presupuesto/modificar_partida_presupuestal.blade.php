<form id="form_guardar_partida_mod" class="form" action="{{url("/presupuesto_autorizado/guardar_mod_presupesto_partida/".$partida_reg->	id_presupuesto_aut)}}" role="form" method="POST" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Partida presupuestal: {{ $partida_reg->clave_presupuestal }}  {{ $partida_reg->nombre_partida }}</h3>
        </div>
        <br>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de enero</label>
                <input class="form-control" id="enero_pres_mod" name="enero_pres_mod" type="number" step=".01" value="{{ $partida_reg->enero_pres }}" required></input>
            </div>
            <div id="pesos_enero_mod">
                <h2> {{ "$".number_format($partida_reg->enero_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de febrero</label>
                <input class="form-control" id="febrero_pres_mod" name="febrero_pres_mod" type="number" step=".01" value="{{ $partida_reg->febrero_pres }}" required></input>
            </div>
            <div id="pesos_febrero_mod">
                <h2> {{ "$".number_format($partida_reg->febrero_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de marzo</label>
                <input class="form-control" id="marzo_pres_mod" name="marzo_pres_mod" type="number" step=".01" value="{{ $partida_reg->marzo_pres }}" required></input>
            </div>
            <div id="pesos_marzo_mod">
                <h2> {{ "$".number_format($partida_reg->marzo_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de abril</label>
                <input class="form-control" id="abril_pres_mod" name="abril_pres_mod" type="number" step=".01" value="{{ $partida_reg->abril_pres }}" required></input>
            </div>
            <div id="pesos_abril_mod">
                <h2> {{ "$".number_format($partida_reg->abril_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de mayo</label>
                <input class="form-control" id="mayo_pres_mod" name="mayo_pres_mod" type="number" step=".01" value="{{ $partida_reg->mayo_pres }}" required></input>
            </div>
            <div id="pesos_mayo_mod">
                <h2> {{ "$".number_format($partida_reg->mayo_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de junio</label>
                <input class="form-control" id="junio_pres_mod" name="junio_pres_mod" type="number" step=".01" value="{{ $partida_reg->junio_pres }}" required></input>
            </div>
            <div id="pesos_junio_mod">
                <h2> {{ "$".number_format($partida_reg->junio_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de julio</label>
                <input class="form-control" id="julio_pres_mod" name="julio_pres_mod" type="number" step=".01" value="{{ $partida_reg->julio_pres }}" required></input>
            </div>
            <div id="pesos_julio_mod">
                <h2> {{ "$".number_format($partida_reg->julio_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
        <div class="col-md-5 ">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de agosto</label>
                <input class="form-control" id="agosto_pres_mod" name="agosto_pres_mod" type="number" step=".01" value="{{ $partida_reg->agosto_pres }}" required></input>
            </div>
            <div id="pesos_agosto_mod">
                <h2> {{ "$".number_format($partida_reg->agosto_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de septiembre</label>
                <input class="form-control" id="septiembre_pres_mod" name="septiembre_pres_mod" type="number" step=".01" value="{{ $partida_reg->septiembre_pres }}" required></input>
            </div>
            <div id="pesos_septiembre_mod">
                <h2> {{ "$".number_format($partida_reg->septiembre_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de octubre</label>
                <input class="form-control" id="octubre_pres_mod" name="octubre_pres_mod" type="number" step=".01" value="{{ $partida_reg->octubre_pres }}" required></input>
            </div>
            <div id="pesos_octubre_mod">
                <h2> {{ "$".number_format($partida_reg->octubre_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de noviembre</label>
                <input class="form-control" id="noviembre_pres_mod" name="noviembre_pres_mod" type="number" step=".01" value="{{ $partida_reg->noviembre_pres }}" required></input>
            </div>
            <div id="pesos_noviembre_mod">
                <h2> {{ "$".number_format($partida_reg->noviembre_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Ingresa presupuesto del mes de diciembre</label>
                <input class="form-control" id="diciembre_pres_mod" name="diciembre_pres_mod" type="number" step=".01" value="{{ $partida_reg->diciembre_pres }}" required></input>
            </div>
            <div id="pesos_diciembre_mod">
             <h2> {{ "$".number_format($partida_reg->diciembre_pres, 2, '.', ',') }}</h2>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
    $("#enero_pres_mod").change(function (event) {
        var p_enero = event.target.value;
        if (isNaN(p_enero)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_enero_mod').empty();

        } else {
            var p_enero1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_enero);
            $('#pesos_enero_mod').empty();
            $('#pesos_enero_mod').append('<h2>' + p_enero1 + '</option>');
        }
    });

    $("#febrero_pres_mod").change(function (event) {
        var p_febrero = event.target.value;
        if (isNaN(p_febrero)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_febrero_mod').empty();

        } else {
            var p_febrero1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_febrero);
            $('#pesos_febrero_mod').empty();
            $('#pesos_febrero_mod').append('<h2>' + p_febrero1+ '</option>');
        }
    });

    $("#marzo_pres_mod").change(function (event) {
        var p_marzo = event.target.value;
        if (isNaN(p_marzo)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_marzo_mod').empty();

        } else {
            var p_marzo1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_marzo);
            $('#pesos_marzo_mod').empty();
            $('#pesos_marzo_mod').append('<h2>' + p_marzo1+ '</option>');
        }
    });

    $("#abril_pres_mod").change(function (event) {
        var p_abril = event.target.value;
        if (isNaN(p_abril)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_abril_mod').empty();

        } else {
            var p_abril1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_abril);
            $('#pesos_abril_mod').empty();
            $('#pesos_abril_mod').append('<h2>' + p_abril1+ '</option>');
        }
    });

    $("#mayo_pres_mod").change(function (event) {
        var p_mayo = event.target.value;
        if (isNaN(p_mayo)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_mayo_mod').empty();

        } else {
            var p_mayo1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_mayo);
            $('#pesos_mayo_mod').empty();
            $('#pesos_mayo_mod').append('<h2>' + p_mayo1+ '</option>');
        }
    });

    $("#junio_pres_mod").change(function (event) {
        var p_junio = event.target.value;
        if (isNaN(p_junio)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_junio_mod').empty();

        } else {
            var p_junio1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_junio);
            $('#pesos_junio_mod').empty();
            $('#pesos_junio_mod').append('<h2>' + p_junio1+ '</option>');
        }
    });

    $("#julio_pres_mod").change(function (event) {
        var p_julio = event.target.value;
        if (isNaN(p_julio)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_julio_mod').empty();

        } else {
            var p_julio1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_julio);
            $('#pesos_julio_mod').empty();
            $('#pesos_julio_mod').append('<h2>' + p_julio1+ '</option>');
        }
    });

    $("#agosto_pres_mod").change(function (event) {
        var p_agosto = event.target.value;
        if (isNaN(p_agosto)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_agosto_mod').empty();

        } else {
            var p_agosto1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_agosto);
            $('#pesos_agosto_mod').empty();
            $('#pesos_agosto_mod').append('<h2>' + p_agosto1+ '</option>');
        }
    });

    $("#septiembre_pres_mod").change(function (event) {
        var p_septiembre = event.target.value;
        if (isNaN(p_septiembre)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_septiembre_mod').empty();

        } else {
            var p_septiembre1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_septiembre);
            $('#pesos_septiembre_mod').empty();
            $('#pesos_septiembre_mod').append('<h2>' + p_septiembre1+ '</option>');
        }
    });

    $("#octubre_pres_mod").change(function (event) {
        var p_octubre = event.target.value;
        if (isNaN(p_octubre)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_octubre_mod').empty();

        } else {
            var p_octubre1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_octubre);
            $('#pesos_octubre_mod').empty();
            $('#pesos_octubre_mod').append('<h2>' + p_octubre1+ '</option>');
        }
    });

    $("#noviembre_pres_mod").change(function (event) {
        var p_noviembre = event.target.value;
        if (isNaN(p_noviembre)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_noviembre_mod').empty();

        } else {
            var p_noviembre1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_noviembre);
            $('#pesos_noviembre_mod').empty();
            $('#pesos_noviembre_mod').append('<h2>' + p_noviembre1+ '</option>');
        }
    });

    $("#diciembre_pres_mod").change(function (event) {
        var p_diciembre = event.target.value;
        if (isNaN(p_diciembre)) {
            alert("el presupuesto debe ser un numero");
            $('#pesos_diciembre_mod').empty();

        } else {
            var p_diciembre1 = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(p_diciembre);
            $('#pesos_diciembre_mod').empty();
            $('#pesos_diciembre_mod').append('<h2>' + p_diciembre1+ '</option>');
        }
    });
    });
</script>