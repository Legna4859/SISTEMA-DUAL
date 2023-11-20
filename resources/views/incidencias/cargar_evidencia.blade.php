@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
<main class="col-md-12">
<div class="row">
    <div class="col-md-5 col-md-offset-4">
     <div class="panel panel-info">
        <div class="panel-heading">
          <h1 class="panel-title text-center">SUBIR EVIDENCIA</h1>
        </div>
     </div>  
    </div>
  <form id="form_enviar_evidencia" action="{{url('/incidencias/guardar_evidencia',$evidencia->id_evid)}}" role="form" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
<div class="row">
  <div class="col-md-10 col-md-offset-2">
    <label>Instrucciones: </label><br>
      <label> Para poder subir la evidencia correspondiente es necesario que su archivo, que desea subir este en formato PDF y que este legible.</label>
  </div>
</div>
<div class="row">
  <div class="col-md-5 col-md-offset-3">
    <div class= "dropdown">
        <label for="Tipo_evi">Tipo de evidencia </label>
          <select class="form-control" placeholder="Seleciona una opción" id="id_tipo_evid" name="id_tipo_evid" required>
              <option disabled selected hidden> Selecciona una opción </option>
              @foreach($tipo_evidencia as $tipo_evidencia)
              <option value="{{$tipo_evidencia->id_tipo_evid}}" data-evid="{{$tipo_evidencia->nombre_evidencia}}"> {{$tipo_evidencia->nombre_evidencia}} </option>
              @endforeach
          </select>
    </div>
  </div>
</div>
            <div class="row">              
    <div class="col-md-5 col-md-offset-3">
                    <span><label for="archivo_subir">Archivo a subir:</label>
                    <input  class="form-control" id="arch_evidencia" name="arch_evidencia" type="file" accept="application/pdf"    required/>
                </div> 
                </div> 
 </form>
 <div class="row" style="display: inline" id="subir">
    <br>
      <div class="col-md-4 col-md-offset-5">
        <button id="enviar_evidencia" type="button" class="btn btn-success btn-lg">Guardar Evidencia</button>
      </div>
</div>
<script>
  $("#enviar_evidencia").click(function(){

var id_tipo_evid= $('#id_tipo_evid').val();
//alert(id_tipo_evid);
if(id_tipo_evid == null)
     {
      swal({
        position: "top",
        type: "error",
        title: "Selecciona tipo de evidencia",
        showConfirmButton: false,
        timer: 3500
      });
     }else{ 
      var arch_evidencia = $('#arch_evidencia').val();
      if(arch_evidencia == ''){
          swal({
        position: "top",
        type: "error",
        title: "Selecciona evidencia que desea subir",
        showConfirmButton: false,
        timer: 3500
      });
      } else{
      $("#form_enviar_evidencia").submit();
      $("#enviar_evidencia").attr("disableb", true);
            swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
    }
  }
///////seecion de evidencia////
    });
   </script>   
</main>
@endsection