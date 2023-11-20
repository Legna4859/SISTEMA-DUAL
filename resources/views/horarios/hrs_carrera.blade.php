
@extends('layouts.app')
@section('title', 'Horas por Carrera')
@section('content')
<main class="col-md-12">
  <div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">Horas de las  Carreras por categoria</h3>
	  		</div>
        </div>
    </div>
  </div>
    <div class="row">
	  					<div class="col-md-3 col-md-offset-4">
                            <div class="dropdown">
                                <label for="selectCargo">Categorias</label>
                                <select class="form-control" id="selectCargo" name="selectCargo" >
                                    <option disabled selected hidden>Selecciona una categoria</option>
                                    @foreach($cargos as $cargo)
                                        @if($cargo->id_cargo==$categoria)
                                            <option value="{{$cargo->id_cargo}}" selected="selected">{{$cargo->cargo}}</option>
                                        @else
                                            <option value="{{$cargo->id_cargo}}"> {{$cargo->cargo}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <p></p>
                        </div>
    </div>
    @if($ver == 1)
    <div class="row">
        <div class="col-md-12 panel-body">
            <table class="table table-bordered">
                <tr>
                    <th rowspan="2" class="text-center">CARRERA</th>
                    <th rowspan="2">HRS.CLASE</th>
                    <th colspan="5" class="text-center">HRS.EXTRA CLASE</th>
                    <th rowspan="2"BGCOLOR="e3f2fd">TOTALES POR CARRERA</th>
                </tr>
                <tr>
                    <th>TUTORIAS</th>
                    <th>GESTIÓN A.</th>
                    <th>INVEST.</th>
                    <th>VINCULACIÓN</th>
                    <th>RESIDENCIA P.</th>
                </tr>
                @foreach($carreras as $carrera)
                    <tr>

                        <td>{{$carrera["carrera"]}}</td>
                        <td>{{$carrera["clase"]}}</td>
                        <td>{{$carrera["tutorias"]}}</td>
                        <td>{{$carrera["gestion"]}}</td>
                        <td>{{$carrera["investigacion"]}}</td>
                        <td>{{$carrera["vinculacion"]}}</td>
                        <td>{{$carrera["residencia"]}}</td>
                        <td BGCOLOR="e3f2fd">{{$carrera["totales"]}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td BGCOLOR="e3f2fd">TOTALES POR CARRERAS</td>
                    <td BGCOLOR="e3f2fd">{{$clase1}}</td>
                    <td BGCOLOR="e3f2fd">{{$tutorias1}}</td>
                    <td BGCOLOR="e3f2fd">{{$gestion1}}</td>
                    <td BGCOLOR="e3f2fd">{{$invest1}}</td>
                    <td BGCOLOR="e3f2fd">{{$vincula1}}</td>
                    <td BGCOLOR="e3f2fd">{{$residencia1}}</td>
                    <td BGCOLOR="90caf9">{{$totales}}</td>
                </tr>
            </table>
        </div>
    </div>
        @endif

</main>
<script>
    $(document).ready(function() {
        $("#selectCargo").on('change',function(e){
            var id_cargo= $("#selectCargo").val();
//alert(id_cargo);
            //var mensaje = confirm('/p_educativa/datos/'+id_carrera +'/'+id_cargo);
            //Detectamos si el usuario acepto el mensaje
            //if (mensaje)
            //{
            window.location.href='/hrs_carrera/categoria/'+id_cargo ;
            //  }

        });
    });
</script>

@endsection
