@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Calificaciones de ingles')
@section('content')
    <main class="col-md-12">
        <?php
        $unidad = Session::get('id_unidad_admin');
        ?>
        <div class="row">
            <div class="col-sm-4 col-md-offset-4">
                <div class="panel panel-success " >
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">CALIFICACIONES DE INGLES <br> NIVEL: {{$nivel}}  GRUPO: {{$id_grupo}}</h3>
                    </div>

                </div>

            </div>
        </div>
        @if($alumnos_inscritos ==0)
            <div class="row">
                <div class="col-sm-4 col-md-offset-4">
                    <div class="panel panel-danger " >
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No hay usuarios inscrito en este grupo</h3>
                        </div>

                    </div>

                </div>
            </div>
        @else
                @if($calificar_unidad['unidad1'] ==13)
                    <div class="row">
                        <div class="col-md-1 col-md-offset-1">
                            <td> <button type="button" class="btn btn-warning center" onclick="window.open('{{url('/ingles/lista_asistencia/'.$id_nivel.'/'.$id_grupo)}}')">Lista de asistencia</button></td>
                        </div>
                        <div class="col-md-1 col-md-offset-7">
                            <td> <button type="button" class="btn btn-success center" onclick="window.open('{{url('/ingles/acta_ordinaria/'.$id_nivel.'/'.$id_grupo)}}')">Acta ordinaria</button></td>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-1 col-md-offset-1">
                            <td> <button type="button" class="btn btn-warning center" onclick="window.open('{{url('/ingles/lista_asistencia/'.$id_nivel.'/'.$id_grupo)}}')">Lista de asistencia</button></td>
                        </div>

                    </div>
              @endif
            <div class="row" id="consultar">
                <div class="col-md-10 col-md-offset-1">
                    <br>
                    <table id="table_enviado" class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th>NO.</th>
                            <th>NO. CUENTA </th>
                            <th>NOMBRE DEL USUARIO</th>
                            <th>CARRERA</th>
                            <th>SPEAKING</th>
                            <th>WRITING</th>
                            <th>READING</th>
                            <th>LISTENING</th>
                            <th>PROMEDIO</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $numero=1;
                        @endphp
                        @foreach($array_calificaciones as $alumnos)

                            <tr>
                                <td >{{ $numero }}</td>
                                @if($alumnos['estado_nivel'] == 1)
                                    <td style="color: black">{{ $alumnos['cuenta']}}</td>
                                @elseif($alumnos['estado_nivel']== 2)
                                    <td  style="background: green; color: white;">{{$alumnos['cuenta'] }}</td>
                                @elseif($alumnos['estado_nivel'] == 3)
                                    <td  style="background: yellow; color: orange">{{ $alumnos['cuenta'] }}</td>
                                @elseif($alumnos['estado_nivel'] == 4)
                                    <td  style="background: red; color: white">{{ $alumnos['cuenta'] }}</td>
                                @endif

                                <td style="color: black; text-align: left">{{ $alumnos['nombre']}}</td>
                                <td style="color: black; text-align: left">{{ $alumnos['carrera']}}</td>
                                @if($calificar_unidad['unidad1'] ==9 || $calificar_unidad['unidad1'] ==5)
                                    <td style="color: black">{{$alumnos['unidad1']}}</td>
                                    <td style="color: black">{{$alumnos['unidad2']}}</td>
                                    <td style="color: black">{{$alumnos['unidad3']}}</td>
                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                    <td style="color: black; text-align: left">{{ $alumnos['promedio']}}</td>


                                @elseif($calificar_unidad['unidad1'] ==1)
                                    <td class="text-center"><input id="error_{{$alumnos['id_carga']}}" type="text" value="0" class=" text-center calificacion_1" style="width:7em; border-radius: 4px" data-id="{{$alumnos['id_carga']}}" name="calificacion_1" ></td>
                                    <td style="color: black">{{$alumnos['unidad2']}}</td>
                                    <td style="color: black">{{$alumnos['unidad3']}}</td>
                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                    <td style="color: black; text-align: left">{{ $alumnos['promedio']}}</td>
                                @elseif($calificar_unidad['unidad1'] ==10 ||  $calificar_unidad['unidad1'] ==6)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">
                                            @if($unidad ==19)
                                                {{$alumnos['unidad1']}}
                                             <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                        @endif
                                        </td>
                                        @else
                                    <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                            <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                        @endif  </td>
                                    @endif
                                    <td style="color: black">{{$alumnos['unidad2']}}</td>
                                    <td style="color: black">{{$alumnos['unidad3']}}</td>
                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                        @if($alumnos['promedio']<80)
                                            <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                        @else
                                            <td style="color: black">{{$alumnos['promedio']}}</td>
                                        @endif
                                @elseif($calificar_unidad['unidad1'] ==2)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                               <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                 <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif </td>
                                    @endif
                                        <td class="text-center"><input id="error_{{$alumnos['id_carga']}}" type="text" value="0" class=" text-center calificacion_2" style="width:7em; border-radius: 4px" data-id="{{$alumnos['id_carga']}}" name="calificacion_2" ></td>
                                        <td style="color: black">{{$alumnos['unidad3']}}</td>
                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                    @if($alumnos['promedio']<80)
                                        <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                    @else
                                        <td style="color: black">{{$alumnos['promedio']}}</td>
                                    @endif
                                @elseif($calificar_unidad['unidad1'] ==7)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                               <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif </td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                 <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif   </td>
                                    @endif
                                        @if($alumnos['unidad2']<80)
                                            <td style="color: black;background: red;">{{$alumnos['unidad2']}} @if($unidad ==19)
                                                    <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                                @endif</td>
                                        @else
                                            <td style="color: black">{{$alumnos['unidad2']}} @if($unidad ==19)
                                                    <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                                @endif</td>
                                        @endif

                                    <td style="color: black">{{$alumnos['unidad3']}}</td>
                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                    @if($alumnos['promedio']<80)
                                        <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                    @else
                                        <td style="color: black">{{$alumnos['promedio']}}</td>
                                    @endif

                                @elseif($calificar_unidad['unidad1'] ==3)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif   </td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                 <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif </td>
                                    @endif
                                    @if($alumnos['unidad2']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad2']}} @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad2']}} @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif

                                    <td class="text-center"><input id="error_{{$alumnos['id_carga']}}" type="text" value="0" class=" text-center calificacion_3" style="width:7em; border-radius: 4px" data-id="{{$alumnos['id_carga']}}" name="calificacion_3" ></td>

                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                    @if($alumnos['promedio']<80)
                                        <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                    @else
                                        <td style="color: black">{{$alumnos['promedio']}}</td>
                                    @endif
                                @elseif($calificar_unidad['unidad1'] ==8)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                 <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif </td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif
                                    @if($alumnos['unidad2']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad2']}}  @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad2']}}  @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif
                                        @if($alumnos['unidad3']<80)
                                            <td style="color: black;background: red;">{{$alumnos['unidad3']}} <a class="modificar_cal3"   href="#" data-id_carga_academica3="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a></td>
                                        @else
                                            <td style="color: black">{{$alumnos['unidad3']}} <a class="modificar_cal3"   href="#" data-id_carga_academica3="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a></td>
                                        @endif

                                    <td style="color: black">{{$alumnos['unidad4']}}</td>
                                    @if($alumnos['promedio']<80)
                                        <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                    @else
                                        <td style="color: black">{{$alumnos['promedio']}}</td>
                                    @endif
                                @elseif($calificar_unidad['unidad1'] ==4)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                 <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif </td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                               <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif </td>
                                    @endif
                                    @if($alumnos['unidad2']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad2']}} @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                                @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad2']}} @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif
                                    @if($alumnos['unidad3']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad3']}}
                                            @if($unidad ==19)
                                            <a class="modificar_cal3"   href="#" data-id_carga_academica3="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif
                                        </td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad3']}}   @if($unidad ==19)
                                                <a class="modificar_cal3"   href="#" data-id_carga_academica3="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif

                                        <td class="text-center"><input id="error_{{$alumnos['id_carga']}}" type="text" value="0" class=" text-center calificacion_4" style="width:7em; border-radius: 4px" data-id="{{$alumnos['id_carga']}}" name="calificacion_4" ></td>

                                    @if($alumnos['promedio']<80)
                                        <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                    @else
                                        <td style="color: black">{{$alumnos['promedio']}}</td>
                                    @endif
                                @elseif($calificar_unidad['unidad1'] ==13)
                                    @if($alumnos['unidad1']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                 <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad1']}}   @if($unidad ==19)
                                                <a class="modificar_cal1"   href="#" data-id_carga_academica1="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif
                                    @if($alumnos['unidad2']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad2']}}
                                            @if($unidad ==19)
                                            <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif
                                        </td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad2']}}  @if($unidad ==19)
                                                <a class="modificar_cal2"   href="#" data-id_carga_academica2="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif
                                    @if($alumnos['unidad3']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad3']}}   @if($unidad ==19)
                                                <a class="modificar_cal3"   href="#" data-id_carga_academica3="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad3']}}  @if($unidad ==19)
                                                <a class="modificar_cal3"   href="#" data-id_carga_academica3="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif

                                    @if($alumnos['unidad4']<80)
                                        <td style="color: black;background: red;">{{$alumnos['unidad4']}}
                                            @if($unidad ==19)
                                            <a class="modificar_cal4"   href="#" data-id_carga_academica4="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @else
                                        <td style="color: black">{{$alumnos['unidad4']}}
                                            @if($unidad ==19)
                                            <a class="modificar_cal4"   href="#" data-id_carga_academica4="{{$alumnos['id_carga']}}"><span class="oi oi-pencil p-1"></span></a>
                                            @endif</td>
                                    @endif
                                    @if($alumnos['promedio']<80)
                                        <td style="color: black;background: red;">{{$alumnos['promedio']}}</td>
                                    @else
                                        <td style="color: black">{{$alumnos['promedio']}}</td>
                                    @endif

                                @endif


                            </tr>


                            @php
                                ++$numero;
                            @endphp
                        @endforeach

                            @if($calificar_unidad['unidad1'] == 9)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                </tr>
                               @elseif($calificar_unidad['unidad1'] ==1)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="1" data-toggle="tooltip" data-placement="top" value="guardar"></td>
                                </tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                            @elseif($calificar_unidad['unidad1'] ==5)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="1" data-toggle="tooltip" data-placement="top" title="La fecha limite para evaluar expiro" value="guardar" disabled></td>
                                </tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                                <td style="background: #5cb750">0%</td>
                            @elseif($calificar_unidad['unidad1'] ==10)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                                    @elseif($calificar_unidad['unidad1'] ==6)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="2" data-toggle="tooltip" data-placement="top" title="La fecha limite para evaluar expiro" value="guardar" disabled></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                            @elseif($calificar_unidad['unidad1'] ==2)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="2" data-toggle="tooltip" data-placement="top"  value="guardar"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                    <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                        @elseif($porcentaje['unidad1'] < 30)
                                            <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                            @elseif($calificar_unidad['unidad1'] ==7)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="3" data-toggle="tooltip" data-placement="top" title="La fecha limite para evaluar expiro" value="guardar" disabled></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad2'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                            @elseif($calificar_unidad['unidad1'] ==3)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="3" data-toggle="tooltip" data-placement="top"  value="guardar"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad2'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                            @elseif($calificar_unidad['unidad1'] ==8)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="4" data-toggle="tooltip" data-placement="top" title="La fecha limite para evaluar expiro" value="guardar" disabled></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad2'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad3'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @elseif($porcentaje['unidad3'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @elseif($porcentaje['unidad3'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                            @elseif($calificar_unidad['unidad1'] ==4)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary tooltip-options link" id="guardar_calificacion" name="guardar_calificacion" data-token="{{ csrf_token() }}" data-id_unidad="4" data-toggle="tooltip" data-placement="top"  value="guardar"></td>
                                </tr>
                                <tr>
                                  
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad2'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad3'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @elseif($porcentaje['unidad3'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @elseif($porcentaje['unidad3'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @endif
                                    <td style="background: #5cb750">0%</td>
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @endif
                                </tr>
                            @elseif($calificar_unidad['unidad1'] ==13)
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                        <td></td>

                                    @if($porcentaje['unidad1'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @elseif($porcentaje['unidad1'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad1']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad2'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @elseif($porcentaje['unidad2'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad2']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad3'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @elseif($porcentaje['unidad3'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @elseif($porcentaje['unidad3'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad3']}}%</td>
                                    @endif
                                    @if($porcentaje['unidad4'] == 30)
                                        <td style="background: yellow;color: white">{{$porcentaje['unidad4']}}%</td>
                                    @elseif($porcentaje['unidad4'] < 30)
                                        <td style="background: red;color: white">{{$porcentaje['unidad4']}}%</td>
                                    @elseif($porcentaje['unidad4'] > 30)
                                        <td style="background: green;color: white">{{$porcentaje['unidad4']}}%</td>
                                    @endif
                                    @if($porcentaje['promedio_general'] == 30)
                                        <td style="background: yellow;color: white" >{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] < 30)
                                        <td style="background: red;color: white">{{ $porcentaje['promedio_general']}}%</td>
                                    @elseif($porcentaje['promedio_general'] >30)
                                        <td style="background: green; color: white">{{ $porcentaje['promedio_general']}}%</td>
                            @endif
                        @endif





                        </tbody>
                    </table>
                </div>
            </div>






        @endif
        <div class="modal fade" id="modal_modificar_cal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="form_mod_periodo_ingles" class="form" action="{{url("/ingles/guardar_modificacion/calificacion")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Calificación</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_modificar_cal">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button     type="submit"  style="" class="btn btn-primary"  >Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".modificar_cal1").click(function () {

                var id_carga_academica1=$(this).data("id_carga_academica1");
                var id_unidad=1;
                $.get("/ingles/modificar_cal/ingles/"+id_carga_academica1+"/"+id_unidad,function (request) {
                    $("#contenedor_modificar_cal").html(request);
                    $("#modal_modificar_cal").modal('show');
                });

            });
            $(".modificar_cal2").click(function () {

                var id_carga_academica2=$(this).data("id_carga_academica2");
                var id_unidad=2;
                $.get("/ingles/modificar_cal/ingles/"+id_carga_academica2+"/"+id_unidad,function (request) {
                    $("#contenedor_modificar_cal").html(request);
                    $("#modal_modificar_cal").modal('show');
                });

            });
            $(".modificar_cal3").click(function () {

                var id_carga_academica3=$(this).data("id_carga_academica3");
                var id_unidad=3;
                $.get("/ingles/modificar_cal/ingles/"+id_carga_academica3+"/"+id_unidad,function (request) {
                    $("#contenedor_modificar_cal").html(request);
                    $("#modal_modificar_cal").modal('show');
                });

            });
            $(".modificar_cal4").click(function () {

                var id_carga_academica4=$(this).data("id_carga_academica4");
                var id_unidad=4;
                $.get("/ingles/modificar_cal/ingles/"+id_carga_academica4+"/"+id_unidad,function (request) {
                    $("#contenedor_modificar_cal").html(request);
                    $("#modal_modificar_cal").modal('show');
                });

            });
            $("#guardar_calificacion").click(function ()
            {

                var calificaciones= { alumno:[] };
                var id_unidad=$(this).data("id_unidad");
                var token=$(this).data("token");
                cal_noValida=false;
                cal_reprobatoria=false;
                var cal_rep=0;
                $(".calificacion_"+id_unidad).each(function () {
                    var id_carga_academica=$(this).data("id");
                    var calificacion=$(this).val();
                    document.getElementById("error_"+id_carga_academica).style.backgroundColor = "white";
                    document.getElementById("error_"+id_carga_academica).style.color = "black";
                    if(calificacion<0 || calificacion>100 || !/^([0-9])*$/.test(calificacion))
                    {
                        cal_noValida=true;
                        document.getElementById("error_"+id_carga_academica).style.color = "white";
                        document.getElementById("error_"+id_carga_academica).style.backgroundColor = "#cd4545";
                    }
                    else if(calificacion>=0 && calificacion<80)
                    {
                        cal_reprobatoria=true;
                        cal_rep++;
                        document.getElementById("error_"+id_carga_academica).style.color = "white";
                        document.getElementById("error_"+id_carga_academica).style.backgroundColor = "#f3a333";
                    }
                    calificaciones.alumno.push({
                        "id_carga_academica" : id_carga_academica,
                        "calificacion" : calificacion,
                        "id_unidad" : id_unidad
                    });
                });
                var data_cal = JSON.stringify(calificaciones);
                if(cal_noValida)
                {
                    swal({
                        type: "error",
                        title: "Existen calificaciones erroneas",
                        text: 'las calificaciones erroneas estan marcadas en rojo',
                        showConfirmButton: true,
                    });
                }
                else
                {
                    if(cal_reprobatoria)
                    {
                        //pide confirmacion
                        Swal({
                            title: 'Ingreso '+(cal_rep==1 ? ''+cal_rep+' calificación reprobatoria': ''+cal_rep+' calificaciones reprobatorias'),
                            text: "¿Esta seguro que desea continuar?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, continuar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                //calificaciones con sumativas
                                $("#guardar_calificacion").attr("disabled", true);
                                $.post('/ingles/agregar_calificaciones_unidad/{{ $id_nivel }}/{{ $id_grupo }}/'+id_unidad+'/insert_calificacion',{_token:token,calificaciones:data_cal},function(request)
                                {
                                    swal({
                                        type: "success",
                                        title: "Registro exitoso",
                                        showConfirmButton: false,
                                        timer: 1500
                                    }). then(function(result)
                                    {
                                        location.reload(true);
                                    });
                                });
                            }
                        })
                    }
                    else
                    {
                        $("#guardar_calificacion").attr("disabled", true);
                        $.post('/ingles/agregar_calificaciones_unidad/{{ $id_nivel }}/{{ $id_grupo }}/'+id_unidad+'/insert_calificacion',{_token:token,calificaciones:data_cal},function(request)
                        {
                            swal({
                                type: "success",
                                title: "Registro exitoso",
                                showConfirmButton: false,
                                timer: 1500
                            }). then(function(result)
                            {
                                location.reload(true);
                            });
                        });
                    }
                }
            });

        });
    </script>
@endsection