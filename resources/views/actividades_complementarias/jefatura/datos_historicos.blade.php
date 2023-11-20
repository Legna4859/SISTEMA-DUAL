@extends('layouts.app')
@section('title', 'DatosHistoricos')
@section('content')


<main class="col-md-12">
  <form>
  <div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Datos Históricos</div>
      </div>
    </div>
  </div>

    <div class="row">
      <div class="col-sm-10 col-md-10 col-lg-10 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
        <table class="table table-bordered tabla-grande2" id="paginacion">

          <thead>
            <tr>
              <th>No. Cuenta</th>
              <th>Alumno</th>
              <th>Semestre</th>
              <th>Grupo</th>
              <th>Actividad</th>
              <th>Docente</th>
              <th>Créditos</th>
              <th>Promedio</th>
              <th>Periodo</th>
            </tr>
          </thead>
          <tbody>
            @foreach($historico as $historico)
            <tr>
              <td>{{$historico->cuenta}}</td>
              <td>{{$historico->nombre}} {{$historico->apaterno}} {{$historico->amaterno}}</td>
              <td>{{$historico->semestre}}</td>
              <td>{{$historico->grupo}}</td>
              <td>{{$historico->descripcion}}</td>
              <td>{{$historico->titulo}} {{$historico->docente}}</td>
              <td>{{$historico->creditos}}</td>
              <td>{{$historico->promedio}}</td>
              <td>{{$historico->periodo}}</td>
            </tr>
            @endforeach  
          </tbody>
        </table>
      </div>
    </div>
</form>
</main>

<script>
  $(document).ready(function(){
         $('#paginacion').DataTable();
  });
</script>

@endsection