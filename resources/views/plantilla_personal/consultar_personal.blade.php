@extends('layouts.app')
@section('title', 'Personal en Plantilla')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-4 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Consultar Personal por Departamento</h3>
                    </div>
                </div>
            </div>
        </div>
    <form id="form_consultar" action="{{url("/departamentoplantilla/mostrar")}}" class="form" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">

            <div class="col-md-4 col-md-offset-3">
                <div class="form-group">
                <div class="dropdown">
                    <label for="deparamento">Departamentos del TESVB</label>
                    <select name="departamento" id="departamento" class="form-control ">
                        <option>Selecciona departamento</option>
                        @foreach($jefaturas as $jefatura)
                            @if($jefatura->id_unidad_admin==$departamento)
                                <option value="{{$jefatura->id_unidad_admin}}" selected="selected">{{$jefatura->nom_departamento}}</option>
                            @else
                                <option value="{{$jefatura->id_unidad_admin}}" >{{$jefatura->nom_departamento}}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                </div>
                </div>

            </div>
                <br>
                <br>
        </div>
    </form>
              @if($ver == 1)
                  <div class="row">
                      <div class="col-md-4 col-md-offset-3">
                          <table class="table table-bordered" id="paginar_table">
                              <thead>
                              <tr>
                                  <th>Titulo</th>
                                  <th>Nombre</th>
                                  <th>Eliminar</th>

                              </tr>
                              </thead>
                              <tbody>
                              @foreach($plantillas as $plantilla)
                                  <tr>
                                      <td>{{$plantilla->titulo}}</td>
                                      <td>{{$plantilla->nombre}}</td>
                                      <td class="text-center">
                                          <a class="elimina" id="{{ $plantilla->id_personal }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                      </td>

                                  </tr>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              @endif



    </main>
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

    </main>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#departamento").on('change',function(e){
                var id_cargo= $("#departamento").val();

                window.location.href='/departamento/plantillas/'+id_cargo ;
                //  }

            });
            $('#paginar_table').DataTable();
            $(".elimina").click(function(){
                var id=$(this).attr('id');
                $('#confirma_elimina').data('id',id);
                $('#modal_elimina').modal('show');
            });



            $("#confirma_elimina").click(function(event){
                var id_personal=($(this).data('id'));
                $("#form_delete").attr("action","/departamento/plantilla/"+id_personal)
                $("#form_delete").submit();
            });

        });
    </script>

@endsection
