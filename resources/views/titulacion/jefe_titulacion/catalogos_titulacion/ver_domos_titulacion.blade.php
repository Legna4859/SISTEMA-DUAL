@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/reg_catalogo_tomos_titulo")}}">Tomos</a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>Tomo de folios de titulos </span>

                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title text-center">Tomo de folios de titulos</h2>
                        @if($catalogo->id_estado_tomo == 0 )
                        <h2 style="text-align: center">Disponible </h2>
                            @elseif($catalogo->id_estado_tomo == 1 )
                                <h2 style="text-align: center">Activo</h2>
                                @elseif($catalogo->id_estado_tomo == 2 )
                                    <h2 style="text-align: center">Finalizado</h2>
                        @endif


                        <h2 style="text-align: center">Del: {{ $catalogo->abreviacion }}{{ $catalogo->numero_inicial }} al {{ $catalogo->abreviacion }}{{ $catalogo->numero_final }}</h2>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="paginar_table" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Número del titulo</th>
                        <th>Abreviatura del folio titulo</th>
                        <th>Estado del folio titulo</th>
                        <th>Nombre del estudiante</th>
                        <th>Tipo de titulación</th>
                        <th>Comentario</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $numero=0; ?>
                    @foreach($array_titulos  as $titulo)
                        <tr>
                            <?php $numero++; ?>
                            <td>{{ $numero }}</td>
                                <td>{{$titulo['numero_titulo']}} </td>
                                <td>{{$titulo['abreviatura_folio_titulo']}} <br>
                                    @if($catalogo->id_estado_tomo == 1 )
                                    <button class="btn btn-primary editar_folio" id="{{ $titulo['id_numero_titulo'] }}"><i class="glyphicon glyphicon-cog"></i></button>
                                    @endif
                                </td>
                               @if($titulo['id_estado_numero_titulo'] == 0)
                                   <td style="text-align: center">Disponible<br>
                                       @if($catalogo->id_estado_tomo == 1 )
                                       <button class="btn btn-primary agregar_estudiante" id="{{ $titulo['id_numero_titulo'] }}">Agregar estudiante autorizado</button>
                                       @endif
                                   </td>
                                <td></td>
                                   <td></td>
                                   <td></td>
                                    @elseif($titulo['id_estado_numero_titulo'] == 1)
                                   <td style="color: #1f6fb2; text-align: center">Autorizado<br>
                                       @if($catalogo->id_estado_tomo == 1 )
                                       <button class="btn btn-primary editar_estado_folio_titulo" id="{{ $titulo['id_numero_titulo'] }}"><i class="glyphicon glyphicon-cog"></i></button>
                                       @endif
                                            </td>
                                    <td>No.cuenta:{{ $titulo['cuenta'] }} <br> Nombre del estudiante: {{ $titulo['nombre_alumno'] }}</td>
                                    @if($titulo['id_tipo_titulacion'] == 1)
                                        <td>Titulacion Integral</td>
                                    @else
                                        <td> Titulacion anterior 2010</td>
                                    @endif
                                @elseif($titulo['id_estado_numero_titulo'] == 2 || $titulo['id_estado_numero_titulo'] == 3 ||
                                    $titulo['id_estado_numero_titulo'] == 4 || $titulo['id_estado_numero_titulo'] == 5 || $titulo['id_estado_numero_titulo'] == 6)
                                    <td style="color:red; text-align: center;">{{ $titulo['estado_numero_titulo'] }} </td>
                                    <td>No.cuenta:{{ $titulo['cuenta'] }} <br> Nombre del estudiante: {{ $titulo['nombre_alumno'] }}</td>
                                    @if($titulo['id_tipo_titulacion'] == 1)
                                        <td>Titulacion Integral</td>
                                    @else
                                        <td> Titulacion anterior 2010</td>
                                    @endif
                                    <td style="color: #942a25">{{ $titulo['comentario'] }}</td>

                                @endif

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <div class="modal fade" id="modal_editar_estado_folio_titulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="{{url("/titulo/guardar_modificacion_estado_titulo/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar estado  del titulo del estudiante</h4>
                    </div>
                    <div id="contenedor_editar_estado_folio_titulo">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modal_agregar_folio_titulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" id="form_guardar_estudiante" action="{{url("/titulo/guardar_agregar_folio_titulo/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Registrar folio del titulo a estudiante</h4>
                    </div>
                    <div id="contenedor_agregar_folio_titulo">


                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  id="guardar_datos" class="btn btn-primary" >Guardar</button>
                    </div>

            </div>

        </div>
    </div>
    <div class="modal fade" id="modal_editar_folio_titulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="{{url("/titulo/guardar_modificacion_folio_titulo/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar estado del folio del titulo</h4>
                    </div>
                    <div id="contenedor_editar_folio_titulo">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <script type="text/javascript">
        $(document).ready( function() {
            $(".editar_estado_folio_titulo").click(function (){

                var id_numero_titulo=$(this).attr('id');

                $.get("/titulacion/estado_folio_titulo_editar/"+id_numero_titulo,function (request) {
                    $("#contenedor_editar_estado_folio_titulo").html(request);
                    $("#modal_editar_estado_folio_titulo").modal('show');
                });

            });

            $(".editar_folio").click(function (){
                var id_numero_titulo=$(this).attr('id');
                $.get("/titulacion/editar_folio_titulo_editar/"+id_numero_titulo,function (request) {
                    $("#contenedor_editar_folio_titulo").html(request);
                    $("#modal_editar_folio_titulo").modal('show');
                });

            });

            $(".agregar_estudiante").click(function (){
                var id_numero_titulo=$(this).attr('id');
                $.get("/titulacion/agregar_estudiante_folio_titulacion/"+id_numero_titulo,function (request) {
                    $("#contenedor_agregar_folio_titulo").html(request);
                    $("#modal_agregar_folio_titulo").modal('show');
                });

            });
            $(".crear_numeros_titulo").click(function (){
                var id_reg_domo =$(this).attr('id');
                $('#id_reg_domo').val(id_reg_domo);
                $('#modal_registrar_numero_titulo').modal('show');
            });
            $('#aceptar_registro').click(function (){
                $("#aceptar_registro").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Registro exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
            $('#guardar_datos').click(function (){
                var id_tipo_titulacion=$('#id_tipo_titulacion').val();
                if(id_tipo_titulacion == 1){
                    var id_alumno_integral=$('#id_alumno_integral').val();
                 if( id_alumno_integral != null){
                     $("#form_guardar_estudiante").submit();
                     $("#guardar_datos").attr("disabled", true);
                 }else{
                     swal({
                         position: "top",
                         type: "error",
                         title: "Selecciona estudiante",
                         showConfirmButton: false,
                         timer: 3500
                     });
                 }
                }
                else if(id_tipo_titulacion == 2)
                {
                    var id_alumno_anterior=$('#id_alumno_anterior').val();
                    if( id_alumno_anterior != null){
                        $("#form_guardar_estudiante").submit();
                        $("#guardar_datos").attr("disabled", true);
                    }else{
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona estudiante",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Selecciona tipo de titulación",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }


            });

        });
    </script>
@endsection