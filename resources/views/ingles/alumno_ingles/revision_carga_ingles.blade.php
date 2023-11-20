@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Revisión de Carga academica ingles')
@section('content')
    <main class="col-md-12">
 @if($registrado == 0)
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No has registrado tu carga academica de ingles</h3>
                        </div>
                    </div>
                </div>
            </div>
     @else
            <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Carga Academica Ingles</h3>
                    </div>
                </div>
            </div>
        </div>
             @if($comentario[0]->id_estado == 3)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">{{ $comentario[0]->comentario }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($enviado == 1)
                <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                    <p style="text-align: center">
                        <a href="#" onclick="window.open('{{url('/ingles/pdf_carga_academica_ingles/'.$carga_academica->id_grupo.'/'.$carga_academica->id_nivel)}}')"><strong ><span class="glyphicon glyphicon-print em"  aria-hidden="true"></span><br>Imprimir</strong></a>
                    </p>
                        </div>
                    </div>
                </div>
                </div>

            @endif
        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">NIVEL:  {{ $carga_academica->nivel }}  GRUPO  : {{$carga_academica->grupo }}   @if($tip_c == 1)  STATUS DEL NIVEL: {{$tipo_curso}} @endif <br>
                        FACILITADOR: {{ $profesor->nombre}} {{ $profesor->apellido_paterno}} {{ $profesor->apellido_materno }}</h3>
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
        @if($enviado == 0)
             @if($comentario[0]->id_estado == 3)
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" class="btn btn-success btn-lg" onclick="window.location='{{ url('/ingles_horarios/enviar_carga_academica_ingles/'.$carga_academica->id_nivel.'/'.$carga_academica->id_grupo.'/1' ) }}'" disabled>Enviar carga academica de ingles </button>
                        <br>
                        <br>
                    </div>
                    <br>
                    <br>
                </div>
            @else
                        {{ csrf_field() }}
                        <div class="row">
                            <input  class="form-control" type="hidden"  id="id_nivel" name="id_nivel"  value="{{ $carga_academica->id_nivel }}">
                            <input  class="form-control" type="hidden"  id="id_grupo" name="id_grupo"  value="{{ $carga_academica->id_grupo }}">
                            <div class="col-md-2 col-md-offset-5">
                                <label>Tipo de curso</label>
                                <select name="id_tipo_curso" id="id_tipo_curso" class="form-control " required>
                                @foreach($eva_tipo_curso as $eva_tipo_curso)
                                        <option disabled selected hidden>Selecciona una opción</option>
                                @if($carga_academica->id_nivel==$carga_academica->estado_nivel)
                                    <option value="{{$carga_academica->estado_nivel}}" selected="selected">{{ $eva_tipo_curso->nombre_curso }}</option>
                                @else
                                    <option value="{{$eva_tipo_curso->id_tipo_curso}}" >{{ $eva_tipo_curso->nombre_curso }}</option>
                                @endif
                                @endforeach
                        </select>
                                <br>
                                <br>
                            </div>
                            <br>
                            <br>
                        </div>

                <div class="row">

                    <div class="col-md-2 col-md-offset-5">
                        <button type="button" id="enviar_carga" class="btn btn-success btn-lg">Enviar carga academica de ingles </button>
                        <br>
                        <br>
                    </div>
                    <br>
                    <br>
                </div>

                @endif
            @endif

     @endif
    </main>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#enviar_carga").click(function(event) {
                var id_nivel = $("#id_nivel").val();
                var id_grupo = $("#id_grupo").val();
                var id_tipo_curso = $("#id_tipo_curso").val();
//alert(id_nivel+" "+id_grupo+" "+id_tipo_curso);
                if (id_nivel!= null && id_grupo != null && id_tipo_curso != null) {
                    window.location.href='/ingles_horarios/enviar_carga_academica_ingles/'+id_nivel+'/'+id_grupo+'/'+id_tipo_curso;
                    $("#enviar_carga").attr("disabled", true);


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


        });

    </script>
@endsection