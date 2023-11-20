@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Vouchers en espera de validación')
@section('content')
    <main class="col-md-12">

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><b>Vouchers de Pago Rechazados</b></h3>
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
                            <td >{{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                            <td style="font-size: 13px">{{ $alumno->linea_captura}}</td>
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

        });
    </script>
@endsection