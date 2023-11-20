
<table>
    <tr>
        <td style="text-align: center"></td>

    </tr>
    <tr>
        <td></td>

    </tr>
    <tr>
        <td></td>

    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="5" style="color: #000000; background: #808080; text-align: center; ">FUENTE DE FINANCIAMIENTO</td>
        <td colspan="4" style="color: #000000; background: #808080; text-align: center;">FUENTE DE FINANCIAMIENTO %</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td style="text-align: center;">ESTATAL</td>
        <td style="text-align: center;">FEDERAL</td>
        <td style="text-align: center;">PROPIOS</td>
        <td style="text-align: center;">TOTAL</td>
        <td style="background: #6c757d; color: #0c0c0c; text-align: center">CAPITULO</td>
        <td style="text-align: center;">ESTATAL</td>
        <td style="text-align: center;">FEDERAL</td>
        <td style="text-align: center;">PROPIOS</td>
        <td style="text-align: center;">TOTAL</td>
    </tr>
    <?php
    $total_presupuesto_estatal=0;
    $total_presupuesto_federal=0;
    $total_presupuesto_propios=0;
    $total_total_presupuesto=0;
    $contar_renglon=0;
    ?>
    @foreach($array_cap as $presupuesto)


        <tr>

                <?php
                $total_presupuesto_estatal=$total_presupuesto_estatal+$presupuesto['presupuesto_estatal'];
                $total_presupuesto_federal=$total_presupuesto_federal+$presupuesto['presupuesto_federal'];
                $total_presupuesto_propios=$total_presupuesto_propios+$presupuesto['presupuesto_propios'];
                ?>
            @if($contar_renglon == 0)
                <td colspan="3" ></td>
            @endif
            @if($contar_renglon == 1)
                <td colspan="3" >{{ $etiqueta->descripcion }}</td>
            @endif
            @if($contar_renglon == 2)
                <td colspan="3" >TECNOLÓGICO  DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO</td>
            @endif
            @if($contar_renglon == 3)
                <td colspan="3" >ANTEPROYECTO DE PRESUPUESTO {{ $proyecto->year }}</td>
            @endif
            @if($contar_renglon == 4)
                <td colspan="3" >{{ $proyecto->nombre_proyecto }}</td>
            @endif
            @if($contar_renglon == 5)
                <td colspan="3" ></td>
            @endif

            @if($presupuesto['presupuesto_estatal'] == 0)
                <td style=" text-align: right">-</td>
            @else
                <td style=" text-align: right">{{  number_format($presupuesto['presupuesto_estatal'], 2, '.', ',') }}</td>
            @endif
            @if($presupuesto['presupuesto_federal'] == 0)
                <td style=" text-align: right">-</td>
            @else
                <td style=" text-align: right">{{  number_format($presupuesto['presupuesto_federal'], 2, '.', ',') }}</td>
            @endif
            @if($presupuesto['presupuesto_propios'] == 0)
                <td style=" text-align: right">-</td>
            @else
                <td style=" text-align: right">{{ number_format($presupuesto['presupuesto_propios'], 2, '.', ',') }}</td>
            @endif
            @if($presupuesto['total_presupuesto'] == 0)
                <td style=" text-align: right"><b>-</b></td>
            @else
                <td style=" text-align: right">{{ number_format($presupuesto['total_presupuesto'], 2, '.', ',') }}</td>
            @endif
            <td style="background: #6c757d; color: #0c0c0c; text-align: right;">{{ $presupuesto['capitulo']}}</td>
            @if($presupuesto['financiamiento_estatal'] == 0)
                <td style=" text-align: right">-</td>
            @else
                <td style=" text-align: right">{{round($presupuesto['financiamiento_estatal'],4) }}</td>
            @endif
            @if($presupuesto['financiamiento_federal'] == 0)
                <td style=" text-align: right"><b>-</b></td>
            @else
                <td style=" text-align: right">{{ round($presupuesto['financiamiento_federal'],4) }}</td>
            @endif
            @if($presupuesto['financiamiento_propios'] == 0)
                <td style=" text-align: right"><b>-</b></td>
            @else
                <td style=" text-align: right">{{ round($presupuesto['financiamiento_propios'],4) }}</td>
            @endif
            @if($presupuesto['total_financiamiento'] == 0)
                <td style=" text-align: right"><b>-</b></td>
            @else
                <td style=" text-align: right">{{ $presupuesto['total_financiamiento'] }}</td>
            @endif

        </tr>
            <?php $contar_renglon=$contar_renglon+1; ?>
    @endforeach
    <?php
    $total_total_presupuesto=$total_presupuesto_estatal+$total_presupuesto_federal+$total_presupuesto_propios
    ?>
    <tr>
        <td colspan="3"></td>
        @if($total_presupuesto_estatal == 0)
            <td style=" text-align: right">-</td>
        @else
            <td style=" text-align: right">{{ number_format($total_presupuesto_estatal, 2, '.', ',') }}</td>
        @endif
        @if($total_presupuesto_federal == 0)
            <td style=" text-align: right">-</td>
        @else
            <td style=" text-align: right">{{  number_format($total_presupuesto_federal, 2, '.', ',') }}</td>
        @endif
        @if($total_presupuesto_propios == 0)
            <td style=" text-align: right">-</td>
        @else
            <td style=" text-align: right">{{  number_format($total_presupuesto_propios, 2, '.', ',') }}</td>
        @endif
        @if($total_total_presupuesto == 0)
            <td style=" text-align: right">-</td>
        @else
            <td style=" text-align: right">{{  number_format($total_total_presupuesto, 2, '.', ',') }}</td>
        @endif
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>


    </tr>





