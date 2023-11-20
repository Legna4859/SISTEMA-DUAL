@extends('layouts.app')
@section('title', 'Incidencias')
@section('content')
    
<main class="col-md-12">

  <div class="row">
        <div class="col-md-5 col-md-offset-4">
          <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title text-center">SOLICITUD DE OFICIOS</h3>
                </div>
          </div>  
        </div>
  </div>
<div>
  <form id="form_guardar_solicitud" action="{{url('/incidencias/guardar_incidencia_solicitada')}}" method="POST" role="form" >
  {{ csrf_field() }}
             <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="form-group">
                         <label for="motivo_oficio">Motivo del oficio:</label>
                         <textarea class="form-control" id="motivo_oficio" name="motivo_oficio" rows="3" placeholder="Ingresa el motivo del oficio (Utilizar letras mayusculas y minusculas), por ejemplo: Entregar documentación" style=""></textarea>
                     </div>
                </div>
             </div>
                
  <div class="row">

      <div class="col-md-4 col-md-offset-1">
          <div class= "dropdown">
             <label for="Tipo_of">Tipo de articulo/clausula aplicada:</label>
             <input type="hidden" id="estado_profesor" name="estado_profesor" value="{{$estado_profesor}}">
             <select class="form-control" placeholder="Seleciona una opción" id="id_articulo" name="id_articulo" required>
                <option disabled selected hidden> Selecciona una opción </option>
                @foreach($articulos as $articulo)
                <option value="{{$articulo->id_articulo}}" data-art="{{$articulo->nombre_articulo}}"> {{$articulo->nombre_articulo}} </option>
                
                @endforeach
             </select>
          </div>
      </div>

                      <div id="message" style="display:none">
                          <div class="col-md-3  ">
                            <div class="alert alert-danger">
                              <strong>Sin días disponibles </strong>
                            </div>
                        </div>
                     </div>
                     <div id="message2" style="display:none">  
                          <div class="col-md-3  ">
                            <div class="alert alert-success">
                              <strong>Puedes realizar tu solicitud </strong>
                            </div>   </div>
                     </div>
           
                     <div class="col-md-2  col-md-offset-1 ">
                        <label for="fecha_req">Fecha requerida:</label>
                        <div class="form-group">
                            <input class="form-control datepicker fecha_req"   type="text"  id="fecha_req" name="fecha_req" data-date-format="yyyy/mm/dd" placeholder="DD/MM/AAAA" >
                        </div>
                     </div>
  </div>
      @if($estado_profesor==1)
                    <div class="col-md-3 col-md-offset-1" id="jefes" style="display:none;">
                        <div class="dropdown">
                            <label for="exampleInputEmail1">Dirigido a:</label>
                            <select class="form-control" placeholder="Seleciona una opción" id="id_jefe" name="id_jefe" required>
                              <option disabled selected hidden> Selecciona una opción </option>
                                @foreach($array_carreras as $carrera)
                              <option value="{{$carrera['id_personal']}}" data-art="{{$carrera['nombre']}}">{{$titulo->titulo}} {{$carrera['nombre']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


      @endif

            {{-----------ARTICULO 64°-----------}}
    <div style="display: none;" id="articulo_64">

            <div class="row">
                  <div class="col-md-2 col-md-offset-2">
                    <label for="horario entrada">Horario de entrada</label><br>
                     <div class="form-group">
                             <input id="hora_e" class="form-control time" type="text" name="hora_e" placeholder="HORA" />
                     </div>
                  </div>
                  <div class="col-md-2 col-md-offset-1">
                     <label for="hora salida tarde">Horario de llegada tarde</label><br>
                     <div class="form-group">
                             <input id="hora_st" class="form-control time" type="text" name="hora_st" placeholder="HORA" />
                     </div>     
                  </div>
            </div>
    </div>
{{--------ARTICULO 73°----------}}
    <div style="display: none;" id="articulo_73">
            <div class="row">
                  <div class="col-md-3 col-md-offset-2">
                      <label for="fecha_invac">Fecha de inicio vacaciones</label>
                     <div class="form-group">
                         <input class="form-control datepicker fecha_invac"   type="text"  id="fecha_invac" name="fecha_invac" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
                  </div>
                  <div class="col-md-3 col-md-offset-1">
                     <label for="fecha_tervac">Fecha de termino de  vacaciones</label>
                     <div class="form-group">
                         <input class="form-control datepicker fecha_tervac"   type="text"  id="fecha_tervac" name="fecha_tervac" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" >
                     </div>
                  </div>               
            </div>
    </div>
{{------ARTICULO 68° 1/2 JORNADA SIN SINDICATO------}}
    <div style="display: none;" id="articuloM_68">
      <div class="row">
                  <div class="col-md-2 col-md-offset-2">
                     <label for="horario entrada">Horario de entrada</label><br>
                     <div class="form-group">
                             <input id="hora_e1" class="form-control time" type="text" name="hora_e1" placeholder="HORA" />
                     </div>
                  </div>
        <div class="col-md-2 col-md-offset-1">
            <label for="hora salida tarde">Horario de salida</label><br>
            <div class="form-group">
                  <input id="hora_s1" class="form-control time" type="text" name="hora_s1" placeholder="HORA" />
            </div>
        </div>
      </div>
    </div>
{{------CLAUSULA 44° 1/2 JORNADA CON SINDICATO------}}
  <div style="display: none;" id="articuloM_44">
    <div class="row">
                <div class="col-md-2 col-md-offset-2">
                     <label for="horario entrada">Horario de entrada</label><br>
                     <div class="form-group">
                             <input id="hora_e2" class="form-control time" type="text" name="hora_e2" placeholder="HORA" />
                     </div>
                </div>
      <div class="col-md-2 col-md-offset-1">
            <label for="hora salida tarde">Horario de salida</label><br>
            <div class="form-group">
                <input id="hora_s2" class="form-control time" type="text" name="hora_s2" placeholder="HORA" />
            </div>
      </div>
    </div>
  </div>
{{-------DESCRIPCIÓN CLAUSULA 44 DIAS ECONOMICOS SINDICATO------------}}
    <div style="display: none;" id="descripcionD_44">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="dia economico SIND" >El personal, después de laborar un año y hasta nueve años en el TESVB disfrutarán de 4 días económicos por año con goce de sueldo íntegro, después de nueve a quince años disfrutarán de 5 días económicos por año con goce de sueldo íntegro, y más de 15 años disfrutarán de 6 días económicos por año con goce de sueldo íntegro, estos no podrán ser fraccionados.</label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 69 OMISIÓN DE ENTRADA------------}}
    <div style="display: none;" id="descripcion_69">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="omisión de salida" >Toda incidencia deberá justificarse ante la Dirección de Administración y Finanzas en el caso del
                personal administrativo y a la Dirección de Académica para el personal docente, en un plazo no mayor a cinco días
                hábiles después de ocurrida; de no respetar el plazo de presentación, esta perderá su carácter de justificable y no
                será autorizada. </label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN CLAUSULA 44 MEDIAS JORNADAS SINDICATO------------}}
    <div style="display: none;" id="descripcionM_44">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="media jornada SIND">Los trabajadores gozaran de 4 medias jornadas al año para atender situaciones personales que se pudieran presentar; el Tecnológico está facultado para corroborar y/o solicitar la constancia correspondiente que constante tal situación. </label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 68 DIAS ECONOMICOS SIN SINDICATO------------}}
    <div style="display: none;" id="descripcionD_68">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="dia economico NO SIND">El personal, después de laborar un año y hasta nueve años en el TESVB disfrutarán de 4 días económicos por año con goce de sueldo íntegro, después de nueve a quince años disfrutarán de 5 días económicos por año con goce de sueldo íntegro, y más de 15 años disfrutarán de 6 días económicos por año con goce de sueldo íntegro, estos no podrán ser fraccionados.</label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 68 MEDIAS JORNADAS SIN SINDICATO------------}}
    <div style="display: none;" id="descripcionM_68">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="media jornada NO SIND">Los trabajadores gozaran de 4 medias jornadas al año para atender situaciones personales que se pudieran presentar; el Tecnológico está facultado para corroborar y/o solicitar la constancia correspondiente que constante tal situación. </label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 56 TITULACION O GRADO------------}}
    <div style="display: none;" id="descripcion_56">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="titulacion">El personal adscrito al Tecnológico con más de un año de antigüedad, tendrán derecho a una licencia
              con goce de sueldo hasta por tres días hábiles por concepto de titulación o grado incluyendo el día de la presentación
              de la evaluación profesional o de grado, lo anterior a efecto de preparar la evaluación profesional que sustenten;
              debiendo presentar documento oficial que acredite la presentación del examen.</label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 61 DIA SIN GOCE DE SUELDO------------}}
    <div style="display: none;" id="descripcion_61">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <label for="dia sin goce">Para disfrutar de las licencias sin goce de sueldo, el personal adscrito al Tecnológico deberá contar con
                    la autorización de la jefatura correspondiente y con el visto bueno del Director General.
                    Las licencias podrán negarse si la ausencia del personal afecta el adecuado desempeño de las operaciones del
                    Tecnológico.</label>
            </div>
        </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 64 RETARDO------------}}
    <div style="display: none;" id="descripcion_64">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <label for="retardo"> La autorización de permisos de entrada y salida fuera del horario establecido y para desempeñar
            comisiones, deberá contar con la aprobación de la jefatura correspondiente, así como del visto bueno de la Dirección
            o Subdirección a la que corresponda en los siguientes casos:
            <br>I. Asistencia a laborar después de dieciséis minutos de los horarios correspondientes al inicio de la jornada y al
            regreso de la comida; y
            <br>II. Cualquier otra excepción para el cumplimiento del horario normal.</label>
        </div>
      </div>
    </div>
{{-------DESCRIPCIÓN ARTICULO 73 VACACIONES NO DISFRUTADAS------------}}
      <div style="display: none;" id="descripcion_73">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <label for="dia sin goce">El personal adscrito al Tecnológico, que durante periodos de vacaciones se encuentren incapacitados
               por enfermedad o gravidez, tendrá derecho a que se le repongan los días de vacaciones que no hubieren disfrutado,
               una vez concluida la incapacidad.</label>
          </div>
         </div>
      </div>
    </form> 

          <div class="row" style="display: inline" id="solicitar">
            <div class="col-md-2 col-md-offset-6">
                <button id="enviar_solicitud" type="button" class="btn btn-success btn-lg">Enviar</button>
            </div>    
          </div>
