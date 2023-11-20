@extends('layouts.app')
@section('title', 'Jefaturas')
@section('content')

<main class="col-md-12">
<div class="row">
	<div class="col-md-7 col-md-offset-2">
     @if (session()->has('flash_notification.message'))
                <div class="alert alert-{{ session('flash_notification.level') }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!! session('flash_notification.message') !!}
                </div>
              @endif
		<div class="panel panel-info">
	  		<div class="panel-heading">
	    		<h3 class="panel-title text-center">JEFATURAS DE DIVSIÓN</h3>
	  		</div>         
	  </div>
	</div>
  <div class="col-md-7 col-md-offset-2">
    <table class="table table-bordered">
                          <thead>
                            <tr>
                                <th>Carrera</th>
                                <th>Jefe</th>
                                <th>Periodo</th>
                                <th>Cargo</th>  
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                         @foreach($jefaturas as $jefatura)
                            <tr>
                              <td>{{$jefatura->carrera}}</td>
                              <td>{{$jefatura->nombre}}</td>
                              <td>{{$jefatura->periodo}}</td>
                              <td>@if($jefatura->tipo_cargo==1)
                                {{ "JEFE" }}
                                @else
                                {{ "ENCARGADO" }}
                                @endif</td>                   
                              <td class="text-center">
                                <a href="/generales/jefaturas/{{ $jefatura->id_jefe_periodo }}/edit"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                              </td>
                              <td class="text-center">
                                <a class="elimina" id="{{ $jefatura->id_jefe_periodo }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table> 
  </div>	
</div>
            

                <div>
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="AGREGA NUEVA JEFATURA" data-target="#modal_crea" type="button" class="btn btn-success btn-lg flotante">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      </div>

@if(isset($edit))
      @section('modifica_jefatura')
      @include('generales.partialsg.partial_mo_jefe')
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
<form id="form_jefe_crea" class="form" role="form" method="POST" >
<div class="modal fade" id="modal_crea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Creación de jefaturas</h4>
      </div>
      <div class="modal-body">
        {{ csrf_field() }}
<div class="row">
              <div class="col-md-12">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group"> 
                <label for="selectCarrera">Carrera</label> 
                <select name="selectCarrera" class="form-control ">
                <option disabled selected>Elige...</option>
                  @foreach($carreras as $carrera)
                  <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                  @endforeach
                </select> 
            </div>
        </div>
            </div>
            <div class="col-md-12">
                      <div class="col-md-6">
            <div class="form-group"> 
                <label for="selectPersonal">Personal</label> 
                <select name="selectPersonal" class="form-control ">
                <option disabled selected>Elige...</option>
                  @foreach($docentes as $docente)
                  <option value="{{ $docente->id_personal }}">{{ $docente->nombre }}</option>
                  @endforeach
                </select> 
            </div>
        </div>
                              <div class="col-md-6">
            <div class="form-group"> 
                <label for="selectCargo">Cargo</label> 
                <select name="selectCargo" class="form-control ">
                <option disabled selected>Elige...</option>
                  <option value="1">JEFE</option>
                  <option value="2">ENCARGADO</option>
                </select> 
            </div>
        </div>
                  <div class="col-md-8 col-md-offset-2">
              <div class="form-group">
                  <label for="nombre_periodo">Periodo</label>
                  <input disabled type="text" class="form-control" name="nombre_periodo" value="{{ $periodo }}">
              </div>
          </div>
            </div>
</div>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="guarda_jefe" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
</form>


<!-- Modal para periodo_igual-->

<form id="periodo_igual" class="form"  role="form" method="POST" >
 {{ csrf_field() }}

</form>

<script>
$(document).ready(function() {

       $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            //alert(id);
            $('#modal_elimina').modal('show');
        });

   $("#guarda_jefe").click(function(event){
            $("#form_jefe_crea").submit();
    });

          $("#form_jefe_crea").validate({
            rules: {
            nombre_jefe : "required",
            selectPersonal : "required",
            selectCarrera : "required", 
        },            
          });

        $("#confirma_elimina").click(function(event){
          var id_jefe=($(this).data('id'));
          $("#form_delete").attr("action","/generales/jefaturas/"+id_jefe)      
          $("#form_delete").submit();
        });

       

});
        </script>

@endsection
