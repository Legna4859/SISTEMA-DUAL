@extends('layouts.app')
@section('title', 'Solicitud de Prorroga')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Solicitud de prorroga</h3>
                    </div>
                </div>
            </div>

        </div>
        @if( $estado_periodo_prorroga == 0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3 ">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <?php  $fecha_inicial=date("d-m-Y ",strtotime($periodo_p->fecha_inicial)) ?>
                            <?php  $fecha_final=date("d-m-Y ",strtotime($periodo_p->fecha_final)) ?>
                            <h3 class="panel-title text-center">El periodo de solicitudes de prorroga es del {{ $fecha_inicial }} al {{ $fecha_final }} en el periodo {{ $periodo_p->periodo }} (si te encuentras en las fechas de solicitud a que revisar si el periodo es el que corresponde, por el contrario lo modificamos en el icono de calendario en el menu). </h3>
                        </div>
                    </div>
                </div>

            </div>

            @else

        @if($estado_solicitud == 0 and $fecha > 0)
            <form id="form_solicitud_prorroga" action="{{url("/solicitud/enviar_solicitud_prorroga/".$id_alumno)}}"class="form" role="form" method="POST">
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p>L. C. MA. ESTHER RODRIGUEZ GÓMEZ</p>
                                <p>DIRECTORA GENERAL DEL TECNOLÓGICO</p>
                                <p>DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO</p>
                                <p><BR></p>
                                <p>El que suscribe <b>{{ $nombre_alumno }}</b> estudiante de la carrera de <b>{{ $carrera }}</b> con
                                    número de cuenta <b>{{$no_cuenta}}</b>, por este medio, se dirige a usted, para solicitar me autorice,
                                    la prórroga de pago de la colegiatura semestral al

                                    <select name="id_semestre" id="id_semestre"  size="1" style="color: black; background: #99cccc" required>
                                        <option disabled selected hidden>Selecciona semestre</option>
                                        @foreach($semestres as $semestre)

                                            <option value="{{$semestre->id_semestre}}" >{{$semestre->descripcion}}</option>

                                        @endforeach
                                        <?php  $fecha_ul=date("d/m/Y ",strtotime($periodo_p->fecha_ult_num)) ?>
                                    </select> semestre, mi compromiso es efectuar el depósito correspondiente  a más tardar el dia <b>{{$periodo_p->fecha_ultima}}</b>

                                    <input type='hidden' name="fecha_registrada"id="fecha_inicial" title="dd/mm/YYYY" placeholder="dd/mm/YYYY"  value="{{$fecha_ul}}" />
                                    <span class="glyphicon glyphicon-calendar"></span>.
                                    <br><br>Estoy consciente que de no realizar el trámite en la fecha pactada se procederá a la suspensión de mis derechos
                                    como estudiante y este mismo documento fungirá como solicitud de baja temporal.
                                    <br><br>Sin otro particular por el momento, agradezco la atención que se sirva dar a la presente solicitud.




                                </p>
                                <p><br><br></p>
                                <p style="text-align: center">ATENTAMENTE</p>
                                <p style="text-align: center">{{$nombre_alumno}}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-3 col-md-offset-5 m">
                        <button  type="button" id="enviar_prorroga" class="btn btn-success btn-lg">Enviar solicitud</button>
                    </div>
                    <br><p><br></p>
                </div>
            </form>


        @elseif($estado_solicitud == 1)
            <div class="row">

                <div class="col-md-6 col-md-offset-3  text-center">
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="text-align: center">
                            <h3 class="panel-title text-center"><br>Tu solicitud de prorroga se envio correctamente. <br><br></h3>
                        </div>
                    </div>
                </div>

            </div>

                <div class="row">

                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p>L. C. MA. ESTHER RODRIGUEZ GÓMEZ</p>
                                <p>DIRECTORA GENERAL DEL TECNOLÓGICO</p>
                                <p>DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO</p>
                                <p><BR></p>
                                <p>El que suscribe <b>{{ $nombre_alumno }}</b> estudiante de la carrera de <b>{{ $carrera }}</b> con
                                    número de cuenta <b>{{$no_cuenta}}</b>, por este medio, se dirige a usted, para solicitar me autorice,
                                    la prórroga de pago de la colegiatura semestral al <b>{{$prorroga_solicitudes->semestre}}</b> semestre, mi compromiso es efectuar el depósito correspondiente  a más tardar el dia
                                  {{$prorroga_solicitudes->fecha_efectuar}}.
                                    <br><br>Estoy consciente que de no realizar el trámite en la fecha pactada se procederá a la suspensión de mis derechos
                                    como estudiante y este mismo documento fungirá como solicitud de baja temporal.
                                    <br><br>Sin otro particular por el momento, agradezco la atención que se sirva dar a la presente solicitud.




                                </p>
                                <p><br><br></p>
                                <p style="text-align: center">ATENTAMENTE</p>
                                <p style="text-align: center">{{$nombre_alumno}}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">


                    <br><p><br></p>
                </div>

         @else
                <div class="row">

                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <?php  $fecha_inicial=date("d-m-Y ",strtotime($periodo_p->fecha_inicial)) ?>
                                <?php  $fecha_final=date("d-m-Y ",strtotime($periodo_p->fecha_final)) ?>
                                <h3 class="panel-title text-center">El periodo de solicitudes de prorroga es del {{ $fecha_inicial }} al {{ $fecha_final }} en el periodo {{ $periodo_p->periodo }} (si te encuentras en las fechas de solicitud a que revisar si el periodo es el que corresponde, por el contrario lo modificamos en el icono de calendario en el menu). </h3>
                            </div>
                        </div>
                    </div>

                </div>

        @endif
@endif




    </main>
    <script type="text/javascript">

        $(document).ready( function() {

            $("#enviar_prorroga").click(function(event) {
                var id_semestre = $("#id_semestre").val();
                if (id_semestre != null) {


                    $("#form_solicitud_prorroga").submit();
                    $("#enviar_prorroga").attr("disabled", true);

                } else {
                    swal({
                        position: "top",
                        type: "error",
                        title: "selecciona el semestre",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });

        });
    </script>
@endsection