</div>
      <div class="modal fade" id="modal_mostrar2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Informacion Adicional</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mostrar2">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
<script>
   $(document).ready( function() {
   $("#id_articulo").change(function(){
    var id_articulo=$(this).val();
    //alert(id_articulo);

    $.get("/incidencias/solicitud/validar/"+id_articulo,function (data) {
          
          var dias_dis=data;
          
          if(dias_dis==0)
          {
            
            $("#message").css("display", "block");
            $("#message2").css("display", "none");
            $("#enviar_solicitud").attr("disabled", true);
          }
          if(dias_dis>0)
          {
           
            $("#message2").css("display", "block");
            $("#message").css("display", "none");
            $("#enviar_solicitud").attr("disabled", false);
          }
          
        }); 
    //alert('hola');
     if(id_articulo == 5){
      $("#articulo_64").css("display", "block");
      $("#articulo_73").css("display", "none");
      $("#articuloM_68").css("display", "none");
      $("#articuloM_44").css("display", "none");
      $("#descripcion_64").css("display", "block"); 
      $("#descripcionD_44").css("display", "none"); 
      $("#descripcionM_44").css("display", "none"); 
      $("#descripcionD_68").css("display", "none");
      $("#descripcionM_68").css("display", "none"); 
      $("#descripcion_56").css("display", "none");  
      $("#descripcion_61").css("display", "none");
      $("#descripcion_73").css("display", "none"); 
      $("#descripcion_69").css("display", "none");
      var id_estado_prof="<?php echo $estado_profesor;?>";
      if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
     
      //alert('hola');
      
     }
      if(id_articulo == 8){
      $("#articulo_73").css("display", "block");
      $("#descripcion_73").css("display", "block");
      $("#articuloM_68").css("display", "none");
      $("#articuloM_44").css("display", "none");
      $("#articulo_64").css("display", "none");
      $("#descripcion_64").css("display", "none");
      $("#descripcion_61").css("display", "none"); 
      $("#descripcion_56").css("display", "none"); 
      $("#descripcionM_68").css("display", "none"); 
      $("#descripcionD_68").css("display", "none"); 
      $("#descripcionM_44").css("display", "none");
      $("#descripcionD_44").css("display", "none"); 
      $("#descripcion_69").css("display", "none"); 
      }
      if (id_articulo == 1){
        $("#descripcionD_44").css("display", "block");
        $("#descripcionM_44").css("display", "none");
        $("#descripcionD_68").css("display", "none");
        $("#descripcionM_68").css("display", "none");
        $("#descripcion_56").css("display", "none");
        $("#descripcion_61").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#articulo_64").css("display", "none");
        $("#articulo_73").css("display", "none");
        $("#descripcion_69").css("display", "none");
        var id_estado_prof="<?php echo $estado_profesor;?>";
      if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
      }
      if (id_articulo == 6){
        $("#descripcionD_68").css("display", "block");
        $("#descripcionD_44").css("display", "none");
        $("#descripcionM_44").css("display", "none");
        $("#descripcionM_68").css("display", "none");
        $("#descripcion_56").css("display", "none");
        $("#descripcion_61").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#articulo_64").css("display", "none");
        $("#articulo_73").css("display", "none");
        $("#descripcion_69").css("display", "none");
        var id_estado_prof="<?php echo $estado_profesor;?>";
      if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
      }
      if (id_articulo == 10){
        $("#descripcionM_68").css("display", "block");
        $("#descripcionD_44").css("display", "none");
        $("#descripcionM_44").css("display", "none");
        $("#descripcionD_68").css("display", "none");
        $("#descripcion_56").css("display", "none");
        $("#descripcion_61").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#articuloM_68").css("display", "block");
        $("#articuloM_44").css("display", "none");
        $("#articulo_64").css("display", "none");
        $("#articulo_73").css("display", "none");
        $("#descripcion_69").css("display", "none");
        var id_estado_prof="<?php echo $estado_profesor;?>";
      if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
      }
      if (id_articulo == 9){
        $("#articuloM_44").css("display", "block");
        $("#descripcionM_44").css("display", "block");
        $("#descripcionD_44").css("display", "none");
        $("#descripcionD_68").css("display", "none");
        $("#descripcionM_68").css("display", "none");
        $("#descripcion_56").css("display", "none");
        $("#descripcion_61").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#articuloM_68").css("display", "none");
        $("#articulo_64").css("display", "none");
        $("#articulo_73").css("display", "none");
        $("#descripcion_69").css("display", "none");
        var id_estado_prof="<?php echo $estado_profesor;?>";
        if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
      }
      if (id_articulo == 2){
        $("#descripcion_56").css("display", "block");
        $("#descripcionM_44").css("display", "none");
        $("#descripcionD_44").css("display", "none");
        $("#descripcionD_68").css("display", "none");
        $("#descripcionM_68").css("display", "none");
        $("#descripcion_61").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#descripcion_69").css("display", "none");
        var id_estado_prof="<?php echo $estado_profesor;?>";
      if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
      }
      if(id_articulo==4){
        $("#descripcion_61").css("display", "block");
        $("#descripcionM_44").css("display", "none");
        $("#descripcionD_44").css("display", "none");
        $("#descripcionD_68").css("display", "none");
        $("#descripcionM_68").css("display", "none");
        $("#descripcion_56").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#descripcion_69").css("display", "none");
        var id_estado_prof="<?php echo $estado_profesor;?>";
        if(id_estado_prof==1){
         $("#jefes").css("display", "block");

      }
      }
      if(id_articulo == 7){
        $("#descripcion_69").css("display", "block")
        $("#descripcionM_44").css("display", "none");
        $("#descripcionD_44").css("display", "none");
        $("#descripcionD_68").css("display", "none");
        $("#descripcionM_68").css("display", "none");
        $("#descripcion_56").css("display", "none");
        $("#descripcion_61").css("display", "none");
        $("#descripcion_64").css("display", "none");
        $("#descripcion_73").css("display", "none");
        $("#articuloM_44").css("display", "none");
        $("#articuloM_68").css("display", "none");
      }
      
    });
   $('#hora_e').pickatime({
                format: 'HH:i',
     });
     $('#hora_st').pickatime({
                format: 'HH:i',
     });
     $('#hora_e1').pickatime({
                format: 'HH:i',
     });
     $('#hora_s1').pickatime({
                format: 'HH:i',
     });
     $('#hora_e2').pickatime({
                format: 'HH:i',
     });
     $('#hora_s2').pickatime({
                format: 'HH:i',
     });
     $( '.fecha_req').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                  $('.fecha_req').datepicker('setStartDate', getDate(selected));
                });
                $( '.fecha_invac').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                  $('.fecha_invac').datepicker('setStartDate', getDate(selected));
                });
                $( '.fecha_tervac').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            }).on('changeDate',
                function (selected) {
                    $('.fecha_tervac').datepicker('setStartDate', getDate(selected));
                });

    //////Validacion llenado///

    $("#enviar_solicitud").click(function(){

      var id_articulo = $('#id_articulo').val();
     //alert (id_articulo);
     if(id_articulo == null)
     {
      swal
      ({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     ////articulo56/////
     else{
      if(id_articulo == 2){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          var motivo_oficio = $('#motivo_oficio').val();
          if(motivo_oficio == ''){
            swal({
        position: "top",
        type: "error",
        title: "Describe el motivo de la incidencia",
        showConfirmButton: false,
        timer: 3500
      });
          }else{
              $("#form_guardar_solicitud").submit();
              $("#enviar_solicitud").attr("disableb", true);
            swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
          } 
        }
      }
    }
if(id_articulo == null){
      swal({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      /////Articulo61
      if(id_articulo == 4){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
        }
      }
    }
    ////articulo64//////
    if(id_articulo == null)
     {
      swal
      ({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 5){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          var hora_e = $('#hora_e').val();
          if(hora_e == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona el horario de entrada",
        showConfirmButton: false,
        timer: 3500
      });
      }else{
        var hora_st = $('#hora_st').val();
          if(hora_st == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona el horario de llegada tarde",
        showConfirmButton: false,
        timer: 3500
      });
    }else{
      $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
           }
          } 
        }
      }
    }
////art68////
if(id_articulo == null){
      swal({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 6){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
        }
      }
    }
    /////art68 media jornada//////
    if(id_articulo == null)
     {
      swal
      ({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 10){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          var hora_e1 = $('#hora_e1').val();
          if(hora_e1 == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona el horario de entrada",
        showConfirmButton: false,
        timer: 3500
      });
      }else{
        var hora_s1 = $('#hora_s1').val();
          if(hora_s1 == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona el horario de salida",
        showConfirmButton: false,
        timer: 3500
      });
    }else{
      $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
           }
          } 
        }
      }
    }
