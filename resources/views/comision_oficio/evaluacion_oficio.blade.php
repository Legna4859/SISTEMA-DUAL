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
                    <li>
                        <a href="{{url('/oficios/evaluacion/historialrecibidos')}}">Historial de oficios Recibidos</a>
                    </li>

                    @if($ofic == 0)
                        <li class="active" ><a href="#">Oficios Recibidos</a></li>
                    @endif
                    @if($ofic > 0)
                    <li  class="active"><a href="#">Oficios Recibidos<button type="button" class="btn btn-info btn-circle">{{ $ofic }}</button></a></li>
                    @endif
                </ul>
                <br>
            </div>
        </div>
                    <div class="row">
                        <div class="col-md-5 col-md-offset-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">

                                    <h3 class="panel-title text-center">Registro de Oficios recibidos {{-- {{Session::has("message")?Session::get("message"):"nada"}} --}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1">
                            <table id="paginar_table" class="table table-bordered table-resposive">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Fecha solicitud</th>
                                    <th>Nobre del solicitante de la comisión</th>
                                   {{-- <th>Descripción del oficio</th>--}}
                                    <th>Permiso de modificación</th>
                                    <th>Comisionados</th>
                                    <th>Mostrar oficio</th>
                                    <th>Evaluar oficio</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($solicitudes as $oficio)
                                    <tr>
                                        <td rowspan="{{$oficio->comisionados->count()+1}}">{{ $oficio->id_oficio }}</td>
                                        <?php  $fecha_hora=date("d-m-Y H:i",strtotime($oficio->fecha_hora)) ?>
                                        <td rowspan="{{$oficio->comisionados->count()+1}}">{{ $fecha_hora }}</td>
                                        @foreach($oficio->usuario as $usuario)

                                            @foreach($usuario->abreviaciones_prof as $abreviacion)
                                                @foreach($abreviacion->abreviaciones as $titulo)
                                            <td rowspan="{{$oficio->comisionados->count()+1}}"><b>{{ $titulo->titulo }}</b> {{ $usuario->nombre }}</td>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                      {{--   <td rowspan="{{$oficio->comisionados->count()+1}}">{{ $oficio->desc_comision }}</td>--}}

@if($oficio->comisiones->count() ==0)
                                            <td rowspan="{{$oficio->comisionados->count()+1}}" >
                                                <button class="btn btn-primary modifica" id="{{$oficio->id_oficio}}"><i class="glyphicon glyphicon-cog em2"></i></button>
                                            </td>
                                            @else
                                            <td rowspan="{{$oficio->comisionados->count()+1}}" >
                                                  </td>
    @endif

                                    </tr>
                                            @foreach($oficio->comisionados as $ofic)

                                                @foreach($ofic->personal as $personal)
                                                    <tr>
                                                         <td> {{$personal->nombre}}</td>

                                                        <td class="text-center">
                                                            <button class="btn btn-primary edita" id="{{$ofic->id_oficio_personal}}"><i class="glyphicon glyphicon-list"></i></button>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-info btn-circle" onclick="window.location='{{ url('/oficios/aceptado/'.$ofic->id_oficio_personal ) }}'" title="Autorizar"><i class="glyphicon glyphicon-ok"></i></button>
                                                            <button type="button" class="btn btn-warning btn-circle" onclick="window.location='{{ url('/oficios/rechazado/'.$ofic->id_oficio_personal ) }}'" title="Rechazar"><i class="glyphicon glyphicon-remove"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                              @endforeach

                                @endforeach
                                </tbody>
                            </table>


                        </div>

                    </div>

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
<form action="" method="POST" role="form" id="form_modificar">
    {{ csrf_field() }}
</form>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#paginar_table").on('click','.edita',function(){
                var idof=$(this).attr('id');

                $.get("/oficios/vercomision/"+idof,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });
            });
            $("#paginar_table").on('click','.modifica',function(){
                var idof=$(this).attr('id');


                swal({
                    title: "¿Seguro que desea dar permiso de modificar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_modificar").attr("action","/oficios/comisionadosenviados/editar/"+idof)
                            $("#form_modificar").submit();
                        }
                    });
            });
            $('#paginar_table').DataTable( {

            } );




        });

    </script>


@endsection