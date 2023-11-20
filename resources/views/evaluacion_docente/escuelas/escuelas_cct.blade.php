@extends('layouts.app')
@section('title', 'Instituciones educativas')
@section('content')


    <main class="col-md-12">




        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Instituciones educativas</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-5" style="text-align: center;" >
              <p><br></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-5" style="text-align: center;" >
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar instituciones" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="paginar_table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>CCT</th>
                        <th>NOMBRE DE LA INSTITUCIÓN</th>
                        <th>DOMICILIO</th>
                        <th>MUNICIPIO</th>
                        <th>LOCALIDAD</th>
                        <th>TURNO</th>
                        <th>SERVICIO</th>
                        <th>EDITAR</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($escuelas as $escuela)
                        <tr>
                            <td>{{$escuela->cct}}</td>
                            <td>{{$escuela->nombre_escuela}}</td>
                            <td>{{$escuela->domicilio}}</td>
                            <td>{{$escuela->municipio}}</td>
                            <td>{{$escuela->localidad}}</td>
                            <td>{{$escuela->turno}}</td>
                            <td>{{$escuela->servicio}}</td>
                            <td class="text-center">
                                <a class="modificar" id="{{ $escuela->id_institucion }}"><span class="glyphicon glyphicon-edit em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade  " id="modal_modificar_esc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="form" class="form" action="{{url("/cct/guardar_modificacion/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar Escuela de Procedencia</h4>
                        </div>
                        <div class="modal-body">
                            <div id="contenedor_modificar_esc">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button     type="submit"  style="" class="btn btn-primary"  >Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade  " id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Agregar Escuela de Procedencia</h4>
                        </div>
                    <form id="form_agregar" class="form" action="{{url("/cct/guardar_institucion_educativa/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="cct">CCT de la Institución educativa</label>

                                        <textarea class="form-control" id="cct" name="cct" onkeyup="javascript:this.value=this.value.toUpperCase();" rows="3"  required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="nombre_escuela">Nombre de la Institución educativa</label>
                                        <textarea class="form-control" id="nombre_escuela" name="nombre_escuela" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="domicilio">Domiclio de la Institución educativa</label>
                                        <textarea class="form-control" id="domicilio" name="domicilio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="municipio">Municipio de la Institución educativa</label>
                                        <textarea class="form-control" id="municipio" name="municipio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="localidad">Localidad de la Institución educativa</label>
                                        <textarea class="form-control" id="localidad" name="localidad" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="turno">Turno de la Institución educativa</label>
                                        <textarea class="form-control" id="turno" name="turno" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="servicio">Servicio de la Institución educativa</label>
                                        <textarea class="form-control" id="servicio" name="servicio" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();"  required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button     type="button"  style="" id="guardar_institucion" class="btn btn-primary"  >Guardar</button>
                        </div>

                </div>
            </div>
        </div>

    <script>
        $(document).ready(function() {
            $('#paginar_table').DataTable();
            $("#paginar_table").on('click','.modificar',function(){
                var id_institucion=$(this).attr('id');
                $.get("/cct/registros_modificar/"+id_institucion,function (request) {
                    $("#contenedor_modificar_esc").html(request);
                    $("#modal_modificar_esc").modal('show');
                });

            });
            $("#guardar_institucion").click(function (){
                var cct = $("#cct").val();
                var nombre_escuela = $("#nombre_escuela").val();
                var domicilio = $("#domicilio").val();
                var municipio = $("#municipio").val();
                var localidad = $("#localidad").val();
                var turno = $("#turno").val();
                var servicio = $("#servicio").val();

                if (cct != "" && nombre_escuela !=""  && domicilio !="" && municipio !="" && localidad !="" && turno != "" && servicio !="") {
                    $("#guardar_institucion").attr("disabled", true);
                    $("#form_agregar").submit();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });

                }
                else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Algún campo se encuentra  vacío.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
        });
    </script>

@endsection
