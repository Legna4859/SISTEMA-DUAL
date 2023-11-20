@extends('layouts.app')
@section('title', 'Inicio')
@section('content')

<main class="col-md-12">
<div>
	
	<div class="col-md-4 col-md-offset-4">
		<label class=" alert alert-danger"  data-toggle="tab" >{{$mensaje_evidencias}}</label> 
	</div>
</div>

</main>
<?php
	$direccion=Session::get('ip');
?>
<script>
	$(document).ready(function(){
		@if(isset($mensaje_evidencias))
		var direccion="{{$direccion}}";
		//setTimeout(myFunction, 2000); 

		function myFunction(){
		window.location.href=direccion+"/evidencias_alumnos/";
		}

	@endif
});
</script>
@endsection

