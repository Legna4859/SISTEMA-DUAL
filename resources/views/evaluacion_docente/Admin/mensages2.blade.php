@extends('layouts.app')
@section('title', 'Inicio')
@section('content')

<main>
<div>
	@if($color==1)
	<div class="col-md-4 col-md-offset-4">
		<label class=" alert alert-danger"  data-toggle="tab" >{{$mensage_carga}}</label> 
	</div>
	@else
	<div class="col-md-4 col-md-offset-4">
		<label class=" alert alert-success"  data-toggle="tab" >{{$mensage_carga}}</label> 
	</div>
	@endif
</div>
</main>
<?php
	$direccion=Session::get('ip');
?>
<script>
	
		@if(isset($mensage_carga))
		var direccion="{{$direccion}}";
		//alert(direccion);
		setTimeout(myFunction, 1000); 

		function myFunction(){
		window.location.href="/buscar_profesores";
		}
		@endif
	
</script>
@endsection