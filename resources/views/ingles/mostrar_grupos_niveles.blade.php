@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Grupos de ingles')
@section('content')
    <main class="col-md-12">


        @if($sin_consultar == 0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Grupos de ingles</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2  col-md-offset-4 "id="niveles_ingles">
                    <div class="dropdown">
                        <label for="nivel_ingles">Niveles</label>
                        <select name="id_nivel" id="id_nivel" class="form-control " required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($niveles as $nivel)
                                <option value="{{$nivel->id_niveles_ingles}}"> {{$nivel->descripcion}}</option>
                            @endforeach

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
            @else
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Grupos de ingles</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-2  col-md-offset-4 "id="niveles_ingles">
                    <div class="dropdown">
                        <label for="nivel_ingles">Niveles</label>
                        <select name="id_nivel" id="id_nivel" class="form-control " required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($niveles as $nivel)
                                @if($nivel->id_niveles_ingles==$id_nivel)
                                    <option value="{{$id_nivel}}" selected="selected">{{ $nivel->descripcion }}</option>
                                @else
                                    <option value="{{$nivel->id_niveles_ingles}}" >{{ $nivel->descripcion }}</option>
                                @endif  @endforeach

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
            @if($no_horario==1)
            <div class="row" id="facilitador">
<br>
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Facilitador: {{ $profesor->nombre }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 " id="imprimir" >
                    <div class="panel panel-default">
                        <div class="panel-heading text-center" >
                            <a href="/ingles_horarios/pdf_grupo_horarios/{{ $id_grupo }}/{{ $id_nivel }}" class="btn btn-primary crear" target="_blank"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span> Imprimir</a>

                        </div>
                    </div>
                </div>
            </div>

            @endif
            <div class="row" id="consultar">
                <div class="col-md-10 col-md-offset-1">
<br>
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

                                                    <div class="bg-success">{{$horario_ingles['nivel']}} <br><b>GRUPO:</b>{{$horario_ingles['grupo']}}<br>

                                                    </div>
                                                @elseif($horario_ingles['disponibilidad'] == 3 )
                                                    <div class="">
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
        @endif
    </main>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#id_nivel").on('change',function(e) {
                $.get('/ingles_horarios/ingles_niveles/', function (data) {
                    $("#facilitador").css( { "display": "none"});
                    $("#consultar").css( { "display": "none"});
                    $("#grupo_ingles").css( { "display": "inline"});
                    $('#grupos').empty();

                    $.each(data, function (datos_alumno, subcatObj) {
                        //  alert(subcatObj);
                        $('#grupos').append('<option disabled selected hidden>Selecciona una opción</option><option value="' + subcatObj.id_grupo_ingles + '">' + subcatObj.descripcion + '</option>');
                    });
                });
            });
            $("#grupos").on('change',function(e) {
                // alert($("#grupos").val());
                $("#facilitador").css( { "display": "inline"});
                $("#consultar").css( { "display": "inline"});
                var id_grupos = $("#grupos").val();
                var id_nivel = $("#id_nivel").val();
                window.location.href='/ingles/grupos_niveles/'+id_grupos+'/'+id_nivel ;


            });
        });
</script>
@endsection

