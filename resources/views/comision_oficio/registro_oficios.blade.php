@extends('layouts.app')
@section('title', 'Registro de Oficios enviados')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li>
                    <a href="{{url('/oficios/historialoficios')}}">Historial de oficios</a>
                </li>
                <li class="active"><a href="#">Oficios enviados</a></li>

            </ul>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Registro de Oficios enviados </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Atencion: Para cancelar un oficio de comisiòn ya aceptado llamar al Departamento de Administraciòn de Personal o para poder modificar un oficio ya autorizado</div>

            </div>
                <br>
            </div>
        </div>
            <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="table_enviado" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fecha solicitud</th>
                        <th>Motivo de la comisión</th>
                        <th>Modificar solicitud</th>
                        <th>Comisionados</th>
                        <th>Ver oficio</th>
                        <th>Imprimir</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($solicitudes as $oficio)

                        <tr>
                            <td rowspan="{{$oficio->comisionesvalidadas->count()+1}}">{{ $oficio->id_oficio }}</td>
                            <?php  $fecha_hora=date("d-m-Y H:i",strtotime($oficio->fecha_hora)) ?>
                            <td rowspan="{{$oficio->comisionesvalidadas->count()+1}}" >{{ $fecha_hora }}</td>
                            <td rowspan="{{$oficio->comisionesvalidadas->count()+1}}" style="font-size:12px;" >{{  $oficio->desc_comision }}</td>
                            <td rowspan="{{$oficio->comisionesvalidadas->count()+1}}" >
                                @if($oficio->id_notificacion_solicitud == 4)
                                <button class="btn btn-primary modifica" onclick="window.location='{{ url('/oficios/modificar/'.$oficio->id_oficio ) }}'"><i class="glyphicon glyphicon-cog em2"></i></button>
                               @endif
                            </td>
                        </tr>
                        @foreach($oficio->comisionesvalidadas as $ofic)

                            @foreach($ofic->personal as $personal)
                                <tr >
                                    <td style="height: 50px"> {{$personal->nombre}}</td>

                                    <td>
                                        <button class="btn btn-primary edita" id="{{ $ofic->id_oficio_personal }}"><i class="glyphicon glyphicon-list"></i></button>
                                    </td>

                                    @if($ofic->id_notificacion==1)
                                        <td>Enviado al D. A. Personal</td>
                                    @endif
                                    @if($ofic->id_notificacion==2  and $ofic->estado_oficio==0)
                                        @if ($ofic->viaticos == 1 AND $ofic->automovil == 1 )
                                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistro', ['id_oficio_personal' => $ofic->id_oficio_personal])}}')">Imprimir</button></td>
                                        @endif
                                        @if ($ofic->viaticos == 2 AND $ofic->automovil == 1 )
                                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroviaticos', ['id_oficio_personal' => $ofic->id_oficio_personal])}}')">Imprimir</button></td>
                                        @endif
                                        @if ($ofic->viaticos == 1 AND $ofic->automovil == 2 )
                                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroautos', ['id_oficio_personal' => $ofic->id_oficio_personal])}}')">Imprimir</button></td>
                                        @endif
                                        @if ($ofic->viaticos == 2 AND $ofic->automovil == 2 )
                                            <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroautosviaticos', ['id_oficio_personal' => $ofic->id_oficio_personal])}}')">Imprimir</button></td>
                                        @endif
                                    @endif
                                    @if($ofic->id_notificacion==2  and $ofic->estado_oficio==1)
                                       <td>Cancelado</td>

                                    @endif
                                    @if($ofic->id_notificacion==2  and $ofic->estado_oficio==2)

                                       <td style="background-color:#bce8f1"><button class="btn btn-primary modifica_comisionado" onclick="window.location='{{ url('/oficios/modificar/oficio_aceptado/'.$ofic->id_oficio_personal ) }}'"><i class="glyphicon glyphicon-cog em2"></i></button>
                                       </td>


                                    @endif
                                    @if($ofic->id_notificacion==3)
                                        <td>Rechazado por D. A. Personal</td>
                                    @endif
                                    @if($ofic->id_notificacion==4)
                                        <td>Proceso modificación</td>
                                    @endif
                                    @if($ofic->id_notificacion==5)
                                        <td>Enviado a subdirección</td>
                                    @endif
                                    @if($ofic->id_notificacion==6)
                                        <td>Rechazado por subdirección</td>
                                    @endif


                                </tr>
                            @endforeach
                        @endforeach

                    @endforeach
                    </tbody>
                </table>
                <br>
            </div>
        </div>

        <div class="modal fade" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Oficio de Comisión</h4>
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
</main>
<script type="text/javascript">
$(document).ready(function() {

    $("#table_enviado").on('click','.edita',function(){
        var idof=$(this).attr('id');

        $.get("/oficios/mostrar/"+idof,function (request) {
            $("#contenedor_mostrar").html(request);
            $("#modal_mostrar").modal('show');
        });
    });
    $('#table_enviado').DataTable( {

    } );
    $("#table_enviado").on('click','.modifica_comisionado',function(){
        var idof=$(this).attr('id');

    });

});
</script>
@endsection