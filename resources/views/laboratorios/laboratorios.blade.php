@extends('layouts.app')
@section('title', 'Laboratorios')
@section('content')
    <main class="col-md-12">

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Horario del {{$laboratorio->descripcion}}<br> del <?php  $fecha_1=date("d-m-Y ",strtotime($fecha_inicial)) ?><?php  $fecha_2=date("d-m-Y ",strtotime($fecha_final)) ?> {{$fecha_1}} al {{$fecha_2}}  </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-11 col-md-offset-1">

                <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th>Hora/Día</th>
                        <th>Lunes <br> {{$fecha_1}}</th>
                        <?php $nueva1 = strtotime ( '+1 day' , strtotime ( $fecha_inicial ) ) ;
                        $nueva1 = date ( 'd-m-Y' , $nueva1 );?>
                        <th>Martes <br> {{$nueva1}}</th>
                        <?php $nueva2 = strtotime ( '+2 day' , strtotime ( $fecha_inicial ) ) ;
                        $nueva2 = date ( 'd-m-Y' , $nueva2 );?>
                        <th>Miercoles <br>{{$nueva2}}</th>
                        <?php $nueva3 = strtotime ( '+3 day' , strtotime ( $fecha_inicial ) ) ;
                        $nueva3 = date ( 'd-m-Y' , $nueva3 );?>
                        <th>Jueves <br> {{$nueva3}}</th>
                        <?php $nueva4 = strtotime ( '+4 day' , strtotime ( $fecha_inicial ) ) ;
                        $nueva4 = date ( 'd-m-Y' , $nueva4 );?>
                        <th>Viernes <br> {{$nueva4}}</th>
                        <?php $nueva5 = strtotime ( '+5 day' , strtotime ( $fecha_inicial ) ) ;
                        $nueva5 = date ( 'd-m-Y' , $nueva5 );?>
                        <th>Sabado<br> {{$nueva5}}</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $contador=1 ?>

                    @foreach($semanas as $semana)
                        @if($contador==1)
                            <tr>
                                <td class="horario">{{ $semana->hora }}</td>
                                @endif
                                <td id="{{ $semana->id_semana }}" class="horario">
                                    @foreach($array_laboratorios as $horario)
                                        @if($horario['id_semana']==$semana->id_semana)
                                            @if($horario['ofp'] ==2)
                                                <div class="bg-primary">{{$horario['nombre']}}<br>{{$horario['carrera']}}</div>
                                                <a class="eliminar_profesor" id="{{ $horario['registro']}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>

                                            @elseif($horario['ofp'] == 3)
                                                <div class="">  <button class="btn btn-success agregar" id="{{ $horario['id_semana'] }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    <button class="btn btn btn-primary profesor" id="{{ $horario['id_semana'] }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                </div>
                                            @elseif($horario['ofp'] == 4)
                                                <div class="bg-info">{{$horario['nombre']}}<br>{{$horario['carrera']}}</div>
                                                <a class="eliminar" id="{{ $horario['registro']}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                            @endif



                                        @endif
                                    @endforeach

                                </td>


                                <?php $contador++?>
                                @if($contador==7)
                                <?php $contador=1 ?>
                                </td>


                            </tr>
                        @endif

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>

{{--registrar  en un periodo --}}
        <form id="form_registrar_profesor" action="{{url("/laboratorios/registrar/profesor/materia")}}" class="form" role="form" method="POST">
            <div class="modal fade bs-example-modal-lg" id="modal_profesor_periodo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">REGISTRAR EN PERIODO</h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}

                            <input type="hidden" id="id_laboratorio1" name="id_laboratorio1" value="{{ $laboratorio->id_laboratorio }}">
                            <input type="hidden" id="id_semana1" name="id_semana1" value="">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="personal">Personal TESVB</label>
                                            <select name="personal" id="personal" class="form-control ">
                                                <option disabled selected hidden>Selecciona personal</option>
                                                @foreach($personales as $personal)

                                                    <option value="{{$personal->id_personal}}" >{{$personal->nombre}}</option>

                                                @endforeach
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <label for="descripcion1">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa el motivo " style=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary " id="guardar_profesor">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal para agragegar comicionados EN FECHA DETERMINADA--}}
        <form id="form_registrar" action="{{url("/laboratorios/registrar")}}" class="form" role="form" method="POST">
            <div class="modal fade bs-example-modal-lg" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">REGISTRAR EN FECHA DETERMINADA</h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}

                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" value="{{ $laboratorio->id_laboratorio }}">
                            <input type="hidden" id="id_semana" name="id_semana" value="">
                            <input type="hidden" id="fecha_registro" name="fecha_registro" value="">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="personal">Personal TESVB</label>
                                            <select name="personal" id="personal" class="form-control ">
                                                <option disabled selected hidden>Selecciona personal</option>
                                                @foreach($personales as $personal)

                                                    <option value="{{$personal->id_personal}}" >{{$personal->nombre}}</option>

                                                @endforeach
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa el motivo " style=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary " id="guardar">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <div id="modal_eliminado" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="form_delete">
                        {{method_field('DELETE') }}
                        {{ csrf_field() }}
                        ¿Realmente deseas eliminar éste elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id="confirma_eliminado" type="button" class="btn btn-danger" value="Aceptar"></input>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_eliminado_profesor" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="form_delete_profesor">
                        {{method_field('DELETE') }}
                        {{ csrf_field() }}
                        ¿Realmente deseas eliminar éste elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id="confirma_eliminado_profesor" type="button" class="btn btn-danger" value="Aceptar"></input>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            sumaFecha = function(d, fecha)
            {
                var Fecha = new Date();
                var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
                var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
                var aFecha = sFecha.split(sep);
                var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
                fecha= new Date(fecha);
                fecha.setDate(fecha.getDate()+parseInt(d));
                var anno=fecha.getFullYear();
                var mes= fecha.getMonth()+1;
                var dia= fecha.getDate();
                mes = (mes < 10) ? ("0" + mes) : mes;
                dia = (dia < 10) ? ("0" + dia) : dia;
                var fechaFinal = dia+sep+mes+sep+anno;
                return (fechaFinal);
            }
            $("#table_enviado").on('click','.agregar',function(){
                var idof=$(this).attr('id');


                var fecha_inicial1 = "<?php  echo $fecha_inicial;?>";
                var info = fecha_inicial1.split('-');
                var fec1= info[2] + '/' + info[1] + '/' + info[0];

              var  fecha_inicial=fec1;



                if( idof <=15){

                    var resultado= fecha_inicial;
                }
                if( idof >15 && idof <=30){
                    var TuFecha =fecha_inicial;

                    var dias = 1;
                    //nueva fecha sumada

                    var  resultado =  sumaFecha(dias,TuFecha);


                }
                if( idof >30 && idof <=45){
                    var TuFecha = fecha_inicial;

                    var dias = 2;
                    var  resultado =  sumaFecha(dias,TuFecha);

                }
                if( idof >45 && idof <=60){
                    var TuFecha = fecha_inicial;
                    var dias = 3;
                    var  resultado =  sumaFecha(dias,TuFecha);
                }
                if( idof >60 && idof <=75){
                    var TuFecha = fecha_inicial;
                    var dias = 4;
                    var  resultado =  sumaFecha(dias,TuFecha);
                }
                if( idof >75 && idof <=90){
                    var TuFecha = fecha_inicial;
                    var dias = 5;
                    var  resultado =  sumaFecha(dias,TuFecha);

                }
                $('#id_semana').val(idof);
                var res = resultado.split('/').reverse().join('-');;

                $('#fecha_registro').val(res);
                $('#modal_agregar').modal('show');
            });
            $("#table_enviado").on('click','.profesor',function(){
                var id_semana_profesor=$(this).attr('id');
                $('#id_semana1').val(id_semana_profesor);
                $('#modal_profesor_periodo').modal('show');
               // alert(id_semana_profesor);

            });
            $("#guardar").click(function (event) {
                $("#form_registrar").submit();
            });
            $("#form_registrar").validate({
                rules: {

                    personal: "required",
                    descripcion: "required",



                },
            });
            $("#guardar_profesor").click(function (event) {
                $("#form_registrar_profesor").submit();
            });
            $("#form_registrar_profesor").validate({
                rules: {

                    personal: "required",
                    descripcion: "required",



                },
            });
            $("#table_enviado").on('click','.eliminar',function() {
                var id = $(this).attr('id');
                $('#confirma_eliminado').data('id',id);
                $('#modal_eliminado').modal('show');
            });
            $("#confirma_eliminado").click(function(event){
                var id=($(this).data('id'));
                $("#form_delete").attr("action","/laboratorios/eliminar/"+id)
                $("#form_delete").submit();
            });

            $("#table_enviado").on('click','.eliminar_profesor',function() {
                var id = $(this).attr('id');
                $('#confirma_eliminado_profesor').data('id',id);
                $('#modal_eliminado_profesor').modal('show');
            });
            $("#confirma_eliminado_profesor").click(function(event){
                var id=($(this).data('id'));
                $("#form_delete_profesor").attr("action","/laboratorios/eliminar/profesores/"+id)
                $("#form_delete_profesor").submit();
            });
        });
    </script>
@endsection