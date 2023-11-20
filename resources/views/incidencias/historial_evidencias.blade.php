@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
    
<main class="col-md-12">
<div class="row">
        <div class="col-md-5 col-md-offset-4">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">HISTORIAL DE EVIDENCIAS ENVIADAS</h3>
        </div>
    </div>  
  </div>
</div>

  <div class="row">
    <div class="col-md-6 col-md-offset-1">
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
    <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title text-center">Aplica articulo</h3>
        </div>
    </div>  
  </div>
</div>
    <table id="tabla_envio" class="table table-bordered table-resposive">
                          <thead>  
                            <tr>                                 
                                <th class="text-center">No.</th> 
                                <th class="text-center">Nombre del solicitante</th>
                                <th class="text-center">Articulo</th>
                                <th class="text-center">Tipo de evidencia</th> 
                                <th class="text-center">Fecha y Hora de envio de evidencia</th> 
                                <th class="text-center">Ver evidencia</th>  
                            </tr>                   
                            </thead>
                          <tbody>
                            @foreach ($evid as $evidencia)
                              <tr>
                                <th>{{$evidencia->id_evid}}</th>
                                <th>{{$evidencia->nombre}}</th>
                                <th>{{$evidencia->nombre_articulo}}</th>
                                <th>{{$evidencia->nombre_evidencia}}</th>
                                <th>{{$evidencia->fecha_envio}}</th>
                                <th>
                                @if($evidencia->arch_evidencia != null)
                                  <a  target="_blank" href="{{$evidencia->arch_evidencia}}" class="btn btn-primary"> <i class=" glyphicon glyphicon-book em128" title="Ver PDF"> </i> Ver evidencia </a>
                                @else
                                  <p>Sin evidencia</p>
                                @endif
                                </th>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
    </div>

    <div class="col-md-4 ">
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
    <div class="panel panel-danger">
        <div class="panel-heading">
          <h3 class="panel-title text-center">No aplica articulo</h3>
        </div>
    </div>  
  </div>
</div>
    <table id="tabla_envio1" class="table table-bordered table-resposive">
                          <thead>  
                            <tr>                                 
                                <th>No.</th> 
                                <th> Nombre del solicitante</th>
                                <th>Tipo de evidencia</th> 
                                <th>Fecha y Hora de envio de evidencia</th> 
                                <th>Ver evidencia</th>  
                            </tr>                   
                            </thead>
                          <tbody>
                            @foreach ($evidencias as $evidencia)
                              <tr>
                                <th>{{$evidencia->id_evid}}</th>
                                <th>{{$evidencia->nombre}}</th>
                                <th>{{$evidencia->nombre_evidencia}}</th>
                                <th>{{$evidencia->fecha_envio}}</th>
                                <th>
                                @if($evidencia->arch_evidencia != null)
                                  <a  target="_blank" href="{{$evidencia->arch_evidencia}}" class="btn btn-primary"> <i class=" glyphicon glyphicon-book em128" title="Ver PDF"> </i> Ver evidencia </a>
                                @else
                                  <p>Sin evidencia</p>
                                @endif
                                </th>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() { 
    $('#tabla_envio').DataTable( {

    } );
    $('#tabla_envio1').DataTable( {

} );
});
</script>
  </main>
@endsection