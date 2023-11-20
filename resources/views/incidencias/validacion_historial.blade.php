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
                     <li  > <a href="{{url('/incidencias/validar_oficios')}}">Oficios recibidos para validación</a></li>
                </ul>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="table_enviado1" class="table table-bordered table-resposive">
                    <thead>
                     <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nombre del solicitante</th>
                        <th class="text-center">Fecha de oficio</th>
                        <th class="text-center">Artículo</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Oficio</th>
                     </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                            @if($id_personal==$solicitud->id_jefe)                           
                                @if($solicitud->id_estado_solicitud==2 || $solicitud->id_estado_solicitud==4)
                                <tr>
                                    <th>{{$solicitud->id_solicitud}}</th>
                                    <th>{{$solicitud->nombre}}</th>
                                    <th>
                                        @for( $articulo=1; $articulo <=10 ; $articulo++)
                                            @if($solicitud->id_articulo == $articulo)
                                                {{$solicitud->fecha_req}}
                                            @endif
                                        @endfor
                                    </th>
                                    <th>
                                        @for( $articulo=1; $articulo <=10 ; $articulo++)
                                            @if($articulo==$solicitud->id_articulo)
                                                {{$solicitud->nombre_articulo}}
                                            @endif
                                        @endfor  
                                    </th>                           
                                       <!-- <button class="btn btn-primary edita1" id="{{ $solicitud->id_solicitud }}"><i class="glyphicon glyphicon-list"></i></button>-->
                                    <th>
                                        @if($solicitud->id_estado_solicitud == 4)
                                            <p>Enviado a dirección</p>
                                        @else
                                            <p>Aceptado</p>
                                        @endif 
                                    </th>
                                    <th>
                                    @if($solicitud->id_estado_solicitud == 2)
                                        @if($solicitud->id_articulo==1 || $solicitud->id_articulo==9)
                                        <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroincidencia',['id_solicitud'=>$solicitud->id_solicitud])}}')">Imprimir</button>
                                        @endif
                                        @if($solicitud->id_articulo==2 || $solicitud->id_articulo==4 || $solicitud->id_articulo==5 ||$solicitud->id_articulo==6  || $solicitud->id_articulo==7 || $solicitud->id_articulo==8 || $solicitud->id_articulo==10)
                                        <button type="button" class="btn btn-primary center" onclick="window.open('{{url('pdfregistroincidencia1',['id_solicitud'=>$solicitud->id_solicitud])}}')">Imprimir</button>
                                        @endif
                                    @else
                                        <p>En proceso</p>
                                    @endif
                                    </th>
                                 
                                </tr>
                                @endif
                            @elseif($id_personal==274)
                            @if($solicitud->id_estado_solicitud==2 && $solicitud->directora == 274 )
                                <tr>
                                    <th>{{$solicitud->id_solicitud}}</th>
                                    <th>{{$solicitud->nombre}}</th>
                                    <th>
                                        @for( $articulo=1; $articulo <=10 ; $articulo++)
                                            @if($solicitud->id_articulo == $articulo)
                                                {{$solicitud->fecha_req}}
                                            @endif
                                        @endfor
                                    </th>
                                    <th>
                                        @for( $articulo=1; $articulo <=10 ; $articulo++)
                                            @if($articulo==$solicitud->id_articulo)
                                                {{$solicitud->nombre_articulo}}
                                            @endif
                                        @endfor  
                                    </th>                           
                                       <!-- <button class="btn btn-primary edita1" id="{{ $solicitud->id_solicitud }}"><i class="glyphicon glyphicon-list"></i></button>-->
                                    <th>
                                        @if($solicitud->id_estado_solicitud == 4)
                                            <p>Enviado a direccion</p>
                                        @else
                                            <p>Aceptado</p>
                                        @endif 
                                    </th>
                                    <th>
                                    @if($solicitud->id_estado_solicitud == 2)
                                        <p>Imprime jefe de división</p>
                                    @else
                                        <p>En proceso</p>
                                    @endif
                                    </th>
                                 
                                </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="modal_mostrar1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Oficio de Incidencia</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mostrar1">
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
    //id de la tabla                 //class de boton
    $("#table_enviado1").on('click','.edita1',function(){
        //alert("HOLA");
        var solicitud=$(this).attr('id');
        //alert(solicitud);
        //url de web
        $.get("/oficios/ver/"+solicitud,function (request) {
            //contenido del modal
            $("#contenedor_mostrar1").html(request);
            //id del modal
            $("#modal_mostrar1").modal('show');
        });    
    });
    $('#table_enviado1').DataTable( {

} );
});
</script>
@endsection