</table>
<table>
    <tr>
        <td rowspan="7"  style="text-align: justify; color: #0c0c0c; background: #808080">CLAVE PRESUPUESTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">DENOMINACIÓN</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">ENERO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">FEBRERO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">MARZO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">ABRIL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">MAYO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">JUNIO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">JULIO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">AGOSTO</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">SEPTIEMBRE</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">OCTUBRE</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">NOVIEMBRE</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>

        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">DICIEMBRE</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">ESTATAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">FEDERAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">PROPIOS</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #32cd32">TOTAL</td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; "></td>
        <td rowspan="7" style="text-align: justify; color: #0c0c0c; background: #808080">TOTAL</td>
        <td>ESTATAL</td>
        <td>FEDERAL</td>
        <td>PROPIOS</td>
        <td>TOTAL</td>

    </tr>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>


    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
</table>
<table>
    <?php
    $suma_total_enero1=0;
    $suma_estatal_enero1=0;
    $suma_federal_enero1=0;
    $suma_propios_enero1=0;
    $total_suma_total_enero1=0;

    $suma_total_febrero1=0;
    $suma_estatal_febrero1=0;
    $suma_federal_febrero1=0;
    $suma_propios_febrero1=0;
    $total_suma_total_febrero1=0;

    $suma_total_marzo1=0;
    $suma_estatal_marzo1=0;
    $suma_federal_marzo1=0;
    $suma_propios_marzo1=0;
    $total_suma_total_marzo1=0;

    $suma_total_abril1=0;
    $suma_estatal_abril1=0;
    $suma_federal_abril1=0;
    $suma_propios_abril1=0;
    $total_suma_total_abril1=0;

    $suma_total_mayo1=0;
    $suma_estatal_mayo1=0;
    $suma_federal_mayo1=0;
    $suma_propios_mayo1=0;
    $total_suma_total_mayo1=0;

    $suma_total_junio1=0;
    $suma_estatal_junio1=0;
    $suma_federal_junio1=0;
    $suma_propios_junio1=0;
    $total_suma_total_junio1=0;

    $suma_total_julio1=0;
    $suma_estatal_julio1=0;
    $suma_federal_julio1=0;
    $suma_propios_julio1=0;
    $total_suma_total_julio1=0;

    $suma_total_agosto1=0;
    $suma_estatal_agosto1=0;
    $suma_federal_agosto1=0;
    $suma_propios_agosto1=0;
    $total_suma_total_agosto1=0;

    $suma_total_sep1=0;
    $suma_estatal_sep1=0;
    $suma_federal_sep1=0;
    $suma_propios_sep1=0;
    $total_suma_total_sep1=0;

    $suma_total_octubre1=0;
    $suma_estatal_octubre1=0;
    $suma_federal_octubre1=0;
    $suma_propios_octubre1=0;
    $total_suma_total_octubre1=0;

    $suma_total_nov1=0;
    $suma_estatal_nov1=0;
    $suma_federal_nov1=0;
    $suma_propios_nov1=0;
    $total_suma_total_nov1=0;

    $suma_total_dic1=0;
    $suma_estatal_dic1=0;
    $suma_federal_dic1=0;
    $suma_propios_dic1=0;
    $total_suma_total_dic1=0;
    $total_partida_total_porcentaje1=0;
    $total_estatal_total_porcentaje1=0;
    $total_federal_total_porcentaje1=0;
    $total_propios_total_porcentaje1=0;
    $total_porcentaje_total_partida1=0;
    ?>
    @foreach($array_capitulos as $capitu)
            <?php
            $suma_total_enero=0;
            $suma_estatal_enero=0;
            $suma_federal_enero=0;
            $suma_propios_enero=0;
            $total_suma_total_enero=0;

            $suma_total_febrero=0;
            $suma_estatal_febrero=0;
            $suma_federal_febrero=0;
            $suma_propios_febrero=0;
            $total_suma_total_febrero=0;

            $suma_total_marzo=0;
            $suma_estatal_marzo=0;
            $suma_federal_marzo=0;
            $suma_propios_marzo=0;
            $total_suma_total_marzo=0;

            $suma_total_abril=0;
            $suma_estatal_abril=0;
            $suma_federal_abril=0;
            $suma_propios_abril=0;
            $total_suma_total_abril=0;

            $suma_total_mayo=0;
            $suma_estatal_mayo=0;
            $suma_federal_mayo=0;
            $suma_propios_mayo=0;
            $total_suma_total_mayo=0;

            $suma_total_junio=0;
            $suma_estatal_junio=0;
            $suma_federal_junio=0;
            $suma_propios_junio=0;
            $total_suma_total_junio=0;

            $suma_total_julio=0;
            $suma_estatal_julio=0;
            $suma_federal_julio=0;
            $suma_propios_julio=0;
            $total_suma_total_julio=0;

            $suma_total_agosto=0;
            $suma_estatal_agosto=0;
            $suma_federal_agosto=0;
            $suma_propios_agosto=0;
            $total_suma_total_agosto=0;

            $suma_total_sep=0;
            $suma_estatal_sep=0;
            $suma_federal_sep=0;
            $suma_propios_sep=0;
            $total_suma_total_sep=0;

            $suma_total_octubre=0;
            $suma_estatal_octubre=0;
            $suma_federal_octubre=0;
            $suma_propios_octubre=0;
            $total_suma_total_octubre=0;

            $suma_total_nov=0;
            $suma_estatal_nov=0;
            $suma_federal_nov=0;
            $suma_propios_nov=0;
            $total_suma_total_nov=0;

            $suma_total_dic=0;
            $suma_estatal_dic=0;
            $suma_federal_dic=0;
            $suma_propios_dic=0;
            $total_suma_total_dic=0;


            $suma_total_partidas=0;
            $total_partida_estatal=0;
            $total_partida_federal=0;
            $total_partida_propios=0;
            $total_total_porcentaje=0;
            $total_partida_total_porcentaje=0;
            $total_estatal_total_porcentaje=0;
            $total_federal_total_porcentaje=0;
            $total_propios_total_porcentaje=0;
            $total_porcentaje_total_partida=0;


            ?>
        @foreach($capitu['array_partidas'] as $partidas)
            @if($partidas['suma_presupuestal_year'] == 0)

            @else
                <tr style="color: #0c0c0c; background: #3f9ae5; text-align: right;">
                    <td style="text-align: center;">{{ $partidas['clave_presupuestal'] }}</td>
                    <td style="text-align: left;">{{ $partidas['nombre_partida'] }}</td>

                    @foreach($partidas['array_meses'] as $meses)
                        @if($meses['suma_req_mes'] == 0)
                            <td >-</td>
                            <td >-</td>
                            <td >-</td>
                            <td >-</td>
                            <td >-</td>
                            <td >-</td>
                        @else

                                <?php
                                $suma_req_mes=round($meses['suma_req_mes'],2);
                                $suma_req_mes1=number_format($suma_req_mes, 2, '.', ',');
                                $financiamiento_estatal= $capitu['financiamiento_estatal']*$meses['suma_req_mes'];
                                $financiamiento_estatal=round($financiamiento_estatal,2);
                                $financiamiento_estatal1= number_format($financiamiento_estatal, 2, '.', ',');
                                $financiamiento_federal= $capitu['financiamiento_federal']*$meses['suma_req_mes'];
                                $financiamiento_federal=round($financiamiento_federal,2);
                                $financiamiento_federal1= number_format($financiamiento_federal, 2, '.', ',');
                                $financiamiento_propios= $capitu['financiamiento_propios']*$meses['suma_req_mes'];
                                $financiamiento_propios=round($financiamiento_propios,2);
                                $financiamiento_propios1= number_format($financiamiento_propios, 2, '.', ',');
                                $suma_financiamiento= $financiamiento_estatal+$financiamiento_federal+$financiamiento_propios;
                                $suma_financiamiento=round($suma_financiamiento,2);
                                $suma_financiamiento1= number_format($suma_financiamiento, 2, '.', ',');

                                /*suma  */
                                if($meses['id_mes'] == 1){
                                    $suma_total_enero=$suma_total_enero+$suma_req_mes;
                                    $suma_estatal_enero=$suma_estatal_enero+$financiamiento_estatal;
                                    $suma_federal_enero=$suma_federal_enero+$financiamiento_federal;
                                    $suma_propios_enero=$suma_propios_enero+$financiamiento_propios;
                                    $total_suma_total_enero=$total_suma_total_enero+$suma_financiamiento;
                                }

                                if($meses['id_mes'] == 2){

                                    $suma_total_febrero=$suma_total_febrero+$suma_req_mes;
                                    $suma_estatal_febrero= $suma_estatal_febrero+$financiamiento_estatal;
                                    $suma_federal_febrero= $suma_federal_febrero+$financiamiento_federal;
                                    $suma_propios_febrero= $suma_propios_febrero+$financiamiento_propios;
                                    $total_suma_total_febrero= $total_suma_total_febrero+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 3){
                                    $suma_total_marzo=$suma_total_marzo+$suma_req_mes;
                                    $suma_estatal_marzo=$suma_estatal_marzo+$financiamiento_estatal;
                                    $suma_federal_marzo=$suma_federal_marzo+$financiamiento_federal;
                                    $suma_propios_marzo=$suma_propios_marzo+$financiamiento_propios;
                                    $total_suma_total_marzo=$total_suma_total_marzo+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 4){
                                    $suma_total_abril=$suma_total_abril+$suma_req_mes;
                                    $suma_estatal_abril=$suma_estatal_abril+$financiamiento_estatal;
                                    $suma_federal_abril=$suma_federal_abril+$financiamiento_federal;
                                    $suma_propios_abril=$suma_propios_abril+$financiamiento_propios;
                                    $total_suma_total_abril=$total_suma_total_abril+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 5){
                                    $suma_total_mayo=$suma_total_mayo+$suma_req_mes;
                                    $suma_estatal_mayo=$suma_estatal_mayo+$financiamiento_estatal;
                                    $suma_federal_mayo=$suma_federal_mayo+$financiamiento_federal;
                                    $suma_propios_mayo=$suma_propios_mayo+$financiamiento_propios;
                                    $total_suma_total_mayo=$total_suma_total_mayo+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 6){
                                    $suma_total_junio=$suma_total_junio+$suma_req_mes;
                                    $suma_estatal_junio=$suma_estatal_junio+$financiamiento_estatal;
                                    $suma_federal_junio=$suma_federal_junio+$financiamiento_federal;
                                    $suma_propios_junio=$suma_propios_junio+$financiamiento_propios;
                                    $total_suma_total_junio=$total_suma_total_junio+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 7){
                                    $suma_total_julio=$suma_total_julio+$suma_req_mes;
                                    $suma_estatal_julio=$suma_estatal_julio+$financiamiento_estatal;
                                    $suma_federal_julio=$suma_federal_julio+$financiamiento_federal;
                                    $suma_propios_julio=$suma_propios_julio+$financiamiento_propios;
                                    $total_suma_total_julio=$total_suma_total_julio+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 8){
                                    $suma_total_agosto=$suma_total_agosto+$suma_req_mes;
                                    $suma_estatal_agosto=$suma_estatal_agosto+$financiamiento_estatal;
                                    $suma_federal_agosto=$suma_federal_agosto+$financiamiento_federal;
                                    $suma_propios_agosto=$suma_propios_agosto+$financiamiento_propios;
                                    $total_suma_total_agosto=$total_suma_total_agosto+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 9){
                                    $suma_total_sep=$suma_total_sep+$suma_req_mes;
                                    $suma_estatal_sep=$suma_estatal_sep+$financiamiento_estatal;
                                    $suma_federal_sep=$suma_federal_sep+$financiamiento_federal;
                                    $suma_propios_sep=$suma_propios_sep+$financiamiento_propios;
                                    $total_suma_total_sep=$total_suma_total_sep+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 10){
                                    $suma_total_octubre=$suma_total_octubre+$suma_req_mes;
                                    $suma_estatal_octubre=$suma_estatal_octubre+$financiamiento_estatal;
                                    $suma_federal_octubre=$suma_federal_octubre+$financiamiento_federal;
                                    $suma_propios_octubre=$suma_propios_octubre+$financiamiento_propios;
                                    $total_suma_total_octubre=$total_suma_total_octubre+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 11){
                                    $suma_total_nov=$suma_total_nov+$suma_req_mes;
                                    $suma_estatal_nov=$suma_estatal_nov+$financiamiento_estatal;
                                    $suma_federal_nov=$suma_federal_nov+$financiamiento_federal;
                                    $suma_propios_nov=$suma_propios_nov+$financiamiento_propios;
                                    $total_suma_total_nov=$total_suma_total_nov+$suma_financiamiento;
                                }
                                if($meses['id_mes'] == 12){

                                    $suma_total_dic=$suma_total_dic+$suma_req_mes;
                                    $suma_estatal_dic=$suma_estatal_dic+$financiamiento_estatal;
                                    $suma_federal_dic=$suma_federal_dic+$financiamiento_federal;
                                    $suma_propios_dic=$suma_propios_dic+$financiamiento_propios;
                                    $total_suma_total_dic=$total_suma_total_dic+$suma_financiamiento;
                                }
                                $total_partida_total_porcentaje=$total_suma_total_enero+$total_suma_total_febrero+$total_suma_total_marzo+$total_suma_total_abril+$total_suma_total_mayo+$total_suma_total_junio+$total_suma_total_julio+$total_suma_total_agosto+$total_suma_total_sep+$total_suma_total_octubre+$total_suma_total_nov+$total_suma_total_dic;
                                $total_estatal_total_porcentaje=$total_partida_total_porcentaje*$capitu['financiamiento_estatal'];
                                $total_federal_total_porcentaje=$total_partida_total_porcentaje*$capitu['financiamiento_federal'];
                                $total_propios_total_porcentaje=$total_partida_total_porcentaje*$capitu['financiamiento_propios'];
                                $total_porcentaje_total_partida=$total_estatal_total_porcentaje+$total_federal_total_porcentaje+$total_propios_total_porcentaje;

                                $total_estatal_total_porcentaje1=$total_estatal_total_porcentaje1+$total_estatal_total_porcentaje;
                                $total_federal_total_porcentaje1=$total_federal_total_porcentaje1+$total_federal_total_porcentaje;
                                $total_propios_total_porcentaje1=$total_propios_total_porcentaje1+$total_propios_total_porcentaje;
                                ?>
                            @if($suma_req_mes == 0)
                                <td>-</td>
                            @else
                                <td>{{ $suma_req_mes1}}</td>
                            @endif
                            @if($financiamiento_estatal == 0)
                                <td>-</td>
                            @else
                                <td>{{ $financiamiento_estatal1 }}</td>
                            @endif
                            @if($financiamiento_federal == 0)
                                <td>-</td>
                            @else
                                <td>{{ $financiamiento_federal1 }}</td>
                            @endif
                            @if($financiamiento_propios == 0)
                                <td>-</td>
                            @else
                                <td>{{ $financiamiento_propios1 }}</td>
                            @endif
                            @if($suma_financiamiento == 0)
                                <td>-</td>
                            @else
                                <td>{{ $suma_financiamiento1 }}</td>
                            @endif
                            <td>-</td>
                        @endif

                    @endforeach
                        <?php
                        $suma_total_partidas=$suma_total_partidas+$partidas['suma_presupuestal_year'];
                        $total_partida_estatal=$partidas['suma_presupuestal_year']*$capitu['financiamiento_estatal'];
                        $total_partida_estatal=round($total_partida_estatal,2);

                        $total_partida_federal=$partidas['suma_presupuestal_year']*$capitu['financiamiento_federal'];
                        $total_partida_federal=round($total_partida_federal,2);

                        $total_partida_propios=$partidas['suma_presupuestal_year']*$capitu['financiamiento_propios'];
                        $total_partida_propios=round($total_partida_propios,2);

                        $total_total_porcentaje=$total_partida_estatal+$total_partida_federal+$total_partida_propios;
                        ?>


                    <td >{{ number_format($partidas['suma_presupuestal_year'], 2, '.', ',') }}</td>

                    @if($total_partida_estatal== 0)
                        <td style="background: #FFFFFF; color: #0c0c0c;">-</td>
                    @else
                        <td   style="background: #FFFFFF; color: #0c0c0c;">{{ number_format($total_partida_estatal, 2, '.', ',') }}</td>
                    @endif
                    @if($total_partida_federal== 0)
                        <td style="background: #FFFFFF; color: #0c0c0c;">-</td>
                    @else
                        <td style="background: #FFFFFF; color: #0c0c0c;">{{ number_format($total_partida_federal, 2, '.', ',') }}</td>
                    @endif
                    @if($total_partida_propios== 0)
                        <td style="background: #FFFFFF; color: #0c0c0c;">-</td>
                    @else
                        <td style="background: #FFFFFF; color: #0c0c0c;">{{ number_format($total_partida_propios, 2, '.', ',') }}</td>
                    @endif
                    <td style="background: #FFFFFF; color: #0c0c0c;">{{ number_format($total_total_porcentaje, 2, '.', ',') }}</td>
                    <td style="background: #FFFFFF; color: #0c0c0c;"></td>
                    <td style="background: #FFFFFF; color: #0c0c0c;"></td>
                    <td style="background: #FFFFFF; color: #0c0c0c;"></td>
                </tr>

            @endif

        @endforeach
            <?php
            $suma_total_enero1=$suma_total_enero1+$suma_total_enero;
            $suma_estatal_enero1=$suma_estatal_enero1+$suma_estatal_enero;
            $suma_federal_enero1=$suma_federal_enero1+$suma_federal_enero;
            $suma_propios_enero1=$suma_propios_enero1+$suma_propios_enero;
            $total_suma_total_enero1=$total_suma_total_enero1+$total_suma_total_enero;

            $suma_total_febrero1=$suma_total_febrero1+$suma_total_febrero;
            $suma_estatal_febrero1=$suma_estatal_febrero1+$suma_estatal_febrero;
            $suma_federal_febrero1=$suma_federal_febrero1+$suma_federal_febrero;
            $suma_propios_febrero1=$suma_propios_febrero1+$suma_propios_febrero;
            $total_suma_total_febrero1=$total_suma_total_febrero1+$total_suma_total_febrero;

            $suma_total_marzo1=$suma_total_marzo1+$suma_total_marzo;
            $suma_estatal_marzo1=$suma_estatal_marzo1+$suma_estatal_marzo;
            $suma_federal_marzo1=$suma_federal_marzo1+$suma_federal_marzo;
            $suma_propios_marzo1=$suma_propios_marzo1+$suma_propios_marzo;
            $total_suma_total_marzo1=$total_suma_total_marzo1+$total_suma_total_marzo;

            $suma_total_abril1=$suma_total_abril1+$suma_total_abril;
            $suma_estatal_abril1=$suma_estatal_abril1+$suma_estatal_abril;
            $suma_federal_abril1=$suma_federal_abril1+$suma_federal_abril;
            $suma_propios_abril1=$suma_propios_abril1+$suma_propios_abril;
            $total_suma_total_abril1=$total_suma_total_abril1+$total_suma_total_abril1;

            $suma_total_mayo1=$suma_total_mayo1+$suma_total_mayo;
            $suma_estatal_mayo1=$suma_estatal_mayo1+$suma_estatal_mayo;
            $suma_federal_mayo1=$suma_federal_mayo1+$suma_federal_mayo;
            $suma_propios_mayo1=$suma_propios_mayo1+$suma_propios_mayo;
            $total_suma_total_mayo1=$total_suma_total_mayo1+$total_suma_total_mayo;

            $suma_total_junio1=$suma_total_junio1+$suma_total_junio;
            $suma_estatal_junio1=$suma_estatal_junio1+$suma_estatal_junio;
            $suma_federal_junio1=$suma_federal_junio1+$suma_federal_junio;
            $suma_propios_junio1=$suma_propios_junio1+$suma_propios_junio;
            $total_suma_total_junio1=$total_suma_total_junio1+$total_suma_total_junio;

            $suma_total_julio1=$suma_total_julio1+$suma_total_julio;
            $suma_estatal_julio1=$suma_estatal_julio1+$suma_estatal_julio;
            $suma_federal_julio1=$suma_federal_julio1+$suma_federal_julio;
            $suma_propios_julio1=$suma_propios_julio1+$suma_propios_julio;
            $total_suma_total_julio1=$total_suma_total_julio1+$total_suma_total_julio;

            $suma_total_agosto1=$suma_total_agosto1+$suma_total_agosto;
            $suma_estatal_agosto1=$suma_estatal_agosto1+$suma_estatal_agosto;
            $suma_federal_agosto1=$suma_federal_agosto1+$suma_federal_agosto;
            $suma_propios_agosto1=$suma_propios_agosto1+$suma_propios_agosto;
            $total_suma_total_agosto1=$total_suma_total_agosto1+$total_suma_total_agosto;

            $suma_total_sep1=$suma_total_sep1+$suma_total_sep;
            $suma_estatal_sep1=$suma_estatal_sep1+$suma_estatal_sep;
            $suma_federal_sep1=$suma_federal_sep1+$suma_federal_sep;
            $suma_propios_sep1=$suma_propios_sep1+$suma_propios_sep;
            $total_suma_total_sep1=$total_suma_total_sep1+$total_suma_total_sep;

            $suma_total_octubre1=$suma_total_octubre1+$suma_total_octubre;
            $suma_estatal_octubre1=$suma_estatal_octubre1+$suma_estatal_octubre;
            $suma_federal_octubre1=$suma_federal_octubre1+$suma_federal_octubre;
            $suma_propios_octubre1=$suma_propios_octubre1+$suma_propios_octubre;
            $total_suma_total_octubre1=$total_suma_total_octubre1+$total_suma_total_octubre;

            $suma_total_nov1=$suma_total_nov1+$suma_total_nov;
            $suma_estatal_nov1=$suma_estatal_nov1+$suma_estatal_nov;
            $suma_federal_nov1=$suma_federal_nov1+$suma_federal_nov;
            $suma_propios_nov1=$suma_propios_nov1+$suma_propios_nov;
            $total_suma_total_nov1=$total_suma_total_nov1+$total_suma_total_nov;

            $suma_total_dic1=$suma_total_dic1+$suma_total_dic;
            $suma_estatal_dic1=$suma_estatal_dic1+$suma_estatal_dic;
            $suma_federal_dic1=$suma_federal_dic1+$suma_federal_dic;
            $suma_propios_dic1=$suma_propios_dic1+$suma_propios_dic;
            $total_suma_total_dic1=$total_suma_total_dic1+$total_suma_total_dic;


            ?>
        @if($total_partida_total_porcentaje > 0)

        <tr>
            <td style="background: #808080; color: #0c0c0c; text-align: right;" ></td>
            <td style="background: #808080; color: #0c0c0c; text-align: center;" >TOTAL</td>
            @if($suma_total_enero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_enero, 2, '.', ',')}}</td>
            @endif
            @if($suma_estatal_enero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_enero, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_enero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_enero, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_enero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_enero, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_enero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_enero, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @if($suma_total_febrero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_febrero, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_febrero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_febrero, 2, '.', ',') }} </td>
            @endif
            @if($suma_federal_febrero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_febrero, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_febrero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_febrero, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_febrero == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_febrero, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @if($suma_total_marzo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_marzo, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_marzo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_marzo, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_marzo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_marzo, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_marzo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_marzo, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_marzo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_marzo, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_abril == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_abril, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_abril == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_abril, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_abril == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_abril, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_abril == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_abril, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_abril == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_abril, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_mayo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_mayo, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_mayo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_mayo, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_mayo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_mayo, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_mayo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_mayo, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_mayo == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_mayo, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_junio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_junio, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_junio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_junio, 2, '.', ',') }} </td>
            @endif
            @if($suma_federal_junio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_junio, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_junio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_junio, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_junio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_junio, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_julio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_julio, 2, '.', ',')}}</td>
            @endif
            @if($suma_estatal_julio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_julio, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_julio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_julio, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_julio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_julio, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_julio == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_julio, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_agosto == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_agosto, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_agosto == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_agosto, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_agosto == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_agosto, 2, '.', ',') }} </td>
            @endif
            @if($suma_propios_agosto == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_agosto, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_agosto == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_agosto, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_sep == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_sep, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_sep == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_sep, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_sep == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_sep, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_sep == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_sep, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_sep == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_sep, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_octubre == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_octubre, 2, '.', ',') }} </td>
            @endif
            @if($suma_estatal_octubre == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_octubre, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_octubre == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_octubre, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_octubre == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_octubre, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_octubre == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_octubre, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_nov == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_nov, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_nov == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_nov, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_nov == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>{{ number_format($suma_federal_nov, 2, '.', ',') }}</b></td>
            @endif
            @if($suma_propios_nov == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_nov, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_nov == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_nov, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>

            @if($suma_total_dic == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_dic, 2, '.', ',') }}</td>
            @endif
            @if($suma_estatal_dic == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_dic, 2, '.', ',') }}</td>
            @endif
            @if($suma_federal_dic == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_dic, 2, '.', ',') }}</td>
            @endif
            @if($suma_propios_dic == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_dic, 2, '.', ',') }}</td>
            @endif
            @if($total_suma_total_dic == 0)
                <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #808080; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_dic, 2, '.', ',') }}</td>
            @endif
            <td style="background: #808080; color: #0c0c0c; text-align: right;"><b>-</b></td>


            @if($total_partida_total_porcentaje == 0)
                <td style="background: #ffff00; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #ffff00; color: #0c0c0c; text-align: right;">{{ number_format($total_partida_total_porcentaje, 2, '.', ',') }}</td>
            @endif
            @if($total_estatal_total_porcentaje == 0)
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_estatal_total_porcentaje, 2, '.', ',') }}</td>
            @endif
            @if($total_federal_total_porcentaje == 0)
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_federal_total_porcentaje, 2, '.', ',') }}</td>
            @endif
            @if($total_propios_total_porcentaje == 0)
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_propios_total_porcentaje, 2, '.', ',') }}</td>
            @endif
            @if($total_porcentaje_total_partida == 0)
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
            @else
                <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_porcentaje_total_partida, 2, '.', ',') }}</td>
            @endif



        </tr>
        @endif


    @endforeach
    <?php
    $total_partida_total_porcentaje1=$total_suma_total_enero1+$total_suma_total_febrero1+$total_suma_total_marzo1+$total_suma_total_abril1+$total_suma_total_mayo1+$total_suma_total_junio1+$total_suma_total_julio1+$total_suma_total_agosto1+$total_suma_total_sep1+$total_suma_total_octubre1+$total_suma_total_nov1+$total_suma_total_dic1;

    $total_porcentaje_total_partida1=$total_estatal_total_porcentaje1+$total_federal_total_porcentaje1+$total_propios_total_porcentaje1;

    ?>
    <tr>
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;" ></td>
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: center;" >TOTALES</td>
        @if($suma_total_enero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_enero1, 2, '.', ',')}}</td>
        @endif
        @if($suma_estatal_enero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_enero1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_enero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_enero1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_enero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_enero1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_enero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_enero1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @if($suma_total_febrero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_febrero1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_febrero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_febrero1, 2, '.', ',') }} </td>
        @endif
        @if($suma_federal_febrero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_febrero1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_febrero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_febrero1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_febrero1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_febrero1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @if($suma_total_marzo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_marzo1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_marzo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_marzo1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_marzo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_marzo1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_marzo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_marzo1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_marzo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_marzo1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_abril1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_abril1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_abril1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_abril1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_abril1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_abril1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_abril1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_abril1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_abril1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_abril1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_mayo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_mayo1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_mayo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_mayo1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_mayo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_mayo1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_mayo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_mayo1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_mayo1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_mayo1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_junio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_junio1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_junio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_junio1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_junio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_junio1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_junio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_junio1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_junio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_junio1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_julio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_julio1, 2, '.', ',')}}</td>
        @endif
        @if($suma_estatal_julio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_julio1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_julio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_julio1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_julio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_julio1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_julio1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_julio1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_agosto1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_agosto1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_agosto1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_agosto1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_agosto1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_agosto1, 2, '.', ',') }} </td>
        @endif
        @if($suma_propios_agosto1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_agosto1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_agosto1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_agosto1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_sep1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_sep1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_sep1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_sep1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_sep1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_sep1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_sep1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_sep1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_sep1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_sep1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_octubre1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF;; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_octubre1, 2, '.', ',') }} </td>
        @endif
        @if($suma_estatal_octubre1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_octubre1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_octubre1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_octubre1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_octubre1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{number_format($suma_propios_octubre1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_octubre1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_octubre1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_nov1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_nov1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_nov1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_nov1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_nov1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_nov1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_nov1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_nov1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_nov1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_nov1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>

        @if($suma_total_dic1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_total_dic1, 2, '.', ',') }}</td>
        @endif
        @if($suma_estatal_dic1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_estatal_dic1, 2, '.', ',') }}</td>
        @endif
        @if($suma_federal_dic1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_federal_dic1, 2, '.', ',') }}</td>
        @endif
        @if($suma_propios_dic1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($suma_propios_dic1, 2, '.', ',') }}</td>
        @endif
        @if($total_suma_total_dic1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_suma_total_dic1, 2, '.', ',') }}</td>
        @endif
        <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @if($total_partida_total_porcentaje1 == 0)
            <td style="background: #ffff00; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #ffff00; color: #0c0c0c; text-align: right;">{{ number_format($total_partida_total_porcentaje1, 2, '.', ',') }}</td>
        @endif
        @if($total_estatal_total_porcentaje1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_estatal_total_porcentaje1, 2, '.', ',') }}</td>
        @endif
        @if($total_federal_total_porcentaje1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF;; color: #0c0c0c; text-align: right;">{{ number_format($total_federal_total_porcentaje1, 2, '.', ',') }}</td>
        @endif
        @if($total_propios_total_porcentaje1 == 0)
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #FFFFFF; color: #0c0c0c; text-align: right;">{{ number_format($total_propios_total_porcentaje1, 2, '.', ',') }}</td>
        @endif
        @if($total_porcentaje_total_partida1 == 0)
            <td style="background: #ffff00; color: #0c0c0c; text-align: right;"><b>-</b></td>
        @else
            <td style="background: #ffff00; color: #0c0c0c; text-align: right;">{{ number_format($total_porcentaje_total_partida1, 2, '.', ',') }}</td>
        @endif




    </tr>
</table>
?>
