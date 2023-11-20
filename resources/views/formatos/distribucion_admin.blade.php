@extends('layouts.app')
@section('title', 'Distribucion de Hrs.')
@section('content')

    <script>
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  e.target // newly activated tab
  e.relatedTarget // previous active tab
})
    </script>
<main class="col-md-12">
     <?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
 $directivo=session()->has('directivo')?session()->has('directivo'):false; ?>

<div class="row">
	<div class="col-md-5 col-md-offset-3">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">Distribución de Horas frente a Grupo</h3>
	  		</div>
        @if($directivo==1)
	  					<div class="panel-body">
                <div class="col-md-6 col-md-offset-3">
                <div class="dropdown">
                   <select name="selectCarrera" id="selectCarrera" class="form-control">
                                  <option disabled selected>Selecciona carrera...</option>
                                @foreach($carreras as $carrera)
                                  @if($carrera->id_carrera==$id_carrera)
                                    <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                  @else
                                    <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                  @endif                                                  
                                @endforeach
                                <option value="00" >Agrega Reticula</option>
                                </select>
              </div>
                </div>                     
	  					</div>
        @endif
		</div>	
	</div>
@if(isset($ver))
<div class="col-md-11 tabla-grande">
  <table class="table table-bordered table-hover tabla-grande3 ">
  <tr>
    <th rowspan="2">SEMESTRE</th>
    <th>PERIODO ESCOlAR: {{ $periodo }}</th>
    <th rowspan="2">HRS SEMESTRALES POR MATERIA</th>
    <th rowspan="2">NO. GRUPOS POR MATERIAS</th>
    <th rowspan="2">CANTIDAD TOTAL DE ALUMNOS POR MATERIA</th>
    <th rowspan="2">CUANDO EN LOS GUPOS EXISTAN ALUMNOS DE OTRAS CARRERAS INDICAR EL NOMBRE DE ESTAS PARA EVITAR QUE LOS GRUPOS SE DUPLIQUEN</th>
    <th rowspan="2">INDICAR EL NUMERO DEL PROFESOR QUE IMPARTE LA MATERIA SEGUN GRUPOS QUE ATIENDA. EL NUMERO DE PROFESOR DEBERA CONICIDIR CON EL ASIGNADO EN LA RELACION DE PERSONAL DOCENTE (FORMATO 03,04,05 ó 06)</th>
    <th colspan="4">TOTAL DE HORAS FRENTE A GRUPO CUBIERTAS POR PERSONAL CON CATEGORIA:</th>
  </tr>
  <tr>
    <th>NOMBRE DE LAS MATERIAS QUE SE OFRECEN POR SEMESTRE</th>
    <th>DOCENTE</th>
    <th>DIRECTIVO</th>
    <th>ATM</th>
    <th>HONORARIOS</th>
  </tr>
  @foreach($materiass as $materia)
 
  <tr>
    <td>{{ $materia ["id_semestre"] }}</td>
    <td>{{ $materia ["nombre_materia"] }}</td>
    <td>{{ $materia ["horas_totales"] }}</td>
    <td>{{ $materia ["no_grupos"] }}</td>
    <td>{{ $materia ["cantidad"] }}</td>
    <td>0</td>
    <td>{{ $materia["clave"] }} <br></td>
    <td>{{ $materia ["total"] }}<br></br> </td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
  </tr>
@endforeach
  <tr>
    <td>9</td>
    <td>RESIDENCIA PROFESIONAL</td>
    <td>{{ $resi_hrs }}</td>
    <td>{{ "N.A" }}</td>
    <td>0</td>
    <td>0</td>
    <td>
      @foreach($residencia as $resi)
        {{ $resi["claver"] }} <br></br>
      @endforeach
      </td>
    <td>{{ $resi_hrs }}</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
  </tr>
  <tr>
    <td colspan="2" class="text-center">TOTALES</td>
    <td>{{ $total_matr }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>{{ $t_tr }}</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table> 

      <div class="col-md-3 col-md-offset-5">
<h4>Cantidad Total de Alumnos:<br>{{ $t_alum }}</h4>
  </div>
       <div class="col-md-2 col-md-offset-4 regis">
        <a href="/excel_distribucion" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-export"  aria-hidden="true"></span>Exportar Excel</a>
          </div>
  <!--<div class="col-md-3 col-md-offset-5 ml">
         <button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
  </div>-->
</div>
@endif

  </div>		
</main>
<script>

  $(document).ready(function() {

    $("#selectCarrera").on('change',function(e){
      var id_carrera= $("#selectCarrera").val();
      window.location.href='/distribucion/'+id_carrera ;
    });

    $("#text_actualiza").keypress(function(e){   
               if(e.which == 13){      
                 alert("Hola");  
               }   
              }); 

});
  
</script>



@endsection
