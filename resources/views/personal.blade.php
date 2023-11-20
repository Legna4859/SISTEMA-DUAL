@extends('layouts.app')
@section('title', 'Inicio')
@section('content')




<script type="text/javascript">



  $(document).ready(function() {


      $('#ejemplo').DataTable();

$(".elimina").click(function(){
            //alert('hola');
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            
            $('#modal_elimina').modal('show');
        });


$("#confirma_elimina").click(function(event){
          var id_sit=($(this).data('id'));
          $("#form_delete").attr("action","/personales/"+id_sit)      
          $("#form_delete").submit();
          });       

  
} );

</script>

<main>

<div class="col-md-7 col-md-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title text-center">ASIGNACIÓN DE PERMISOS</h3>
        </div>         
    </div>
  </div>


  <div class=" col-md-10 col-md-offset-1">

      


                            <table id="ejemplo" class="table table-bordered " Style="background: white;" >
                                   <thead>
                                          <tr>
                                                  <th>NOMBRE</th>
                                                
                                                  <th>CLAVE</th>
                                                  <th>CORREO</th>
                                                  <th>PERMISO</th>
                                                  <th>MODIFICAR</th>
                                                  <th>ELIMINAR</th>

                                                  
                                           </tr>
                                    </thead>
                                    <tbody>

                                            @foreach($personal as$per)
                                          <tr>
                                                  <th>{{$per->nombre}}</th>
                                                  <th>{{$per->clave}}</th>
                                                   <th>{{$per->correo}}</th>
                                                    <th>{{$per->id_departamento}}</th>
                                                  <th class="text-center"><a href="/personales/{{$per->id_personal}}/edit"><span class="glyphicon glyphicon-cog em6" aria-hidden="true" ></span></a></th>
                                                  <th class="text-center"><a class="elimina" id="{{$per->id_personal}}"><span class="glyphicon glyphicon-trash em6" aria-hidden="true" ></span></span></a></th>
                                                  
                                          </tr>
                                          @endforeach

                                         
    
                                   </tbody>
                            </table>

                
       </div>



   @if(isset($edit))
  @section('editar_personal')
  @include('editar_personal')
  @show
  @endif
                     
  <div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_delete">
         {{method_field('DELETE') }}
          {{ csrf_field() }}
                ¿Realmente deseas eliminar a este usuario?
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
@endsection