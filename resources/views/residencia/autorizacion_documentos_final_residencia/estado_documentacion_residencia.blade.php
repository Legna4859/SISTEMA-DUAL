@extends('layouts.app')
@section('title', 'Documentación final de residenciaa')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Enviar Documentación de Liberación de Residencia</h3>
                    </div>
                </div>
            </div>
        </div>
        @if( $estado_calificado == 0)
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">No se ha terminado de calificar tu Seguimiento de Residencia</h3>
                    </div>
                </div>
            </div>
        </div>
            @elseif( $estado_calificado == 1)
            @if($estado_enviado == 1 || $estado_enviado == 3)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Se envió correctamente tu documentación al Departamento de Servicio Social y Residencia Profesional para su revisión</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($estado_enviado == 4)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center"> Tu documentación de Liberación de Residencia fue autorizada por el Departamento de Servicio Social y Residencia Profesional.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endif
    </main>
@endsection