
@extends('layouts.app')
@section('title', 'Concentrado Estruct. Académica')
@section('content')
<main class="col-md-12">
<div class="row">
	<div class="col-md-11 tabla-grande">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">Concentrado Estructura Educativa</h3>
	  		</div>
	  					<div class="panel-body">
                    <table class="table table-bordered tabla-grande3">
  <tr>
    <th rowspan="2">NUMERO</th>
    <th>PERIODO ESCOlAR: {{ $periodo }}</th>
    <th rowspan="2">HORAS SEMANALES POR CARRERA</th>
    <th rowspan="2">NO DE GRUPOS POR CARRERA</th>
    <th rowspan="2">CANTIDAD TOTAL DE ALUMNOS POR CARRERA</th>
    <th rowspan="2">PROMEDIO DE ALUMNOS ATENDIDOS POR CARRERA</th>
    <th rowspan="2">MATRICULA SEMESTRE ANTERIOR</th>
    <th colspan="2">TOTAL DE HORAS CUBIERTAS CON CATEORIA</th>
    <th colspan="3">DISTRIBUCION CANTIDAD DE HORAS CUBIERTAS POR PERSONAL CON CATEGORIA DE:</th>
  </tr>
  <tr>
    <th>NOMBRE DE LAS CARRERAS QUE OFRECE LA INSTITUCION</th>
    <th>DOCENTE</th>
    <th>DIRECTIVA, A.T.M,HONORARIOS</th>
    <th>DIRECTIVA</th>
    <th>A.T.M.</th>
    <th>HONORARIOS</th>
  </tr>
  <?php $contador=1 ?>
@foreach($carreras as $carrera)
 @foreach($carrera["semanas"] as $semana)
  <tr>
    <td>{{ $contador }}</td>
    <td>{{ $carrera ["nombre_carrera"] }}</td>
    <td>{{ $semana ["hrs_semanas"] }}</td>  
      <td>{{ $carrera ["g_carreras"] }}</td>
      <td>{{ $carrera["total_alumnos"] }}</td>
      <td>0</td>
      <td>0</td>
      <td>{{ $carrera["t_docente"] }}</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <?php $contador++ ?>
  </tr>
  @endforeach
@endforeach
<tr>
  <td colspan="2" class="text-center">TOTALES:</td>
  <td>{{ $t_sem }}</td>
  <td>{{ $total_g }}</td>
  <td></td>
  <td></td>
  <td></td>
  <td>{{ $t_td }}</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
</table>                 
	  					</div>
		</div>	
	</div>
  
     <div class="col-md-2 col-md-offset-4 regis">
        <a href="/excel_concentrado" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-export"  aria-hidden="true"></span>Exportar Excel</a>
          </div> <br>

<!--<div class="col-md-2 regis">
  <a href="/pdf_estructura" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir PDF</a>
                        </div>-->


  </div>		
</main>

@endsection
