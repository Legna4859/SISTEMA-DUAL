@extends('tutorias.app_tutorias')
@section('content')
<div class="row">
                    <div class="col-3 offset-3">
                        <h3>Reporte semestral </h3>
                    </div>       
</div>
<div class="row">
                    <div class="col-3 offset-3">
                        <button type="button" class="btn-primary center" onclick="window.open('{{url('/tutorias/reportecoordinador/tutorias_reportesemestralinstitucional')}}')">Imprimir</button>
                    </div>       
</div>
<div class="row">
<div class="col-10 offset-1">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nombre de Carrera</th>
        <th>Observaciones</th>
      </tr>
    </thead>
    <tbody>
        @foreach($dat_carreras as $key => $carrera)
      <tr>
        <td>{{ $key + 1}}</td>
        <td>{{ $carrera['nombre']}}</td>
        @if($carrera['estado'] == 1)
        <td> <botton title="agregar observacion" id="{{$carrera['id_carrera']}}" 
        class="btn btn-primary agregar_observacion">agregar </botton>
      </td>
        @elseif($carrera['estado'] == 2)
        <td><botton title="editar observacion" id="{{$carrera['id_carrera']}}" 
        class="btn btn-primary editar_observacion">editar</botton></td>
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
        <form id="form_agregar_observacion" class="form" action="{{url("/tutorias/reporteinstitucional/guardar_observacion")}}" role ="from" method="POST">
        {{csrf_field()}}
        <input type="hidden" id="id_carreras" name="id_carreras" value="">
        <div class = "row"> 
          <div class = "col-md-10" col-md-offset-1>
        <div class="form-group">
          <label>Agregar Observación</label>
          <textarea class="form-control" id="observacion" name="observacion" rows="3" 
          onkeyup="javascript::this.values=this.value.toUpperCase();" required></textarea>
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

  var id_carrera = $(this).attr('id');
  //alert(id_asigna_generacion);
       $('#id_carreras').val(id_carrera);
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
    var id_carrera = $(this).attr('id');
    
    $.get("/tutorias/reporteinstitucional/editar_observacion_carrera/"+id_carrera, function(request){

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