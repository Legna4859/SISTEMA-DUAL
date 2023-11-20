@extends('layouts.app')
@section('title', 'Calificaciones')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <p>Nombre del alumno: {{ $datos_alumno->nombre }}  {{ $datos_alumno->apaterno }} {{ $datos_alumno->amaterno }}</p>
        </div>

    </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-8">
                <button type="button" class="btn btn-success acta_materias" >Boleta de calificaciones</button>
            </div>
            <br>
            <br>
        </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">

                <div class="col-md-12">
                    <table class="table text-center col-md-12">
                        <thead class="bg-primary" >
                        <tr style="border: 2px solid #3097d1">
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
                                <td style="background: {{ $materias['promedio']>=70  ? '' : '#a94442;color:white;' }}">{{ $materias['promedio']>=70 ?  $materias['promedio'] : 'N.A' }}</td>
                                <?php $materias['promedio'] !=0 ? $promedio_sum+=$materias['promedio']  : 0 ; $num_materias++; ?>
                                <td>{!! $materias['curso']=='NORMAL' && $materias['esc_alumno'] ? 'ESC'  : ( $materias['curso']=='NORMAL' ? 'O'  : ($materias['curso']=='REPETICION' && $materias['esc_alumno'] ? 'ESC2' : ($materias['curso']=='REPETICION' ? 'O2' : ($materias['curso']=='ESPECIAL' ? 'CE' : ($materias['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                            </tr>
                        @endforeach
                            @if($cal_resi == 0)
                            @else
                                <th class="text-center"> RESIDENCIA PROFESIONAL</th>
                                <td colspan="{{$mayor_unidades}}" class="text-center"></td>
                                @if($calificada == 0)
                                    <td class="text-center" >0</td>
                                    <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary calificar_residencia" data-id_carga="{{$id_alumno}}"   value="Calificar"></td>


                                @else
                                    <?php $promedio_sum+=$resi->calificacion; $num_materias++; ?>
                                        @if($resi->calificacion < 70)
                                           <td class="text-center" style="background: #FF0000">N.A.</td>
                                        @else
                                            <td class="text-center" style="">{{$resi->calificacion}}</td>

                                        @endif
                                @endif

                            @endif
                        <tr>
                            <td colspan="1" ></td>
                            <td colspan="{{$mayor_unidades}}" class="text-center"><strong>PROMEDIO</strong></td>
                            <?php $promedio=$promedio_sum/($num_materias==0 ? 1 : $num_materias) ?>
                            <td>{{ $pro=number_format($promedio, 2, '.', '') }}</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-striped col-md-12">
                        <thead class="bg-primary" >
                        <tr style="border: 2px solid #3097d1">
                            <th class="col-md-4 ">DOCENTE</th>
                            <th class="col-md-7 ">MATERIA</th>
                            <th class="col-md-1 ">GRUPO</th>
                        </tr>
                        </thead>
                        <tbody style="border: 2px solid #3097d1">
                        @foreach($profesores as $profesor)
                            <tr>
                                <td>{{$profesor->nombre}}</td>
                                <td>{{$profesor->materias}}</td>
                                <td>{{$profesor->id_semestre}}0{{$profesor->grupo}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

        </div>
    </div>

    <div id="modal_calificar_residencia" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-content" role="document">
            <div class="modal-content">
                <form  method="POST" role="form" action="{{url("/servicios_escolares/historial_academico/alumno/residencia/".$id_alumno)}}">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2"><h3>Calificar Residencia</h3></div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <label>Calificación</label>
                                <input class="form-control"  type="number" max="100" min="0" id="cal_residencia" name="cal_residencia"  required>
                            </div>

                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <label>Fecha de termino</label>
                                <input class="form-control datepicker"  type="text"  id="fecha_residencia" name="fecha_residencia"  placeholder="dd/MM/YYYY" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Aceptar"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_acta_materias" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-content" role="document">
            <div class="modal-content">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2"><h3>Registrar datos</h3></div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">ELIGE TURNO<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="turno" name="turno" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($turnos as $turno)
                                            <option value="{{$turno->id_turno}}">{{$turno->turno}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">ELIGE SEMESTRE<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="semestre" name="semestre" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($semestres as $semestre)
                                            <option value="{{$semestre->id_semestre}}">{{$semestre->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">ELIGE GRUPO<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="grupo" name="grupo" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($grupos as $grupo)
                                            <option value="{{$grupo->id_grupo}}">{{$grupo->grupo}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="button" class="btn btn-primary " id="abrir_pdf" value="Aceptar"></input>
                    </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#abrir_pdf").click(function(event) {
                var turno = $("#turno").val();
                var semestre = $("#semestre").val();
                var grupo = $("#grupo").val();

                if (turno!= null && semestre != null && grupo != null) {


                    var link="/acta_materias/{{$id_alumno}}/"+turno+"/"+semestre+"/"+grupo;
                    window.open(link);
                    $('#modal_acta_materias').modal('hide');


                } else {
                    swal({
                        position: "top",
                        type: "error",
                        title: "hay un campo vacio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });

            $(".calificar_residencia").click(function(event) {

                $('#modal_calificar_residencia').modal('show');
            });
            $(".acta_materias").click(function(event) {

                $('#modal_acta_materias').modal('show');
            });

            $('#fecha_residencia').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: +0,
            });

        });

    </script>
@endsection
