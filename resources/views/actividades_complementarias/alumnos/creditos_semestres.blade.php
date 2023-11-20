@extends('layouts.app')
@section('title', 'HistorialCreditos')
@section('content')

<main class="col-md-12">
  <form>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-info">
          <div class="panel-heading">Créditos Liberados</div>
        </div>
      </div>
    </div>

       <div class="row">
              <div class="col-md-8 col-md-offset-2">
               <table class="table table-bordered tabla-grande2 responsive">
                  <thead>
                  <tr>
                    <th>Actividad</th>
                    <th>Créditos</th>
                    <th>Docente</th>
                    <th>Semestre</th>
                    <th>Promedio</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($historial_creditos as $creditos)
                  <tr>
                    <td>{{$creditos->ac}}</td>
                    <td>{{$creditos->cre}}</td>
                    <td>{{$creditos->titulo}} {{$creditos->docente}}</td>
                    <td>{{$creditos->semestre}}</td>
                    <td>{{$creditos->promedio}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
</main>

@endsection