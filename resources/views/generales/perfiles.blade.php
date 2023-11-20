@extends('layouts.app')
@section('title', 'Perfil')
@section('content')

<main class="col-md-12">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
     @if (session()->has('flash_notification.message'))
            <div class="alert alert-{{ session('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('flash_notification.message') !!}
            </div>
          @endif
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">PERFILES</h3>
	  		</div>
		</div>	
	</div>
  <div class="col-md-6 col-md-offset-3">
    <table id="paginar_table" class="table table-bordered">
                          <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Editar</th>  
                                <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($perfiles as $perfil)
                            <tr>
                              <td>{{$perfil->descripcion}}</td>
                              <td>
                                <a href="/generales/perfiles/{{ $perfil->id_perfil }}/edit"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                              </td>
                              <td>
                                <a class="elimina" id="{{ $perfil->id_perfil }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                              </td>
                            </tr>
                            @endforeach
                            
                          </tbody>
                        </table> 
  </div>

</div>	
      <div>
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="AGREGA NUEVO PERFIL" data-target="#modal_crea" type="button" class="btn btn-success btn-lg flotante">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>


@if(isset($edit))
  @section('modifica_perfil')
  @include('generales.partialsg.partial_mo_perfil')
  @show
@endif

</main>

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

<!-- Modal para crear-->
<form id="form_perfil_crea" class="form" role="form" method="POST" >
<div class="modal fade" id="modal_crea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar Perfil</h4>
      </div>
      <div class="modal-body">
        <form>
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_perfil">Nombre del Perfil</label>
                      <input type="text" class="form-control " id="caja-error" name="nombre_perfil" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_perfil'))
                          <span style="color:red;">{{ $errors -> first('nombre_perfil') }}</span>
                         <style>
                          #caja-error
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>          
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input id="save_perfil" type="button" class="btn btn-primary" value="Guardar"/>
      </div>
      </form>
    </div>
  </div>
</div>
</form>

<script>

  
$(document).ready(function() {
  $('#paginar_table').DataTable();
  
       $("#paginar_table").on('click','.elimina',function(){

            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

   $("#save_perfil").click(function(event){
            $("#form_perfil_crea").submit();
    });

          $("#form_perfil_crea").validate({
            rules: {
           nombre_perfil: {
            required: true,
          },     
        },            
          
          });

      $("#confirma_elimina").click(function(event){
          var id_per=($(this).data('id'));
          $("#form_delete").attr("action","/generales/perfiles/"+id_per)      
          $("#form_delete").submit();
        });
});
        </script>

@endsection
