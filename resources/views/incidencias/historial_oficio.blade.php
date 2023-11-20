@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')

<main class="col-md-12">
            <div class="row"> 
                <div class="col-md-5 col-md-offset-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">HISTORIAL DE OFICIOS ENVIADOS</h3>
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
                                    <th class="text-center">Nombre del Solicitante</th>
                                    <th class="text-center">Articulo aplicado</th>
                                    <th class="text-center">Ver evidencia</th>  
                                    <th class="text-center">Imprimir</th>   
                     </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($solicitud as $solicita)
                        @if( $solicita->id_estado_solicitud==2)
                        <tr>
                            <th>{{ $solicita->id_solicitud}}</th>
                            <th>{{$solicita->nombre}}</th>
                            <th>
                                @for($articulo=1; $articulo<=10; $articulo++)
                                    @if($solicita->id_articulo==$articulo)
                                        {{$solicita->nombre_articulo}}
                                    @endif
                                @endfor
                            </th>
                            <th>
                                <button class="btn btn-primary edita2" id="{{ $solicita->id_solicitud }}"><i class="glyphicon glyphicon-list"></i></button>
                            </th>
                            <th>
                                @if($solicita->arch_solicitud != null)
                                 <a  target="_blank" href="/incidencias_oficios/{{$solicita->arch_solicitud}}" class="btn btn-primary">Ver oficio </a>
                                @else
                                    <p>Sin oficio</p>
                                @endif
                            </th>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
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
</main>

@endsection