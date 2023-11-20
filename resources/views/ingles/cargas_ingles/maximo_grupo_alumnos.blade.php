@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Vouchers en espera de validación')
@section('content')

<main class="col-md-12">

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>Número Máximo de Usuarios del Periodo {{$periodo->periodo_ingles}}</b></h3>
                    </div>
                </div>
            </div>
        </div>

        @if($estado_maximo==0)
        <form action="{{url("/ingles/guardar_maximo_grupo_alumnos")}}" role="form" method="post" >
        	@csrf
        	<div style="padding: 1m;">
        		<div class="container" style="width: 30%; height: 5%; margin-top: 1em; margin-bottom: 1em">
        			<label style="margin-top: 1.5em"> Ingresa el número de usuarios para el nivel</label>
                    <input type="number" id="num_max_alumnos" name="num_max_alumnos" placeholder="¡¡¡Ingrese número de usuarios para el nivel!!!" class="form-control" style="align-items: center" required/>
        		</div>
                        <div style="padding: 1.5em;">
                        <div class="d-grid gap-2 d-md-flex" style="size: 25px; margin-top: 1.5em; margin-bottom: 1.5em; align-items: center; display: flex; justify-content: center">
                                <button type="submit" id="boton_azul" class="btn btn-primary" style="position:absolute;left: 40%;width:150px; height:50px; border-radius: 2em;">
                                    <strong><b>Guardar</b></strong>
                                </button>
                        </div>
                    </div>
                </div>
                </div>
        </form>
        @else($estado_maximo==1)
        <div class="row" id="consultar">
            <div class="col-md-10 col-md-offset-1">
                <br>
                <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th style="text-align: center; color: black;"> No.</th>
                        <th style="text-align: center; color: black;"> Número Máximo de Alumnos</th>
                        <th style="text-align: center; color: black;"> Status</th>
                    </tr>
                    <tr>
                    	<th style="text-align: center">1</th>
                    	<th style="text-align: center">{{$maximo_estudiantes->num_maximo_alumnos}}</th>
                    	<th style="text-align: center">
                    		<form action="{{url("/ingles/editar_maximo")}}" method="POST">
                                    @csrf
                                    <button id="boton_editar" type="button" class="btn" 
                                    style="border-bottom:2em; background: crimson;color: white;">
                  	 					<i class="glyphicon glyphicon-pencil" ></i>
                   					</button>
                            </form>
                  		</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>	
			<div id="editar_maximo" class="container" style="display:none;">
			    <form action="{{url("/ingles/guardar_editar_boton")}}" role="form" method="post" >
		    	@csrf
		        	<div style="padding: 1m;">
		        		<div class="container" style="width: 30%; height: 5%; margin-top: 1em; margin-bottom: 1em">
		       			<label style="margin-top: 1.5em"> Edite el número de usuarios para el nivel</label>
	                    <input type="number" id="num_max_alumnos" name="num_max_alumnos" placeholder="Edite número de usuarios para el nivel!!!" class="form-control" style="align-items: center" required/>
 		       		</div>
			            <div style="padding: 1.5em;">
			                <div class="d-grid gap-2 d-md-flex" style="size: 25px; margin-top: 1.5em; margin-bottom: 1.5em; align-items: center; display: flex; justify-content: center">
			                    <button type="submit" id="boton_azul" class="btn btn-primary" style="position:absolute;left: 40%;width:150px; height:50px; border-radius: 2em;">
	                                <strong><b>Guardar</b></strong>
			                    </button>
			                    <button type="button" id="cerrar" class="btn" style="background-color: crimson;color: black; position:absolute;left: 50%;width:150px; height:50px; border-radius: 2em">
                                <strong style="color:white;"><b>Cerrar Edicion</b></strong>
                            </button> 
		                	</div>

			          	</div>
			        </form
			</div>
        @endif
</main>

    <script type="text/javascript">
        $(document).ready(function(){
        	$ ("#boton_editar").click(function(){
        		$("#editar_maximo").css("display","block");
        	});
        	$ ("#cerrar").click(function(){
        		$("#editar_maximo").css("display","none");
        	});
        });
    </script>    
@endsection        