@extends('layouts.app')
@section('title', 'Horarios Docentes')
@section('content')

<main class="col-md-12">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">HORARIOS DOCENTES</h3>
	  		</div>
		</div>	
	</div>
  <div class="col-md-6 col-md-offset-3">
    <table id="paginar_table" class="table table-bordered">
            <thead>
              <tr>
                  <th >Clave</th>
                  <th >Nombre</th>
                  <th >Horario</th>
              </tr>
            </thead>
            <tbody class="text-center">
        @foreach($docentes as $docente)
              <tr>
                <td>{{ $docente->clave }}</td>
                <td>{{ $docente->nombre }}</td> 
                <td>
                  <a href="/horarios_docentes/{{ $docente->id_personal }}"><span class="glyphicon glyphicon-list-alt em6" aria-hidden="true"></span></a>
                </td>          
              </tr>
        @endforeach
            </tbody>
          </table>
  </div>
</div>	

@if(isset($ver))
      @section('horario_docente')
      @include('horarios.partialsh.partial_ver_horarios')
      @show
@endif

</main>
<script>
  $(document).ready(function() {

  $('#paginar_table').DataTable();

});
</script>

@endsection


