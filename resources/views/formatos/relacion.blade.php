@extends('layouts.app')
@section('title', 'Relación Personal Docente')
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
	    		<h3 class="panel-title text-center">Relación de Personal Docente</h3>
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
                          <div class="alert alert-danger" role="alert" id="notifi_bloqueo" style="display:none">
  Menú bloqueado hasta agregar factibilidad de incrementar hrs (si/no)
</div>
        </div>
@if(isset($ver))
<div class="col-md-11 tabla-grande table-responsive">
<table class="table table-bordered tabla-grande3">
<tr>
        <th rowspan="3">NO CONTROL</th>
        <th>PERIODO ESCOlAR: {{ $periodo }}</th>
        <th rowspan="3">NOMBRAMIENTO</th>
        <th rowspan="3">FECHA DE INGRESO AL I.T.S</th>
        <th rowspan="3">CODIGO DE PLAZA</th>
        <th rowspan="3">TOTAL DE HORAS POR NOMBRAMINTO</th>
        <th rowspan="2" colspan="2">NUMERO DE HORAS FRENTE A GRUPO</th>
        <th colspan="2">FACTIBILIDAD DE INCREMENTAR HORAS FRENTE A GRUPO CONFORME A SU CATEGORIA</th>
        <th rowspan="3">MATERIAS QUE IMPARTE</th>
        <th rowspan="3">DIVISION O DPTO</th>
        <th rowspan="2" colspan="2">HORAS SEMESTRES POR MATERIA</th>
        <th rowspan="3">CANTIDAD DE GRUPOS</th>
        <th rowspan="3">CARRERA</th> 
       <th rowspan="3">ESCOLARIDAD DEL PROFESOR</th>
    </tr>  
    <tr>
        <th rowspan="2">NOMBRE DEL PROFESOR</th>
        <th rowspan="2">SI/NO</th>
        <th rowspan="2">CAUSA</th>
    </tr>
    <tr>
        <th>LIC.</th>
        <th>POSG.</th>
        <th>T</th>
        <th>P</th>
    </tr>
    @foreach($docentes as $docente)
      @foreach($docente["materias"] as $mates)
  <tr>
    <td>{{ $docente["clave"] }}</td>
    <td>{{ $docente["nombre"] }}</td>
    <td class="text-center">{{ $docente["nombramiento"] }}</td>
    <td>{{ $docente["fecha_ingreso"] }}</td>
    <td>{{ $docente["codigo"] }}</td>
    <td>{{ $docente["hrs_max"] }}</td>
    <td>{{ $mates["t_lic"] }}</td>
    <td>0</td>
    <td>
        <select name="selectCaso" id="{{ $docente["id_horario"] }}" class="selectCaso_{{ $docente["id_horario"] }}{{ $mates["id_materia"] }}">
          <option disabled selected>Caso..</option>
          @if($docente["caso"]=="0")
            <option value="SI">SI</option>
            <option value="NO">NO</option>
          @endif
            @if($docente["caso"]=="SI")
              <option value="SI" selected="selected">SI</option>
              <option value="NO">NO</option>
            @endif
            @if($docente["caso"]=="NO")
              <option value="SI">SI</option>
              <option value="NO" selected="selected">NO</option>
            @endif
        </select> 
    </td>
    <td>
      @if($docente["causa"]==1)
        <label>Tiene disponibilidad</label>
      @endif
      @if($docente["causa"]==2)
        <label>Tiene carga máxima</label>
      @endif
      @if($docente["causa"]==0)
        <label> </label>
      @endif
    </td>
    <td>{{ $mates["nombre_materia"] }}</td>
    <td>{{ $ncarrera }}</td>
    <td>{{ $mates["hrs_teoria"] }}</td>
    <td>{{ $mates["hrs_practica"] }}</td>
    <td>{{ $mates["no_grupos"] }}</td>
    <td>{{ $ncarrera }}</td>
    <td>{{ $docente["escolaridad"] }}</td>
  </tr>
    @endforeach
  @endforeach
<tr>
  <td colspan="2">TOTALES</td>
  <td></td>
  <td></td>
  <td></td>
  <td>{{ $t_nombra }}</td>
  <td>{{ $total_lic }}</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td colspan="2">{{ $t_hrs }}</td>
  <td></td>
  <td></td>

</tr>
</table> 
</div>  
@endif                  	
	</div>
  
  <!--<div class="col-md-3 col-md-offset-5 ml">
         <button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
  </div>-->

  </div>		
</main>

<script>

  $(document).ready(function() {

    $("#selectCarrera").on('change',function(e){
      var id_carrera= $("#selectCarrera").val();
      window.location.href='/relacion/ver/'+id_carrera ;
    });

@foreach($docentes as $docente)
  @foreach($docente["materias"] as $mates)
    $(".selectCaso_{{ $docente["id_horario"] }}{{ $mates["id_materia"] }}").on('change',function(){
      var idh=$(this).attr('id');
      var caso=$(".selectCaso_{{ $docente["id_horario"] }}{{ $mates["id_materia"] }}").val();    
      window.location.href='/cambiar/caso/'+idh+'/'+caso ;
    });
  @endforeach
@endforeach

});
    console.log("{{ $fals }}")

  @if($fals>0)
  $('.bloqueo').addClass('disabled');
    $('#notifi_bloqueo').show(1000);
@else
    $('.bloqueo').removeClass('disabled');
  $('#notifi_bloqueo').hide(1000);
@endif
</script>
@endsection
