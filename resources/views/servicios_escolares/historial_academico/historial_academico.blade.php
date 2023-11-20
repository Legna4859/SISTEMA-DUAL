@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">HISTORIAL ACADÉMICO <br> {{$alumno}} </h3>
                    <h5 class="panel-title text-center"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    @if($calificada == 1)
                        <h3 class="panel-title text-center"><br>LAS MATERIAS DE ESTE PERIODO SE TOMARAN EN CUENTA PARA EL HISTORIAL ACADÉMICO.</h3>

                    @elseif($calificada == 2)
                        <h3 class="panel-title text-center"><br>LAS MATERIAS DE ESTE PERIODO NO SE  TOMARAN EN CUENTA PARA EL HISTORIAL ACADÉMICO.</h3>

                    @endif

                </div>
            </div>
        </div>
    </div>
    @if($suma_mat == 0)
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">No tiene materias</h3>
                        <h5 class="panel-title text-center"></h5>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-m2 col-md-offset-8">
                <button  class="btn btn-primary pdf_historial">Historial Academico</button>
              {{-- <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/servicios_escolares/historial_academico/pdf_historial_academico/'.$id_alumno)}}')">Historial academico</button>
           --}}
            </div>
            <br>
            <br>
        </div>
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">


                    <table class="table table-bordered " style="border: #1d1b2c;" >
                        <thead>
                        <tr class="info">
                            <th style="text-align: center">Sem.</th>
                            <th style="text-align: center">Clave</th>
                            <th style="text-align: center">Nombre materia</th>
                            <th style="text-align: center">Cr.</th>
                            <th style="text-align: center">Cal.</th>
                            <th style="text-align: center">Acr.</th>
                            <th style="text-align: center">Periodo</th>
                            <th style="text-align: center">Año</th>
                            <th style="text-align: center">Fec. Esp.</th>
                            <th style="text-align: center">Quitar materia duplicada</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($materias_actualizadas as $alumno)
                            <tr>
                                <td style="text-align: center">{{$alumno['id_semestre']}}</td>
                                <td style="text-align: center">{{$alumno['clave']}}</td>
                                <td style="text-align: center">{{$alumno['nombre_materia']}}</td>
                                <td style="text-align: center">{{$alumno['creditos']}}</td>
                               @if( $alumno['promedio'] < 70)
                                    <td style="text-align: center">N. A.</td>
                                   @else
                                    <td style="text-align: center">{{$alumno['promedio']}}</td>
                                   @endif


                                <td style="text-align: center">{{$alumno['esc']}}</td>
                                <td style="text-align: center">{{$alumno['periodo']}}</td>
                                <td style="text-align: center">{{$alumno['year']}}</td>
                                <td> </td>
                                @if( $alumno['promedio'] < 70)
                                    <td class="text-center"><input style="width: 7em" type="button" class="btn btn-danger quitar" data-id_carga="{{$alumno['id_carga_academica']}}"  data-nombre_materia="{{$alumno['nombre_materia']}}"  value="Eliminar"></td>

                                @else
                                    <td></td>
                               @endif

                            </tr>

                        @endforeach
                        @if($residencia ==0)
                            @else
                            <tr>
                                <td>9</td>
                                <td>RES-0001</td>
                                <td>RESIDENCIA PROFESIONAL</td>

                                @if($datos_residencia->calificacion< 70)
                                    <td>0</td>
                                    <td>N.A.</td>
                                @else
                                    <td>10</td>
                                <td>{{$datos_residencia->calificacion}}</td>
                                @endif
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php  //$fecha_r=$datos_residencia->fecha_termino;
                                $num=$datos_residencia->fecha_termino;
                                $year =substr($num, 0,4);
                                $mes =substr($num, 5,2);
                                $dia =substr($num, 8,2);
                                $fecha_r= $dia.'/'.$mes.'/'.$year;
                                ?>
                                <td>{{$fecha_r}} </td>

                            </tr>

                            @endif
                        @if($servicio ==0)
                        @else
                            <tr>
                                <td>9</td>
                                <td>SSC-0001</td>
                                <td>SERVICIO SOCIAL</td>

                                @if($datos_servicio->calificacion < 70)
                                    <td>0</td>
                                    <td>N.A.</td>
                                    @else
                                    <td>10</td>
                                <td>{{$datos_servicio->calificacion}}</td>
                                @endif
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php  //$fecha_s=$datos_servicio->fecha_termino;
                                $num=$datos_servicio->fecha_termino;
                                $year =substr($num, 0,4);
                                $mes =substr($num, 5,2);
                                $dia =substr($num, 8,2);
                                $fecha_s= $dia.'/'.$mes.'/'.$year;
                                ?>
                                <td>{{$fecha_s}} </td>

                            </tr>

                        @endif
                        @if($actividades ==0)
                        @else
                            <tr>
                                <td>9</td>
                                <td>ACC-0001</td>
                                <td>ACTIVIDADES COMPLEMENTARIAS</td>
                                <td>5</td>
                                <td>ACA</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                            </tr>

                        @endif

                        <tr>
                            <td colspan="3"  style="text-align: right; border: white">Totales:</td>
                            <td>{{$contar_creditos}}</td>
                            <td>{{$promedio_f}}</td>
                        </tr>

                        </tbody>
                    </table>
        </div>
    </div>



        @if($residencia ==0)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if($verifi_reg_ante == 0)
                        @if($verificar_periodo_residencia == 0)
                        <div class="alert alert-warning">
                            <strong>Atención !! </strong>El estudiante no tiene registro de residencia en sus cargas academicas
                        </div>
                       @else
                        <div class="alert alert-warning">
                            <strong>Atención !! </strong>El estudiante dio de alta su residencia en el o en los periodos:
                        @foreach($verificar_periodo_residencia as $per)
                            {{ $per->periodo }},
                        @endforeach
                            <input style="width: 7em" type="button" class="btn btn-primary calificar_residencia" data-id_carga="{{$id_alumno}}"   value="Calificar">
                        </div>
                        @endif

                @else
                    <div class="alert alert-warning">
                        <strong>Atención !! </strong><br> El estudiante esta en proceso de seguimiento de residencia en el periodo {{ $periodo_seguimiento }}
                    </div>
                @endif
            </div>
        </div>
        @endif
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            @if( $servicio ==0 || $actividades ==0 )
        <table class="table table-bordered " Style="background: white;">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Calificacion</th>
                <th>Estado</th>

            </tr>
            </thead>
            <tbody>

            @if($servicio ==0)
            <tr>
                <td> Servicio social</td>
                <td>0</td>
                <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary calificar_servicio" data-id_carga="{{$id_alumno}}"   value="Calificar"></td>
            </tr>
            @endif
            @if($actividades ==0)
            <tr>
                <td> Actividades complementarias</td>

                    <td>0</td>
                    <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary calificar_actividades" data-id_carga="{{$id_alumno}}"   value="Calificar"></td>



            </tr>
            @endif


            </tbody>
        </table>
            @endif
        </div>

    </div>
    @endif
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Materias eliminadas del historial </h3>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered " Style="background: white;">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Clave</th>
                        <th>Nombre de la materia</th>
                        <th>Semestre</th>
                        <th>Periodo</th>
                        <th>Nombre del periodo</th>
                        <th>Fecha que fue eliminada</th>
                        <th>Agregarla nuevamente al historial</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $num=0; ?>
                         @foreach($mat_eliminadas as $mat)
                             <?php $num++; ?>
                        <tr>
                            <td>{{$num}} </td>
                            <td>{{ $mat->clave }} </td>
                            <td>{{ $mat->nombre }} </td>
                            <td>{{ $mat->id_semestre }} </td>
                            <td>{{ $mat->id_periodo }} </td>
                            <td>{{ $mat->periodo }} </td>
                            <td>{{ $mat->fecha }} </td>
                            <td class="text-center"><input style="width: 7em" type="button" class="btn btn-primary agregar" data-id_carga="{{$mat->id_carga_academica}}"  data-nombre_materia="{{$mat->nombre}}"  value="Agregar "></td>

                        </tr>
                         @endforeach
                    </tbody>
                </table>
        </div>
    </div>

    <div id="modal_calificar_residencia" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-content" role="document">
            <div class="modal-content">
                <form  method="POST" role="form" action="{{url("/servicios_escolares/historial_academico/alumno/residencia/".$id_alumno)}}">
                    {{ csrf_field() }}
                <div class="modal-body">

                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2"><h3>Calificar Residencia</h3></div>
                        </div>
                    <div class="row" >
                        <div class="col-md-8 col-md-offset-2">
                            <label>Calificación</label>
                        <input class="form-control"  type="number" max="100" min="0" id="cal_residencia" name="cal_residencia"  required>
                        </div>

                    </div>
                    <div class="row" >
                        <div class="col-md-8 col-md-offset-2">
                            <label>Fecha de termino</label>
                            <input class="form-control datepicker"  type="text"  id="fecha_residencia" name="fecha_residencia"  placeholder="dd/MM/YYYY" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input  type="submit" class="btn btn-primary" value="Aceptar"></input>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_calificar_servicio" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <form  method="POST" role="form" action="{{url("/servicios_escolares/historial_academico/alumno/servicio_social/".$id_alumno)}}">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1"><h3>Calificar Servicio Social</h3></div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <label>Calificación</label>
                                <input class="form-control"  type="number" max="100" min="0" id="cal_servicio" name="cal_servicio"  required>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <label>Fecha de termino</label>
                                <input class="form-control datepicker"  type="text"  id="fecha_servicio" name="fecha_servicio"  placeholder="dd/MM/YYYY" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Aceptar"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_calificar_actividades" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <form  method="POST" role="form" action="{{url("/servicios_escolares/historial_academico/alumno/actividades/".$id_alumno)}}">
                {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1"><h3>Calificar Actividades complementarias</h3></div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <label>¿El alumno ya acredito las actividades complementarias? Si es correcto, dar clic en el boton aceptar</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Aceptar"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_pdf_historial" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <form  method="POST" role="form" action="window.open('{{url('/servicios_escolares/historial_academico/pdf_historial_academico/'.$id_alumno)}}')">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1"><h3>Historial Academico</h3></div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">Elige especialidad<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="especialidad" name="especialidad" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($especialidad as $especialidad)
                                            <option value="{{$especialidad->especialidad}}">{{$especialidad->especialidad}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-8 col-md-offset-2">
                                <div class="dropdown">
                                    <label for="exampleInputEmail1">Elige plan<b style="color:red; font-size:23px;">*</b></label>
                                    <select class="form-control  "placeholder="selecciona una Opcion" id="plan" name="plan" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($plan as $plan)
                                            <option value="{{$plan->plan}}">{{$plan->plan}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="button" class="btn btn-primary link_pdf" value="Aceptar"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_enviar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/servicios_escolares/historial_academico/alumno/eliminar/")}}" method="POST" role="form" >
                    <div class="modal-body">

                        {{ csrf_field() }}
                        ¿Realmente deseas quitar la materia  <input type="button" id="nombre_materia" name="nombre_materia" value=""> del historial academico?
                        <input type="hidden" id="id_carga_academica" name="id_carga_academica" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_agregar_nuevamente" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/servicios_escolares/historial_academico/alumno/agregar_nuevamente/")}}" method="POST" role="form" >
                    <div class="modal-body">

                        {{ csrf_field() }}
                        ¿Realmente deseas agregar nuevamente la materia  <input type="button" id="nombre_materia_l" name="nombre_materia_l" value=""> al historial academico?
                        <input type="hidden" id="id_carga_academica_l" name="id_carga_academica_l" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".link_pdf").click(function(event) {
                var especialidad = $("#especialidad").val();
                var plan = $("#plan").val();

                if (especialidad != null && plan != null) {


                    var link="/servicios_escolares/historial_academico/pdf_historial_academico/{{$id_alumno}}/"+plan+"/"+especialidad+"/{{$calificada}}";
                    window.open(link);
                    $('#modal_pdf_historial').modal('hide');


                } else {
                    swal({
                        position: "top",
                        type: "error",
                        title: "hay un campo vacio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
            $('#tablas_alumnos').DataTable();
            $(".pdf_historial").click(function(event) {

                $('#modal_pdf_historial').modal('show');
            });
            $(".calificar_residencia").click(function(event) {

                $('#modal_calificar_residencia').modal('show');
            });
            $(".calificar_servicio").click(function(event) {

                $('#modal_calificar_servicio').modal('show');
            });
            $(".calificar_actividades").click(function(event) {

                $('#modal_calificar_actividades').modal('show');
            });
            $('#fecha_servicio').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: +0,
            });
            $('#fecha_residencia').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: +0,
            });
            $(".quitar").click(function(event) {

                var id_carga_academica=$(this).data("id_carga");
                var nombre_materia=$(this).data("nombre_materia");

                $('#id_carga_academica').val(id_carga_academica);
                $('#nombre_materia').val(nombre_materia);
                $('#modal_enviar').modal('show');
            });

            $(".agregar").click(function(event) {

                var id_carga_academica=$(this).data("id_carga");
                var nombre_materia=$(this).data("nombre_materia");
                $('#id_carga_academica_l').val(id_carga_academica);
                $('#nombre_materia_l').val(nombre_materia);
                $('#modal_agregar_nuevamente').modal('show');
            });
        });

    </script>
@endsection