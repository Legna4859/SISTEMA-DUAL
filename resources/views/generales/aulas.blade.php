@extends('layouts.app')
@section('title', 'Aulas')
@section('content')


<main class="col-md-12">

 <?php $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
 $directivo=session()->has('directivo')?session()->has('directivo'):false; 
 $consultas=session()->has('consultas')?session()->has('consultas'):false;?>


<div class="row">
	<div class="col-md-7 col-md-offset-2">
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">AULAS</h3>
	  		</div>         
	  </div>
	</div>
  <div class="col-md-7 col-md-offset-2">
    <table id="paginar_table" class="table table-bordered">
                          <thead>
                            <tr>
                                <th>Aula</th>
                                <th>Edificio</th>
                                <th>Carrera</th>  
                                <th>Estado</th>
                                @if($directivo!=null || $consultas!=null)
                                <th>Editar</th>
                                <th>Eliminar</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($aulas as $aula)
                            <tr>
                              <td>{{$aula->aula}}</td>
                              <td>{{$aula->edificio}}</td>
                              <td>{{$aula->carrera}}</td>
                              @if($aula->estado==1)
  <td class="text-center" data-toggle="tooltip" data-placement="left" title="Aula Compartida"><a href = '/aulas/estados/{{ $aula->id_aula }}'><span style="color:green;" class="glyphicon glyphicon-ok-circle em2" aria-hidden="true"></span></td>
                              @else
  <td class="text-center" data-toggle="tooltip" data-placement="left" title="Aula No Compartida"><a href = '/aulas/estados/{{ $aula->id_aula }}'><span style="color:red;" class="glyphicon glyphicon-ban-circle em2" aria-hidden="true"></span></a></td>
                              @endif 
                              @if($directivo==1 || $consultas==1)                   
                              <td class="text-center">
                                <a href="/generales/aulas/{{ $aula->id_aula }}/edit"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                              </td>
                              <td class="text-center">
                                <a class="elimina" id="{{ $aula->id_aula }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                              </td>
                              @endif
                            </tr>
                          @endforeach
                          </tbody>
                        </table> 
  </div>	
</div>
@if($directivo!=null || $consultas!=null)
                <div>
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="AGREGA NUEVA AULA" data-target="#modal_crea" type="button" class="btn btn-success btn-lg flotante">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>
@endif
@if(isset($edit))
      @section('modifica_aula')
      @include('generales.partialsg.partial_mo_aula')
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
<form id="form_aula_crea" class="form" role="form" method="POST" >
<div class="modal fade" id="modal_crea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Creación de Aulas</h4>
      </div>
      <div class="modal-body">
          {{ csrf_field() }}
          @if (session()->has('flash_notification.message'))
          <div class="alert alert-{{ session('flash_notification.level') }}">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {!! session('flash_notification.message') !!}
          </div>
          @endif
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-5 col-md-offset-1">
                <div class="form-group">
                    <label for="nombre_aula">Nombre del Aula</label>
                    <input type="text" class="form-control" id="caja-error" name="nombre_aula" placeholder="Nombre..." style="text-transform:uppercase">
                    @if($errors -> has ('nombre_aula'))
                        <span style="color:red;">{{ $errors -> first('nombre_aula') }}</span>
                        <style>
                        #caja-error
                        {
                          border:solid 1px red;
                        }
                        </style>
                    @endif
                </div>
              </div>
                      <div class="col-md-5" >
                        <div class="btn-group">
                          <label for="selectEstado">Estado</label>
                                <select name="selectEstado" class="form-control ">
                                  <option disabled selected>Selecciona...........</option>
                                  <option value="1">Compartida</option>
                                  <option value="0">No Compartida</option>
                                </select>
                        </div>
                      </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-5 col-md-offset-1" >
                        <div class="btn-group">
                          <label for="selectEdificio">Edificio</label>
                                <select name="selectEdificio" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($edificios as $edificio)
                                            <option value="{{$edificio->id_edificio}}" >{{$edificio->nombre}}</option>
                                    @endforeach
                                </select>
                        </div>
                      </div>
                      <div class="col-md-4" >
                        <div class="btn-group">
                          <label for="dropdown">Carrera</label>
                                <select name="selectCarrera" class="form-control ">
                                  <option disabled selected>Selecciona...</option>
                                    @foreach($carreras as $carrera)
                                            <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                    @endforeach
                                </select>
                        </div>
                      </div> 
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_aula" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>
function bloqueo()
{
    $.blockUI({
    //message: '<img src="/img/cargando.gif" />',
  });
        //setTimeout($.unblockUI, 4000); 
}
$(document).ready(function() {
$('#paginar_table').DataTable();

       $("#paginar_table").on('click','.elimina',function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

   $("#guarda_aula").click(function(event){
            $("#form_aula_crea").submit();
    });

          $("#form_aula_crea").validate({
            rules: {
           nombre_aula: {
            required: true,
          },
            selectCarrera : "required",
            selectEstado : "required",
            selectEdificio : "required",    
        },            
          });

        $("#confirma_elimina").click(function(event){
          var id_aula=($(this).data('id'));
          $("#form_delete").attr("action","/generales/aulas/"+id_aula);     
          $("#form_delete").submit();
        });
});
        </script>

@endsection
