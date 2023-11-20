@extends('layouts.app')
@section('title', 'Docentes en Plantilla')
@section('content')

<main class="col-md-12">
<div class="row">
  <div class="col-md-12">
    <div class="col-md-6 col-md-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title text-center">PROFESORES</h3>
            </div>                                
        </div>
        <table id="paginar_table" class="table table-bordered ">
                          <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Nombre</th>
                                <th>Perfil</th>
                                <th>Fecha/Recontrato</th>
                                <th>A Plantilla</th>
                            </tr>
                          </thead>

                          <tbody>
                            @foreach($docentes as $docente)
                              <tr>
                              <td>{{ $docente->clave }}</td>
                              <td>{{ $docente->nombre }}</td>
                              <td>{{ $docente->descripcion }}</td>
                              <td>{{ $docente->fch_recontratacion }}</td>
                              <td class="text-center">
                                <a class="agrega" id="{{ $docente->id_personal }}"><span class="glyphicon glyphicon-log-in em2" aria-hidden="true"></span></a>
                              </td>
                            </tr>  
                            @endforeach                     
                          </tbody>
                        </table>
    </div>
          <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title text-center">PROFESORES EN PLANTILLA</h3>
            </div> 
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Eliminar</th>
                    <th>Materias/Perfil</th>
                </tr>
            </thead>
            <tbody>
            @foreach($plantillas as $plantilla)
                <tr>
                    <td>{{ $plantilla->nombre }}</td>
                    <td class="text-center">
                        <a class="elimina" id="{{ $plantilla->id_personal }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                    </td>
                    <td class="text-center">
                        <a class="materias" id="{{ $plantilla->id_personal }}"><span class="glyphicon glyphicon-list-alt em2" aria-hidden="true"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
  </div>
</div>	

<!-- MODAL PARA ELIMINAR -->
    <div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                        <form action="" method="POST" role="form" id="form_delete">
                         {{method_field('DELETE') }}
                          {{ csrf_field() }}
                                ¿Realmente deseas eliminar éste elemento?
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <input id="confirma_elimina" type="button" class="btn btn-danger" value="Aceptar"></input>
                                    </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal para ver materias -->
<form id="form_ver_materias" class="form" role="form" method="POST">
<div class="modal fade bs-example-modal-lg" id="modal_materias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">MATERIAS</h4>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          <input type="hidden" id="prof" name="prof" value="">
          <input type="hidden" id="materias" name="materias" value="">
          <div class="row">
              <div id="contenedor_materias">

              </div>
          </div>
        </div>
                      <div class="modal-footer">
              <button type="button" class="btn btn-primary acepta">Agregar</button>
          </div>
    </div>

  </div>

</div>
</form>

    <!-- MODAL PARA AGREGAR DOCENTES A PLANTILLA -->
    <div id="modal_agrega" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="form_docente_crea" class="form" role="form" method="POST" >
                        {{ csrf_field() }}
                            <input type="hidden" id="docente" name="docente" value="" />
                            ¿Realmente deseas agregar a éste docente a plantilla?

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <input id="confirma_agrega" type="button" class="btn btn-success" value="Aceptar"></input>
                                </div>
                    </form>
              </div>
        </div>
      </div>
    </div>

</main>

<script>
  $(document).ready(function() {
  $('#paginar_table').DataTable();
  
        $(".materias").click(function(){
        var idprof=$(this).attr('id');
        $('#prof').val(idprof);
          /*var arreglo_id=$(this).attr('id');
          var arreglo=[];
          arreglo[0]=arreglo_id;
          arreglo[1]=1;
          window.location.href='/docentes/materias/'+arreglo;
          $("#contenedor_materias").empty();*/
        $.get("/docentes/materias/"+idprof,function(request)
          {
            $("#contenedor_materias").html(request);
        });
        $('#modal_materias').modal('show');

        });


       $(".elimina").click(function(){
            var id=$(this).attr('id');
            $('#confirma_elimina').data('id',id);
            $('#modal_elimina').modal('show');
        });

        $("#paginar_table").on('click','.agrega',function(){
            var id=$(this).attr('id');
            $('#docente').val(id);
            $('#modal_agrega').modal('show');
        });

        $("#confirma_elimina").click(function(event){
          var id_docente=($(this).data('id'));
          $("#form_delete").attr("action","/plantilla/docentes/"+id_docente)      
          $("#form_delete").submit();
          });

          $("#confirma_agrega").click(function(event){    
            $("#form_docente_crea").submit();
          });

      $(".acepta").click(function(){
        var arreglo_materias=[];
        $("input[name='materia[]']:checked").each(function(){
          arreglo_materias[arreglo_materias.length]=$(this).val();        
        });
        $("#materias").val(arreglo_materias);

      $.post("/agrega/materias_perfil", $("#form_ver_materias").serialize(),function(request)
        {
          window.location.href='/plantilla/docentes';
          $('#modal_materias').modal('hide');
        });
    });
});
  
</script>

@endsection
