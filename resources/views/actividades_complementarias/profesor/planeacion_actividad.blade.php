@extends('layouts.app')
@section('title', 'PlaneacionActividad')
@section('content')
<main class="col-md-12">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                  <div class="panel-heading">Planeación de Actividades</div>
                </div>
              </div>
            </div>
              <a type="button" class="btn btn-success btn-lg flotante" data-target="#planea_doc" data-tooltip="true" data-toggle="modal" data-placement="left" title="AGREGAR PLANEACIÓN">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </a>
            
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
	             <table class="table table-bordered tabla-grande2 ">
                  <thead>
                    <tr>
                      <th>Actividad</th>
                      <th>Número Evidencias</th>
                      <th>Rúbrica de Evaluación</th>
                      <th></th>
                      <th>Estado</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead> 
                    <tbody>
                      @foreach($docente_actividad as $docente)
                        <tr>
                          <td>{{$docente->descripcion}}</td>
                          <td>{{$docente->no_evidencias}}</td>
                          <td>{{$docente->rubrica}}</td>
                          <td><a href="{{url("/archivo_docente/".$docente->rubrica)}}" target="_blank"><span class="glyphicon glyphicon-file em"  aria-hidden="true"></span></a></td>
                            @if($docente->evi == 1)
                            <td>
                            En proceso...
                            </td>
                            <td><a href="{{url("/planeacion_actividad/",($docente->id_reg_coordinador."/edit"))}}"><span class="glyphicon glyphicon-cog em" aria-hidden="true"></span></a></td>
                            <td><a class="elimina" id="{{$docente->id_reg_coordinador}}"><span class="glyphicon glyphicon-trash em" aria-hidden="true"></span></a></td>
                            @endif
                            @if($docente->evi == 2)
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


     
@if(isset($editar_planeacion))
  @section('editar_planeacion')
  @include('actividades_complementarias.partials_actividades.profesor.editar_planeacion')
  @show
@endif

<!-- Modal PARA AGREGAR NUEVA ACTIVIDAD -->
<form method="POST" role="form" class="form" id="agregar_planeacion" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="row">
    <div class="col-md-8 col-md-offset-3">
      <div class="modal fade" id="planea_doc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                <h3 class="modal-title text-center" id="myModalLabel">Planeación de actividad</h3>
            </div>
          <div class="modal-body">
            <div class="panel panel-info">
              <div class="panel-body">

              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label >Actividad</label>
                      <div class="dropdown">
                        <select class="form-control" name="actividad_docen" id="actividad_docen">
                          <option disabled selected hidden>Selecciona Opción...</option>
                            @foreach($actividad_docen as $actividad_docen)
                              <option value="{{$actividad_docen->id_actividad_comple}}" data-horas="{{$actividad_docen->horas}}">{{$actividad_docen->descripcion}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6" >
                    <div class="form-group">
                      <label >Número de Horas</label>
                        <input class="form-control" name="horas_docente" type="text" id="horas_docente" value="" placeholder="Horas" disabled>
                    </div>      
                  </div>
              </div>

              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label >Número de evidencias</label>
                      <input class="form-control" name="evidencias_doc" type="text" placeholder="Evidencias">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label >Rúbrica de evaluación</label>
                      <input type="file"  name="urlImg" id="archivo" accept=".pdf" required>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">
                    <label id="pdf">Solo se acepta extensión PDF</label> 
                    <style>
                    #pdf{
                      color: red;
                    }
                    </style>
                  </div>
                </div>
              </div>       
            </div>
          </div>
        </div>
            <div class="modal-footer" >
              <button type="submit" class="btn btn-primary" href="!#" id="registra">Guardar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<input name="fecha" type="text" id="fecha"  value="<?php echo date("Y/m/d"); ?>" style="visibility:hidden"/>
</form>

<!--MODAL PARA ELIMINAR REGISTRO DEL PROFESOR-->
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
        <p style="font-weight: bold; color:#BA0000; text-align:center;">LA ACTIVIDAD QUE INTENTA REGISTRAR YA EXISTE</p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
  $direccion=Session::get('ip');
?>

</main>

<script>
   $(document).ready(function(){
    var direccion="{{$direccion}}";

   $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            $('#modal_elimina').modal('show');
        });

    $("#registra").click(function(event){
    $("#agregar_planeacion").submit();
        
        });

          $("#agregar_planeacion").validate({
            rules:{
              
              
              evidencias_doc: 
              {
                required:true,
                digits: true,
                minlength: 1,
              },

              actividad_docen: "required",
              
            },
      });


   $('#actividad_docen').on('change',function(){
       var selected = $(this).find('option:selected');
       var extra = selected.data('horas'); 
       document.getElementById("horas_docente").value = extra+" Horas";
      });
    $("#confirma_elimina").click(function(event){
          var id_sit=($(this).data('id'));
          $("#form_delete").attr("action","/planeacion_actividad/"+id_sit)      
          $("#form_delete").submit();
          });   
    @if($condicion==0) 

    @else
    <?php
      Session::put('entra',0);
    ?>
            $('#mensaje_actividad').modal('show');
              setTimeout(myFunction, 2000); 

              function myFunction(){
              window.location.href=direccion+"/planeacion_actividad/";
              }
    @endif


   });
</script>
@endsection