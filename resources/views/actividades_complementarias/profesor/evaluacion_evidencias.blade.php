@section('evaluacionnn')

<main class="col-md-12">
<!--MODAL PARA EVALUAR ACTIVIDADES-->
  <div class="row">
    <div class="col-md-12 col-md-offset-1">
      <div class="modal fade" id="modal_evaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
                <h3 class="modal-title text-center" id="myModalLabel">Evaluación Actividad</h3>
            </div>
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <form class="form-horizontal" id="evaluacion_evidencia" role="form" method="POST" action="{{url("/consulta_general/",$eevaluacion->id_registro_alumno)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT" />
                      {{csrf_field()}} 

              <?php
                $direccion=Session::get('ip');
                $alumnos=Session::get('nombres');

              ?>
          <div class="row">
            <div class="col-md-12">
              <p style="font-weight: bold; color:black; text-align:left;">ALUMNO(A): {{$alumnos}}</p>

                 <table class="table table-bordered tabla-grande2 responsive">

                    <thead>
                    <tr>
                      <th>Evidencia</th>
                      <th>Evaluación</th>
                      <th>Calificación</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($evalua_evidencia as $evalua_evidencia)
                  <tr>
                    <td><a href="{{url("/ArchivosAlumnos",$evalua_evidencia->archivo)}}" target="_blank" data-toggle="modal" id="archivo"><span class="glyphicon glyphicon-list em" data-tooltip="true" data-placement="left" title="VISUALIZAR EVIDENCIA"></span></a> {{$evalua_evidencia->archivo}}</td>
                    <td>
                      <div class="dropdown">
                          <select class="form-control" id="{{$evalua_evidencia->evidencia}}" value="">
                          <option>Selecciona Opción...</option>
                          <option value="100" >Excelente</option>
                          <option value="90" >Muy Bien</option>
                          <option value="80">Bien</option>
                          <option value="70">Regular</option>
                          <option value="0">No Aprobado</option>
                        </select>
                        <input style="display:none" value="{{$evalua_evidencia->id_evidencia_alumno}}" id="{{$evalua_evidencia->id_evidencia_alumno}}">
                        <input style="display:none" value="{{$evalua_evidencia->cuenta}}" id="{{$evalua_evidencia->cuenta}}">

                      </div>
                    </td>
                    <td>
                      <input  class="" value="" id="{{$evalua_evidencia->nombre}}" disabled >
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                  </table>
                    <br></br>
                      <p style="font-weight: bold; color:#BA0000; text-align:center;">UNA VEZ EVALUADA LA ACTIVIDAD NO PODRÁS VOLVER A VER TU EVIDENCIA</p>                </div>
              </div>
            </div>
            </div>
              <div class="modal-footer" >
                <button type="button" class="btn btn-primary" href="!#" id="registra">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
  <input name="fecha" type="text" id="fecha"  value="<?php echo date("Y/m/d"); ?>" style="visibility:hidden" />


</main>
<script>
  $(document).ready(function(){
    var direccion="{{$direccion}}";
@foreach($combo as $com)
$("#{{$com->evidencia}}").on('change',function(){
 var valor=$('#{{$com->evidencia}}').val();

    $("#{{$com->nombre}}").val(valor);

});
@endforeach   

var calificacion=[];
var alumnos=[];
var cuenta=[];

$('#registra').click(function(){
  @foreach($combo as $coms)
    calificacion[calificacion.length]=$("#{{$coms->nombre}}").val();
    alumnos[alumnos.length]=$("#{{$coms->id_evidencia_alumno}}").val();
    cuenta[cuenta.length]=$("#{{$coms->cuenta}}").val();
  @endforeach
   window.location.href=direccion+"/insercion_datos/"+calificacion+ ',' +alumnos+ ',' +cuenta;
});

   $("#modal_evaluacion").modal("show");
     $("#evaluacion_evidencia").click(function(event){

     });


});
</script>
@endsection