/////art69/////
if(id_articulo == null){
      swal({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 7){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
        }
      }
    }
/////art73//////
if(id_articulo == null)
     {
      swal
      ({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 8){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          var fecha_invac = $('#fecha_invac').val();
          if(fecha_invac == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona la fecha de inicio de vacaciones",
        showConfirmButton: false,
        timer: 3500
      });
      }else{
        var fecha_tervac = $('#fecha_tervac').val();
          if(fecha_tervac == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona la fecha de termino de vacaciones",
        showConfirmButton: false,
        timer: 3500
      });
    }else{
      $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
           }
          } 
        }
      }
    }
  /////art44diaeconomico////
  if(id_articulo == null){
      swal({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 1){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
        }
      }
    }
    ////art44mediasjornadas////
    if(id_articulo == null)
     {
      swal
      ({
        position: "top",
        type: "error",
        title: "Selecciona articulo",
        showConfirmButton: false,
        timer: 3500
      });
     }
     else{
      if(id_articulo == 9){
        var fecha_req = $('#fecha_req').val();
        if(fecha_req == ''){
          swal({
        position: "top",
        type: "error",
        title: "Elige fecha solicitada",
        showConfirmButton: false,
        timer: 3500
      });
        }else{
          var hora_e2 = $('#hora_e2').val();
          if(hora_e2 == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona el horario de entrada",
        showConfirmButton: false,
        timer: 3500
      });
      }else{
        var hora_s2 = $('#hora_s2').val();
          if(hora_s2 == ''){
            swal({
        position: "top",
        type: "error",
        title: "Selecciona el horario de salida",
        showConfirmButton: false,
        timer: 3500
      });
    }else{
      $("#form_guardar_solicitud").submit();
          $("#enviar_solicitud").attr("disableb", true);
          swal({
        position: "top",
        type: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 3500
            });
           }
          } 
        }
      }
    }
  //////seccion de acticulo/////
    });
                
  });
</script>
</main>
@endsection