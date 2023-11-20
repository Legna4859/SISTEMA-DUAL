@extends('layouts.app')
@section('title', 'Servicio Social')
@section('content')
    <main>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Carta de Presentación-Aceptación</h3>
                    </div>
                </div>
            </div>

            <div class="row col-md-11 col-md-offset-1">
                <ul class="nav nav-tabs">
                    <li><a href="{{ url('/servicio_social/ingresar_contancia/departamento/' ) }}" >Enviar Carta de Presentación</a></li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_modificacion_cartapresentacion/departamento/' ) }}" >En proceso de Modificación</a>
                    </li>
                    <li>
                        <a href="{{ url('/servicio_social/proceso_revicion_cartapresentacion/departamento/' ) }}" >Estudiantes para Revisión Carta P.</a>
                    </li>
                    <li class="active"><a href="#">Cartas de presentación Autorizadas</a>
                    </li>



                </ul>

                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="uno">

                        <div class=" col-md-12 ">
                            </br>
                            <button   class="btn btn-success  ver_datos_excel">Exportar datos</button>
                            </br><p></p>

                            <table class="table table-bordered " Style="background: white;" id="tabla_revicion_costancia">
                                <thead>
                                <tr>
                                    <th>No. CUENTA</th>
                                    <th>NOMBRE DE ALUMNO(A)</th>
                                    <th>CARRERA</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>NOMBRE DEL PERIODO</th>
                                    <th>VER</th>



                                </tr>
                                </thead>
                                <tbody>

                                @foreach($alumnos as $alumno)
                                    <tr>
                                        <th>{{$alumno["cuenta"]}}</th>
                                        <td>{{$alumno["nombre"]}} </td>
                                        <td>{{$alumno["carrera"]}}</td>
                                        <td>{{$alumno["correo_electronico"]}}</td>
                                        <td>{{$alumno["nombre_periodo"]}}</td>
                                        <td><a target="_blank" href="{{asset('/servicio_social_pdf/carta_presentacion/'.$alumno["pdf_constancia_presentacion"])}}"> <i class="glyphicon glyphicon glyphicon-file"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>

        </div>
        <div class="modal fade" id="modal_seleccion_periodo" role="dialog">

            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="POST" id="form_autorizar" action="{{ url("/servicio_social/exportar_datos_servicio_social") }}">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Seleccionar periodo para exportar datos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <label for="nombre_proyecto">Seleccionar el Periodo<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control" id="id_periodo" name="id_periodo" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($periodos as $periodos)
                                            <option value="{{$periodos->id_periodo}}"> {{$periodos->periodo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                $('#tabla_revicion_costancia').DataTable();
                $(".ver_datos_excel").click(function (event) {
                    $("#modal_seleccion_periodo").modal('show');
                });


            });
        </script>

    </main>

@endsection