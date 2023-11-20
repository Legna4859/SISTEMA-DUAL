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
                    <li class="active" ><a href="#">Historial de oficios Recibidos </a>
                    </li>

                    @if($ofic === 0)
                        <li  > <a href="{{url('/oficios/evaluacionsubdirecion')}}">Oficios Recibidos</a></li>
                    @endif
                    @if($ofic > 0)
                        <li  > <a href="{{url('/oficios/evaluacionsubdirecion')}}">Oficios Recibidos<button type="button" class="btn btn-info btn-circle">{{ $ofic }}</button></a></li>
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
                        <h3 class="panel-title text-center">Registro de Oficios recibidos por los profesores {{-- {{Session::has("message")?Session::get("message"):"nada"}} --}}</h3>
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
            <div class="col-md-8 col-md-offset-2">
                <table id="paginar_table" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Nombre del comisionado</th>
                        <th>Descripcion del oficio</th>
                        <th>Fecha  oficio</th>
                        <th>Ver oficio</th>
                        <th>Estado de oficio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($oficioss as $historial)
                        <tr>
                            <td>{{$historial->no_oficio}}</td>
                            <td>{{$historial->titulo}} {{$historial->nombre}}</td>
                            <td>{{$historial->desc_comision}}</td>
                            <?php  $fecha_hora=date("d-m-Y H:i",strtotime($historial->fecha_hora)) ?>
                            <td>{{$fecha_hora}}</td>
                            <td class="text-center">
                                <button class="btn btn-primary edita" id="{{ $historial->id_oficio_personal }}"><i class="glyphicon glyphicon-list"></i></button>
                            </td>

                            @if($historial->id_notificacion==2)
                                <td>Autorizado</td>
                            @endif

                            @if($historial->id_notificacion==3)
                                <td>Rechazado por el D. A. de Personal </td>
                            @endif
                            @if($historial->id_notificacion==6)
                            <td>Rechazado por la sudirección </td>
                            @endif
                            @if($historial->id_notificacion==1)
                                <td>Solicitado al D. A. de personal</td>
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
                "order": [[ 4, "desc" ]]
            } );

            $("#ano_oficio").on('change',function(e) {
                // alert($("#grupos").val());
                var id_anos = $("#ano_oficio").val();
                window.location.href='/oficios/evaluacion/historial_mostrar_profesores/'+id_anos;



            });

        });

    </script>


@endsection