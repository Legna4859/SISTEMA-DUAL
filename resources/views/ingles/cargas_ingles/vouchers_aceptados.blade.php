@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Vouchers en espera de validación')
@section('content')
    <main class="col-md-12">

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>Vouchers de Pago Aceptados</b></h3>
                    </div>
                </div>
            </div>
        </div>
            @if($estado_voucher_excell == 0)
            <div class="row">
                <div class="col-md-2 col-md-offset-6">
                    <button id="aceptacion_descargar" class="btn btn-primary">Aceptación de descargar excel</button>
                </div>
            </div>
            <div class="modal fade" id="aceptacion_descarga" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Aceptación de descarga</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_descarga" class="form" action="{{url("/ingles/guardar_aceptacion_excel_voucher")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                            <p>Deseas descargar los datos de los estudiantes con voucher aceptado</p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="aceptar_descarga" class="btn btn-primary" >Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="consultar">
                <div class="col-md-10 col-md-offset-1">
                    <br>
                    <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                        <thead>
                        <tr>
                            <th style="text-align: center; color: black;"> No. cuenta</th>
                            <th style="text-align: center; color: black;"> Nombre del Estudiante</th>
                            <th style="text-align: center; color: black;"> Linea de Captura</th>
                            <th style="text-align: center; color: black;"> Fecha de Entrega (Finanzas)</th>
                            <th style="text-align: center; color: black;"> Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td >{{ $alumno->cuenta }}</td>
                                <td style="text-align: center;">{{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                                <td style="font-size: 13px;text-align: center">{{ $alumno->linea_captura}}</td>
                                <td>{{ $alumno->fecha_cambio }}</td>
                                <td>
                                    <div style="display: flex; justify-content: center">
                                        <button>
                                            <a onclick="window.open('{{url($alumno->voucher)  }}')"  href="#" >
                                                <i class="glyphicon glyphicon-eye-open" ></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-2 col-md-offset-2">
                    <button type="button" class="btn btn-success" onclick="window.open('{{url('/ingles/exportar_excell_voucher_aceptado/')}}')">
                        <strong style="color:white;"><b>Exportar Concentrado<span class="oi oi-document p-1"></span></b></strong>
                    </button>
                </div>
                <div class="col-md-4">
                    <button id="agregar_reg_pendientes" class="btn btn-primary">Agregar registros pendientes en el excel para descargar</button>
                </div>
            </div>
            <div class="modal fade" id="aceptacion_reg_pendientes" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Agregar registros pendientes</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_agregar_pendientes" class="form" action="{{url("/ingles/guardar_agregar_pendi_excel")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <p>Deseas agregar registros pendientes en el excel para descargar</p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="aceptar_agregar_pendientes" class="btn btn-primary" >Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="consultar">
                <div class="col-md-10 col-md-offset-1">
                    <br>
                    <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                        <thead>
                        <tr>
                            <th style="text-align: center; color: black;"> No. cuenta</th>
                            <th style="text-align: center; color: black;"> Nombre del Estudiante</th>
                            <th style="text-align: center; color: black;"> Linea de Captura</th>
                            <th style="text-align: center; color: black;"> Fecha de Entrega (Finanzas)</th>
                            <th style="text-align: center; color: black;"> Acciones</th>
                            <th style="text-align: center; color: black;">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td >{{ $alumno->cuenta }}</td>
                                <td style="text-align: center;">{{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                                <td style="font-size: 13px;text-align: center">{{ $alumno->linea_captura}}</td>
                                <td>{{ $alumno->fecha_cambio }}</td>
                                <td>
                                    <div style="display: flex; justify-content: center">
                                        <button>
                                            <a onclick="window.open('{{url($alumno->voucher)  }}')"  href="#" >
                                                <i class="glyphicon glyphicon-eye-open" ></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                @if($alumno->estado_agregacion_excel == 0)
                                        <button id="{{ $alumno->id_voucher }}" class="btn btn-primary aceptacion_descargar">Agregar registro pendiente <br> en el excel para descargar</button>
                                 @else
                                      <p>Registro agregado</p>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif


    </main>
    <div class="modal modal fade bs-example-modal-sm" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header btn-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mostrar">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_ver_registro" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar registro pendiente</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_ver_registro">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="aceptar_registro" class="btn btn-primary" >Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( {

            } );
            $("#table_enviado").on('click','.editar',function(){
                var id_validar_carga=$(this).attr('id');
                $.get("/ingles/modificar_carga_academica_ingles/"+id_validar_carga,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });


            });
            $("#aceptacion_descargar").click(function (){
                $("#aceptacion_descarga").modal('show');
            });
            $("#aceptar_descarga").click(function (){
                $("#aceptar_descarga").attr("disabled", true);
                $("#form_descarga").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Descarga exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });
            });
            $("#table_enviado").on('click','.aceptacion_descargar',function(){
                var id_voucher=$(this).attr('id');
                $.get("/ingles/ver_registro_voucher/"+id_voucher,function (request) {
                    $("#contenedor_ver_registro").html(request);
                    $("#modal_ver_registro").modal('show');
                });

                $("#aceptar_registro").click(function (){
                    $("#aceptar_registro").attr("disabled", true);
                    $("#form_enviar_registro").submit();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Agregación exitosa",
                        showConfirmButton: false,
                        timer: 3500
                    });
                });
            });
            $("#agregar_reg_pendientes").click(function (){
                $("#aceptacion_reg_pendientes").modal('show');
            });

            $("#aceptar_agregar_pendientes").click(function (){
                $("#aceptar_agregar_pendientes").attr("disabled", true);
                $("#form_agregar_pendientes").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Agregación exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });
            });

        });
    </script>
@endsection