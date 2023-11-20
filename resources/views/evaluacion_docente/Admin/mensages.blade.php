@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<?php
  $direccion=Session::get('ip');
?>
<main>
<div>
	
	<div class="col-md-4 col-md-offset-4">
		<label class=" alert alert-danger"  data-toggle="tab" >{{$mensage_carga}}</label> 
	</div>
</div>
</main>

<script>
	alert('hola');
		@if(isset($mensage_carga))
		
		setTimeout(myFunction, 2000); 

		function myFunction(){
			
var direccion="{{$direccion}}";
		window.location.href="/consulta_actividades/";
		//window.location.href="http://"+direccion+":8000/
		}
		@endif
	
</script>
@endsection