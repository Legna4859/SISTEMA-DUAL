@extends('layouts.app')
@section('title', 'Presupuesto autorizado modificado')
@section('content')
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Presupuesto autorizado del {{ $year }} para modificar</h3>
                </div>
            </div>
        </div>
    </div>



        @if($estado_presupuesto == 0)
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="text-align: center">No se ha terminado de agregar presupuesto del año {{ $year }}</div>
                    </div>
                </div>
            </div>

    @else
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p>PRESUPUESTO DEL MES <b>(PM)</b></p>
                    <p>PRESUPUESTO EJERCIDO <b>(PE)</b></p>
                    <p>PRESUPUESTO SOBRANTE <b>(PS)</b></p>
                </div>
            </div>




        <div class="row">
            <div class="col-md-1 col-md-offset-2">
                <p><br></p>
            </div>
        </div>
        <style type="text/css">
            #tabla_presupuesto thead tr th {
                position: sticky;
                top: 0;
                z-index: 10;



            }


        </style>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-bordered" id="tabla_presupuesto">
                    <thead>
                    <tr>
                        <th style="background: grey; color: black;">Partida</th>
                        <th style="background: grey; color: black;">Denominaciòn</th>
                        <th style="background: grey; color: black;">Total</th>
                        <th style="background: #b0d4f1; color: black;">Enero</th>
                        <th style="background: #b0d4f1; color: black;">Febrero</th>
                        <th style="background: #b0d4f1; color: black;">Marzo</th>
                        <th style="background: #b0d4f1; color: black;">Abril</th>
                        <th style="background: #b0d4f1; color: black;">Mayo</th>
                        <th style="background: #b0d4f1; color: black;">Junio</th>
                        <th style="background: #b0d4f1; color: black;">Julio</th>
                        <th style="background: #b0d4f1; color: black;">Agosto</th>
                        <th style="background: #b0d4f1; color: black;">Septiembre</th>
                        <th style="background: #b0d4f1; color: black;">Octubre</th>
                        <th style="background: #b0d4f1; color: black;">Noviembre</th>
                        <th style="background: #b0d4f1; color: black;">Diciembre</th>
                        @if($estado_presupuesto == 0)
                            <th></th>
                            <th></th>
                        @endif
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <th colspan="2" style="text-align: center">Total autorizado</th>
                        <th style="text-align: right">{{number_format($total_presupuesto, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_enero, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_febrero, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_marzo, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_abril, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_mayo, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_junio, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_julio, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_agosto, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_septiembre, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_octubre, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_noviembre, 2, '.', ',') }}</th>
                        <th style="text-align: right">{{number_format($total_diciembre, 2, '.', ',') }}</th>
                    </tr>
                    <tr>

                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"></td>
                        @if($estado_presupuesto == 0)
                            <td style="text-align: center">Editar</td>
                            <td style="text-align: center">Eliminar</td>
                        @else
                        @endif
                    </tr>
                    @foreach($array_partidas as $partida)
                        <tr>

                            <td style="text-align: right">{{$partida['clave_presupuestal']}}</td>
                            <td style="text-align: right">{{$partida['nombre_partida'] }}</td>
                            <td style="text-align: right">{{number_format($partida['total_presupuesto'], 2, '.', ',') }}</td>

                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b> {{number_format($partida['enero_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['enero_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['enero_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a  href="#" class="edita_enero" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit" ></i></a></p>

                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b>  {{number_format($partida['febrero_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['febrero_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['febrero_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_febrero" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b> {{number_format($partida['marzo_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['marzo_utilizado'], 2, '.', ',') }}</p>
                                <p>{{number_format($partida['marzo_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_marzo" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>

                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b>  {{number_format($partida['abril_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['abril_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['abril_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_abril" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b>  {{number_format($partida['mayo_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['mayo_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['mayo_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_mayo" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b> {{number_format($partida['junio_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['junio_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['junio_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_junio" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>

                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b>  {{number_format($partida['julio_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['julio_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['julio_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_julio" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b>  {{number_format($partida['agosto_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['agosto_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['agosto_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_agosto" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b> {{number_format($partida['septiembre_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['septiembre_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['septiembre_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_septiembre" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b>  {{number_format($partida['octubre_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['octubre_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['octubre_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_octubre" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>

                            </td>
                            <td style="text-align: right">
                                <p style="color: blue"><b>PM = </b> {{number_format($partida['noviembre_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['noviembre_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['noviembre_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_noviembre" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            <td style="text-align: right">
                               <p style="color: blue"><b>PM = </b> {{number_format($partida['diciembre_pres'], 2, '.', ',') }}</p>
                                <p style="color: red"><b>PE = </b> {{number_format($partida['diciembre_utilizado'], 2, '.', ',') }}</p>
                                <p><b>PS = </b>{{number_format($partida['diciembre_pres_total'], 2, '.', ',') }}</p>
                                <p style="text-align: center;">  <a href="#" class="edita_diciembre" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-edit"></i></a></p>
                            </td>
                            @if($estado_presupuesto == 0)
                                <td style="text-align: center;">   <button class="btn btn-primary editar" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-cog"></i></button></td>
                                <td style="text-align: center;">   <button class="btn btn-danger eliminar" id="{{ $partida['id_presupuesto_aut_copia'] }}"><i class="glyphicon glyphicon-trash"></i></button></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        {{-- modal modificar requisicion de materiales--}}

        <div class="modal fullscreen-modal fade" id="modal_mod_partida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar partida</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mod_partida">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="guardar_mod_partida"  class="btn btn-primary" >Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal modificar presupuesto del mes de la requisicion--}}

        <div class="modal" id="modal_mod_req_mes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar presupuesto del mes de la requisición</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_mod_req_mes">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="guardar_mod_req_mes"  class="btn btn-primary" >Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <style>
            /*
    Full screen Modal
    */
            .fullscreen-modal .modal-dialog {
                margin: 0;
                margin-right: auto;
                margin-left: auto;
                width: 100%;
            }
            @media (min-width: 768px) {
                .fullscreen-modal .modal-dialog {
                    width: 750px;
                }
            }
            @media (min-width: 992px) {
                .fullscreen-modal .modal-dialog {
                    width: 970px;
                }
            }
            @media (min-width: 1200px) {
                .fullscreen-modal .modal-dialog {
                    width: 1170px;
                }
            }
        </style>
        <script>
            $(document).ready(function() {
                $(".edita_enero").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/1",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });

                });
                $("#guardar_mod_req_mes").click(function (){

                    var id_mes = $("#id_mes").val();

                    if(id_mes == null){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona mes",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{

                        var presupuesto_sobrante = $("#presupuesto_sobrante").val();
                        var presupuesto_dado = $("#presupuesto_dado").val();
                      if(presupuesto_dado == ''){
                          swal({
                              position: "top",
                              type: "error",
                              title: "Ingresa presupuesto a dar",
                              showConfirmButton: false,
                              timer: 3500
                          });

                      }else {

                          if (presupuesto_dado > presupuesto_sobrante) {
                              swal({
                                  position: "top",
                                  type: "error",
                                  title: "No alcanza el presupuesto",
                                  showConfirmButton: false,
                                  timer: 3500
                              });
                          } else {
                              $("#form_mod_mes_partida").submit();
                              $("#guardar_mod_req_mes").attr("disabled", true);
                              swal({
                                  position: "top",
                                  type: "success",
                                  title: "Registro exitoso",
                                  showConfirmButton: false,
                                  timer: 3500
                              });
                          }
                      }
                    }
                });
                $(".edita_febrero").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/2",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_marzo").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/3",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_abril").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/4",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_mayo").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/5",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_junio").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/6",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_julio").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/7",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_agosto").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/8",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_septiembre").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/9",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_octubre").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/10",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_noviembre").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/11",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $(".edita_diciembre").click(function (){
                    var id_presupuesto_aut_copia = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_mes_requisicion/"+id_presupuesto_aut_copia+"/12",function (request) {
                        $("#contenedor_mod_req_mes").html(request);
                        $("#modal_mod_req_mes").modal('show');
                    });
                });
                $("#aceptar_terminar").click(function (){

                    $("#form_guardar_partida").submit();
                    $("#aceptar_terminar").attr("disabled", true);

                });
                $("#aceptar_eliminar_partida").click(function (){
                    $("#form_eliminar_partida").submit();
                    $("#aceptar_eliminar_partida").attr("disabled", true);
                });
                $(".eliminar").click(function (){
                    var id_presupuesto_aut = $(this).attr('id');
                    $.get("/presupuesto_autorizado/eliminar_presupesto_partida/"+id_presupuesto_aut,function (request) {
                        $("#contenedor_eliminar_partida").html(request);
                        $("#modal_eliminar_partida").modal('show');
                    });
                });
                $(".editar").click(function (){
                    var id_presupuesto_aut = $(this).attr('id');
                    $.get("/presupuesto_autorizado/modificar_presupesto_partida/"+id_presupuesto_aut,function (request) {
                        $("#contenedor_mod_partida").html(request);
                        $("#modal_mod_partida").modal('show');
                    });
                });
                $("#enviar_presupuesto").click(function (){
                    var id_partida = $("#id_partida").val();
                    if(id_partida == null){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona partida presupuestal",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else {
                        var enero_pres = $("#enero_pres").val();
                        if (enero_pres == '') {
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresa el presupuesto de enero",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        } else {
                            var febrero_pres = $("#febrero_pres").val();
                            if (febrero_pres == '') {
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa el presupuesto de febrero",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            } else {
                                var marzo_pres = $("#marzo_pres").val();
                                if (marzo_pres == '') {
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Ingresa el presupuesto de marzo",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                } else {
                                    var abril_pres = $("#abril_pres").val();
                                    if (abril_pres == '') {
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Ingresa el presupuesto de abril",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    } else {
                                        var mayo_pres = $("#mayo_pres").val();
                                        if (mayo_pres == '') {
                                            swal({
                                                position: "top",
                                                type: "error",
                                                title: "Ingresa el presupuesto de mayo",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        } else {
                                            var junio_pres = $("#junio_pres").val();
                                            if (junio_pres == '') {
                                                swal({
                                                    position: "top",
                                                    type: "error",
                                                    title: "Ingresa el presupuesto de junio",
                                                    showConfirmButton: false,
                                                    timer: 3500
                                                });
                                            } else {
                                                var julio_pres = $("#julio_pres").val();
                                                if (julio_pres == '') {
                                                    swal({
                                                        position: "top",
                                                        type: "error",
                                                        title: "Ingresa el presupuesto de julio",
                                                        showConfirmButton: false,
                                                        timer: 3500
                                                    });
                                                } else {
                                                    var agosto_pres = $("#agosto_pres").val();
                                                    if (agosto_pres == '') {
                                                        swal({
                                                            position: "top",
                                                            type: "error",
                                                            title: "Ingresa el presupuesto de agosto",
                                                            showConfirmButton: false,
                                                            timer: 3500
                                                        });
                                                    } else {
                                                        var septiembre_pres = $("#septiembre_pres").val();
                                                        if (septiembre_pres == '') {
                                                            swal({
                                                                position: "top",
                                                                type: "error",
                                                                title: "Ingresa el presupuesto de septiembre",
                                                                showConfirmButton: false,
                                                                timer: 3500
                                                            });
                                                        } else {
                                                            var octubre_pres = $("#octubre_pres").val();
                                                            if (octubre_pres == '') {
                                                                swal({
                                                                    position: "top",
                                                                    type: "error",
                                                                    title: "Ingresa el presupuesto de octubre",
                                                                    showConfirmButton: false,
                                                                    timer: 3500
                                                                });
                                                            } else {
                                                                var noviembre_pres = $("#noviembre_pres").val();
                                                                if (noviembre_pres == '') {
                                                                    swal({
                                                                        position: "top",
                                                                        type: "error",
                                                                        title: "Ingresa el presupuesto de noviembre",
                                                                        showConfirmButton: false,
                                                                        timer: 3500
                                                                    });
                                                                } else {
                                                                    var diciembre_pres = $("#diciembre_pres").val();
                                                                    if (diciembre_pres == '') {
                                                                        swal({
                                                                            position: "top",
                                                                            type: "error",
                                                                            title: "Ingresa el presupuesto de diciembre",
                                                                            showConfirmButton: false,
                                                                            timer: 3500
                                                                        });
                                                                    } else {
                                                                        $("#form_guardar_partida").submit();
                                                                        $("#enviar_presupuesto").attr("disabled", true);

                                                                    }

                                                                }

                                                            }

                                                        }

                                                    }

                                                }

                                            }

                                        }


                                    }

                                }

                            }

                        }
                    }
                });
                $("#enero_pres").change(function (event) {
                    var p_enero = event.target.value;
                    if (isNaN(p_enero)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_enero').empty();

                    } else {
                        var p_enero1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_enero);
                        $('#pesos_enero').empty();
                        $('#pesos_enero').append('<h2>' + p_enero1 + '</option>');
                    }
                });

                $("#febrero_pres").change(function (event) {
                    var p_febrero = event.target.value;
                    if (isNaN(p_febrero)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_febrero').empty();

                    } else {
                        var p_febrero1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_febrero);
                        $('#pesos_febrero').empty();
                        $('#pesos_febrero').append('<h2>' + p_febrero1+ '</option>');
                    }
                });

                $("#marzo_pres").change(function (event) {
                    var p_marzo = event.target.value;
                    if (isNaN(p_marzo)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_marzo').empty();

                    } else {
                        var p_marzo1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_marzo);
                        $('#pesos_marzo').empty();
                        $('#pesos_marzo').append('<h2>' + p_marzo1+ '</option>');
                    }
                });

                $("#abril_pres").change(function (event) {
                    var p_abril = event.target.value;
                    if (isNaN(p_abril)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_abril').empty();

                    } else {
                        var p_abril1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_abril);
                        $('#pesos_abril').empty();
                        $('#pesos_abril').append('<h2>' + p_abril1+ '</option>');
                    }
                });

                $("#mayo_pres").change(function (event) {
                    var p_mayo = event.target.value;
                    if (isNaN(p_mayo)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_mayo').empty();

                    } else {
                        var p_mayo1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_mayo);
                        $('#pesos_mayo').empty();
                        $('#pesos_mayo').append('<h2>' + p_mayo1+ '</option>');
                    }
                });

                $("#junio_pres").change(function (event) {
                    var p_junio = event.target.value;
                    if (isNaN(p_junio)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_junio').empty();

                    } else {
                        var p_junio1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_junio);
                        $('#pesos_junio').empty();
                        $('#pesos_junio').append('<h2>' + p_junio1+ '</option>');
                    }
                });

                $("#julio_pres").change(function (event) {
                    var p_julio = event.target.value;
                    if (isNaN(p_julio)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_julio').empty();

                    } else {
                        var p_julio1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_julio);
                        $('#pesos_julio').empty();
                        $('#pesos_julio').append('<h2>' + p_julio1+ '</option>');
                    }
                });

                $("#agosto_pres").change(function (event) {
                    var p_agosto = event.target.value;
                    if (isNaN(p_agosto)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_agosto').empty();

                    } else {
                        var p_agosto1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_agosto);
                        $('#pesos_agosto').empty();
                        $('#pesos_agosto').append('<h2>' + p_agosto1+ '</option>');
                    }
                });

                $("#septiembre_pres").change(function (event) {
                    var p_septiembre = event.target.value;
                    if (isNaN(p_septiembre)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_septiembre').empty();

                    } else {
                        var p_septiembre1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_septiembre);
                        $('#pesos_septiembre').empty();
                        $('#pesos_septiembre').append('<h2>' + p_septiembre1+ '</option>');
                    }
                });

                $("#octubre_pres").change(function (event) {
                    var p_octubre = event.target.value;
                    if (isNaN(p_octubre)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_octubre').empty();

                    } else {
                        var p_octubre1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_octubre);
                        $('#pesos_octubre').empty();
                        $('#pesos_octubre').append('<h2>' + p_octubre1+ '</option>');
                    }
                });

                $("#noviembre_pres").change(function (event) {
                    var p_noviembre = event.target.value;
                    if (isNaN(p_noviembre)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_noviembre').empty();

                    } else {
                        var p_noviembre1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_noviembre);
                        $('#pesos_noviembre').empty();
                        $('#pesos_noviembre').append('<h2>' + p_noviembre1+ '</option>');
                    }
                });

                $("#diciembre_pres").change(function (event) {
                    var p_diciembre = event.target.value;
                    if (isNaN(p_diciembre)) {
                        alert("el presupuesto debe ser un numero");
                        $('#pesos_diciembre').empty();

                    } else {
                        var p_diciembre1 = new Intl.NumberFormat("es-MX", {
                            style: "currency",
                            currency: "MXN"
                        }).format(p_diciembre);
                        $('#pesos_diciembre').empty();
                        $('#pesos_diciembre').append('<h2>' + p_diciembre1+ '</option>');
                    }
                });

                $("#guardar_mod_partida").click(function (){

                    var enero_pres = $("#enero_pres_mod").val();
                    if (enero_pres == '') {
                        swal({
                            position: "top",
                            type: "error",
                            title: "Ingresa el presupuesto de enero",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    } else {
                        var febrero_pres = $("#febrero_pres_mod").val();
                        if (febrero_pres == '') {
                            swal({
                                position: "top",
                                type: "error",
                                title: "Ingresa el presupuesto de febrero",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        } else {
                            var marzo_pres = $("#marzo_pres_mod").val();
                            if (marzo_pres == '') {
                                swal({
                                    position: "top",
                                    type: "error",
                                    title: "Ingresa el presupuesto de marzo",
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            } else {
                                var abril_pres = $("#abril_pres_mod").val();
                                if (abril_pres == '') {
                                    swal({
                                        position: "top",
                                        type: "error",
                                        title: "Ingresa el presupuesto de abril",
                                        showConfirmButton: false,
                                        timer: 3500
                                    });
                                } else {
                                    var mayo_pres = $("#mayo_pres_mod").val();
                                    if (mayo_pres == '') {
                                        swal({
                                            position: "top",
                                            type: "error",
                                            title: "Ingresa el presupuesto de mayo",
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    } else {
                                        var junio_pres = $("#junio_pres_mod").val();
                                        if (junio_pres == '') {
                                            swal({
                                                position: "top",
                                                type: "error",
                                                title: "Ingresa el presupuesto de junio",
                                                showConfirmButton: false,
                                                timer: 3500
                                            });
                                        } else {
                                            var julio_pres = $("#julio_pres_mod").val();
                                            if (julio_pres == '') {
                                                swal({
                                                    position: "top",
                                                    type: "error",
                                                    title: "Ingresa el presupuesto de julio",
                                                    showConfirmButton: false,
                                                    timer: 3500
                                                });
                                            } else {
                                                var agosto_pres = $("#agosto_pres_mod").val();
                                                if (agosto_pres == '') {
                                                    swal({
                                                        position: "top",
                                                        type: "error",
                                                        title: "Ingresa el presupuesto de agosto",
                                                        showConfirmButton: false,
                                                        timer: 3500
                                                    });
                                                } else {
                                                    var septiembre_pres = $("#septiembre_pres_mod").val();
                                                    if (septiembre_pres == '') {
                                                        swal({
                                                            position: "top",
                                                            type: "error",
                                                            title: "Ingresa el presupuesto de septiembre",
                                                            showConfirmButton: false,
                                                            timer: 3500
                                                        });
                                                    } else {
                                                        var octubre_pres = $("#octubre_pres_mod").val();
                                                        if (octubre_pres == '') {
                                                            swal({
                                                                position: "top",
                                                                type: "error",
                                                                title: "Ingresa el presupuesto de octubre",
                                                                showConfirmButton: false,
                                                                timer: 3500
                                                            });
                                                        } else {
                                                            var noviembre_pres = $("#noviembre_pres_mod").val();
                                                            if (noviembre_pres == '') {
                                                                swal({
                                                                    position: "top",
                                                                    type: "error",
                                                                    title: "Ingresa el presupuesto de noviembre",
                                                                    showConfirmButton: false,
                                                                    timer: 3500
                                                                });
                                                            } else {
                                                                var diciembre_pres = $("#diciembre_pres_mod").val();
                                                                if (diciembre_pres == '') {
                                                                    swal({
                                                                        position: "top",
                                                                        type: "error",
                                                                        title: "Ingresa el presupuesto de diciembre",
                                                                        showConfirmButton: false,
                                                                        timer: 3500
                                                                    });
                                                                } else {
                                                                    $("#form_guardar_partida_mod").submit();
                                                                    $("#guardar_mod_partida").attr("disabled", true);

                                                                }

                                                            }

                                                        }

                                                    }

                                                }

                                            }

                                        }
                                    }
                                }

                            }
                        }
                    }
                });


            });
        </script>



        @endsection