@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">EDITAR CEDULA Y TITULO DEL JURADO</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">PROFESORES</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="tabla_profesores" class="table table-bordered " Style="background: white;" >
                        <thead>
                        <tr>
                            <th>TITULO</th>
                            <th>NOMBRE DEL PROFESOR</th>
                            <th>CEDULA</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($profesores as $profesor)
                            <tr>
                                <td style="text-align: center">{{$profesor->titulo }}<a  class="pull-left btn_edit_titulo" data-id_abreviacion_prof="{{$profesor->id_abreviacion_prof}}" data-toggle="tooltip" title="Editar titulo"><span class="glyphicon glyphicon-cog"></span></a>
                                </td>
                                <td style="text-align: center">{{$profesor->nombre }}      </td>
                                <td style="text-align: center">{{$profesor->cedula}}<a  class="pull-left btn_edit_cedula" data-id_personal="{{$profesor->id_personal}}" data-toggle="tooltip" title="Editar cedula del profesor"><span class="glyphicon glyphicon-cog"></span></a>
                                </td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">TITULOS DE LOS PROFESORES</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p style="text-align: center">Agregar titulo <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar titulo" data-target="#modal_agregar_titulo" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button></p>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="tabla_titulo" class="table table-bordered " Style="background: white;" >
                        <thead>
                        <tr>
                            <th>ABREVIACIONES DE LOS TITULOS</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($abreviaciones as $abreviacion)
                            <tr>
                                <td style="text-align: center">{{$abreviacion->titulo }}           </td>
                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   {{--agregar titulo--}}
    <div class="modal fade" id="modal_agregar_titulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar abreviación del titulo</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar_titulo" class="form" action="{{url("/titulo/agregar_titulo/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                  <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                          <div class="form-group">
                              <label for="licencia">Nombre del Titulo</label>
                              <input class="form-control required" id="nombre_titulo" name="nombre_titulo"  onkeyup="javascript:this.value=this.value.toUpperCase();" />
                          </div>
                          <br>
                      </div>

                  </div>


                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_titulo"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--fin de agregar titulo--}}
{{--editar abreviacion de titulo--}}
    <div class="modal fade" id="modal_editar_titulo_profesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar titulo de profesor</h4>
                </div>
                <div class="modal-body">
                    <form id="form_editar_titulo_profesor" class="form" action="{{url("/titulacion/guardar_editar_titulo_profesor/")}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div id="contenedor_editar_titulo_profesor">

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_editar_titulo_profesor" class="btn btn-success">Modificar</button>

                </div>
            </div>
        </div>
    </div>
    {{--editar cedula  del profesor--}}
    <div class="modal fade" id="modal_editar_cedula_profesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar titulo de profesor</h4>
                </div>
                <div class="modal-body">
                    <form id="form_editar_cedula_profesor" class="form" action="{{url("/titulacion/guardar_editar_cedula_profesor/")}}" role="form" method="POST" >
                        {{ csrf_field() }}

                        <div id="contenedor_editar_cedula_profesor">

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="guardar_editar_cedula_profesor" class="btn btn-success">Modificar</button>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">



        $(document).ready(function() {
            $('#tabla_alumnos').DataTable();
            $('#tabla_titulo').DataTable();
        } );
        $("#tabla_profesores").on('click','.btn_edit_titulo',function(){
            var id_abreviacion_prof=$(this).data('id_abreviacion_prof');
            $.get("/titulacion/editar_titulo_profesor/"+id_abreviacion_prof,function (request) {
                $("#contenedor_editar_titulo_profesor").html(request);
                $("#modal_editar_titulo_profesor").modal('show');
            });
        });

        $("#tabla_profesores").on('click','.btn_edit_cedula',function(){
            var id_personal=$(this).data('id_personal');

            $.get("/titulacion/edita_cedula/"+id_personal,function (request) {
                $("#contenedor_editar_cedula_profesor").html(request);
                $("#modal_editar_cedula_profesor").modal('show');
            });
        });

        $("#guardar_titulo").click(function (){
            var nombre_titulo = $("#nombre_titulo").val();
            if(nombre_titulo !=''){
                $("#form_agregar_titulo").submit();
                $("#guardar_titulo").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Registro exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            }else{
                swal({
                    position: "top",
                    type: "error",
                    title: "Ingresa la abreviación del titulo",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
        });
        $("#guardar_editar_titulo_profesor").click(function (){
            $("#form_editar_titulo_profesor").submit();
            $("#guardar_editar_titulo_profesor").attr("disabled", true);
        });
        $("#guardar_editar_cedula_profesor").click(function (){
            $("#form_editar_cedula_profesor").submit();
            $("#guardar_editar_cedula_profesor").attr("disabled", true);
        });



    </script>

@endsection