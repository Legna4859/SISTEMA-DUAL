@extends('layouts.app')
@section('title', 'Calificaciones')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">REGISTRO DE CALIFICACIONES DE <br> {{$nombre_alumno}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <input type="{{ ($calificar_dual==0 ? 'button' : 'hidden') }}" class="btn btn-success tooltip-options " id="cal_dual" name="cal_duales" data-toggle="tooltip" data-placement="top" title="Terminar calificar dual" target="_blank" value="Terminar de calificar dual">
            @if($calificar_dual == 1)
            <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/acta_dual_actual/'.$id_alumno.'/'.$id_periodo)}}')">Acta dual</button> <a></a>
                <a href="#" id="modificar_mentor"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Modificar mentor</a>

            @endif
                <br>
            <br>
        </div>
    </div>
    <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table text-center col-md-12">
                        <thead class="bg-info" >
                        <tr style="border: 2px solid #3097d1">
                            <th class="text-center ">MATERIA</th>
                            @for ($i = 0; $i < $mayor_unidades; $i++)
                                <th class="text-center">
                                    {{($i==0 ? 'I' : ($i==1 ? 'II' :($i==2 ? 'III' :($i==3 ? 'IV' :($i==4 ? 'V' :($i==5 ? 'VI' :($i==6 ? 'VII' :($i==7 ? 'VIII' :($i==8 ? 'IX' :($i==9 ? 'X' :($i==10 ? 'XI' :($i==11 ? 'XII' :($i==12 ? 'XIII' :($i==13 ? 'XIV' :($i==14 ? 'XV' : ' ' )))))))))))))))}}
                                </th>
                            @endfor
                            <th class="text-center">PROMEDIO</th>
                            <th class="text-center"> T.E.</th>
                            @if($calificar_dual == 0)
                            <th class="text-center">Calificar</th>
                            @endif

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
                                <td style="background: {{ $materias['promedio']>=70 ? '' : '#a94442;color:white;' }}">{{ $materias['promedio']>=70 ?  $materias['promedio'] : 'N.A' }}</td>
                                <?php $materias['promedio'] !=0 ? $promedio_sum+=$materias['promedio']  : 0 ; $num_materias++; ?>
                                <td>{!! $materias['curso']=='NORMAL' && $materias['esc_alumno'] ? 'ESC'  : ( $materias['curso']=='NORMAL' ? 'O'  : ($materias['curso']=='REPETICION' && $materias['esc_alumno'] ? 'ESC2' : ($materias['curso']=='REPETICION' ? 'O2' : ($materias['curso']=='ESPECIAL' ? 'CE' : ($materias['curso']=='GLOBAL' ? 'EG': '' )))))!!}</td>
                                @if($calificar_dual == 0)
                                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary calificar_dual" data-id_carga="{{$materias['id_carga_academica']}}"   value="Calificar"></td>
                                @endif
                            </tr>
                        @endforeach
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
    </div>

<div class="modal fade" id="modal_calificar_dual_actual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="calificar_duales_actuales" class="form"  action="{{url("/registrar_cal_duales/")}}" role="form" method="POST" >
                {{ csrf_field() }}
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Calificar a estudiante dual</h4>
                </div>
                <div id="contenedor_cal_dual_actual">

                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button  id="calificacion_duales_actuales" type="button"   class="btn btn-primary " >Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <div id="modal_termino_calificar_dual" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-content" role="document">
            <div class="modal-content">
                <form action="" method="POST"  role="form" id="form_termino_calificar_actuales">
                    {{ csrf_field() }}
                <div class="modal-body">

                        ¿Ya termino de evaluar al estudiante dual?
                        <div class="row">
                        <div class="col-md-12 ">

                            <label for="exampleInputEmail1"> SELECCIONA MENTOR DUAL<b style="color:red; font-size:23px;">*</b></label>

                            <select class="form-control" placeholder="selecciona una Opcion" id="mentor" name="mentor" required>
                                <option disabled selected>Selecciona una opción</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{$profesor->id_personal}}">{{$profesor->titulo}} <b> {{$profesor->nombre}}</b></option>
                                @endforeach
                            </select>

                        </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id="confirma_termino_dual" type="button" class="btn btn-danger" value="Aceptar"></input>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_modificar_mentor" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-content" role="document">
            <div class="modal-content">
                <form action="" method="POST"  role="form" id="form_modificar_mentor">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12 ">

                                <label for="exampleInputEmail1">MODIFICAR MENTOR DUAL<b style="color:red; font-size:23px;">*</b></label>

                                <select class="form-control" placeholder="selecciona una Opcion" id="mentor" name="mentor" required>
                                    <option disabled selected>Selecciona una opción</option>
                                    @foreach($profesores as $profesor)
                                        @if($profesor->id_personal==$mentor)
                                            <option value="{{$profesor->id_personal}}" selected="selected">{{$profesor->titulo}} <b> {{$profesor->nombre}}</b></option>
                                        @else
                                        <option value="{{$profesor->id_personal}}">{{$profesor->titulo}} <b> {{$profesor->nombre}}</b></option>
                                    @endif
                                            @endforeach
                                </select>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_modificacion_mentor" type="button" class="btn btn-danger" value="Aceptar"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#form_termino_calificar_actuales").validate({
            rules: {

                mentor: "required",
            },
        });
        $(".calificar_dual").click(function (event) {
            var id_carga_academica = $(this).data("id_carga");
           // alert(id_carga_academica);
            $.get("/calificar_estudiante_duales_actuales/" + id_carga_academica, function (request) {
                $("#contenedor_cal_dual_actual").html(request);
                $("#modal_calificar_dual_actual").modal('show');
            });
        });
        $("#calificacion_duales_actuales").click(function(event){
            $("#calificacion_duales_actuales").attr("disabled", true);
            $("#calificar_duales_actuales").submit();
        });
        $("#modificar_mentor").click(function(event) {

            $('#modal_modificar_mentor').modal('show');
        });
        $("#cal_dual").click(function(event) {

            $('#modal_termino_calificar_dual').modal('show');
        });
        $("#confirma_termino_dual").click(function(event){
            var id_alumno="{{ $id_alumno }}";
            var id_periodo="{{ $id_periodo }}";
            $("#form_termino_calificar_actuales").attr("action","/terminar_calificar/duales_actuales/"+id_alumno+"/"+id_periodo)
            $("#form_termino_calificar_actuales").submit();
           // $("#confirma_termino_dual").attr("disabled", true);
        });
        $("#confirma_modificacion_mentor").click(function(event){
            var id_alumno="{{ $id_alumno }}";
            var id_periodo="{{ $id_periodo }}";
            $("#form_modificar_mentor").attr("action","/modificar_mentor/"+id_alumno+"/"+id_periodo)
            $("#form_modificar_mentor").submit();
            // $("#confirma_termino_dual").attr("disabled", true);
        });
    });
</script>
@endsection