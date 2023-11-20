@extends('layouts.app')
@section('title', 'Plantilla Educativa')
@section('content')

    <script>
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  e.target // newly activated tab
  e.relatedTarget // previous active tab
})
    </script>

        <div id="contenedor_horarios">

    </div>

<main class="col-md-12">
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">Plantilla Educativa</h3>
	  		</div>
	  					              <div class="panel-body">
                            <div class="col-md-5 col-sm-6 col-md-offset-1">
                              <div class="dropdown">
                                <label for="SelectCarrera">Carrera</label>
                                 <select name="SelectCarrera" id="SelectCarrera" class="form-control ">
                                  <option>Selecciona carrera...</option>
                                    @foreach($carreras as $carrera)
                                      @if($carrera->id_carrera==$id_carrera)
                                        <option value="{{$id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                      @else
                                        <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                      @endif
                                    @endforeach
                                </select>
                            </div>
                            </div> 
 @if(isset($ver))
                         <div class="col-md-6 col-sm-6" id="div_cargo">
                              <div class="dropdown-center">
                                <label for="selectcargo">Cargo</label>
                                 <select name="selectCargo" id="selectCargo" class="form-control ">
                                  <option disabled selected>Selecciona cargo...</option>
                                    @foreach($cargos as $cargo)
                                    @if($cargo->id_cargo==$id_cargo)
                                            <option value="{{$cargo->id_cargo}}" selected="selected">{{$cargo->cargo}}</option>
                                      @else
                                        <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                      @endif
                                    @endforeach
                                </select>
                            </div>
                            </div>  
                              @else
                         <div class="col-md-6 col-sm-6" id="div_cargo" style="display:none;">
                              <div class="dropdown-center">
                                <label for="selectCargo">Cargo</label>
                                 <select name="selectCargo" id="selectCargo" class="form-control ">
                                  <option disabled selected>Selecciona cargo...</option>
                                    @foreach($cargos as $cargo)                             
                                        <option value="{{$cargo->id_cargo}}" >{{$cargo->cargo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div> 
@endif                        
              </div>
		</div>	
	</div>

 @if(isset($ver))

@foreach($docentes as $docente)
<div class="panel-group col-md-8 col-md-offset-2 plantilla_c" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading link horario" style="color:<?php if($docente["aprobado"]==0){echo "#e05c5c";}else{echo "#409e45";} ?>">
      <h4 class="panel-title v{{$docente["id_horario"]}}">
        <a data-toggle="collapse" data-parent="#accordion" href="#per_{{ $docente ["id_personal"]}}">{{ $docente ["nombre"]}}</a>
        <a class = "tooltip-options link em cont graficas" id="{{ $docente["id_personal"]}}" data-toggle="tooltip" data-placement="top" title ="GRÁFICA"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span></a>
<a class = "tooltip-options link em hr" id="{{ $docente["id_personal"]}}" data-toggle="tooltip" data-placement="top" title ="HORARIO DOCENTE"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
      </h4>
    </div>
    <div id="per_{{ $docente ["id_personal"]}}" class="panel-collapse collapse">
      <div class="panel-body">

<?php $cont=true; ?>
          <ul class="nav nav-tabs">
            @if($docente["clases"]=="true")<li ><a data-toggle="tab" href="#clase{{ $docente["id_horario"] }}">HRS.CLASE</a></li>@endif
            @foreach($docente["actividades"] as $doc_act)
                <li>
                  <a data-toggle="tab" href="#act_{{ $doc_act["id_hrs_actividad_extra"] }}{{ $docente["id_horario"] }}">{{ $doc_act["descripcion"] }}</a>
                </li>
              <?php $cont=false; ?>
            @endforeach
          </ul>

<div class="tab-content">
@if($docente["clases"]=="true")
  <div id="clase{{ $docente["id_horario"] }}" class="tab-pane fade text-center"> <!-- hrs_clase -->
    <h4>Aprobar Horario</h4>
    @if($docente["apro_h"]==1)
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-8{{ $docente["id_horario"] }}" data-act="20000" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" checked type="checkbox">
            <label for="cmn-toggle-8{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @else
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-8{{ $docente["id_horario"] }}" data-act="20000" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" type="checkbox">
            <label for="cmn-toggle-8{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @endif
    <p>Total de Hrs :<strong>{{ $docente["h_total"] }}</strong></p>
    <div class="col-md-10 col-md-offset-1">
      <table class="table table-hover">
                          <thead>
                            <tr>
                                <th class="text-center">Asignatura</th>
                                <th>No.Grupos</th>
                                <th class="text-center">Hrs.Asignadas x materia</th>
                                <th>Hrs.totales asignadas</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($docente["materias"] as $mates)
                            <tr>
                              <td>{{ $mates["nombre"] }}</td>                  
                              <td class="text-center">
                                @foreach($mates["grupos"] as $grupos)
                                {{ $grupos["grupo"] }}<br>
                                @endforeach
                              </td> 
                              <td>{{$mates["totales_mat"]}}</td>               
                              <td>{{ $mates["totales"] }}</td>
                            </tr>
                          @endforeach
                          </tbody>
      </table>
    </div>
  </div>
@endif

  <div id="act_20005{{ $docente["id_horario"] }}" class="tab-pane fade text-center"> <!-- gestion -->
    <h4>Aprobar Horario</h4>
    @if($docente["apro_g"]==1)
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-5{{ $docente["id_horario"] }}" data-act="20005" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" checked type="checkbox">
            <label for="cmn-toggle-5{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @else
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-5{{ $docente["id_horario"] }}" data-act="20005" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" type="checkbox">
            <label for="cmn-toggle-5{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @endif
    <p>Total de Hrs :<strong>{{ $docente["g_total"] }}</strong></p>
    <div class="col-md-10 col-md-offset-1">
      <table class="table table-hover">
                          <thead>
                            <tr>
                                <th class="text-center">Actividad</th>
                                <th>Grupos/Gestión</th>
                                <th>Hrs.Asignadas</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($docente["gestion"] as $doc_ges)
                            <tr>
                              <td>{{ $doc_ges["ges_act"] }}</td>
                              <td>{{ $doc_ges["ges_grupo"] }}</td>
                              <td>{{ $doc_ges["ges_t"] }}</td>
                            </tr>
                          @endforeach
                          </tbody>
      </table>
    </div>
  </div>

  <div id="act_20003{{ $docente["id_horario"] }}" class="tab-pane fade text-center"><!-- investigacion -->
        <h4>Aprobar Horario</h4>
            @if($docente["apro_i"]==1)
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-3{{ $docente["id_horario"] }}" data-act="20003" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" checked type="checkbox">
            <label for="cmn-toggle-3{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @else
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-3{{ $docente["id_horario"] }}" data-act="20003" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" type="checkbox">
            <label for="cmn-toggle-3{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @endif
    <p>Total de Hrs :<strong>{{ $docente["i_total"] }}</strong></p>
    <div class="col-md-10 col-md-offset-1">
      <table class="table table-hover">
                          <thead>
                            <tr>
                                <th class="text-center">Actividad</th>
                                <th>Hrs.Asignadas</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($docente["investigacion"] as $doc_inv)
                            <tr>
                              <td>{{ $doc_inv["inv_act"] }}</td>
                              <td>{{ $doc_inv["inv_t"] }}</td>
                            </tr>
                          @endforeach
                          </tbody>
      </table>
    </div>
  </div>

    <div id="act_20006{{ $docente["id_horario"] }}" class="tab-pane fade text-center"><!--vinculacion -->
        <h4>Aprobar Horario</h4>
        @if($docente["apro_v"]==1)
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-6{{ $docente["id_horario"] }}" data-act="20006" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" checked type="checkbox">
            <label for="cmn-toggle-6{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @else
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-6{{ $docente["id_horario"] }}" data-act="20006" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" type="checkbox">
            <label for="cmn-toggle-6{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @endif
    <p>Total de Hrs :<strong>{{ $docente["v_total"] }}</strong></p>
    <div class="col-md-10 col-md-offset-1">
      <table class="table table-hover">
                          <thead>
                            <tr>
                                <th class="text-center">Actividad</th>
                                <th>Hrs.Asignadas</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($docente["vinculacion"] as $doc_vin)
                            <tr>
                              <td>{{ $doc_vin["vin_act"] }}</td>
                              <td>{{ $doc_vin["vin_t"] }}</td>
                            </tr>
                          @endforeach
                          </tbody>
      </table>
    </div>
  </div>

    <div id="act_20001{{ $docente["id_horario"] }}" class="tab-pane fade text-center"><!-- residencia -->
            <h4>Aprobar Horario</h4>
            @if($docente["apro_r"]==1)
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-1{{ $docente["id_horario"] }}" data-act="20001" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" checked type="checkbox">
            <label for="cmn-toggle-1{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @else
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-1{{ $docente["id_horario"] }}" data-act="20001" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" type="checkbox">
            <label for="cmn-toggle-1{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @endif
    <p>Total de Hrs :<strong>{{ $docente["r_total"] }}</strong></p>
    <div class="col-md-10 col-md-offset-1">
      <table class="table table-hover">
                          <thead>
                            <tr>
                                <th class="text-center">Actividad</th>
                                <th>Hrs.Asignadas</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($docente["residencia"] as $doc_res)
                            <tr>
                              <td>{{ $doc_res["res_act"] }}</td>
                              <td>{{ $doc_res["res_t"] }}</td>
                            </tr>
                          @endforeach
                          </tbody>
      </table>
    </div>
  </div>

    <div id="act_20002{{ $docente["id_horario"] }}" class="tab-pane fade text-center"><!-- tutorias -->
            <h4>Aprobar Horario</h4>
            @if($docente["apro_t"]==1)
        <div class="row">
          <div class="switch-p">
            <input  id="cmn-toggle-2{{ $docente["id_horario"] }}" data-act="20002" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" checked type="checkbox">
            <label for="cmn-toggle-2{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @else
        <div class="row">
          <div class="switch-p">
            <input id="cmn-toggle-2{{ $docente["id_horario"] }}" data-act="20002" data-hr="{{ $docente["id_horario"] }}" class="cmn-toggle cmn-toggle-yes-no aprobar{{ $docente["id_horario"] }}" type="checkbox">
            <label for="cmn-toggle-2{{ $docente["id_horario"] }}" data-on="SI" data-off="NO"></label>
          </div>
        </div>
    @endif
    <p>Total de Hrs :<strong>{{ $docente["t_total"] }}</strong></p>
    <div class="col-md-10 col-md-offset-1">
      <table class="table table-hover">
                          <thead>
                            <tr>
                                <th class="text-center">Grupos</th>
                                <th>Hrs.Asignadas</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($docente["tutorias"] as $doc_tut)
                            <tr>
                              <td>{{ $doc_tut["tut_grupo"] }}</td>
                              <td>{{ $doc_tut["tut_t"] }}</td>
                            </tr>
                          @endforeach
                          </tbody>
      </table>
    </div>
  </div>

</div>

      </div>
    </div>
  </div>
</div>
@endforeach

 @endif 

  </div>		
</main>

<!-- Modal para ver graficas -->
<div class="modal fade bs-example-modal-lg" id="modal_graficas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info">
          <button id="acepta2" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">HISTORIAL DE HORAS DOCENTE</h4>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          <input type="hidden" id="prof" name="prof" value="">
          <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <div class="dropdown">
                    <select name="selectCiclo" id="selectCiclo" class="form-control">
                      <option disabled selected>Selecciona ciclo...</option>
                      <option value="1" >{{ "Marzo-Agosto" }}</option>
                      <option value="2" >{{ "Septiembre-Febrero" }}</option>
                    </select>
                </div>
              </div> 
              <div id="contenedor_graficas">

              </div>
          </div>
        </div>
                      <div class="modal-footer">
              <button id="acepta" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
          </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    $(".link").tooltip({html:true});

@foreach($docentes as $docente)
$('.aprobar{{ $docente["id_horario"] }}').change(function() {
var horario = $(this).data("hr");
var act = $(this).data("act");

//window.location.href='/aprobar_act/'+horario +'/'+act;
     $.get('/aprobar_act/'+horario+'/'+act,function(request){
        var datos=request['verde'];
        //console.log(datos);
        if(datos=="false")
        {
            $('.v{{ $docente["id_horario"] }}').css({
                /* 'visibility': 'visible', */
                'color': '#e05c5c',
            })

          $('.v{{ $docente["id_horario"] }}').removeClass('verde');
          $('.v{{ $docente["id_horario"] }}').addClass('rojo');
        }
        if(datos=="true")
        {
            $('.v{{ $docente["id_horario"] }}').css({
                /* 'visibility': 'visible', */
                'color': '#409e45',
            })
           // alert("hola");
          $('.v{{ $docente["id_horario"] }}').removeClass('rojo');
          $('.v{{ $docente["id_horario"] }}').addClass('verde');
        }
      });
});
@endforeach


   $(".hr").click(function()
  {

    $("#contenedor_horarios").empty();
    var id=$(this).attr('id');

      $.get("/plantilla/horario/"+id,function(request)
        {
          $("#contenedor_horarios").html(request);

        });
    });

  $("#SelectCarrera").on('change',function(e){
      $("#div_cargo").show(1000);
      $('#selectCargo').val($('#selectCargo > option:first').val());
      $(".plantilla_c").hide();
    });

  $("#selectCargo").on('change',function(e){
      var id_carrera= $("#SelectCarrera").val();
      var id_cargo= $("#selectCargo").val();

      //var mensaje = confirm('/p_educativa/datos/'+id_carrera +'/'+id_cargo);
      //Detectamos si el usuario acepto el mensaje
      //if (mensaje) 
      //{
        window.location.href='/p_educativa/datos/'+id_carrera +'/'+id_cargo;
     //  }

    });

  $(".graficas").click(function()
{
  var idp=$(this).attr('id');
  $('#selectCiclo').data('idp',idp);
  $('#modal_graficas').modal('show');
});

$("#selectCiclo").on('change',function(e)
{
  var idp=($(this).data('idp'));
  var idc= $("#selectCiclo").val();

    $("#contenedor_graficas").empty();
    $.get("/graficas_admin/"+idp+"/"+idc,function(request)
        {
          $("#contenedor_graficas").html(request);
        });
});
$("#acepta").click(function()
{
  $("#contenedor_graficas").empty();
  $('#selectCiclo').val($('#selectCiclo > option:first').val());
});
$("#acepta2").click(function()
{
  $("#contenedor_graficas").empty();
  $('#selectCiclo').val($('#selectCiclo > option:first').val());
});

});
</script>
@endsection
