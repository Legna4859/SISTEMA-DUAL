@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <p>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                    <a href="{{url("/titulacion/consultar_fecha_dia_relacion_doc/".$fecha)}}">RELACIÓN DE DOCUMENTOS </a>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span>RELACIÓN DE MENCIÓN HONORIFICA</span>
                </p>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">RELACIÓN DE MENCIÓN HONORIFICA</h3>
                        <h2 class="panel-title text-center">Dia: {{ $fecha_solicitada }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @if($estado_reg == 0)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <h4 style="text-align: center">Registrar número de oficio de la relación de mención honorífica</h4>

                            <div class="row">
                                <form id="form_guardar_relacion_mencion" class="form" action="{{url("/titulacion/registrar_num_relac_mencion/")}}" role="form" method="POST" >
                                    {{ csrf_field() }}
                                    <div class="col-md-8  col-md-offset-1">
                                        <div class="form-group">
                                            <label for="numero_acta_titulación">Número de oficio de la relación mención honorífica</label>
                                            <input class="form-control"   type="hidden"  id="fecha_titulacion" name="fecha_titulacion"  value="{{ $fecha }}"  required>

                                            <input class="form-control"   type="text"  id="numero_relacion_mencion_honorifica" name="numero_relacion_mencion_honorifica" onkeyup="javascript:this.value=this.value.toUpperCase();"   value=""  required>

                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-2">
                                    <p></p>
                                    <p></p>
                                    <button type="button " class="btn btn-primary btn-lg" id="guardar_relacion_mencion_honorifica" >Guardar</button>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($estado_reg == 1)
            @if($consultar_reg->id_estado == 0)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 style="text-align: center">Editar número de oficio de la relación de mención honorífica</h4>

                                <div class="row">
                                    <form id="form_editar_relacion_mencion_honorifica" class="form" action="{{url("/titulacion/editar_num_relac_mencion_honorifica/")}}" role="form" method="POST" >
                                        {{ csrf_field() }}
                                        <div class="col-md-8  col-md-offset-1">
                                            <div class="form-group">
                                                <label for="numero_mencion_honorifica">Número de oficio de la relación de actas de titulación</label>
                                                <input class="form-control"   type="hidden"  id="id_relacion_mencion_honorifica" name="id_relacion_mencion_honorifica"  value="{{ $consultar_reg->id_relacion_mencion_honorifica }}"  required>

                                                <input class="form-control"   type="text"  id="numero_mencion_honorifica1" name="numero_mencion_honorifica1" onkeyup="javascript:this.value=this.value.toUpperCase();"   value="{{ $consultar_reg->numero_oficio }}"  required>

                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-2">
                                        <p></p>
                                        <p></p>
                                        <button type="button " class="btn btn-primary " id="editar_relacion_mencion_honorifica" >Editar</button>

                                    </div>
                                    <div class="col-md-2">
                                        <p></p>
                                        <p></p>
                                        <button type="button " class="btn btn-success " id="autorizar" >Autorizar</button>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_autorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form  class="form" action="{{url("/titulacion/autorizar_num_relac_mencion_honorifica/$consultar_reg->id_relacion_mencion_honorifica")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                                <div class="modal-header bg-info">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title text-center" id="myModalLabel">Autorizacion de datos del estudiante</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <h4>¿ Seguro que quiere autorizar número de oficio de la relación de mención honorífica?</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button   type="submit" style="" class="btn btn-primary"  >Aceptar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if($consultar_reg->id_estado == 1)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 style="text-align: center">Número de oficio de la relación de actas de titulación</h4>
                                <h2 style="text-align: center">{{ $consultar_reg->numero_oficio }}</h2>
                                <p style="text-align: center"><button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/relacion_pdf_mencion_honorifica/'.$consultar_reg->id_relacion_mencion_honorifica)}}')">Imprimir oficio </button></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @endif


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: center">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>NÚMERO DE CUENTA</th>
                                <th>CARRERA</th>
                                <th>NOMBRE DEL EGRESADO TITULADO</th>
                                <th>FECHA TITULACIÓN</th>
                                <th>NO. DE REGISTRO DE MENCIÓN HONORIFICA</th>
                                <th>LIBRO DE REGISTRO DE MENCIÓN HONORIFICA</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($alumnos as $alumnos)
                                <tr>
                                    <td>{{ $alumnos->no_cuenta }}</td>
                                    <td>{{ $alumnos->carrera }}</td>
                                    <td>{{ $alumnos->nombre_al }} {{ $alumnos->apaterno }} {{ $alumnos->amaterno }}</td>
                                    <td>{{ $fecha }}</td>
                                    <td>{{ $alumnos->no_registro }}</td>
                                    <td>{{ $alumnos->libro_registro }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script type="text/javascript">
        $(document).ready( function() {
            $('#fecha_dia').datepicker({
                daysOfWeekDisabled: [0,6],
                autoclose: true,
                language: 'es',

            });

            $("#ver_consulta_fecha").click(function (){

                var fecha_dia=$("#fecha_dia1").val();
                var fecha_dia = fecha_dia.split("/").reverse().join("-");
                var fecha_dia = fecha_dia.split("-").reverse().join("-");

                window.location.href='/titulacion/consultar_fecha_dia_relacion_doc/'+fecha_dia ;

            });
            $("#ver_consulta_fecha2").click(function (){

                var fecha_dia=$("#fecha_dia2").val();
                var fecha_dia = fecha_dia.split("/").reverse().join("-");
                var fecha_dia = fecha_dia.split("-").reverse().join("-");

                window.location.href='/titulacion/consultar_fecha_dia_relacion_doc/'+fecha_dia ;

            });
            $("#guardar_relacion_mencion_honorifica").click(function (){
                var numero_relacion_mencion_honorifica=$("#numero_relacion_mencion_honorifica").val();
                if(numero_relacion_mencion_honorifica != ''){
                    $("#guardar_relacion_mencion_honorifica").attr("disabled", true);
                    $("#form_guardar_relacion_mencion").submit();

                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else {

                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa número de oficio de la relación de mención honorífica",
                        showConfirmButton: false,
                        timer: 3500
                    });

                }
            });
            $("#editar_relacion_mencion_honorifica").click(function (){
                var numero_mencion_honorifica=$("#numero_mencion_honorifica1").val();
                if(numero_mencion_honorifica != ''){
                    $("#editar_relacion_mencion_honorifica").attr("disabled", true);
                    $("#form_editar_relacion_mencion_honorifica").submit();

                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else {

                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa número de oficio de la relación de mención honorífica",
                        showConfirmButton: false,
                        timer: 3500
                    });

                }
            });
        });
        $("#autorizar").click(function (){
            $("#modal_autorizacion").modal('show');

        });


    </script>



@endsection