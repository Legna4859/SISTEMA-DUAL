@extends('layouts.app')
@section('title', 'Revisión de modificaciones de requisiciones')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Revisión de las modificaciones de las  requisiciones del anteproyecto de presupuesto {{ $datos_jefe->year_requisicion }}<br>
                        (NOMBRE DEL JEFE(A) DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->titulo }} {{ $datos_jefe->nombre }})</b><br>
                        (NOMBRE DEL DEPARTAMENTO O JEFATURA: <b>{{ $datos_jefe->nom_departamento }}</b></h3>
                </div>
            </div>
        </div>
        <br>
    </div>

    <?php setlocale(LC_MONETARY, 'es_MX');
/*
    function money_format($format, $number)
    {
        $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value  *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                    ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                    $csuffix;
            } else {
                $currency = '';
            }
            $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            $value = implode($locale['mon_decimal_point'], $value);
            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return $format;
    }
*/
    ?>


    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <p></p>
        </div>
    </div>

    @foreach($requisiciones2 as $requisicion)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h4 style="text-align: center; color: #0c0c0c">PARTIDA PRESUPUESTAL: <b>{{ $requisicion['nombre_partida'] }}</b></h4>
                                <h4 style="text-align: center; color: #0c0c0c">MES: <b>{{ $requisicion['mes'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">JUSTIFICACIÓN: <b>{{ $requisicion['justificacion'] }}</b></h5>
                                <h4 style="text-align: center; color: #0c0c0c">PROYECTO: <b>{{ $requisicion['nombre_proyecto'] }}</b></h4>
                                <h5 style="text-align: center; color: #0c0c0c">META: <b>{{ $requisicion['meta'] }}</b></h5>
                            </div>
                        </div>
                        @if( $requisicion['id_autorizacion']  == 0)
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5">
                                    <button class="btn btn-success btn-lg" onclick="window.location='{{ url('/presupuesto_anteproyecto/revisicion_bienes_servicios_departamento/'.$requisicion['id_actividades_req_ante'] ) }}'">Revisar requisición</button>
                                </div>

                            </div>
                        @else
                            @if( $requisicion['id_autorizacion']  == 2)
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading" style="text-align: center">Permiso de modificar.<br>
                                                COMENTARIO:  <b>{{ $requisicion['comentario']  }}</b></div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                            @if( $requisicion['id_autorizacion']  == 4)
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-success">
                                            <div class="panel-heading" style="text-align: center">
                                                Requisición autorizada
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                            @if( $requisicion['id_autorizacion']  == 3)
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading" style="text-align: center">Rechazar requisición.<br>
                                                COMENTARIO DE PORQUE SE RECHAZÓ :  <b>{{ $requisicion['comentario']  }}</b></div>
                                        </div>
                                    </div>
                                </div>

                            @endif

                        @endif
                    </div>
                </div>

            </div>

            @endforeach
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p><br></p>
                </div>
            </div>
            @if($numero_requisicion == $total_req_cal )
                @if($total_mod == 0)
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <button  id="{{ $id_req_mat_ante }}"  class="btn btn-primary btn-lg  autorizar_requisiciones" >Autorizar requisiciones
                            </button>
                        </div>
                    </div>

                @else
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <button  id="{{ $id_req_mat_ante }}"  class="btn btn-success btn-lg  mod_requisiciones" >Enviar modificaciones
                            </button>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p><br></p>
                </div>
            </div>

            {{-- modal enviar modificaciones --}}

            <div class="modal fade" id="modal_enviar_modificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Enviar modificaciones</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_enviar_modificaciones" action="{{url("/presupuesto_anteproyecto/enviar_modificaciones_depart/")}}" method="POST" role="form" >
                                {{ csrf_field() }}
                                <input type="hidden" id="id_req_mat_ante" name="id_req_mat_ante" value="">
                                <h2 style="text-align: center;">¿ Seguro(a) que quiere enviar las modificaciones al jefe(a) de departamento o jefatura</h2>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_enviar_modificaciones"  class="btn btn-primary" >Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $(".mod_requisiciones").click(function (){
                        var id_req_mat_ante = $(this).attr('id');
                        $('#id_req_mat_ante').val(id_req_mat_ante);
                        $("#modal_enviar_modificacion").modal('show');
                    });
                    $("#guardar_enviar_modificaciones").click(function (){
                        $("#form_enviar_modificaciones").submit();
                        $("#guardar_enviar_modificaciones").attr("disabled", true);
                    });

                });
            </script>
@endsection