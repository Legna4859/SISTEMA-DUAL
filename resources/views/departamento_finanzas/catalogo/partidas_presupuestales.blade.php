@extends('layouts.app')
@section('title', 'Partidas presupuestales')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Partidas presupuestales</h3>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-1 col-md-offset-2">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nueva partida presupuestal" data-target="#modal_crear_partida_presupuestal" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
        </div>

    <div class="row">
        <div class="col-md-10">
            <p><br></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered" id="registros_partidas">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Clave  de la partida presupuestal</th>
                    <th>Nombre  de la partida presupuestal</th>
                    <th>Modificar</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach($partidas as $partida)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $partida->clave_presupuestal }}</td>
                        <td>{{ $partida->nombre_partida }}</td>
                        <td>
                            <button data-toggle="tooltip" data-placement="top" id="{{$partida->id_partida_pres }}" title="Modificar partida presupuestal" class="btn btn btn-primary h-primary_m pl-5 pr-5 modificar_partida">Modificar partida</button>
                        </td>

                    </tr>
                @endforeach



                </tbody>
            </table>
        </div>
    </div>

    {{-- modal crear partida--}}

    <div class="modal fade" id="modal_crear_partida_presupuestal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar partida presupuestal</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/presupuesto_anteproyecto/guardar_partida_presupuestal/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Agregar clave de la partida presupuestal</label>
                                    <input class="form-control "   type="number"  id="clave_partida" name="clave_partida"  >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Agregar nombre de la partida presupuestal</label>
                                    <input class="form-control "   type="text"  id="nombre_partida"  onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre_partida"  >
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_partida"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal modificar partida--}}

    <div class="modal fade" id="modal_modificacion_partida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Modificar partida presupuestal </h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificacion_partida">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="guardar_modificacion_partida"  class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready( function() {
            $("#registros_partidas").dataTable();

            $("#guardar_partida").click(function (){
                var clave_partida = $('#clave_partida').val();

                if( clave_partida != ''){
                    var nombre_partida = $('#nombre_partida').val();
                    if(nombre_partida != ''){
                        $("#form_agregar").submit();
                        $("#guardar_partida").attr("disabled", true);
                    }else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "El nombre de partida presupuestal no debe ser vacia",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "La clave de la partida presupuestal no debe ser vacia",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $("#registros_partidas").on('click','.modificar_partida',function(){
                var id_partida =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/modificar_partida_presupuestal/"+id_partida,function (request) {
                    $("#contenedor_modificacion_partida").html(request);
                    $("#modal_modificacion_partida").modal('show');
                });
            });

            $("#registros_periodos").on('click','.modificar_periodo',function(){
                var id_periodo =$(this).attr('id');

                $.get("/presupuesto_anteproyecto/modificar_periodos_anteproyecto/"+id_periodo,function (request) {
                    $("#contenedor_modificacion").html(request);
                    $("#modal_modificacion").modal('show');
                });
            });
            $("#guardar_modificacion_partida").click(function (){
                $("#form_modificar_partida").submit();
                $("#guardar_modificacion_partida").attr("disabled", true);
            });


        });
    </script>
@endsection