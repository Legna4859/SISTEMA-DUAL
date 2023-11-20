@extends('layouts.app')
@section('title', 'Registro de Oficios enviados')
@section('content')
    <style type="text/css">

        .btn-circle {

            width: 25px;
            height: 25px;
            text-align: center;
            padding: 3px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px ;
        }
    </style>
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li class="active" ><a href="#">Historial de oficios recibidos</a>
                    </li>

                    @if($ofic === 0)
                        <li  > <a href="{{url('/oficios/evaluacion')}}">Oficios recibidos</a></li>
                    @endif
                    @if($ofic > 0)
                        <li  > <a href="{{url('/oficios/evaluacion')}}">Oficios recibidos<button type="button" class="btn btn-info btn-circle">{{ $ofic }}</button></a></li>
                    @endif
                </ul>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">

                        {{-- {{dd(session()->all())}}--}}
                        <h3 class="panel-title text-center">Registro de oficios recibidos {{-- {{Session::has("message")?Session::get("message"):"nada"}} --}}</h3>
                    </div>
                </div>
            </div>
        </div>
        @if($mostrar == 0)
                <div class="row" >
                    <div class="col-md-3 col-md-offset-4">
                        <div class="form-group">
                            <div class="dropdown">
                                <label for="ano_oficio">Seleccionar año para ver oficios</label>
                                <select name="ano_oficio" id="ano_oficio" class="form-control " required>
                                    @foreach($anos_oficios as $anos_oficio)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        <option value="{{$anos_oficio->id_ano}}" >{{$anos_oficio->descripcion}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if($mostrar == 1)
                <div class="row" >
                    <div class="col-md-3 col-md-offset-4">
                        <div class="form-group">
                            <div class="dropdown">
                                <label for="ano_oficio">Seleccionar año para ver oficios</label>
                                <select name="ano_oficio" id="ano_oficio" class="form-control " required>
                                    @foreach($anos_oficios as $anos_oficio)
                                        @if($anos_oficio->id_ano==$id_anos)
                                            <option value="{{$id_anos}}" selected="selected">{{$anos_oficio->descripcion}}</option>
                                        @else
                                            <option value="{{$anos_oficio->id_ano}}" >{{$anos_oficio->descripcion}} </option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="paginar_table" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Nombre del comisionado</th>
                        <th>Descripción del oficio</th>
                        <th>Dia de la comisión</th>
                        <th>Dia de regreso de la comisión</th>
                        <th>Lugar salida</th>
                        <th>Lugar regreso</th>
                        <th>Ver oficio</th>
                        <th>Estado de oficio</th>
                       <th>Liberar comisionado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($oficioss as $historial)
                        <tr>
                            @if($historial->no_oficio == 0)
                            <td>{{$historial->no_oficio}}</td>
                            <td>{{$historial->titulo}} {{$historial->nombre}}</td>
                            <td>{{$historial->desc_comision}}</td>
                            <?php  $fecha_salida=date("d-m-Y ",strtotime($historial->fecha_salida)) ?>
                            <td>{{$fecha_salida}} hora:{{$historial->hora_r }} </td>
                            <?php  $fecha_regreso=date("d-m-Y ",strtotime($historial->fecha_regreso)) ?>
                            <td >{{$fecha_regreso}} {{$historial->hora_r }} </td>
                                @if($historial->id_lugar_salida == 1)
                                    <td >TESVB  </td>
                                @elseif($historial->id_lugar_salida == 2)

                                    <td >domicilio </td>
                                @endif
                                @if($historial->id_lugar_entrada == 1)
                                    <td >TESVB </td>
                                @elseif($historial->id_lugar_entrada == 2)

                                    <td >domicilio  </td>
                                @endif
                        @else
                            <td style="background-color:lightblue">{{$historial->no_oficio}}</td>
                                <td>{{$historial->titulo}} {{$historial->nombre}}</td>
                                <td >{{$historial->desc_comision}}</td>
                                <?php  $fecha_salida=date("d-m-Y ",strtotime($historial->fecha_salida)) ?>
                                <td >{{$fecha_salida}} {{$historial->hora_s }} </td>
                                <?php  $fecha_regreso=date("d-m-Y ",strtotime($historial->fecha_regreso)) ?>
                                <td >{{$fecha_regreso}} {{$historial->hora_r }} </td>
                                @if($historial->id_lugar_salida == 1)
                                    <td >TESVB </td>
                                    @elseif($historial->id_lugar_salida == 2)

                                    <td >domicilio </td>
                                @endif
                                @if($historial->id_lugar_entrada == 1)
                                    <td >TESVB  </td>
                                @elseif($historial->id_lugar_entrada == 2)

                                    <td >domicilio  </td>
                                @endif

                        @endif



                            <td class="text-center">
                                <button class="btn btn-primary edita" id="{{ $historial->id_oficio_personal }}"><i class="glyphicon glyphicon-list"></i></button>
                            </td>

                            @if($historial->id_notificacion==2)
                                <td>Autorizado</td>
                               @if($historial->estado_oficio==0)
                                <td> <button class="btn btn-primary modifica" id="{{ $historial->id_oficio_personal }}" ><i class="glyphicon glyphicon-cog em2"></i></button>
                                </td>
                                    @elseif($historial->estado_oficio==1)
                                        <td>Cancelado</td>
                                    @elseif($historial->estado_oficio==2)
                                        <td>Tiene permiso de modificar</td>
                                @endif


                            @elseif($historial->id_notificacion==3)
                                <td>Rechazado</td>
                                <td></td>

                            @endif


                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
        @endif

        <div class="modal fade" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">DATOS DEL COMISIONADO</h4>
                    </div>
                    <div class="modal-body">

                        <div id="contenedor_mostrar">

                        </div>
                    </div> <!-- modal body  -->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
        <div id="modal_modificar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form action="/oficios/evaluacion/historialrecibidos/modificar" method="POST" role="form" id="fo">
                    <div class="modal-body">
                            {{ csrf_field() }}
                        <div class="row">
                            ¿Qué desea hacer?
                            <input id="personal" type="hidden"  name="personal"/>
                        </div>
                        <div class="row">
                            <div class="col-md-11 ">
                                <p ><label class="radio-inline"><input type="radio" id="optradio1" name="optradio" value="1"  required>Cancelar comisión</label>
                                </p>
                                <p>
                                    <label class="radio-inline"><input type="radio" id="optradio2" name="optradio" value="2" required>Dar permiso de modificar oficio</label>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" class="btn btn-danger" >Aceptar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#paginar_table").on('click','.edita',function(){
                var idof=$(this).attr('id');

                $.get("/oficios/vercomision/"+idof,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });
            });
            $('#paginar_table').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
            $("#paginar_table").on('click','.modifica',function(){
                var id=$(this).attr('id');
                $('#personal').val(id);
                $('#modal_modificar').modal('show');
            });
            $("#ano_oficio").on('change',function(e) {
                // alert($("#grupos").val());
                var id_anos = $("#ano_oficio").val();
                window.location.href='/oficios/evaluacion/historial_mostrar/'+id_anos;



            });


        });

    </script>


@endsection