@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
             <div class="col-3 offset-3"> <h3>Reporte semestral</h3></div>       
</div>
<div class="row">
    <div class="col-3 offset-3">
    <button type="button" class="btn-primary center" onclick="window.open
    ('{{url('/tutorias/reportecoordinador/tutorias_reportesemestralcarrera/'.$id_asigna_coordinador)}}')">Imprimir</button>
    </div>       
</div>
<div class="row">
<div class="col-10 offset-1">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nombre</th>
        <th>Grupo</th>
        <th>Observaciones</th>
      </tr>
    </thead>
    <tbody>
        @foreach($array_tutores as $key => $tutores)
      <tr>
        <td>{{ $key + 1}}</td>
        <td>{{ $tutores['nombre_tutor']}}</td>
        <td>{{ $tutores['grupo']}}</td>
        @if($tutores['estado_observacion'] == 1)
        <td> <botton title="agregar observacion" id="{{$tutores['id_asigna_generacion']}}" 
        class="btn btn-primary agregar_observacion">agregar </botton>
        @elseif($tutores['estado_observacion'] == 2)
        <td><botton title="editar_observacion" id="{{$tutores['id_asigna_generacion']}}" 
        class="btn btn-primary editar_observacion">editar </botton>
        </td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_agregar_observacion" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Observación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_observacion" class="form" action="{{url("/tutorias/reportecoordinador/guardar_observacion")}}" role ="from" method="POST">
        {{csrf_field()}}
        <input type="hidden" id="id_asigna_gen" name="id_asigna_gen" value="">
        <div class = "row"> 
          <div class = "col-md-10" col-md-offset-1>
          <div align="center">
                        <h5>Tutorias</h5>
                      </div>
        <div class="form-group">
          <label>Agregar Observación</label>
          <textarea class="form-control" id="observacion" name="observacion" rows="3" 
          onkeyup="javascript::this.values=this.value.toUpperCase();" required></textarea>
          <small>Las observaciones deben contener un máximo de 38 caracteres.</small>
        </div>  
        </div> 
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar_observacion" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_mod_observacion" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Observación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenedor_mod_observacion">

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar_mod_observacion" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script>

$(document).ready(function(){
  
  $(".agregar_observacion").click(function (){

  var id_asigna_generacion = $(this).attr('id');
  //alert(id_asigna_generacion);
       $('#id_asigna_gen').val(id_asigna_generacion);
       $('#modal_agregar_observacion').modal('show');
  });
  $("#guardar_observacion").click(function(){
  
    var observacion = $('#observacion').val();
  if(observacion == ''){
      alert ("Agrega observacion");
  }else{
    $("#form_agregar_observacion").submit();
    $("#guardar_observacion").attr("disabled",true);
  }
  });
  $(".editar_observacion").click(function(){
    var id_asigna_generacion = $(this).attr('id');
    $.get("/tutorias/reportecoordinador/editar_observacion_tutor/"+id_asigna_generacion, function(request){
       $("#contenedor_mod_observacion").html(request);
       $("#modal_mod_observacion").modal('show');
    });

  });
  $("#guardar_mod_observacion").click(function(){
    var observacion = $('#observacion_mod').val();
  if(observacion == ''){
      alert ("Agrega observacion");
  }else{
    $("#form_mod_observacion").submit();
    $("#guardar_mod_observacion").attr("disabled",true);
  }
  });
});


</script>
@endsection