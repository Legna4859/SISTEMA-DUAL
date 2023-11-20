@extends('layouts.app')
@section('title', 'RegistroActividad')
@section('content')


<main>
  <form>
  <div class="row">
     <div class="col-md-10 col-md-offset-1">   
        <div class="panel panel-info">
          <div class="panel-heading">Actividades Registradas</div>
        </div>
      </div>
        <div class="col-md-2 col-md-offset-9">
          <div class="form-group "id="hhhh">              
            <label "form-control">Total Horas:</label>   <label "form-control">   {{$suma}}</label>
            <input class="form-control" value="{{$suma}}" id="total_horas" style="visibility:hidden"></input>
          </div>

        </div>
      </div>
        <div class="col-md-8 col-md-offset-2">
            @if($suma>=40)
            @else
            <a type="button" class="btn btn-success btn-lg flotante" data-target="#agrega_actalu" data-tooltip="true" 
                                            data-toggle="modal" data-placement="left" title="AGREGAR ACTIVIDAD" id="agrega">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
            @endif
         </div>
                    

            <div class="row">
              <div class="col-md-10 col-md-offset-1">
               <table class="table table-bordered tabla-grande2 ">
                <thead>
                  <tr>
                    <th>Actividad</th>
                    <th>Categoría</th>
                    <th>Fecha</th>
                    <th>Coordinador</th>
                    <th>Horas</th>
                    <th>Créditos</th>
                    <th>Estado Solicitud</th> 
                    <th>Editar</th>
                    <th>Eliminar</th>               
                  </tr>
                </thead>
                    <tbody>
                      @foreach($consulta_alumno as $alumno)                     
                        <tr>
                          <td>{{$alumno->descripcion}}</td>
                          <td>{{$alumno->descripcion_cat}}</td>
                          <td>{{$alumno->fecha_registro}}</td>
                          <td>{{$alumno->titulo}} {{$alumno->nombre}}</td>
                          <td>{{$alumno->horas}}</td>
                          <td>{{$alumno->creditos}}</td>
                            @if($alumno->liberacion == 0)
                            <td>
                            En espera Jefe de división...
                            </td>
                              <td><a href="{{url("/consulta_actividades/",$alumno->id_registro_alumno)}}/edit"><span class="glyphicon glyphicon-cog em" aria-hidden="true" ></span></a></td>
                              <td><a class="elimina" id="{{$alumno->id_registro_alumno}}"><span class="glyphicon glyphicon-trash em" aria-hidden="true"></span></a></td>
                            @endif
                            @if($alumno->liberacion == 1)
                            <td>
                            En espera subdirección...
                            </td>
                            @endif
                            @if($alumno->liberacion == 2)
                            <td>
                            Aprobado
                            </td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                       @endforeach 

                  </tbody>
                </table>
            </div>
          </div>



@if(isset($edit))
  @section('editar_actalu')
  @include('actividades_complementarias.partials_actividades.alumno.editar_actividad_alumno')
  @show
@endif



<!-- Modal PARA AGREGAR NUEVA ACTIVIDAD -->
<form method="POST" role="form" class="form" id="agregar_actividad_alu" >
  <div class="row">
    <div class="col-md-10 col-md-offset-3">
      <div class="modal fade" id="agrega_actalu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title text-center" id="myModalLabel">Registro de Actividad</h3>
            </div>
      
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">

                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label >Actividad</label>
                          <div class="dropdown">
                            <select class="form-control" name="actividad_alumnos" id="actividad_alumnos">
                              <option disabled selected hidden>Selecciona Opción...</option>
                                @foreach($docente_actividad as $docente_actividad)
                                  <option value="{{$docente_actividad->id_actividad_comple}}" data-horas="{{$docente_actividad->horas}}" data-docente="{{$docente_actividad->titulo}}  {{$docente_actividad->nombre}}" data-profesor="{{$docente_actividad->nombre}}">{{$docente_actividad->descripcion}} </option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label >Número de Horas</label>
                          <input class="form-control" id="horas_alumno" type="text" placeholder="Horas" name="horas_alumno" disabled>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                      <div class="col-md-9">
                        <div class="form-group">
                          <label >Encargado</label>
                            <input class="form-control" id="docente" type="text" placeholder="Encargado" name="docente" disabled>
                             <input id="profesor" type="hidden" name="profesor">
                        </div>
                      </div>
                    </div>
                    <input name="fecha" type="text" id="fecha"  value="<?php echo date("Y/m/d"); ?>" style="visibility:hidden"/>
                  </div>     
                </div>
              </div>
             <div class="modal-footer" >
              <button type="button" class="btn btn-primary registra"  id="registra">Registrar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Modal PARA CONFIRMAR AGREGAR-->

