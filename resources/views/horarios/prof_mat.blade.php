@extends('layouts.app')
@section('title', 'Prof-Materia')
@section('content')

<main class="col-md-12">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">RELACIÓN PROFESORES-MATERIAS</h3>
	  		</div>
		</div>	
	</div>
  <div class="col-md-8 col-md-offset-2">
    <table id="paginar_table" class="table table-bordered">
                          <thead>
                            <tr>
                                <th>No.</th>
                                <th>Grado</th>  
                                <th>Nombre Completo</th> 
                                <th>Cédula</th>
                                <th>Materias</th>
                                <th>Unidades</th>
                                <th>Grupo</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $contador=1;  ?>
                            @foreach($relacion as $rel)
                            <tr>
                              <td>{{ $contador }}</td>
                              <td>{{$rel->descripcion}}</td>
                              <td>{{$rel->nombre}}</td>
                              <td>{{$rel->cedula}}</td>
                              <td>{{$rel->materia}}</td>
                              <td>{{$rel->unidades}}</td>
                              <td>{{$rel->grupo}}</td>
                              <?php $contador++; ?>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>  
  </div>
  <!--<div class="col-md-2">
    <a href="/pdf/prof-mat/" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>
  </div>-->
  <div class="col-md-2">
        <a href="/excel/prof-mat" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-export"  aria-hidden="true"></span>Exportar Excel</a>
          </div>
</div>	
</main>


<script>
$(document).ready(function() {
  $('#paginar_table').DataTable();

});
        </script>
@endsection
