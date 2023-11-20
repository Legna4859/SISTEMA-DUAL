@extends('layouts.app')
@section('title', 'Periodo de anteproyectos')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title text-center">Periodos de evaluación de anteproyecto</h2>
                    </div>
                </div>
            </div>
        </div>

        @if($periodo_activo != null)
            <div class="row">
                <div class="col-md-5 col-md-offset-3">

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 style="text-align: center">Periodo activo</h3>
                            <h3 style="text-align: center">Fecha de inicio:  {{$periodo_activo->fecha_inicio}}   </h3>
                            <h3 style="text-align: center">Fecha de termino:{{$periodo_activo->fecha_final}}</h3>
                            <h3 style="text-align: center"> Periodo:{{$periodo_activo->periodo}}</h3>
                            <p style="text-align: center"> <button class="btn btn-danger desactivar" id="{{ $periodo_activo->id_periodo_eval_anteproyecto }}">Desactivar</button></p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-5 col-md-offset-3">

                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No hay periodo activo</h3>

                        </div>
                    </div>
                </div>
            </div>
            @endif


        <?php $n=1 ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="table_periodo_eval_anteproyecto" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Final</th>
                        <th>Periodo</th>
                        @if($periodo_activo == null)
                        <th>Estado</th>
                        <th>Eliminar</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($periodo_anteproyectos as $periodo_anteproyecto)
                        <tr>
                            <td>{{ $n }}</td>
                            <td>{{$periodo_anteproyecto->fecha_inicio}}</td>
                            <td>{{$periodo_anteproyecto->fecha_final}}</td>
                            <td>{{$periodo_anteproyecto->periodo }}</td>
                            @if($periodo_activo == null)
                          <td>  <button class="btn btn-primary activar" id="{{ $periodo_anteproyecto->id_periodo_eval_anteproyecto }}">Activar</button>
                          </td>
                            <td>
                                <a class="eliminar_periodo" id="{{$periodo_anteproyecto->id_periodo_eval_anteproyecto}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                                @endif
                        </tr>
                        <?php $n++ ?>
                    @endforeach

                    </tbody>
                </table>
            </div>




        </div>
        <div class="row">
            <div class="col-md-1 col-md-offset-3">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar nuevo periodo de evaluación" data-target="#modal_agregar_periodo" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
            <br><br>
        </div>
        <br><br>
    </main>

        <div class="modal fade" id="modal_agregar_periodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar periodo de evaluación de anteproyecto</h4>
                    </div>
                    <form class="form" role="form" method="POST" >
                        {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                    <div class="form-group">
                                        <label for="deparamento">Selecciona fecha Inicial</label>
                                        <div class='input-group date' data-date-format="yyyy/mm/dd" id='fecha_inicial' >
                                            <input type='text' id="fecha_inicial" name="fecha_inicial" class="form-control" required />
                                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                        </div>

                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label for="deparamento">Selecciona fecha Final</label>
                                    <div class='input-group date' data-date-format="yyyy/mm/dd" id='fecha_final' >
                                        <input type='text' id="fecha_final" name="fecha_final" class="form-control" required />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                     </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" class="btn btn-primary">Guardar</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- MODAL PARA ELIMINAR -->
    <div id="modal_eliminado_periodo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="" method="POST" role="form" id="form_delete">
                    {{method_field('DELETE') }}
                    {{ csrf_field() }}
                <div class="modal-body">

                        ¿Realmente deseas eliminar éste elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id="confirma_eliminado_periodo" type="button" class="btn btn-danger" value="Aceptar" />
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- activar periodo -->
    <div id="modal_activar_periodo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="form_agregar" class="form" action="{{url("/residencia/activar_periodo_anteproyecto/")}}" role="form" method="POST" >


                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id_periodo_eval_anteproyecto" name="id_periodo_eval_anteproyecto" value="">

                        ¿Realmente quiere activar este periodo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- activar periodo -->
    <div id="modal_activar_periodo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="form_agregar" class="form" action="{{url("/residencia/activar_periodo_anteproyecto/")}}" role="form" method="POST" >


                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id_periodo_eval_anteproyecto" name="id_periodo_eval_anteproyecto" value="">

                        ¿Realmente quiere activar este periodo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- activar periodo -->
    <div id="modal_desactivar_periodo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="form_agregar" class="form" action="{{url("/residencia/desactivar_periodo_anteproyecto/")}}" role="form" method="POST" >


                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id_periodo_eval_anteproyecto1" name="id_periodo_eval_anteproyecto1" value="">

                        ¿Realmente quiere activar este periodo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#fecha_inicial').datepicker({

                autoclose: true,
                startDate: '+0d',
                language: 'es'
            });
            $('#fecha_final').datepicker({

                autoclose: true,
                startDate: '+0d',
                language: 'es'
            });
            $("#table_periodo_eval_anteproyecto").on('click','.activar',function(){
                var id=$(this).attr('id');
                $('#id_periodo_eval_anteproyecto').val(id);
                $('#modal_activar_periodo').modal('show');

            });
            $("#table_periodo_eval_anteproyecto").on('click','.eliminar_periodo',function(){
                var id=$(this).attr('id');
                $('#confirma_eliminado_periodo').data('id',id);
                $('#modal_eliminado_periodo').modal('show');

            });
            $("#confirma_eliminado_periodo").click(function(event){
                var id=($(this).data('id'));
                $("#form_delete").attr("action","/residencia/evalucion_anteproyecto/eliminar/"+id)
                $("#form_delete").submit();
            });
            $(".desactivar").click(function (event){
                var id=$(this).attr('id');
                $('#id_periodo_eval_anteproyecto1').val(id);
                $('#modal_desactivar_periodo').modal('show');
            });


        });
    </script>
@endsection