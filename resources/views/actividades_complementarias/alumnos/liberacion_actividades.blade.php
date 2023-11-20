@extends('layouts.app')
@section('title', 'LiberacionActividades')
@section('content')


<main class="col-md-12">
<form>
  <div class="row">
    <div class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
      <div class="panel panel-info">
        <div class="panel-heading">Liberación de Actividades</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
      <table class="table table-bordered tabla-grande2">

  <thead>
    <tr>
      <th>Actividad</th>
      <th>Categoría</th>
      <th>Horas</th>
      <th>Créditos</th>
      <th>Calificación Obtenida</th>
    </tr>
  </thead>
  <tbody>
    @foreach($libera_activi as $libera_activi)
    <tr>
      <td>{{$libera_activi->descripcion}}</td>
      <td>{{$libera_activi->descripcion_cat}}</td>
      <td>{{$libera_activi->horas}}</td>
      <td>{{$libera_activi->creditos}}</td>
      <td>{{$libera_activi->promedio}}</td>
    </tr>
    @endforeach  
  </tbody>
</table>
</div>
</div>
</form>
</main>

@endsection