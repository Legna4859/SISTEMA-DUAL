@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Faciltadores de ingles')
@section('content')
    <main class="col-md-12">


        @if($sin_consultar == 0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Armar  horarios</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-3">
                    <div class="form-group">
                        <div class="dropdown">
                            <label for="nivel_ingles">Facilitadores</label>
                            <select name="id_profesor" id="id_profesor" class="form-control " required>
                                <option disabled selected hidden>Selecciona una opción</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{$profesor->id_profesores}}"> {{$profesor->nombre}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2  "id="niveles_ingles" style="display:none;">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Niveles</label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="niveles" name="niveles" value="" required>

                        </select>
                    </div>
                </div>
                <div class="col-md-2 " id="grupo_ingles" style="display: none;">
                    <div class="dropdown" >
                        <label for="exampleInputEmail1">Grupos</label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="grupos" name="grupos" value="" required>

                        </select>
                    </div>
                </div>
            </div>


        @elseif($sin_consultar=1)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Armar  horarios</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 " id="imprimir" style="display: block;">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center" >
                            <a href="/ingles_horarios/pdf_profesor_horarios/{{$id_profesor}}" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-3 col-md-offset-3">
                    <div class="form-group">
                        <div class="dropdown">
                            <label for="nivel_ingles">Faciltadores</label>
                            <select name="id_profesor" id="id_profesor" class="form-control " required>
                                @foreach($profesores as $profesor)
                                    @if($profesor->id_profesores==$id_profesor)
                                        <option value="{{$id_profesor}}" selected="selected">{{$profesor->nombre}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</option>
                                    @else
                                        <option value="{{$profesor->id_profesores}}" >{{$profesor->nombre}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2  "id="niveles_ingles">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Niveles</label>
                        <select class="form-control" placeholder="selecciona una Opcion" id="niveles"  value="" required>
                            @foreach($niveles as $nivel)
                                @if($nivel->id_niveles_ingles==$id_niveles)
                                    <option value="{{$id_niveles}}" selected="selected">{{ $nivel->descripcion }}</option>
                                @else
                                    <option value="{{$nivel->id_niveles_ingles}}" >{{ $nivel->descripcion }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 " id="grupo_ingles">
                    <div class="dropdown" >
                        <label for="exampleInputEmail1">Grupos</label>
                        <select class="form-control"placeholder="selecciona una Opcion"id="grupos"  value=""  required>
                            @foreach($grupos as $grupo)
                                @if($grupo->id_grupo_ingles==$id_grupo)
                                    <option value="{{$id_grupo}}" selected="selected">{{ $grupo->descripcion }}</option>
                                @else
                                    <option value="{{$grupo->id_grupo_ingles}}" >{{ $grupo->descripcion }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @if($horas_max_prof ==1)
                <div class="row" id="facilitador">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading" style="text-align: center">El falicitador ya alcanzo su limite de horas. </div>

                        </div>
                    </div>
                </div>
            @endif
            @if($disponible_grupo ==1)
                <div class="row" id="grupo_facilitador">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading" style="text-align: center">El grupo ya tiene facilitador es {{$nombress->nombre}} {{$nombress->apellido_paterno}} {{$nombress->apellido_materno}}</div>

                        </div>
                    </div>
                </div>
            @endif
            @if($maximo_horas ==19)
                <div class="row" id="maximas_horas">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading" style="text-align: center">El grupo su maximo de horas ya esta completo</div>

                        </div>
                    </div>
                </div>
            @endif
            <div class="row" id="consultar">
                <div class="col-md-11 col-md-offset-1">

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
                                                    @if($horario_ingles['id_grupo']== $id_grupo and $horario_ingles['id_nivel']== $id_niveles)
                                                        <div class="bg-info">{{$horario_ingles['nombre']}}<br>{{$horario_ingles['nivel']}} <b>GRUPO:</b>{{$horario_ingles['grupo']}}<br>
                                                            <a class="eliminar_profesor" id="{{ $horario_ingles['registro']}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>

                                                        </div>
                                                    @else
                                                        <div class="bg-success">{{$horario_ingles['nombre']}}<br>{{$horario_ingles['nivel']}} <b>GRUPO:</b>{{$horario_ingles['grupo']}}<br>
                                                            <a class="eliminar_profesor" id="{{ $horario_ingles['registro']}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                                        </div>
                                                    @endif
                                                @elseif($horario_ingles['disponibilidad'] == 3 and $disponible_grupo == 0 and $maximo_horas <7 and $horas_max_prof==0)
                                                    <div class="">  <button class="btn btn-success agregar" id="{{ $horario_ingles['id_semana'] }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 and $disponible_grupo == 0 and $maximo_horas <7 and $horas_max_prof==1)
                                                    <div class="">  <button class="btn btn-success agregar" id="{{ $horario_ingles['id_semana'] }}" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 and $disponible_grupo == 0 and $maximo_horas ==7 and $horas_max_prof ==0)
                                                    <div class="">  <button class="btn btn-success agregar" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 and $disponible_grupo == 0 and $maximo_horas ==7 and $horas_max_prof ==1)
                                                    <div class="">  <button class="btn btn-success agregar" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 and $disponible_grupo == 1 and $horas_max_prof==1)
                                                    <div class="">  <button class="btn btn-success agregar" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 and $disponible_grupo == 1 and $horas_max_prof==0)
                                                    <div class="">  <button class="btn btn-success agregar" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                                    </div>
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
            </div>
        @endif
    </main>
    <script type="text/javascript">
        $(document).ready(function()
        {

            $("#niveles").on('change',function(e) {
                var id_profesor = $("#id_profesor").val();
                var id_niveles = $("#niveles").val();
                $("#consultar").css("display", "none");
                $("#imprimir").css("display", "none");
                $("#consultar").css("display", "none");
                $("#facilitador").css("display", "none");
                $("#grupo_facilitador").css("display", "none");
                $("#maximas_horas").css("display", "none");
                $.get('/ingles_horarios/horarios_ingles_niveles/' + id_profesor + '/' + id_niveles, function (data) {
                    $("#grupo_ingles").css( {"background-color": "#e8eaf6", "display": "block"});
                    $('#grupos').empty();

                    $.each(data, function (datos_alumno, subcatObj) {
                        //  alert(subcatObj);
                        $('#grupos').append('<option disabled selected hidden>Selecciona una opción</option><option value="' + subcatObj.id_grupo_ingles + '">' + subcatObj.descripcion + '</option>');
                    });
                });
            });

            $("#id_profesor").on('change',function(e){
                var id_profesor= $("#id_profesor").val();
                $.get('/ingles_horarios/horarios_ingles/'+id_profesor,function(data){
                    $("#niveles_ingles").css( {"background-color": "#e8eaf6", "display": "block"});
                    $("#grupo_ingles").css("display", "none");
                    $("#imprimir").css("display", "none");
                    $("#consultar").css("display", "none");
                    $("#facilitador").css("display", "none");
                    $("#grupo_facilitador").css("display", "none");
                    $("#maximas_horas").css("display", "none");
                    $('#niveles').empty();

                    $.each(data,function(datos_alumno,subcatObj){
                        //  alert(subcatObj);
                        $('#niveles').append('<option disabled selected hidden>Selecciona una opción</option><option value="'+subcatObj.id_niveles_ingles+'" >'+subcatObj.descripcion+'</option>');
                    });
                });



                // window.location.href='/ver/profesores/'+id_profesor;
            });
            $("#grupos").on('change',function(e) {
                // alert($("#grupos").val());
                var id_grupos = $("#grupos").val();
                var id_niveles = $("#niveles").val();
                var id_profesor = $("#id_profesor").val();
                window.location.href='/ingles_horarios/profesor_horarios/'+id_profesor+'/'+id_niveles+'/'+id_grupos ;
                //  alert(id_grupos);

            });

            $(".agregar").click(function(){
                var id_semana=$(this).attr('id');
                var id_grupo = "<?php  echo $id_grupo;?>";
                var id_profesor = "<?php  echo $id_profesor;?>";
                var id_niveles = "<?php  echo $id_niveles;?>";

                $(".agregar").attr("disabled", true);
                $.get('/ingles_horarios/agregar_horario_semana/'+id_semana+'/'+id_grupo+'/'+id_profesor+'/'+id_niveles,function(request)
                {

                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    }). then(function(result)
                    {
                        location.reload(true);
                    });
                });
            });
            $(".eliminar_profesor").click(function(){
                var id_registro_horario=$(this).attr('id');
                var id_grupo = "<?php  echo $id_grupo;?>";
                var id_profesor = "<?php  echo $id_profesor;?>";
                var id_niveles = "<?php  echo $id_niveles;?>";
                $.get('/ingles_horarios/eliminar_horario_semana/'+id_registro_horario+'/'+id_grupo+'/'+id_profesor+'/'+id_niveles,function(request)
                {

                    swal({
                        type: "success",
                        title: "Eliminado",
                        showConfirmButton: false,
                        timer: 1500
                    }). then(function(result)
                    {
                        location.reload(true);
                    });
                });

            });
        });
    </script>
@endsection