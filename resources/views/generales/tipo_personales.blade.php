@extends('layouts.app')
@section('title', 'Tipo de Personal')
@section('content')

<main class="col-md-12">
<div class="row">
	<div class="col-md-5 col-md-offset-3">
     @if (session()->has('flash_notification.message'))
            <div class="alert alert-{{ session('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('flash_notification.message') !!}
            </div>
          @endif
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">TIPOS DE PERSONALES</h3>
	  		</div>
		</div>	
	</div>
  <div class="col-md-5 col-md-offset-3">
    <table class="table table-bordered">
                          <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Editar</th>  
                                <th>Eliminar</th> 
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($personales as $personal)
                            <tr>
                              <td>{{$personal->descripcion}}</td>
                              <td class="text-center">
                                <a href="/generales/personales/{{ $personal->id_tipo_personal }}/edit"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                              </td>
                              <td class="text-center">
                              <a class="elimina" id="{{ $personal->id_tipo_personal }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>                              
                            </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>  
  </div>
</div>	
                <div>
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="NUEVO TIPO DE PERSONAL" data-target="#modal_crea" type="button" class="btn btn-success btn-lg flotante">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>

      @if(isset($edit))
      @section('modifica_personal')
      @include('generales.partialsg.partial_mo_personal')
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
<form id="form_personal_crea" class="form" role="form" method="POST" >
<div class="modal fade" id="modal_crea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar Tipo de Personal</h4>
      </div>
      <div class="modal-body">
        <form>
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
                  <div class="form-group">
                      <label for="nombre_personal">Descripción</label>
                      <input type="text" class="form-control" id="caja-error" name="nombre_personal" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_personal'))
                          <span style="color:red;">{{ $errors -> first('nombre_personal') }}</span>
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_personal" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>
$(document).ready(function() {

$(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

   $("#guarda_personal").click(function(event){
            $("#form_personal_crea").submit();
    });

          $("#form_personal_crea").validate({
            rules: {
           nombre_act: {
            required: true,
          },     
        },            
          });

          $("#confirma_elimina").click(function(event){
          var id_personal=($(this).data('id'));
          $("#form_delete").attr("action","/generales/personales/"+id_personal)      
          $("#form_delete").submit();
          });

});
        </script>
@endsection
