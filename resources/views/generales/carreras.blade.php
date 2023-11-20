@extends('layouts.app')
@section('title', 'Carreras')
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
	    		<h3 class="panel-title text-center">CARRERAS</h3>
	  		</div>
		</div>	
	</div>
  <div class="col-md-5 col-md-offset-3">
    <table class="table table-bordered table-resposive">
                          <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Color</th>
                                <th>Editar</th>  
                                <th>Eliminar</th> 
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($carreras as $carrera)
                            <tr>
                              <td>{{$carrera->nombre}}</td>
                              <td>
                                  <div class="input-group colorpicker-component">
                                    <input disabled value="{{ $carrera->COLOR }}" class="form-control" />
                                    <span disabled class="input-group-addon"><i></i></span>
                                  </div>
                              </td>
                              <td>
                                <a href="/generales/carreras/{{ $carrera->id_carrera }}/edit"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                              </td>
                              <td>
                                <a class="elimina" id="{{ $carrera->id_carrera }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                              </td>
                            </tr>
                            @endforeach
                            
                          </tbody>
                        </table>  
  </div>
</div>	
      <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="AGREGA NUEVA CARRERA" data-target="#modal_crea" type="button" class="btn btn-success btn-lg flotante">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>

      @if(isset($edit))
      @section('modifica_carrera')
      @include('generales.partialsg.partial_mo_carrera')
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
<form id="form_carrera_crea" class="form" role="form" method="POST" >
<div class="modal fade" id="modal_crea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar Carrera</h4>
      </div>
      <div class="modal-body">
        <form>
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_carrera">Descripción</label>
                      <input type="text" class="form-control " id="caja-error1" name="nombre_carrera" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_carrera'))
                          <span style="color:red;">{{ $errors -> first('nombre_carrera') }}</span>
                         <style>
                          #caja-error1
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                </div>          
              <div class="col-md-4 ">
                    <div class="form-group">
                      <label for="color">Color</label>
                      <div class="input-group colorpicker-component">
                        <input name="color" type="text" class="form-control" style="text-transform:uppercase" />
                        <span class="input-group-addon"><i></i></span>
                      </div>
                     @if($errors -> has ('color'))
                          <span style="color:red;">{{ $errors -> first('color') }}</span>
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
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input id="save_carrera" type="button" class="btn btn-primary" value="Guardar"/>
      </div>
      </form>
    </div>
  </div>
</div>
</form>

<script>

$('.colorpicker-component').colorpicker();

$(document).ready(function() {

  $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

   $("#save_carrera").click(function(event){
            $("#form_carrera_crea").submit();
    });

          $("#form_carrera_crea").validate({
            rules: {
           nombre_carrera: {
            required: true,
          }, 
         color: {
            required: true,
          },     
        },            
          });

                $("#confirma_elimina").click(function(event){
          var id_car=($(this).data('id'));
          $("#form_delete").attr("action","/generales/carreras/"+id_car)      
          $("#form_delete").submit();
          });

});
        </script>
@endsection


