@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<?php
	$men=Session::get('men');
	$fecha=Session::get('fecha');
	$profesor_men=session()->has('profesor_men')?session()->has('profesor_men'):false;
            
?>
<script>
$(document).ready(function() {

$("#modal").modal('show');
setTimeout(myFunction, 1000); 
        function myFunction(){
        window.location.href='/inicio';
        }

});

</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	@if($profesor_men==true)
	                <div class="panel-heading">{{$men}}</div>
	                <div class="panel-heading">NOTA:
	                	La última fecha de liberación de Actividades Complementarias es el {{$fecha}}</div>
            	@else
            		<div class="panel-heading">{{$men}}</div>
            	@endif
            </div>
        </div>
    </div>
</div>

<div id="modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        {{ "CARGANDO...." }}
      </div>
    </div>
  </div>
</div>

@endsection
