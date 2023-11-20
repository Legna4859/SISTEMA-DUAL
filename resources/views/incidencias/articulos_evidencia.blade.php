@extends('layouts.app')
@section('title','Incidencias')
@section('content')

<main class="col-md-12">
            <div class="row"> 
                <div class="col-md-5 col-md-offset-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Evidencia a subir</h3>
                        </div>
                    </div>  
                </div>
            </div>

    <div class="row">
            <div class="col-md-8 col-md-offset-2">       
                <table id="tabla_envio" class="table table-bordered table-resposive">
                    <thead>
                     <tr>
                         <th class="text-center"> Artículo que requiere evidencia</th>
                         <th class="text-center">Fecha requerida</th>
                         <th class="text-center">Agregar evidencia</th>
                     </tr>
                    </thead>
                    <tbody>
                        @foreach($eviden as $evidArt)

<tr>
@if($evidArt->arch_evidencia == null)
                                    
                                    @if($evidArt->id_estado_solicitud==2)
                                      <?php
$date_now = $evidArt->fecha_req;
$date_future = strtotime('+5 days', strtotime($date_now));
$date_future = date('Y-m-d', $date_future);
                                      ?>
                                        <th>{{$evidArt->nombre_articulo}}</th>
                                        <th>{{$evidArt->fecha_req}}</th>
                                        <th> {{$date_future}}</th>
                                        <th>
                                            @if($evidArt->arch_evidencia==null)
                                                @if( $fechaact>=$evidArt->fecha_req  && $fechaact<= $date_future)
                                                    <a class="btn btn-success" href="{{url('incidencias/cargar_evidencia',$evidArt->id_evid)}}">Agregar</a>
                                                    @elseif($fechaact> $date_future)
                                                        <p>Has olvidado subir tu evidencia</p>
                                                    @else
                                                    <p>Podras subir tu evidencia el dia requerido hasta 5 dias habiles despues</p>
                                                @endif

                                            @else
                                            <a  target="_blank" href="/incidencias/{{$evidArt->arch_evidencia}}" class="btn btn-primary">Ver evidencia </a>
                                            @endif
                                        </th>
                                    @endif
                                
                                @endif
</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <div class="row">    
            <div class="col-md-2 col-md-offset-7">
                <div class="alert alert-success">
                    <strong>Nota: </strong> Puedes agregar otro tipo de evidencia si así se requiere.
                </div>
            </div>
        
        <div class="col-md-1 ">
            <a class="btn btn-success" href="{{url('incidencias/cargar_otra_evidencia')}}">Agregar</a>
        </div>
    </div>

  </main>

@endsection