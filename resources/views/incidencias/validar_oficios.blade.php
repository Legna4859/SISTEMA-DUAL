@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
    
<main class="col-md-12">
          <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{{url('/incidencias/validar_oficios/historial')}}">Historial de oficios recibidos</a>
                    </li>
                    <li class="active" ><a href="#">Oficios recibidos para validación</a></li>
               </ul>
                
            </div>
        </div>
<div class="row">
  <div class="col-md-5 col-md-offset-4">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">VALIDAR OFICIOS DE INCIDENCIAS</h3>
        </div>
    </div>  
  </div>
</div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
                
                <table id="table_enviado2" class="table table-bordered table-resposive">
                  <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nombre del solicitante</th>
                        <th class="text-center">Fecha oficio</th>
                        <th class="text-center">Artículo</th>
                        <th class="text-center">Ver oficio</th>
                        <th class="text-center">Evaluar oficio</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($solicitudes as $solicitud)
                      @if($id_personal==$solicitud->id_jefe)
                        @if($solicitud->id_estado_solicitud==1 && $solicitud->directora == null)
                        <tr>
                          <th>{{$solicitud->id_solicitud}} </th>
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

                          <th>
                            <button class="btn btn-primary edita2" id="{{ $solicitud->id_solicitud }}"><i class="glyphicon glyphicon-list"></i></button>
                          </th>
                            
                          <th>
                              @if($solicitud->id_articulo != 4 )
                                <button type="button" class="btn btn-info btn-circle" onclick="window.location='{{ url('/incidencias/historial_docentesSo/oficio/aceptado', $solicitud->id_solicitud) }}'" title="Autorizar"><i class="glyphicon glyphicon-ok"></i></button>
                                <button type="button" class="btn btn-warning btn-circle" onclick="window.location='{{ url('/incidencias/historial_docentesSo/oficio/rechazado', $solicitud->id_solicitud ) }}'" title="Rechazar"><i class="glyphicon glyphicon-remove"></i></button>
                              @else 
                                  <button type="button" class="btn btn-info btn-circle" onclick="window.location='{{ url('/incidencias/historial_docentesSo/oficio/enviar', $solicitud->id_solicitud ) }}'" title="Enviar a directora">Realizar solicitud</button> 
                              @endif
                            </th>
                        </tr>
                        @endif
                      @elseif($solicitud->directora==274 )  
                        @if($solicitud->id_estado_solicitud==4)
                        <tr>
                          <th>{{$solicitud->id_solicitud}} </th>
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

                          <th>
                            <button class="btn btn-primary edita2" id="{{ $solicitud->id_solicitud }}"><i class="glyphicon glyphicon-list"></i></button>
                          </th>
                            
                          <th>
                              @if($solicitud->id_articulo == 4 )
                                <button type="button" class="btn btn-info btn-circle" onclick="window.location='{{ url('/incidencias/historial_docentesSo/oficio/aceptado', $solicitud->id_solicitud) }}'" title="Autorizar"><i class="glyphicon glyphicon-ok"></i></button>
                                <button type="button" class="btn btn-warning btn-circle" onclick="window.location='{{ url('/incidencias/historial_docentesSo/oficio/rechazado', $solicitud->id_solicitud ) }}'" title="Rechazar"><i class="glyphicon glyphicon-remove"></i></button>
                              @endif
                            </th>
                        </tr>
                        @endif
                      @endif
                    @endforeach
                  <tbody>
                </table>


        </div>
    </div>
        <div class="modal fade" id="modal_mostrar2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Oficio de Incidencia</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mostrar2">
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
    $("#table_enviado2").on('click','.edita2',function(){
        //alert("HOLA");
        var soli=$(this).attr('id');
       // alert(soli);
        //url de web
        $.get("/oficios/ver/"+soli,function (request) {
            //contenido del modal
            $("#contenedor_mostrar2").html(request);
            //id del modal
            $("#modal_mostrar2").modal('show');
        });    
    });
    $('#table_enviado2').DataTable( {

    } );
});
</script>
  
@endsection