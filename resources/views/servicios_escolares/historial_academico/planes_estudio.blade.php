@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PLANES DE ESTUDIO</h3>
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
                                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar plan de estudio" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
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
                                <table id="tabla_planes" class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nombre del plan de estudio</th>
                                        <th>Carrera</th>
                                        <th>Modificar</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i=1;?>
                                    @foreach($planes as $plan)
                                        <tr>
                                            <th>{{$i++}}</th>
                                            <td>{{ $plan->plan }}</td>
                                            <td>{{ $plan->nombre }}</td>
                                            <td class="text-center">
                                                <a class="modificar" id="{{ $plan->id_plan }}"><span class="glyphicon glyphicon-edit em2" aria-hidden="true"></span></a>
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

    <div class="modal fade" id="modal_modificar_plan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar nombre del plan de estudio</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar_plan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button     id="guardar_modificacion_plan"  style="" class="btn btn-primary"  >Guardar</button>
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

                    <form id="form_agregar" class="form" action="{{url("/plan/registrar_plan/$id_carrera")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre_escuela">Nombre de la especialidad</label>
                                    <input class="form-control" id="nombre_plan" name="nombre_plan"   required/>
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


                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
                window.location.href='/servicios_escolares/plan_estudio/carreras/'+carrera ;


            });
            $("#tabla_planes").on('click','.modificar',function(){
                var id_plan=$(this).attr('id');
                $.get("/plan/modificar/"+id_plan,function (request) {
                    $("#contenedor_modificar_plan").html(request);
                    $("#modal_modificar_plan").modal('show');
                });


            });
            $("#guardar_modificacion_plan").click(function (event) {

                var plan= $("#plan").val();
                var id_plan= $("#id_plan").val();

                if (plan != "") {

                    var plan=plan.toUpperCase();

                    window.location.href='/plan/modificacion_plan/'+id_plan+'/'+plan;


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
        });
    </script>
@endsection