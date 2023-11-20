<?php setlocale(LC_MONETARY, 'es_MX');
?>
<form id="form_modificar_capitulo" class="form" action="{{url("/presupuesto_anteproyecto/techo_presupuestal/guardar_mod_capitulo/".$capitulo->id_fuente_financiamiento )}}" role="form" method="POST" >
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-warning">
                <h4 style="text-align: center;">AÑO: {{ $capitulo->year}} </h4>
                <h4 style="text-align: center;">NOMBRE DEL PROYECTO: {{ $capitulo->nombre_proyecto }} </h4>
                @if($capitulo->id_capitulo == 1)
                <h4 style="text-align: center;">CAPITULO: 1000 </h4>
                @endif
                @if($capitulo->id_capitulo == 2)
                    <h4 style="text-align: center;">CAPITULO: 2000 </h4>
                @endif
                @if($capitulo->id_capitulo == 3)
                    <h4 style="text-align: center;">CAPITULO: 3000 </h4>
                @endif
                @if($capitulo->id_capitulo == 4)
                    <h4 style="text-align: center;">CAPITULO: 4000 </h4>
                @endif
                @if($capitulo->id_capitulo == 5)
                    <h4 style="text-align: center;">CAPITULO: 5000 </h4>
                @endif
                @if($capitulo->id_capitulo == 6)
                    <h4 style="text-align: center;">CAPITULO: 6000 </h4>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa importe de fuente de financiamiento estatal </label>
                <input class="form-control" id="presupuesto_estatal_mod"  name="presupuesto_estatal_mod" type="number-only" value="{{ $capitulo->presupuesto_estatal  }}"   required />
                <div id="pesos_presupuesto_estatal">
                    <?php
                    $presupuesto_estatal=$capitulo->presupuesto_estatal ;
                    $presupuesto_estatal= "$ ".number_format($presupuesto_estatal, 2, '.', ',');
                    ?>
                    <h2>{{ $presupuesto_estatal }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa importe de fuente de financiamiento federal</label>
                <input class="form-control" id="presupuesto_federal_mod" name="presupuesto_federal_mod" type="number-only" value="{{ $capitulo->presupuesto_federal  }}"   required />
                <div id="pesos_presupuesto_federal">
                    <?php
                    $presupuesto_federal=$capitulo->presupuesto_federal ;
                    $presupuesto_federal= "$ ".number_format($presupuesto_federal, 2, '.', ',');
                    ?>
                    <h2>{{ $presupuesto_federal }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label>Ingresa importe de fuente de financiamiento propios </label>
                <input class="form-control" id="presupuesto_propios_mod" name="presupuesto_propios_mod" type="number-only" value="{{ $capitulo->presupuesto_propios  }}"  required />
                <div id="pesos_presupuesto_propios">
                    <?php
                    $presupuesto_propios=$capitulo->presupuesto_propios ;
                    $presupuesto_propios= "$ ".number_format($presupuesto_propios, 2, '.', ',');
                    ?>
                    <h2>{{ $presupuesto_propios }}</h2>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready( function() {
        $("#presupuesto_estatal_mod").change(function (event){
            var presupuesto_estatal_pesos= event.target.value;
            if(isNaN(presupuesto_estatal_pesos)){
                alert( "La cantidad de fuente de financiamiento estatal debe ser un numero");
                $('#pesos_presupuesto_estatal').empty();

            }else {
                var p_estatal_peso_mexicano = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(presupuesto_estatal_pesos);
                $('#pesos_presupuesto_estatal').empty();
                $('#pesos_presupuesto_estatal').append('<h2>' + p_estatal_peso_mexicano + '</option>');
            }
        });
        $("#presupuesto_federal_mod").change(function (event){
            var presupuesto_federal_pesos= event.target.value;
            if(isNaN(presupuesto_federal_pesos)){
                alert( "La cantidad de fuente de financiamiento federal debe ser un numero");
                $('#pesos_presupuesto_federal').empty();

            }else {
                var p_federal_peso_mexicano = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(presupuesto_federal_pesos);
                $('#pesos_presupuesto_federal').empty();
                $('#pesos_presupuesto_federal').append('<h2>' + p_federal_peso_mexicano + '</option>');
            }
        });
        $("#presupuesto_propios_mod").change(function (event){
            var presupuesto_propios_pesos= event.target.value;
            if(isNaN(presupuesto_propios_pesos)){
                alert( "La cantidad de fuente de financiamiento propios debe ser un numero");
                $('#pesos_presupuesto_propios').empty();

            }else {
                var p_propios_peso_mexicano = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(presupuesto_propios_pesos);
                $('#pesos_presupuesto_propios').empty();
                $('#pesos_presupuesto_propios').append('<h2>' + p_propios_peso_mexicano + '</option>');
            }
        });
    });
</script>