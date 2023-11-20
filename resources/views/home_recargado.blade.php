@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<?php
	$men=Session::get('men');
	$fecha=Session::get('fecha');
	$profesor_men=session()->has('profesor_men')?session()->has('profesor_men'):false;
     $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
     $directivo=session()->has('directivo')?session()->has('directivo'):false;
      $palumno = session()->has('palumno') ? session()->has('palumno') : false;
            
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

				@if($jefe_division == true || $directivo == true)
					<div class="panel panel-success">
					<div class="panel-heading" style="text-align: center">ATENCION: !!!!El modulo de RETICULA y DOCENTE se cambio a Generales en el submenu ACADEMICO!!</div>
					</div>
				@endif
            	@if($profesor_men==true)
	                <div class="panel-heading">{{$men}}</div>
	                <div class="panel-heading">NOTA:
	                	La última fecha de liberación de Actividades Complementarias es el {{$fecha}}</div>
            	@else
            		<div class="panel-heading">{{$men}} </div>
            	@endif
            </div>
        </div>
    </div>
	@if($palumno == true)
		@if($estado_encuesta == 1)
			<div class="row" style="display: none">
				<div class="col-md-12">
					<div class="panel panel-success">
						<div class="panel-heading">Encuestas de satisfacion al cliente</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<p style="text-align: center"><button type="button" class="btn btn-primary" onclick="window.location='{{ url('/encuestas_satisfaccion/encuesta_incripcion/' ) }}'">Encuesta de Inscripción</button></p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		@endif
	@endif
           @if($palumno  == true)
			   @if($adeudo  == 1)
				<!-- Modal adeudo en los departamentos -->
					<div class="modal fade" id="modal_adeudo"  role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title " style="text-align: center">Alerta</h4>
								</div>
								<div class="modal-body">
									<p>	<strong>Contacta al o a los siguientes Departamentos o Jefaturas, porque cuentas con un adeudo (por ejemplo: préstamo de material o instrumentos, o un documento):</strong></p>
									@foreach($departamento_carrera as $departamento)
										<div class="alert alert-danger">
											<strong>Nombre del departamento o jefatura: {{ $departamento['nombre'] }}</strong><br> <b>¿Que es lo que adeudas en el departamento?</b> {{ $departamento['comentario'] }}
										</div>
									@endforeach
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
				   @endif
		   @endif
</div>
	<script type="text/javascript">
		$(document).ready(function (){
			var alumno = "<?php echo $palumno  ?>";
					if(alumno == true){
						var adeudo = "<?php echo $adeudo ?>"
						if(adeudo ==1) {
							$('#modal_adeudo').modal('show');
						}
					}
		});
	</script>
@endsection