<div id="modal_confirmacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form id="form_confirma" class="form" role="form" method="POST">
          {{ csrf_field() }}
          <input type="hidden" id="actividad_alu" name="actividad_alu" value="">
          <input type="hidden" id="horas_alu" name="horas_alu" value="">
          <input type="hidden" id="docente_alu" name="docente_alu" value="">
          <input type="hidden" id="profesor_alu" name="profesor_alu" value="">    
          <input type="hidden" id="fecha_alu" name="fecha_alu" value="">        
                ¿Realmente deseas agregar esta actividad?
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <input id="confirma_actividad" type="button" class="btn btn-danger" value="Aceptar"></input>
                </div>
           </form>

      </div>
    </div>
  </div>
</div>

  <!--MODAL PARA ELIMINAR REGISTRO DEL ALUMNO-->
  <div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_delete">
         {{method_field('DELETE') }}
          {{ csrf_field() }}
                ¿Realmente deseas eliminar éste elemento?
              </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input id="confirma_elimina" type="button" class="btn btn-danger" value="Aceptar"></input>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="mensaje_actividad" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-warning">
        <p style="font-weight: bold; color:#BA0000; text-align:center;">NO HAS SELECCIONADO ACTIVIDAD</p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="actividad_registrada" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-warning">
        <p style="font-weight: bold; color:#BA0000; text-align:center;">LA ACTIVIDAD QUE INTENTA REGISTRAR YA EXISTE</p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<?php
  $direccion=Session::get('ip');
?>
</div>
</form>

</main>

<script>
   $(document).ready(function(){

   $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            $('#modal_elimina').modal('show');
        });



    $(".registra").click(function(event){
      var confirma=$("#actividad_alumnos").val();

      $("#agregar_actividad_alu").validate({
            rules:{
              actividad_alumnos: "required"
            }

      });
      var actividad=$('#actividad_alumnos').val();
      var horas=$('#horas_alumno').val();
      var docente=$('#docente').val();
      var docentes=$('#profesor').val();
      var fecha=$('#fecha').val();
      var horas_act=$('#total_horas').val();



      $('#actividad_alu').val(actividad);
      $('#horas_alu').val(horas);
      $('#docente_alu').val(docente);
      $('#profesor_alu').val(docentes);
      $('#fecha_alu').val(fecha);


      horas_total=(parseInt(horas)+parseInt(horas_act));
      if(horas_total>40)
      {
        alert("Excede el número de horas");
      }
      else
      {
        if(confirma!=null)
        {
          $('#agrega_actalu').modal('hide');
          $('#modal_confirmacion').modal('show');
        }
        else
        {
            $('#mensaje_actividad').modal('show');
              setTimeout(myFunction, 2000); 

              function myFunction(){
              $('#mensaje_actividad').modal('hide');
              }
        }
      }


    });

   $("#confirma_actividad").click(function(event){
      $("#form_confirma").submit();


   });

    @if($condicion==0) 

    @else
    <?php
      Session::put('entra',0);
    ?>
            $('#actividad_registrada').modal('show');
              var direccion="{{$direccion}}";
              setTimeout(myFunction, 2000); 

              function myFunction(){
              window.location.href=direccion+"/consulta_actividades/";
              }
    @endif

   $('#actividad_alumnos').on('change',function(){

       var selected = $(this).find('option:selected');
       var extra = selected.data('horas'); 
       var titulo = selected.data('docente'); //lo que se coloca dentro del parentesis es el data-docente
       var docentes = selected.data('profesor');
     
       $("#docente").val(titulo);
       $("#horas_alumno").val(extra + " Horas");
       $("#profesor").val(docentes);

      
      });

    $("#confirma_elimina").click(function(event){
          var id_sit=($(this).data('id'));
          $("#form_delete").attr("action","{{url("/consulta_actividades/")}}"+id_sit)
          $("#form_delete").submit();
          }); 


    });
</script>

@endsection