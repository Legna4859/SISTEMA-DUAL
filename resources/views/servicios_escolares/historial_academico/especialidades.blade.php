@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">ESPECIALIDADES</h3>
                    <h5 class="panel-title text-center">(PROGRAMAS DE ESTUDIO)</h5>
                </div>
                <div class="panel-body">


                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($carreras as $carrera)
                                            @if($carrera->id_carrera==$id_carrera)
                                                <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                            @else
                                                <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <br>
                        </div>
                    @if($no_seleccion == 0)
                          @else
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5" style="text-align: center;" >
                                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar especialidad" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                <br>
                            </div>
                            <br>
                        </div>
                    <div class="row">
                        <br>
                    </div>
                        <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <table id="tabla_especialidades" class="table table-bordered ">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nombre de la especialidad</th>
                                    <th>Carrera</th>
                                    <th>Modificar</th>

                                </tr>
                                </thead>

                                <tbody>
                                <?php $i=1;?>
                                @foreach($especialidades as $especialidad)
                                    <tr>
                                        <th>{{$i++}}</th>
                                        <td>{{ $especialidad->especialidad }}</td>
                                        <td>{{ $especialidad->nombre }}</td>
                                        <td class="text-center">
                                            <a class="modificar" id="{{ $especialidad->id_especialidad }}"><span class="glyphicon glyphicon-edit em2" aria-hidden="true"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>

                          @endif
                    </div>

            </div>
        </div>
    </div>
    <div>
    </div>

    <div class="modal fade" id="modal_modificar_especialidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar nombre de la especialidad</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_modificar_especialidades">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button     id="guardar_modificacion_especialidad"  style="" class="btn btn-primary"  >Guardar</button>
                    </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar especialidad</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/registrar/especialidad/$id_carrera")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_escuela">Nombre de la especialidad</label>
                                    <input class="form-control" id="nombre_especialidad" name="nombre_especialidad"   required/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" >Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#guardar_modificacion_especialidad").click(function (event) {
                var especialidad= $("#especialidad").val();
                var id_especialidad= $("#id_especialidad").val();

                if (especialidad != "") {

                    var especialidad=especialidad.toUpperCase();

                    window.location.href='/especialidades/modificacion_especialidad/'+id_especialidad+'/'+especialidad;


                } else {
                    swal({
                        position: "top",
                        type: "error",
                        title: "hay un campo vacio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
                window.location.href='/servicios_escolares/especialidades/carreras/'+carrera ;


            });
            $("#tabla_especialidades").on('click','.modificar',function(){
                var id_especialidad=$(this).attr('id');
                $.get("/especialidades/modificar/"+id_especialidad,function (request) {
                    $("#contenedor_modificar_especialidades").html(request);
                    $("#modal_modificar_especialidades").modal('show');
                });


            });
        });
    </script>
@endsection