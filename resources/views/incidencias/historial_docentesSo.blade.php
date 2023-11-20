@extends('layouts.app')
@section('title','Incidencias')
@section('content')

<main class="col-md-12">
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">HISTORIAL DE OFICIOS</h3>
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
                                    <th class="text-center">Artículo aplicado</th>
                                    <th class="text-center">Motivo de oficio</th>
                                    <th class="text-center">Fecha solicitada</th>
                                    <th class="text-center">Estado de oficio</th>
                                    <th class="text-center">Subir oficio firmado</th>
                    </tr>
                  </thead>
                  <tbody>
                            @foreach ($histSol as $hist)
                                @if($id_personal== $hist->id_personal)
                                    <tr>
                                        <td>{{$hist->id_solicitud}}</td>
                                        <td>{{$hist->nombre_articulo}}</td>
                                        <td>{{$hist->motivo_oficio}}</td>
                                        <td>{{$hist->fecha_req}}</td>
                                        
                                        @if($hist->id_estado_solicitud==1)
                                            <td>Enviado</td>
                                            <td>En proceso</td>
                                        @endif
                                        
                                             
                                            @if($hist->id_estado_solicitud==2)
                                            <td>Autorizado</td>
                                            @elseif($hist->id_estado_solicitud==4)
                                            <td>Enviado a dirección</td>
                                            <td>En proceso</td>
                                            @endif
                                            
                                        @if($hist->id_estado_solicitud==2)
                                            <td> 
                                                @if($hist->arch_solicitud==null)
                                                <a class="btn btn-success" href="{{url('incidencias/cargar_oficio',$hist->id_solicitud)}}">Agregar</a>
                                                @else
                                                <a  target="_blank" href="/incidencias_oficios/{{$hist->arch_solicitud}}" class="btn btn-primary">Ver oficio </a>   
                                                @endif
                                            </td>
                                        @endif
                                        @if($hist->id_estado_solicitud==3)
                                            <td>Rechazado</td>
                                        @endif 
                                    </tr>
                                @endif
                                @endforeach
                  <tbody>
                </table>
        </div>
    </div>
    <script type="text/javascript">
  $(document).ready(function() { 
    $('#table_enviado2').DataTable( {

    } );
});
</script>
</main>


@endsection
