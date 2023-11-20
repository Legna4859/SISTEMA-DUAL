@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
<main class="col-md-12">
<div class="row">
    <div class="col-md-5 col-md-offset-4">
     <div class="panel panel-info">
       <div class="panel-heading">
          <h1 class="panel-title text-center">EDITAR EVIDENCIA</h1>
      </div>
    </div>  
</div>
    <div class="row">
    <div class="col-md-5 col-md-offset-4">
     <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"> Tipo de evidencia enviada</h3>
          <br>
          <div class="row">
    <div class="col-md-5 col-md-offset-4">
          <a  target="_blank" href="/incidencias/{{$evidencia->arch_evidencia}}" class="btn btn-primary"> <i class=" glyphicon glyphicon-book em128" title="Ver PDF"> </i> Ver evidencia </a>
          <button id="{{$evidencia->id_evid}}" class="btn btn-primary editar_evid"> Editar </button>
        </div>  
    </div>  
    </div>  
    </div>
  <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center" id="myModalLabel">EDITAR EVIDENCIA</h4>
        </div>
      <div class="modal-body">
    <div id="contenedor_editar">
  </div>
</div> <!-- modal body  -->
                    <div class="modal-footer">
                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                       
                        <button type="button" id="guardar_mod"class="btn btn-primary" >Guardar</button>
                   </div>
 
                </div>
            </div>
        </div>

     <script>
$(document).ready(function(){
  $(".editar_evid").click(function(){
        //alert("HOLA");
    var id_evid = $(this).attr('id');
    $.get("/incidencias/modificar_evidencia/"+id_evid,function(request){
    $("#contenedor_editar").html(request);
    $("#modal_editar").modal('show');
    });
  }); 
  $("#guardar_mod").click(function(){

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
      $("#guardar_mod").attr("disableb", true);
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

/////////Sigue script//////
});   
</script>


</main>
@endsection