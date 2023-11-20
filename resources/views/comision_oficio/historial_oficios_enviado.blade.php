@extends('layouts.app')
@section('title', 'Registro de Oficios enviados')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#">Historial de oficios</a>
                    </li>
                    <li ><a href="{{url('/oficios/registrosoficio')}}">Oficios enviados</a></li>

                </ul>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Historial de Oficios  </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table id="tabla_envio" class="table table-bordered table-resposive">
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
                    @foreach($historiales as $historial)
                        <tr>
                            <td>{{$historial->id_oficio_personal}}</td>
                            <td>{{$historial->titulo}} {{$historial->nombre}}</td>
                            <td>{{$historial->desc_comision}}</td>
                            <?php  $fecha_hora=date("d-m-Y H:i",strtotime($historial->fecha_hora)) ?>
                            <td>{{$fecha_hora}}</td>
                            <td class="text-center">
                                <button class="btn btn-primary edita" id="{{ $historial->id_oficio_personal }}"><i class="glyphicon glyphicon-list"></i></button>
                            </td>

                            @if($historial->id_notificacion==1)
                                <td>Enviado</td>
                            @endif
                            @if($historial->id_notificacion==2)
                                @if ($historial->viaticos == 1 AND $historial->automovil == 1 )
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistro', ['id_oficio_personal' => $historial->id_oficio_personal])}}')">Imprimir</button></td>
                                @endif
                                @if ($historial->viaticos == 2 AND $historial->automovil == 1 )
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroviaticos', ['id_oficio_personal' => $historial->id_oficio_personal])}}')">Imprimir</button></td>
                                @endif
                                @if ($historial->viaticos == 1 AND $historial->automovil == 2 )
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroautos', ['id_oficio_personal' => $historial->id_oficio_personal])}}')">Imprimir</button></td>
                                @endif
                                @if ($historial->viaticos == 2 AND $historial->automovil == 2 )
                                    <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroautosviaticos', ['id_oficio_personal' => $historial->id_oficio_personal])}}')">Imprimir</button></td>
                                @endif
                            @endif
                            @if($historial->id_notificacion==3)
                                <td>Rechazado</td>
                            @endif
                            @if($historial->id_notificacion==0)
                                <td>proceso</td>
                            @endif


                        </tr>

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
                        <h4 class="modal-title text-center" id="myModalLabel">Oficio de Comision</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mostrar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal para agragegar comicionados--}}
        <form id="form_registar_comisionados" action="{{url("/oficios/agregarcomicionado/agregado")}}" class="form" role="form" method="POST">
            <div class="modal fade bs-example-modal-lg" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">AGREGAR COMISIONADO</h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" id="id_oficio" name="id_oficio" value="">
                            <div class="row">
                                <div id="contenedor_agregar">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary acepta" id="guardar">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tabla_envio").DataTable( {
                "order": [[ 3, "desc" ]]
            } );

            $("#tabla_envio").on('click','.edita',function(){
                var idof=$(this).attr('id');

                $.get("/oficios/mostrar/"+idof,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });
            });


        });
    </script>
@endsection