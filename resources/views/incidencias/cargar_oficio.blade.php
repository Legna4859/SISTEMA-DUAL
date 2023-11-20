@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
<main class="col-md-12">
<div class="row">
    <div class="col-md-5 col-md-offset-4">
     <div class="panel panel-info">
        <div class="panel-heading">
          <h1 class="panel-title text-center">SUBIR OFICIO FIRMADO</h1>
        </div>
     </div>  
    </div>
  <form id="form_enviar_oficio" action="{{url('/incidencias/guardar_oficio',$oficio->id_solicitud)}}" role="form" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
<div class="row">
  <div class="col-md-10 col-md-offset-2">
    <label>Instrucciones: </label><br>
      <label> Para poder subir la evidencia correspondiente es necesario que su archivo, que desea subir este en formato PDF y que este legible.</label>
  </div>
</div>

<div class="row">              
    <div class="col-md-5 col-md-offset-3">
                    <span><label for="archivo_subir">Archivo a subir:</label>
                    <input  class="form-control" id="arch_solicitud" name="arch_solicitud" type="file" accept="application/pdf"    required/>
                </div> 
                </div> 
 </form>
 <div class="row" style="display: inline" id="subir">
    <br>
      <div class="col-md-4 col-md-offset-5">
        <button id="enviar_oficio" type="button" class="btn btn-success btn-lg">Guardar oficio</button>
      </div>
</div>
<script>
  $("#enviar_oficio").click(function(){
      var arch_oficio = $('#arch_solicitud').val();
      if(arch_oficio == ''){
          swal({
        position: "top",
        type: "error",
        title: "Selecciona oficio que desea subir",
        showConfirmButton: false,
        timer: 3500
      });
      } else{
      $("#form_enviar_oficio").submit();
      $("#enviar_oficio").attr("disableb", true);
            swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
    }
  
///////seecion de evidencia////
    });
   </script>   
</main>
@endsection