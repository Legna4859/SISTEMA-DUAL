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
          <input id="no_alumnos" type="hidden" value="" />
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
  Menú bloqueado hasta agregar cantidad de alumnos por materia
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
    <th colspan="2">TOTAL DE HORAS CUBIERTAS CON CATEGORIA</th>
    <th colspan="3">DISTRIBUCION CANTIDAD DE HORAS QUE SE NECESITAN DEBIDO A QUE SON IMPARTIDAS POR</th>
  </tr>
  <tr>
    <th>NOMBRE DE LAS MATERIAS QUE SE OFRECEN POR SEMESTRE</th>
    <th>DOCENTE</th>
    <th>DIRECTIVO, A.T.M., HONORARIOS</th>
    <th>DIRECTIVO</th>
    <th>ATM</th>
    <th>HONORARIOS</th>
  </tr>
  @foreach($materiass as $materia)
  <?php $first=false; ?>
  <tr>
    <td>{{ $materia ["id_semestre"] }}</td>
    <td>{{ $materia ["nombre_materia"] }}</td>
    <td>{{ $materia ["horas_totales"] }}</td>
    <td>{{ $materia ["no_grupos"] }}</td>
    <td class="text_actualiza" id="{{ $materia ["id_distribucion"] }}">
        <div id="almacena{{ $materia ["id_distribucion"] }}">{{ $materia ["cantidad"] }}</div>
        <input style="display:none" type="number" value="" placeholder="{{ $materia ["cantidad"] }}" id="no_alu{{ $materia ["id_distribucion"] }}"/>
    </td>
    <td>0</td> <!-- alumnos de otras carreras -->
    <td>{{ $materia["clave"] }} <br></td>
    <td>{{ $materia ["total"] }}<br></br> </td>
    <td>0</td> <!-- hrs direc,atm,honor -->
    <td>{{ $materia["total_direc"] }}</td> <!-- hrs directivo -->
    <td>0</td> <!-- hrs atm -->
    <td>0</td> <!-- hrs honorarios-->
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
    <td>{{ $t_di}}</td>
    <td></td>
    <td></td>
  </tr>
</table> 

      <div class="col-md-3 col-md-offset-5">
<h4>Cantidad Total de Alumnos:<br>{{ $t_alum }}</h4>
  </div>
  <!--<div class="col-md-3 col-md-offset-5 ml">
         <button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
  </div>-->
</div>
@endif

  </div>		
</main>
<script>
function bloqueo()
{
    $.blockUI({
    //message: '<img src="/img/cargando.gif" />',
  });
        //setTimeout($.unblockUI, 4000); 
}

  $(document).ready(function() {

$(".link").tooltip({html:true});

    $("#selectCarrera").on('change',function(e){
      var id_carrera= $("#selectCarrera").val();
      window.location.href='/distribucion/'+id_carrera ;
    });

  $( ".text_actualiza" ).dblclick(function() {
    var iddistribucion=$(this).attr('id');
    $("#no_alumnos").val(iddistribucion);
    //alert(iddistribucion);
    $('#no_alu'+iddistribucion).show(1000);
    $('#almacena'+iddistribucion).hide(1000);
    });

  $(".text_actualiza").keypress(function(e){  
  var iddistribucion=$("#no_alumnos").val(); 
      if(e.which == 13)
      {     
        bloqueo();
        //alert(cantidad);
            var cantidad=$("#no_alu"+iddistribucion).val();
            if(cantidad<1)
            {
              alert("Ingresa una cantidad");
              $.unblockUI();
            }
            else
            {
              window.location.href='/agregando/cantidad/'+iddistribucion+'/'+cantidad;
              $.unblockUI();
            }
      }   
  }); 
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

