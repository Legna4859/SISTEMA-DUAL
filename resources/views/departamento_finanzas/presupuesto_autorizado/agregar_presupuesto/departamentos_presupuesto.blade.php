@extends('layouts.app')
@section('title', 'Presupuesto autorizado')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Departamentos y jefaturas de división del año {{ $year }}</h3>
                </div>
            </div>
        </div>
    </div>
    @foreach($departamentos as $departamento)
        @if($departamento->estado == 1)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="button" class="btn btn-success btn-lg btn-block"  onclick="window.location='{{ url('/presupuesto_autorizado/departamentos_agregar_presupuesto/'.$departamento->id_unidad_admin ) }}'">{{ $departamento->nom_departamento }}</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <p><br></p>
                         </div>
                </div>
        @else
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <button type="button" class="btn btn-default btn-lg btn-block"  onclick="window.location='{{ url('/presupuesto_autorizado/departamentos_agregar_presupuesto/'.$departamento->id_unidad_admin ) }}'">{{ $departamento->nom_departamento }}</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <p><br></p>
                </div>
            </div>
        @endif
    @endforeach
@endsection