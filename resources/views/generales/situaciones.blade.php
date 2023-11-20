@extends('layouts.app')
@section('title', 'Situación Profesional')
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
	    		<h3 class="panel-title text-center">SITUACIÓN PROFESIONAL</h3>
	  		</div>
		</div>	
	</div>
  <div class="col-md-5 col-md-offset-3">
                  <table class="table table-bordered table-resposive">
                          <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Abreviacion</th>
                                <th>Editar</th>  
                                <th>Eliminar</th> 
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($situaciones as $situacion)
                            <tr>
                              <td>{{$situacion->situacion}}</td>
                              <td>{{$situacion->abrevia}}</td>
                              <td class="text-center">
                                <a href="/generales/situaciones/{{ $situacion->id_situacion }}/edit"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                              </td>
                              <td class="text-center">
                                <a class="elimina" id="{{ $situacion->id_situacion }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                              </td>
                            </tr>
                            @endforeach
                            
                          </tbody>
                        </table>  
  </div>
</div>	
      <div>
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="AGREGA NUEVA SITUACION" data-target="#modal_crea" type="button" class="btn btn-success btn-lg flotante">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>

@if(isset($edit))
      @section('modifica_situacion')
      @include('generales.partialsg.partial_mo_situacion')
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

<!-- *************Modal para crear*************-->
<form id="form_situacion_crea" class="form" role="form" method="POST" >
<div class="modal fade" id="modal_crea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar Situación Profesional</h4>
      </div>
      <div class="modal-body">
        <form>
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-6 col-md-offset-1">
                     <div class="form-group">
                      <label for="nombre_situacion">Descripción</label>
                      <input type="text" class="form-control " id="caja-error1" name="nombre_situacion" placeholder="Nombre..." style="text-transform:uppercase">
                      @if($errors -> has ('nombre_situacion'))
                        <span style="color:red;">{{ $errors -> first('nombre_situacion') }}</span>
                         <style>
                          #caja-error1
                          {
                            border:solid 1px red;
                          }
                          </style>
                      @endif
                    </div>
                  </div>          
                  <div class="col-md-3 ">
                    <div class="form-group">
                      <label for="abre_situacion">Abreviatura</label>
                      <input type="text" maxlength="5" class="form-control" id="caja-error" name="abre_situacion" placeholder="Abreviacion..." style="text-transform:uppercase">
                     @if($errors -> has ('abre_situacion'))
                          <span style="color:red;">{{ $errors -> first('abre_situacion') }}</span>
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
        <input id="save_situacion" type="button" class="btn btn-primary" value="Guardar"/>
      </div>
      </form>
    </div>
  </div>
</div>
</form>

<!-- **************SCRIPTS************** -->
<script>
$(document).ready(function() {

     $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

   $("#save_situacion").click(function(event){
            $("#form_situacion_crea").submit();
    });

          $("#form_situacion_crea").validate({
            rules: {
           nombre_situacion: {
            required: true,
          }, 
         abre_situacion: {
            required: true,
          },     
        },            
          });

      $("#confirma_elimina").click(function(event){
          var id_sit=($(this).data('id'));
          $("#form_delete").attr("action","/generales/situaciones/"+id_sit)      
          $("#form_delete").submit();
          });

});
        </script>
@endsection


