@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Carga academica ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Llenar Carga Academica Ingles</h3>
                    </div>
                </div>
            </div>
        </div>

        {{--Si no ha subido voucher de pago--}}
        @if($id_estado_valida_voucher==0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Aún no has subido tu voucher de pago, dirígete al apartado de "Cargar voucher de pago" para subirlo y poder continuar</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{--Si ya ha subido baucher de pago y esta en proceso de validacion--}}
        @elseif($id_estado_valida_voucher==1)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tu voucher se encuentra en proceso de validación por el moderador, porfavor espera la respuesta de aceptación</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{--Si su baucher fue aceptado ya lo deja realizar su carga--}}
        @elseif($id_estado_valida_voucher==2)
            <div class="panel-body">
                @if($disponibilidad == 0)
                    @if($contar_disponibilidad == 0)
                        <div class="row">

                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">No hay  grupos en este periodo, verificar con el JEFE(A) DEL DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($contar_disponibilidad == 1)
                        <div class="row">

                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">Verifica si el periodo que seleccionaste es correcto.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($contar_disponibilidad == 3)
                        <div class="row">

                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">No hay  grupos en este periodo del nivel que debes seleccionar, verificar con el JEFE(A) DEL DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($contar_disponibilidad == 4)
                        <div class="row">

                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">Ya no puedes dar de alta tu carga academica, reprobaste el nivel en estado GLOBAL , verificar con el JEFE(A) DEL DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if($enviado == 1)
                            <div class="row">

                                <div class="col-md-6 col-md-offset-3">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <h3 class="panel-title text-center">Ya enviaste tu carga academica de ingles, verifica en el menu en ver carga academica de ingles</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-2 col-md-offset-4">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="nivel_ingles">Niveles disponibles</label>
                                            <select name="id_niveles" id="id_niveles" class="form-control " required>
                                                <option disabled selected hidden>Selecciona una opción</option>
                                                @foreach($niveles as $nivel)
                                                    <option value="{{$nivel->id_nivel}}"> {{$nivel->descripcion}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2  "  id="grupo_ingles" style="display: none;">
                                    <div class="dropdown" >
                                        <label for="exampleInputEmail1">Grupos</label>
                                        <select class="form-control  "placeholder="selecciona una Opcion" id="grupos" name="grupos" value="" required>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @elseif($disponibilidad=1)
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4  "id="niveles_ingles">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Niveles</label>
                                <select name="id_niveles" id="id_niveles" class="form-control " required>
                                    @foreach($niveles as $nivel)
                                        @if($nivel->id_nivel==$id_nivel)
                                            <option value="{{$id_nivel}}" selected="selected">{{ $nivel->descripcion }}</option>
                                        @else
                                            <option value="{{$nivel->id_nivel}}" >{{ $nivel->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 " id="grupo_ingles">
                            <div class="dropdown" >
                                <label for="exampleInputEmail1">Grupos</label>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="grupos" name="grupos" value="" required>
                                    @foreach($grupos as $grupo)
                                        @if($grupo->id_hrs_ingles_profesor==$id_hrs_niveles_grupo)
                                            <option value="{{$id_hrs_niveles_grupo}}" selected="selected">{{ $grupo->id_grupo }}</option>
                                        @else
                                            <option value="{{$grupo->id_hrs_ingles_profesor}}" >{{ $grupo->id_grupo }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($registrado == 0)
                            <div class="col-md-2 ">
                                <br>
                                <button type="button" class="btn btn-primary envia1" id="{{$id_hrs_niveles_grupo}}"  ><i class="glyphicon glyphicon-ok em2"></i></button>
                            </div>
                        @else
                            <div class="col-md-2 ">
                                <br>
                                <button type="button" class="btn btn-primary envia2" id="{{$id_hrs_niveles_grupo}}"><i class="glyphicon glyphicon-ok em2"></i></button>
                            </div>
                        @endif
                    </div>

                    <div class="row" id="consultar">
                        <div class="col-md-8 col-md-offset-2">
                            <br><br>

                            <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                                <thead>
                                <tr>
                                    <th>Hora/Día</th>
                                    <th>Lunes </th>
                                    <th>Martes</th>
                                    <th>Miercoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sabado</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $contador=1 ?>

                                @foreach($semanas as $semana)
                                    @if($contador==1)
                                        <tr>
                                            <td class="horario">{{ $semana->hora }}</td>
                                            @endif
                                            <td id="{{ $semana->id_semana }}" class="horario">
                                                @foreach($array_ingles as $horario_ingles)
                                                    @if($horario_ingles['id_semana']==$semana->id_semana)
                                                        @if($horario_ingles['disponibilidad'] ==2)

                                                            <div class="bg-info">{{$horario_ingles['nombre']}}<br>NIVEL <i>{{$horario_ingles['id_nivel']}}</i> <b>GRUPO:</b>{{$horario_ingles['id_grupo']}}<br>

                                                            </div>

                                                        @elseif($horario_ingles['disponibilidad'] == 3 )
                                                            <div class="">   </div>
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </td>


                                                <?php $contador++?>
                                            @if($contador==7)
                                                    <?php $contador=1 ?>
                                                </td>


                                        </tr>
                                    @endif

                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                @endif
            </div>


            <script type="text/javascript">
                $(document).ready( function() {
                    $("#id_niveles").on('change',function(e){
                        var id_niveles= $("#id_niveles").val();
                        $.get('/ingles_horarios/carga_academica_niveles/'+id_niveles, function (data) {
                            $("#grupo_ingles").css( {"background-color": "#e8eaf6", "display": "block"});
                            $('#grupos').empty();
                            $.each(data, function (datos_alumno, subcatObj) {
                                $('#grupos').append('<option disabled selected hidden>Selecciona una opción</option><option value="' + subcatObj.id_hrs_ingles_profesor + '">' + subcatObj.id_grupo + '</option>');
                            });
                        });
                    });
                    $("#grupos").on('change',function(e) {
                        // alert($("#grupos").val());
                        var id_hrs_ingles_profesor = $("#grupos").val();
                        window.location.href='/ingles_horarios/carga_academica_grupo/'+id_hrs_ingles_profesor ;
                    });


                    $(".envia1").click(function(event) {
                        $(".envia1").attr("disabled", true);
                        var id=$(this).attr('id');
                        window.location.href = '/ingles_horarios/seleccionar_grupo_carga/'+id+'/1';

                    });
                    $(".envia2").click(function(event){
                        $(".envia2").attr("disabled", true);
                        var id=$(this).attr('id');
                        window.location.href = '/ingles_horarios/seleccionar_grupo_carga/'+id+'/2';

                    });

                });
            </script>

            {{--Si su baucher fue rechazado--}}
        @elseif($id_estado_valida_voucher==3)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Tu voucher fue rechazado, verificar el motivo con el JEFE(A) DEL DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </main>

@endsection