@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class=" text-center">Tomos de folios de titulos</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                <p style="text-align: center">Agregar tomo de titulos <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar otro domo de titulos" data-target="#modal_agregar_domo" type="button" class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="paginar_table" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Abreviación</th>
                        <th>Número inicial</th>
                        <th>Número final</th>
                        <th>Fecha de registro</th>
                        <th>Estado del tomo</th>
                        <th>Activar folios de titulos</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $numero=0; ?>
                    @foreach($catalogos as $catalogo)
                        <tr>
                            <?php $numero++; ?>
                                <td>{{ $numero }}</td>
                                <td>{{$catalogo->abreviacion}} </td>
                                <td>{{$catalogo->numero_inicial}}</td>
                                <td>{{$catalogo->numero_final}}</td>
                                <td>{{$catalogo->fecha_reg}}</td>
                                @if($catalogo->id_registrado == 0)
                                <td class="text-center">
                                <button class="btn btn-primary crear_numeros_titulo" id="{{ $catalogo->id_reg_domo }}">Crear series de numeros de titulos</button>
                                </td>
                                @else
                                    <td><a style="" class="btn btn-primary" data-toggle="pill" onclick="window.location='{{ url('/titulacion/consultar_domos_numeros_titulos/'.$catalogo->id_reg_domo) }}'" href="" >Ver titulos</a></td>
                                    @if($estado_activo == 0)
                                        @if($catalogo->id_estado_tomo == 0)
                                            <td> <button class="btn btn-success activar_folios_titulos" id="{{ $catalogo->id_reg_domo }}">Activar</button></td>
                                        @elseif($catalogo->id_estado_tomo == 1)
                                            <td>Activado</td>
                                        @elseif($catalogo->id_estado_tomo == 2)
                                            <td>Finalizado</td>
                                        @endif
                                        @else
                                        @if($catalogo->id_estado_tomo == 0)
                                        <td></td>
                                            @elseif($catalogo->id_estado_tomo == 1)
                                                <td>Activado<br><button class="btn btn-danger finalizar_activacion_titulos" id="{{ $catalogo->id_reg_domo }}">Finalizar</button></td>
                                                @elseif($catalogo->id_estado_tomo == 2)
                                                    <td>Finalizado</td>
                                        @endif
                                    @endif

                                @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
{{-- Modal agregar domo de titulo--}}
    <div class="modal fade" id="modal_agregar_domo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agregar domo de titulos</h4>
                    </div>
                <form class="form" id="form_reg_domo" action="{{url("/titulacion/guardar_domo_titulacion/")}}" role="form" method="POST" >
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="abreviacion">Abreviación de catalogo</label>
                                <input class="form-control required" id="abreviacion" name="abreviacion" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"  value=""  required />
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="numero_inicial">Número inicial de los titulos del tomo</label>
                                <input class="form-control required" id="numero_inicial" name="numero_inicial" type="int"  value=""  required />
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="numero_final">Número final de los titulos del tomo</label>
                                <input class="form-control required" id="numero_final" name="numero_final" type="int"  value=""  required />
                            </div>

                        </div>
                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="button" id="guardar_agregar_domo" class="btn btn-primary" >Guardar</button>
                    </div>

            </div>

        </div>
    </div>
    {{-- Modal agregar domo de titulo--}}

    <!-- agregar numero de titulos -->
    <div id="modal_registrar_numero_titulo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/titulos/agregar_numeros_titulos_domo/")}}" method="POST" role="form" >
                    <div class="modal-body">
                        {{ csrf_field() }}
                        ¿Realmente deseas crear numeros de serie de los  titulos del tomo?
                        <input type="hidden" id="id_reg_domo" name="id_reg_domo" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_registro" type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- activacion -->
    <div id="modal_activar_titulo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/titulos/activar_folios_titulos/")}}" method="POST" role="form" >
                    <div class="modal-body">
                        {{ csrf_field() }}
                        ¿Realmente deseas activar los folios de titulo para su utilización?
                        <input type="hidden" id="id_reg_domo1" name="id_reg_domo1" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_activar_titulos" type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- finalizar -->
    <div id="modal_finalizar_titulo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/titulos/finalizar_folios_titulos/")}}" method="POST" role="form" >
                    <div class="modal-body">
                        {{ csrf_field() }}
                        ¿Realmente deseas finalizar la utilización de los folios de titulo de este domo?
                        <input type="hidden" id="id_reg_domo2" name="id_reg_domo2" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="aceptar_finalizar_titulos" type="submit" class="btn btn-primary" >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_agregar_domo").click(function (){
                var abreviacion = $("#abreviacion").val();
                if( abreviacion != ''){
                    var numero_inicial = $("#numero_inicial").val();
                    if( numero_inicial != ''){
                        var numero_final = $("#numero_final").val();
                        if( numero_final != ''){
                            $("#form_reg_domo").submit();
                            $("#guardar_agregar_domo").attr("disabled", true);

                        }else{
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Ingresa número final de los titulos del domo",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Ingresa número inicial de los titulos del domo",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa abreviación de catalogo.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
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
            $('.activar_folios_titulos').click(function (){
                var id_reg_domo =$(this).attr('id');
                $('#id_reg_domo1').val(id_reg_domo);
                $('#modal_activar_titulo').modal('show');
            });
            $('#aceptar_activar_titulos').click(function (){
                $("#aceptar_activar_titulos").attr("disabled", true);
            });
            $('.finalizar_activacion_titulos').click(function (){
                var id_reg_domo =$(this).attr('id');
                $('#id_reg_domo2').val(id_reg_domo);
                $('#modal_finalizar_titulo').modal('show');
            });

            $('#aceptar_finalizar_titulos').click(function (){
                $("#aceptar_finalizar_titulos").attr("disabled", true);
            });
        });
    </script>
@endsection