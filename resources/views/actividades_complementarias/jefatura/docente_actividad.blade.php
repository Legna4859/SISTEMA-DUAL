
@extends('layouts.app')
@section('title', 'DocenteActividad')
@section('content')


<main class="col-md-12">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-info">
        <div class="panel-heading">Docentes en Actividades</div>
      </div>
    </div>
  </div>


              <a type="button" class="btn btn-success btn-lg flotante" data-target="#nuevo_docente" data-tooltip="true" data-toggle="modal" data-placement="left" title="AGREGAR DOCENTE A ACTIVIDAD">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </a>

              <div class="row">
               <div class="col-md-10 col-md-offset-1">
	               <table class="table table-bordered tabla-grande2 ">
                    <thead>
                      <th>Nombre de Actividad</th>
                      <th>Categoría</th>
                      <th>Número de Horas</th>
                      <th>Docente</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </thead>

                    <tbody>
                      @foreach($docentes_tabla as $docente)
                        <tr>
                          <td>{{$docente->descripcion}}</td>
                          <td>{{$docente->descripcion_cat}}</td>
                          <td>{{$docente->horas}}</td>
                          <td>{{$docente->titulo}} {{$docente->nombre}}</td>
                          <td><a href="{{url("/docente_actividad/",$docente->id_docente_actividad,"/edit")}}"><span class="glyphicon glyphicon-cog em" aria-hidden="true"></span></a></td>
                          <td><a class="elimina" id="{{$docente->id_docente_actividad}}" ><span class="glyphicon glyphicon-trash em" aria-hidden="true"></span></a></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

@if(isset($editar_docente))
  @section('editar_docente')
  @include('actividades_complementarias.partials_actividades.jefatura.editar_docente')
  @show
@endif


<!-- Modal PARA AGREGAR NUEVO DOCENTE -->
<form method="POST" role="form" class="form" id="docente_actividad">
    {{csrf_field()}}
  <div class="row">
    <div class="col-md-8 col-md-offset-3">
      <div class="modal fade" id="nuevo_docente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title text-center" id="myModalLabel">Asignar Docente</h3>
            </div>
          <div class="modal-body">
            <div class="panel panel-info">
              <div class="panel-body">
                <div class="col-md-12">

                  <div class="col-md-6" >
                    <div class="form-group">
                      <label >Categoría</label>
                         <div class="dropdown">
                            <select class="form-control" name="categoria_docente" id="categoria_docente">
                              <option disabled selected hidden> Selecciona Opción...</option>
                                @foreach($categorias as $categorias)
                                  <option value="{{$categorias->id_categoria}}">{{$categorias->descripcion_cat}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                  <div class="col-md-6">
                     <div class="form-group">
                       <label >Actividad</label>
                         <div class="dropdown">
                           <select class="form-control" name="actividad_docente" id="actividad_docente">
                               <option disabled selected hidden>Selecciona Opción...</option>
                            </select>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Número de Horas</label>
                        <input class="form-control" name="horas_docente" type="text" id="horas_docente" value="" placeholder="Horas" disabled>
                              
                        </div>
                    </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Docente Asignado</label>
                        <div class="dropdown">
                          <select class="form-control" name="docente">
                            <option disabled selected hidden>Selecciona Opción...</option>
                              @foreach($docentes as $docentes)
                                <option value="{{$docentes->id_personal}}">{{$docentes->titulo}} {{$docentes->nombre}}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
              <div class="modal-footer" >
                <button type="submit" class="btn btn-primary" id="registra" href="">Registrar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

</main>

<script>

   $(document).ready(function(){
    var carrera={!!$carrera!!};


   $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });


    $("#registra").click(function(event){

    $("#docente_actividad").submit();
        
        });
          $("#docente_actividad").validate({
            rules:{
              categoria_docente: "required",
              actividad_docente:"required",
              docente: "required",
            },
      });



    $('#categoria_docente').on('change', function(e) {
      console.log(e);
      var id_actividad=e.target.value;

      $.get('/docente_nueva_actividad?id_actividad=' +id_actividad,function(data){
        console.log();
        $('#actividad_docente').empty();
        //var numero=0;
        $.each(data,function(docente_actividad,subCatObj){
                 //numero=numero+1;  
        if(subCatObj.estado==1 && subCatObj.id_jefatura==carrera)
        {
            //alert(numero);
             $('#actividad_docente').append(
             '<option value="'+subCatObj.id_actividad_comple+'" data-horas="'+subCatObj.horas+'">'+subCatObj.descripcion+ ' </option>');
        }         
      });
    });
  });



    ///////////////////////////////////////////////////

   
    $('#actividad_docente').click(function(){
       var selected = $(this).find('option:selected');
       var extra = selected.data('horas'); 
       document.getElementById("horas_docente").value = extra+" Horas";
           //document.getElementById(“prueba”).value =""+extra;
    });

    $("#confirma_elimina").click(function(event){
          var id_sit=($(this).data('id'));
          $("#form_delete").attr("action","/docente_actividad/"+id_sit)      
          $("#form_delete").submit();
          });  

});
</script>

@endsection