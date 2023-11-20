@extends('layouts.app')
@section('title', 'NuevaActividad')
@section('content')

<main class="col-md-12">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Actividades Registradas</div>
      </div>
    </div>
  </div>

                <div class="row">
                  <div class="col-md-10 col-md-offset-1">
	                   <table class="table table-bordered tabla-grande2" id="paginacion"> 
                            <thead>
                              <th>Nombre de Actividad</th>
                              <th>Categoría</th>
                              <th>Horas Asignadas</th>
                              <th>Créditos</th>
                              <th>Departamento Encargado</th>
                              <th>Editar</th>
                              <th>Eliminar</th>
                            </thead>
                            <tbody>
                              @foreach($categoria as $n)
                                  <tr>
                                    <td>{{$n->descripcion}}</td>
                                    <td>{{$n->descripcion_cat}}</td>
                                    <td>{{$n->horas}}</td>
                                    <td>{{$n->creditos}}</td>
                                    <td>{{$n->nom_jefatura}}</td>
                                    <td><a href="{{url("/nueva_actividad/",$n->id_actividad_comple,"/edit")}}"><span class="glyphicon glyphicon-cog em" aria-hidden="true" ></span></a></td>
                                    <td><a class="elimina" id="{{$n->id_actividad_comple}}"><span class="glyphicon glyphicon-trash em" aria-hidden="true"></span></a></td>
                                  </tr>
                                @endforeach
                            </tbody>
                     </table>
                      
                      

                  </div>
                </div>


@if(isset($edit))
  @section('editar_actividad')
  @include('actividades_complementarias.partials_actividades.subdireccion.editar_actividad')
  @show
@endif

<!-- Modal PARA AGREGAR NUEVA ACTIVIDAD <-->
<form method="POST" role="form" class="form" id="agregar_actividad" >
  {{csrf_field()}}
  <div class="row">
    <div class="col-md-10 col-md-offset-3">
     <div class="modal fade" id="agrega_actsub" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
 
                    <div class="col-md-12" >
                          <div class="col-md-5" >
                            <div class="form-group">
                              <label >Nombre de Actividad</label>
                                <input class="form-control" id="" type="text" name="actividad_sub" placeholder="Actividad" enable>
                                  @if($errors->has('actividad'))
                                  <span>{{$errors->first('actividad')}}</span>
                                  @endif
                            </div>      
                          </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label >Categoría</label>
                              <div class="dropdown">
                                <select class="form-control" name="categoria_sub" id="categoria_sub">
                                   <option disabled selected hidden> Selecciona Opción...</option>
                                      @if($errors->has('categoriaa'))
                                      <span>{{$errors->first('categoriaa')}}</span>
                                      @endif

                                      @foreach($categorias as $categoria)
                                       <option value="{{$categoria->id_categoria}}">{{$categoria->descripcion_cat}}</option>
                                      @endforeach
                                </select>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-group">
                            <label>Agregar</label>
                            <a type="button" class="btn btn-success" data-target="#agrega_cat" data-toggle="modal" data-placement="left" data-tooltip="true" title="AGREGAR CATEGORÍA">
                            <span class="glyphicon glyphicon-plus"  aria-hidden="true"></span></a>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                          <div class="col-md-5">
                           <div class="form-group">
                              <label >Número de Horas</label>
                                <div class="dropdown">
                                  <select class="form-control" name="horas_sub">
                                    <option disabled selected hidden>Selecciona Opción...</option>
                                      <option value="20">20</option>
                                      <option value="40">40</option>
                                        @if($errors->has('hora'))
                                        <span>{{$errors->first('hora')}}</span>
                                        @endif
                                  </select>
                                </div>
                            </div>
                          </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label >Departamento Encargado</label>
                               <div class="dropdown">
                                  <select class="form-control" name="jefatura_sub">
                                     <option disabled selected hidden>Selecciona Opción...</option>
                                        @if($errors->has('jefaturas'))
                                        <span>{{$errors->first('jefaturas')}}</span>
                                        @endif

                                        @foreach($jefaturascar as $jefatura)
                                          <option value="{{$jefatura->id_jefatura}}">{{$jefatura->nom_jefatura}}</option>
                                        @endforeach
                                  </select>
                                </div>
                          </div>
                        </div>
                    </div>

                      <div class="modal-footer" >
                        <button  type="submit" class="btn btn-primary" id="registra">Registrar </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


<!--MODAL PARA AGREGAR CATEGORIAS-->
<form  role="form" class="form" id="agregar_categoria"  >
  {{csrf_field()}}
  <div class="row">
    <div class="col-md-10 col-md-offset-3">
     <div class="modal fade" id="agrega_cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>
                <h3 class="modal-title text-center" id="myModalLabel">Nueva Categoría</h3>
            </div>
            
            <div class="modal-body">
              <div class="panel panel-info">
                <div class="panel-body">
                 
                    <div class="col-md-12">
                          <div class="col-md-6 col-md-offset-3" >
                            <div class="form-group">
                              <label >Nombre de Categoría</label>
                                <input class="form-control" id="" type="text" name="categorias" placeholder="Categoría" enable>
                                  @if($errors->has('actividad'))
                                  <span>{{$errors->first('actividad')}}</span>
                                  @endif
                            </div>      
                          </div>
                        </div>
                      <div class="modal-footer" >
                        <input  type="button" class="btn btn-primary" id="categoria" value="Agregar"/>
                        <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancelar"/>
                      </div>
                    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


<!-- MODAL PARA ELIMINAR -->
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


<a type="button" class="btn btn-success btn-lg flotante" data-target="#agrega_actsub" data-tooltip="true" data-toggle="modal" data-placement="left" title="AGREGAR ACTIVIDAD">
  <span class="glyphicon glyphicon-plus"  aria-hidden="true"></span>
</a>


</main>



<script>
  $(document).ready(function(){

   $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

  $("#registra").click(function(event){
    $("#agregar_actividad").submit();
        
        });

          $("#agregar_actividad").validate({
            rules:{
              actividad_sub:
              {
                required: true,
                minlength: 4
              },
              categoria_sub:"required",
              horas_sub:"required",
              jefatura_sub:"required",
            },
      });
    $("#categoria").click(function(event){
      $.post("nueva_categoria",$("#agregar_categoria").serialize(),function(request){
       var html="";
       for (var i = 0; i < request.length; i++) 
       {
        html+="<option value='"+request[i].id_categoria+"'>"+request[i].descripcion_cat+"</option>";
        
       }
        $('#categoria_sub').html(html);
        $("#agrega_cat").modal('hide');
      });

    });
      $("#agregar_categoria").validate({
        rules:{
          categorias:"required",
        }
      });

    $("#confirma_elimina").click(function(event){
          var id_sit=($(this).data('id'));
          $("#form_delete").attr("action","/nueva_actividad/"+id_sit)      
          $("#form_delete").submit();
          });       
     $('#paginacion').DataTable();
  });  



$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});


</script>


@endsection