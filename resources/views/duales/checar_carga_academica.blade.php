@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
    <?php
    $ver_carga=session()->has('ver_carga')?session()->has('ver_carga'):false;
    $escolar = session()->has('escolar') ? session()->has('escolar') : false;
    $jefe_division = session()->has('jefe_division') ? session()->has('jefe_division') : false;

    ?>

    <main>
        {{--  autorizar semestre al estudiante--}}
        <div class="modal fade" id="modal_autorizar_estudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Autorizar registro del estudiante</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_autorizar_estudiante">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="guardar_autorizar_estudiante"  class="btn btn-primary" >Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  actualizar semestre al estudiante--}}
        <div class="modal fade" id="modal_actualizar_estudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar registro del estudiante</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_actualizar_estudiante">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="guardar_actualizar_estudiante"  class="btn btn-primary" >Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">VER CARGA ACADEMICA</h3>
                    </div>
                </div>
            </div>
        </div>
        @if($usuario == 1)
            @if( $validaciones[0]->estado_validacion==3)
                <div class=" col-md-5 col-md-offset-3">
                    <label class=" alert alert-danger"  data-toggle="tab" >{{ $validaciones[0]->descripcion }}</label>
                </div>
            @endif
            @if($validaciones[0]->estado_validacion==0 || $validaciones[0]->estado_validacion==3)
                @if($creditoss == 1)
                    <div class=" col-md-5 col-md-offset-3">
                        <label class=" alert alert-danger"  data-toggle="tab" >El maximo  de creditos es de 38, verifica tu carga academica, gracias.</label>
                    </div>
                @endif
                @if($creditoss == 2)
                    <div class=" col-md-5 col-md-offset-3">
                        <label class=" alert alert-danger"  data-toggle="tab" >El minimo de creditos  de creditos es de 22, verifica  tu carga academica  para poder ser enviada, gracias.</label>
                    </div>
                @endif
                @if($creditoss == 4)
                    <div class=" col-md-5 col-md-offset-3">
                        <label class=" alert alert-danger"  data-toggle="tab" >El maximo  de creditos con una materia en especial es de 24 creditos, debes modificar tu carga académica  para poder ser enviada, gracias.</label>
                    </div>
                @endif
                @if($creditoss == 5)
                    <div class=" col-md-5 col-md-offset-3">
                        <label class=" alert alert-danger"  data-toggle="tab" >Solamente puedes dar de alta dos especiales o menos, debes modificar tu carga académica  para poder ser enviada, gracias.</label>
                    </div>
                @endif
                @if($creditoss == 6)
                    <div class=" col-md-5 col-md-offset-3">
                        <label class=" alert alert-danger"  data-toggle="tab" >Solamente puedes dar de alta las dos especiales, debes modificar tu carga académica  para poder ser enviada, gracias.</label>
                    </div>
                @endif
            @endif
        @endif
        @if($usuario == 2)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-primary">
                        <h4 style="text-align: center;">{{ $cuenta_y_nom }}</h4>

                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            @if($usuario==2)
                @if($validaciones[0]->estado_validacion==0 || $validaciones[0]->estado_validacion==3)

                    @if($adeudo == 0)
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">No tiene adeudo</h3>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title text-center">Tiene adeudo con los siguientes departamentos o carreras:</h3><br>
                                    @foreach($departamento_carrera as $departamento_carrera)
                                        <p style="text-align: center">{{$departamento_carrera['nombre']}}:- {{$departamento_carrera['comentario']}}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($jefe_division == true)
                        @if($estado_sem_act == 0)
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <form  id="form_guardar_semestre" action="{{url("/servicios_escolares/guardar_semestre_al/".$alumno."/2")}}" role="form" method="POST" enctype="multipart/form-data" >
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <div class="dropdown">
                                                            <label for="exampleInputEmail1">Selecciona periodo que ingreso el estudiante al TESVB</label>
                                                            <select class="form-control  "placeholder="selecciona una Opcion" id="id_periodo" name="id_periodo" required>
                                                                <option disabled selected hidden>Selecciona una opción</option>
                                                                @foreach($periodos as $periodo)
                                                                    <option value="{{$periodo->id_periodo}}" data-esta="{{$periodo->periodo }}">{{ $periodo->periodo }} </option>
                                                                @endforeach
                                                            </select>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <div class="dropdown">
                                                            <label for="exampleInputEmail1">Selecciona semestre que ingreso el estudiante al TESVB</label>
                                                            <select class="form-control  "placeholder="selecciona una Opcion" id="id_semestre" name="id_semestre" required>
                                                                <option disabled selected hidden>Selecciona una opción</option>
                                                                @foreach($semestres as $semestre)
                                                                    <option value="{{$semestre->id_semestre}}" data-esta="{{$semestre->descripcion }}">{{ $semestre->descripcion }} </option>
                                                                @endforeach
                                                            </select>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>

                                            </form>
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-5">
                                                    <button id="guardar_agregar_semestre"  class="btn btn-primary" >Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            @if($datos_actu->id_estado_rev == 2)
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="panel panel-primary">
                                            <div class="panel-body">
                                                <h4>Periodo que ingreso el estudiante al TESVB: <b>{{ $datos_actu->periodo }}</b></h4>
                                                <h4>Semestre que ingreso el estudiante al TESVB: <b>{{ $datos_actu->semestre }}</b></h4>
                                                <p style="text-align: right"><button class="btn btn-success autorizar_semestre" id="{{ $datos_actu->id_semestres_al }}">Autorizar </button>     <button class="btn btn-primary editar_semestre" id="{{ $datos_actu->id_semestres_al }}"><span class="glyphicon glyphicon-cog em" aria-hidden="true" ></span></button></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($datos_actu->id_estado_rev == 1)

                                <form class="form-horizontal" role="form" method="POST" action="/duales/validacion_de_carga/ {{ $id }}" novalidate id="formupdate">
                                    <input type="hidden" name="_method" value="PUT" />
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div  class=" col-md-4  col-md-offset-4 alert alert-success" >
                                            <p style="text-align: center"><label class="radio-inline"><input type="radio" id="optradio1" name="optradio" value="1" >Autorizar</label>
                                            </p>
                                            <p>
                                                <input type="hidden" id="estado" name="estado" value="2">
                                            </p>
                                            <p style="text-align: center">
                                                <button  class="btn btn-primary" id="aceptar">Aceptar</button>
                                            </p>
                                        </div>
                                    </div>
                                </form>

                            @endif
                        @endif
                    @endif
                @endif
                <div class="row">


                    @if($validaciones[0]->estado_validacion==0)
                        @if($creditoss == 3)
                            <div class=" col-md-5 col-md-offset-3">
                                <label class=" alert alert-success"  data-toggle="tab" >Tu carga académica se creo correctamente, verifica si tus materias son las que tomarás en el semestre, si es asi, dar clic en enviar.</label>
                            </div>
                        @endif

                        @if($creditoss == 5)
                            <div class=" col-md-5 col-md-offset-3">
                                <label class=" alert alert-success"  data-toggle="tab" >Tu carga académica se creo correctamente, verifica si tus materias son las que tomarás en el semestre, si es asi, dar clic en enviar.</label>
                            </div>
                        @endif
                    @endif
                    @endif
                </div>
                @if($usuario == 1)
                    @if($validaciones[0]->estado_validacion==0)

                        <div class="row">
                            <div  class=" col-md-4  col-md-offset-4 alert alert-success" >
                                <strong>La carga académica se envió correctamente, está en proceso de revisión por la Subdirección de Servicios Escolares, una vez aprobada podrás imprimirla.<br></strong>

                                <p style="text-align: center">
                                    <button type="button" class="btn btn-default" disabled>
                                        <span class="glyphicon glyphicon-print em"  aria-hidden="true" ></span>
                                    </button>
                                </p>
                            </div>
                        </div>
                    @elseif($validaciones[0]->estado_validacion==2 || $validaciones[0]->estado_validacion==8 || $validaciones[0]->estado_validacion==9)
                        <div>
                            <div  class=" col-md-3 col-md-offset-4  alert alert-success" id="notificciones" style="">
                                <p style="text-align: center">
                                    <strong>Carga Academica Aceptada</strong>
                                </p>
                                <p  style="text-align: center">
                                    <a href="/duales/imprime_carga" target="_blank"><span class="glyphicon glyphicon-print em"  aria-hidden="true"></span></a>
                                </p>
                                <p style="text-align: center">
                                    <a href="/duales/imprime_carga"><strong >Imprimir</strong></a>
                                </p>
                            </div>
                        </div>
                    @endif
                @endif
                @if($usuario == 2)
                    @if($ls == 2 || $ls == 8 || $ls == 9 )

                        <div  class=" col-md-3 col-md-offset-4  alert alert-success" id="notificciones" style="">
                            <p style="text-align: center">
                                <strong>Carga Academica Aceptada</strong>
                            </p>
                            <p  style="text-align: center">
                                <a href="/duales/imprime_control/{{$id}}" target="_blank"><span class="glyphicon glyphicon-print em"  aria-hidden="true"></span></a>
                            </p>
                            <p style="text-align: center">
                                <a href="/duales/imprime_control/{{$id}}"><strong >Imprimir</strong></a>
                            </p>
                        </div>
                    @endif
                @endif
        </div>


        <div class="row">
            <div class=" col-md-10 col-md-offset-1">
                <table class="table table-bordered " Style="background: white;">
                    <thead>
                    <tr class="info">
                        <th style="text-align: center">CLAVE DE LA MATERIA</th>
                        <th style="text-align: center">NOMBRE DE LA MATERIA</th>
                        <th style="text-align: center">CREDITOS</th>
                        <th style="text-align: center">STATUS</th>
                        <th style="text-align: center">TIPO CURSA</th>
                        <th style="text-align: center">GRUPO</th>
                        @if($validaciones[0]->estado_validacion==0 || $validaciones[0]->estado_validacion==3  || $validaciones[0]->estado_validacion==4)
                            <th style="text-align: center" >ELIMINAR</th>
                            <th style="text-align: center" >MODIFICAR</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos_carga as$consulta1)
                        @if($consulta1['id_materia'] == 2258)
                            <tr>
                                <th></th>
                                <th style="text-align: center">{{$consulta1['clave']}}</th>
                                <td style="text-align: center">{{$consulta1['nombre']}}</td>
                                <td></td>
                                <td style="text-align: center">ALTA</td>
                                <td></td>
                                <td></td>

                                @if($validaciones[0]->estado_validacion==0 || $validaciones[0]->estado_validacion==3 || $validaciones[0]->estado_validacion==4)
                                    <th style="text-align: center">
                                        <a class="elimina" data-id_carga_academica="{{$consulta1['id_carga_academica']}}" >
                                            <span class="glyphicon glyphicon-trash em" aria-hidden="true" ></span>
                                        </a>
                                    </th
                                @endif
                            </tr>
                        @else
                            <tr>
                                <th style="text-align: center">{{$consulta1['clave']}}</th>
                                <td style="text-align: center">{{$consulta1['nombre']}}</td>
                                <td style="text-align: center">{{$consulta1['creditos']}}</td>
                                <td style="text-align: center">{{$consulta1['nombre_status']}}</td>
                                <td style="text-align: center">{{$consulta1['nombre_curso']}}</td>
                                <td style="text-align: center">{{$consulta1['id_semestre']}}0{{$consulta1['grupo']}}</td>

                                @if($validaciones[0]->estado_validacion==0 || $validaciones[0]->estado_validacion==3 || $validaciones[0]->estado_validacion==4)
                                    <th style="text-align: center">
                                        <a class="elimina" data-id_carga_academica="{{$consulta1['id_carga_academica']}}" >
                                            <span class="glyphicon glyphicon-trash em" aria-hidden="true"  style="color:crimson;"></span>
                                        </a>
                                    </th>
                                    <th style="text-align: center">
                                        <a href="/duales/checar_carga_academica/{{$consulta1['id_carga_academica']}}/edit" >
                                            <span class="glyphicon glyphicon-cog em" aria-hidden="true" style="color: darkgreen;"></span>
                                        </a>
                                    </th>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <th></th>
                        <th></th>
                        <td style="text-align: center"><b>Total de creditos:</b></td>
                        <td style="text-align: center">{{$suma}}</td>
                        <td></td>
                        @if($validaciones[0]->estado_validacion==0 || $validaciones[0]->estado_validacion==3 || $validaciones[0]->estado_validacion==4)
                            <td></td>
                            <td></td>
                        @endif
                        @if($usuario==2)
                            <td ></td>
                            <td></td>
                        @else
                            @if($ver_carga==false)
                                <td></td>
                                <td></td>
                            @endif
                        @endif


                    </tr>



                    </tbody>
                </table>


            </div>
        </div>
        @if($validaciones[0]->estado_validacion==0  || $validaciones[0]->estado_validacion==3 || $validaciones[0]->estado_validacion==4)
            @if($usuario == 1)
                @if($creditoss == 3 || $creditoss == 7 )
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">

                            <div class="text-center">
                                <button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location='{{ url('/duales/enviar_carga/'. $id_alu ) }}'" title="Enviar">Enviar</button>
                            </div>

                        </div>
                    </div>
                @endif
                @if($creditoss == 1 || $creditoss == 2 || $creditoss == 4 || $creditoss == 5 || $creditoss == 6)
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">

                            <div class="text-center">
                                <button type="button" class="btn btn-success btn-lg btn-block"  title="Enviar" disabled>Enviar</button>
                            </div>

                        </div>
                    </div>
                    @endif
                    @endif
                    @endif

                    </div>

                    <div id="modal_elimina" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="" method="POST" role="form" id="form_delete">
                                        {{method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="id_carga_academica" name="id_carga_academica" value="">
                                        ¿Realmente deseas eliminar éste elemento?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <input id="confirma_elimina" type="button" class="btn btn-danger" value="Aceptar"></input>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
    </main>

    <script>
        $(document).ready(function(){
            $(".elimina").click(function(){
                var id_carga_academica=$(this).data('id_carga_academica');
                //alert(id_carga_academica);
                $('#id_carga_academica').val(id_carga_academica);
                $('#modal_elimina').modal('show');
            });
            $(".editar_semestre").click(function(){
                var id_semestres_al=$(this).attr('id');
                $.get("/servicios_escolares/actualizar_semestre_al/"+id_semestres_al,function (request) {
                    $("#contenedor_actualizar_estudiante").html(request);
                    $("#modal_actualizar_estudiante").modal('show');
                });
            });
            $(".autorizar_semestre").click(function (){
                var id_semestres_al=$(this).attr('id');
                $.get("/servicios_escolares/autorizar_semestre_al/"+id_semestres_al,function (request) {
                    $("#contenedor_autorizar_estudiante").html(request);
                    $("#modal_autorizar_estudiante").modal('show');
                });
            });
            $("#aceptar").click(function(event){
                $("#formupdate").submit();
            });
            $("#formupdate").validate({
                rules: {
                    optradio: {
                        required: true,
                    },
                },
            });

            $("#confirma_elimina").click(function(event){
                var id_carga_academica = $("#id_carga_academica").val()
                //alert(id_carga_academica);
                $("#form_delete").attr("action","/duales/eliminar_carga_academica/"+id_carga_academica)
                $("#form_delete").submit();
            });
            $("#optradio1").change(function() {
                var validez=$(this).val();
                $("#observacion").css("display", "none");
                $("#status").css("display", "inline");
            });
            $("#optradio2").change(function() {
                var validez=$(this).val();
                $("#observacion").css("display", "inline");
                $("#status").css("display", "none");
            });
            $("#guardar_actualizar_estudiante").click(function (){
                $("#form_guardar_mod_semestre").submit();
                $("#guardar_actualizar_estudiante").attr("disabled", true);
            });
            $("#guardar_autorizar_estudiante").click(function (){
                $("#form_autorizar_semestre").submit();
                $("#guardar_autorizar_estudiante").attr("disabled", true);
            });
            $("#guardar_agregar_semestre").click(function (){
                var id_periodo = $("#id_periodo").val();
                if(id_periodo != null){
                    var id_semestre = $("#id_semestre").val();
                    if(id_semestre != null){
                        $("#form_guardar_semestre").submit();
                        $("#guardar_agregar_semestre").attr("disabled", true);
                        swal({
                            position: "top",
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }else{
                        swal({
                            position:"top",
                            type: "error",
                            title: "Selecciona semestre que ingreso",
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }else{
                    swal({
                        position:"top",
                        type: "error",
                        title: "Selecciona periodo que ingreso el estudiante",
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });

        });
    </script>

@endsection