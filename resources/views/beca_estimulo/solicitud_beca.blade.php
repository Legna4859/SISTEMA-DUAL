@extends('layouts.app')
@section('title', 'Estímulo al Desempeño escolar')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Solicitud del Estimulo al Desempeño Escolar</h3>
                    </div>
                </div>
            </div>

        </div>
        @if($alta_carga == 0)
            @if($periodo_beca == 0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3 ">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">El periodo de solicitud de Estimulo al Desempeño Escolar fue o sera del {{ $peri->fecha_inicial }} al  {{ $peri->fecha_final }} del periodo {{$peri->periodo}} </h3>
                        </div>
                    </div>
                </div>

            </div>
            @endif
            <div class="row">

                <div class="col-md-6 col-md-offset-3 ">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tu carga academica no se encuentra autorizada</h3>
                        </div>
                    </div>
                </div>

            </div>
        @else



        @if($estado_beca == 0)
                @if($periodo_beca == 0)
                    <div class="row">

                        <div class="col-md-6 col-md-offset-3 ">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">El periodo de solicitud de Estimulo al Desempeño Escolar fue o sera del {{ $peri->fecha_inicial }} al  {{ $peri->fecha_final }} del periodo {{$peri->periodo}} </h3>
                                </div>
                            </div>
                        </div>

                    </div>
                @else
                <div class="row">

                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">REQUISITOS: <br></h3>
                                <h5>
                                    Requisitos para el 100 % descuento:<br>
                                    -Tu promedio debe ser mayor 95 y menor a 100 si ninguna sumativa<br>
                                    - Ser alumno regular:<br>

                                    Requisitos para el 50 % descuento:<br>
                                    -Tu promedio debe ser mayor 90 y menor a 95 sin ninguna sumativa o tambien  tu promedio debe ser mayor a 95 y menor a 100 con una sumativa .<br>
                                    - Ser alumno regular:<br>
                                    <b>Nota importante: Antes de enviar tu solicitud, selecciona el semestre que cursaste</b>
                                </h5>
                            </div>
                        </div>
                    </div>

                </div>


        @if($estado_estimulo == 1 )

            @if($descuento_estimulo==4)
                <div class="row">

                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">No cumples con los requisitos</h3>
                            </div>
                        </div>
                    </div>

                </div>
                @elseif($descuento_estimulo==1)
                            <div class="row">

                                <div class="col-md-6 col-md-offset-3 ">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h1 class="panel-title text-center">NO.CUENTA: {{$datosalumno[0]->cuenta }} <br>
                                                NOMBRE DEL ESTUDIANTE: {{$datosalumno[0]->nombre}} {{$datosalumno[0]->apaterno}}  {{$datosalumno[0]->amaterno}}<br>
                                                PROGRAMA DE ESTUDIOS: {{$datosalumno[0]->carrera}}<br>
                                                CURP: {{$datosalumno[0]->curp_al}}</h1>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    <div class="row">

                        <div class="col-md-6 col-md-offset-3 ">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Porcentaje del estimulo es del 100 %</h3>
                                </div>
                            </div>
                        </div>

                    </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <label for="exampleInputEmail1">Elige el semestre que cursaste<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control" id="id_semestre" name="id_semestre" >
                                        <option  disabled selected hidden>Selecciona semestre</option>
                                        @foreach($semestres as $semestre)
                                            <option value="{{$semestre->id_semestre}}">{{$semestre->descripcion}}</option>
                                        @endforeach

                                    </select>
                                    <p><br></p>
                                </div>
                            </div>
                <div class="row">

                    <div class="col-md-2 col-md-offset-5 ">
                        <button id="enviar" type="button" class="btn btn-success btn-lg btn-block"  title="Enviar">Enviar solicitud</button>
                        <br>
                        <br>
                    </div>
                    <br>
                    <br>

                </div>

            @elseif($descuento_estimulo==2)
                            <div class="row">

                                <div class="col-md-6 col-md-offset-3 ">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h1 class="panel-title text-center">NO.CUENTA: {{$datosalumno[0]->cuenta }} <br>
                                                NOMBRE DEL ESTUDIANTE: {{$datosalumno[0]->nombre}} {{$datosalumno[0]->apaterno}}  {{$datosalumno[0]->amaterno}}<br>
                                                PROGRAMA DE ESTUDIOS: {{$datosalumno[0]->carrera}}<br>
                                                CURP: {{$datosalumno[0]->curp_al}}</h1>
                                        </div>
                                    </div>
                                </div>

                            </div>
                <div class="row">

                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Porcentaje del estimulo es del 50 %</h3>
                            </div>
                        </div>

                    </div>


                </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <label for="exampleInputEmail1">Elige el semestre que cursaste<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control" id="id_semestre" name="id_semestre" >
                                        <option  disabled selected hidden>Selecciona semestre</option>
                                        @foreach($semestres as $semestre)
                                            <option value="{{$semestre->id_semestre}}">{{$semestre->descripcion}}</option>
                                        @endforeach

                                    </select>
                                    <p><br></p>
                                </div>
                            </div>
                <div class="row">

                    <div class="col-md-2 col-md-offset-5 ">
                        <button id="enviar" type="button" class="btn btn-success btn-lg btn-block"  title="Enviar">Enviar solicitud</button>
                        <br>
                        <br>
                    </div>
                    <br>
                    <br>
                </div>
            @elseif($descuento_estimulo==3)
                            <div class="row">

                                <div class="col-md-6 col-md-offset-3 ">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h1 class="panel-title text-center">NO.CUENTA: {{$datosalumno[0]->cuenta }} <br>
                                                NOMBRE DEL ESTUDIANTE: {{$datosalumno[0]->nombre}} {{$datosalumno[0]->apaterno}}  {{$datosalumno[0]->amaterno}}<br>
                                                PROGRAMA DE ESTUDIOS: {{$datosalumno[0]->carrera}}<br>
                                                CURP: {{$datosalumno[0]->curp_al}}</h1>
                                        </div>
                                    </div>
                                </div>

                            </div>
                <div class="row">

                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Porcentaje del estimulo es del 50 %</h3>
                            </div>
                        </div>


                    </div>


                </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <label for="exampleInputEmail1">Elige el semestre que cursaste<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control" id="id_semestre" name="id_semestre" >
                                            <option  disabled selected hidden>Selecciona semestre</option>
                                            @foreach($semestres as $semestre)
                                                <option value="{{$semestre->id_semestre}}">{{$semestre->descripcion}}</option>
                                            @endforeach

                                    </select>
<p><br></p>
                                </div>
                            </div>
                <div class="row">

                    <div class="col-md-2 col-md-offset-5">
                        <button id="enviar" type="button" class="btn btn-success btn-lg btn-block"  title="Enviar">Enviar solicitud</button>

                        <br>
                        <br>
                    </div>
                    <br>
                    <br>
                </div>

            @endif

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table text-center col-md-12">
                            <thead class="bg-primary" >
                            <tr style="border: 2px solid #3097d1">
                                <th>SEMESTRE</th>
                                <th class="text-center ">MATERIA</th>
                                @for ($i = 0; $i < $mayor_unidades; $i++)
                                    <th class="text-center">
                                        {{($i==0 ? 'I' : ($i==1 ? 'II' :($i==2 ? 'III' :($i==3 ? 'IV' :($i==4 ? 'V' :($i==5 ? 'VI' :($i==6 ? 'VII' :($i==7 ? 'VIII' :($i==8 ? 'IX' :($i==9 ? 'X' :($i==10 ? 'XI' :($i==11 ? 'XII' :($i==12 ? 'XIII' :($i==13 ? 'XIV' :($i==14 ? 'XV' : ' ' )))))))))))))))}}
                                    </th>
                                @endfor
                                <th class="text-center">PROMEDIO</th>
                                <th class="text-center"> T.E.</th>
                            </tr>
                            </thead>
                            <tbody style="border: 2px solid #3097d1">
                            <?php $promedio_sum=0; $num_materias=0;?>
                            @foreach($array_materias as $materias)
                                <?php $cont_res=0;?>
                                <tr>
                                    @if($materias['id_semestre'] ==1)
                                        <th class="text-center">PRIMERO</th>
                                    @elseif($materias['id_semestre'] ==2)
                                        <th class="text-center">SEGUNDO</th>
                                    @elseif($materias['id_semestre'] ==3)
                                        <th class="text-center">TERCERO</th>
                                    @elseif($materias['id_semestre'] ==4)
                                        <th class="text-center">CUARTO</th>
                                    @elseif($materias['id_semestre'] ==5)
                                        <th class="text-center">QUINTO</th>
                                    @elseif($materias['id_semestre'] ==6)
                                        <th class="text-center">SEXTO</th>
                                    @elseif($materias['id_semestre'] ==7)
                                        <th class="text-center">SEPTIMO</th>
                                    @elseif($materias['id_semestre'] ==8)
                                        <th class="text-center">OCTAVO</th>
                                    @elseif($materias['id_semestre'] ==9)
                                        <th class="text-center">NOVENO</th>
                                    @elseif($materias['id_semestre'] ==10)
                                        <th class="text-center">DECIMO</th>
                                    @elseif($materias['id_semestre'] ==11)
                                        <th class="text-center">ONCEAVO</th>
                                    @elseif($materias['id_semestre'] ==12)
                                        <th class="text-center">DOCEAVO</th>
                                    @elseif($materias['id_semestre'] ==13)

                                    @endif
                                    <th class="text-center">{{ $materias['materia'] }}</th>
                                    @foreach($materias['calificaciones'] as $calificaciones)
                                        @if($calificaciones != null)
                                            <td style="background: {{ $calificaciones['calificacion']>=70 ? ' ' : '#FFEE62' }}">
                                                {{ $calificaciones['calificacion']>=70 ? $calificaciones['calificacion'] : 'N.A'  }}
                                            </td>
                                            <?php $cont_res++; ?>
                                        @else
                                        @endif
                                    @endforeach
                                    @for ($i = 0; $i < ($mayor_unidades-$cont_res); $i++)
                                        @if($materias['unidades'] <= ($cont_res+$i) )
                                            <td class="bg-info"></td>
                                        @else
                                            <td>0</td>
                                        @endif
                                    @endfor
                                    @if( $materias['reprobada'] == true || $materias['promedio'] < 70)
                                    <td style="background: #a94442;color:white;"> N.A</td>
                                    @else
                                        <td>{{$materias['promedio']}}</td>
                                        @endif
                                        <?php $materias['promedio'] !=0 ? $promedio_sum+=$materias['promedio']  : 0 ; $num_materias++; ?>
                                    <td>{!! $materias['curso']=='NORMAL' && $materias['esc_alumno'] ? 'ESC'  : ( $materias['curso']=='NORMAL' ? 'O'  : ($materias['curso']=='REPETICION' && $materias['esc_alumno'] ? 'ESC2' : ($materias['curso']=='REPETICION' ? 'O2' : ($materias['curso']=='ESPECIAL' ? 'CE' : ($materias['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="1" ></td>
                                <td colspan="{{$mayor_unidades+1}}" class="text-center"><strong>PROMEDIO</strong></td>
                                 <td>{{$promedio_final }}</td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
       @endif
       @endif

            @else
            <div class="row">
                <div class="col-md-6 col-md-offset-3 ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">NO.CUENTA: {{$datosalumno[0]->cuenta }} <br>
                                NOMBRE DEL ESTUDIANTE: {{$datosalumno[0]->nombre}} {{$datosalumno[0]->apaterno}}  {{$datosalumno[0]->amaterno}}<br>
                                PROGRAMA DE ESTUDIOS: {{$datosalumno[0]->carrera}}<br>
                                SEMESTRE: {{$registro_estado->semestre}}<br>
                                CURP: {{$datosalumno[0]->curp_al}}</h1>
                                PROMEDIO: {{ $registro_estado->promedio }}
                        </div>
                    </div>
                </div>
            </div>
            @if($registro_estado->id_estado == 1 || $registro_estado->id_estado == 3)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">
                                    Se envio correctamente tu solicitud, del
                                    @if($registro_estado->id_descuento == 1)
                                        100 %,
                                        @elseif($registro_estado->id_descuento == 2)
                                        50 %,
                                            @elseif($registro_estado->id_descuento == 3)
                                        50 %
                                    @endif
                                    a la Subdirección de Servicio Escolares.
                                    Espera la publicacion de resultados en la fechas programadas.
                                </h1>

                            </div>
                        </div>
                    </div>
                </div>

                @elseif($registro_estado->id_estado == 2)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">
                                    Tu solicitud fue rechazada.
                                </h1>

                            </div>
                        </div>
                    </div>
                </div>


            @elseif($registro_estado->id_estado == 4)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">
                                    Tu solicitud fue rechazada.
                                </h1>

                            </div>
                        </div>
                    </div>
                </div>v>
                </div>
            @elseif($registro_estado->id_estado == 5)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 ">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title text-center">
                                    Felicidades. Tu solicitud fue autorizada, del
                                    @if($registro_estado->id_descuento == 1)
                                        100 % DE DESCUENTO.
                                    @elseif($registro_estado->id_descuento == 2)
                                        50 % DE DESCUENTO.
                                    @elseif($registro_estado->id_descuento == 3)
                                        50 % DE DESCUENTO.
                                    @endif
                                </h1>

                            </div>
                        </div>
                    </div>
                </div>
                @endif

        @endif

        @endif
    </main>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#enviar").click(function(event) {
                var id_semestre = $("#id_semestre").val();
 if(id_semestre != null) {
     $("#enviar").attr("disabled", true);
     window.location.href = '/beca_estimulo/enviar_solicitud/{{$datosalumno[0]->id_alumno}}/{{$descuento_estimulo}}/{{$promedio_final}}/' + id_semestre;

 }else{
     swal({
         position: "top",
         type: "error",
         title: "No elegiste el semestre",
         showConfirmButton: false,
         timer: 3500
     });
 }
            });
        });
        </script>

@endsection