@extends('layouts.app')
@section('title', 'Titulación')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/titulacion/autorizar_titulacion_alumnos/$alumno->id_carrera")}}">Estudiantes para registar datos</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Autorizar titulación del estudiante</span>

            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title text-center">Autorizar titulación del estudiante<br>
                        No. cuenta: {{ $alumno->cuenta }} <br>
                        Nombre del estudiante: {{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}<br>
                        Nombre de la carrera: {{ $alumno->carrera }}<br>
                        Fecha de titulaccion: {{ $alumno->fecha_titulacion }}

                    </h2>

                </div>
            </div>
        </div>
    </div>

   <div class="row">
       <div class="col-md-4 col-md-offset-4">
           <div class="panel panel-default">
               <div class="panel-heading"style="text-align: center">
           <button type="button" id="autorizar_titulacion" class="btn btn-success btn-lg" >Autorizar titulación</button>
               </div>
           </div>
       </div>
   </div>
    <div class="modal fade" id="modal_autorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form  class="form" action="{{url("/titulacion/guardar_autorizacion_titulacion/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Autorizacion de la titulación del estudiante</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <input class="form-control"   type="hidden"  id="id_alumno" name="id_alumno" value="{{ $alumno->id_alumno }}"    required>
                                <input class="form-control"   type="hidden"  id="mencion_honorifica" name="mencion_honorifica" value="{{ $alumno->men_honorifica }}"    required>

                                <input class="form-control"   type="hidden"  id="numero_mencion_honorifica" name="numero_mencion_honorifica" value="{{ $numero_mencion_honorifica }}"    required>
                                <input class="form-control"   type="hidden"  id="libro_mencion_honorifica" name="libro_mencion_honorifica" value="{{ $libro_mencion_honorifica }}"    required>

                                <input class="form-control"   type="hidden"  id="numero_foja_titulo" name="numero_foja_titulo" value="{{ $numero_foja_titulo }}"    required>
                                <input class="form-control"   type="hidden"  id="numero_libro_titulo" name="numero_libro_titulo" value="{{ $numero_libro_titulo }}"    required>

                                <input class="form-control"   type="hidden"  id="num_acta" name="num_acta" value="{{ $num_acta }}"    required>
                                <input class="form-control"   type="hidden"  id="numero_libro_acta_titulacion" name="numero_libro_acta_titulacion" value="{{ $numero_libro_acta_titulacion }}"    required>
                                <input class="form-control"   type="hidden"  id="foja_acta_titulacion" name="foja_acta_titulacion" value="{{ $foja_acta_titulacion }}"    required>

                                <h4>¿ Seguro que quieres autorizar la titulación del estudiante?</h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button   type="submit" id="autorizacionaceptada" style="" class="btn btn-primary"  >Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#autorizar_titulacion").click(function () {



                    $("#modal_autorizacion").modal('show');


            });
            $("#autorizacionaceptada").click(function (){
                $("#autorizacionaceptada").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Autorización exitosa",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
    </script>
@endsection