@extends('layouts.app')
@section('title', 'Constancias de no Adeudo')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Descargar Constancias de no adeudo</h3>
                    </div>
                </div>
            </div>

        </div>

        @if($estado == 1)
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($carreras as $carrera)
                                <option value="{{$carrera->id_carrera}}" data-esta="{{$carrera->nombre}}">{{$carrera->nombre}}</option>
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <br>
            </div>
        @elseif($estado == 2)
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="dropdown">
                        <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                        <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($carreras as $carrera)
                                @if($carrera->id_carrera==$id_carrera)
                                    <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                                @else
                                    <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Estudiantes de la carrera</h3>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            <table id="table_enviado" class="table table-bordered table-resposive">
                                <thead>
                                <tr>
                                    <th>No. Cuenta</th>
                                    <th>Nombre del Estudiante</th>
                                    <th>Semestre</th>
                                    <th>Carrera</th>
                                    <th>Constancias</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alumnos as $alumno)

                                    <tr>
                                        <td>{{ $alumno->cuenta }}</td>
                                        <td> {{ $alumno->apaterno }} {{ $alumno->amaterno }} {{ $alumno->nombre }}</td>
                                        <td>{{ $alumno->semestre }}</td>
                                        <td>{{ $alumno->carrera }}</td>
                                        <td style="text-align: center">  <button type="button" class="btn btn-primary  btn-small enviar" data-id_alumno="{{$alumno->id_alumno}}" ><i class="glyphicon glyphicon-pencil em2"></i></button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        @endif


        <div class="modal fade" id="modal_constancia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Constancias de no adeudo </h4>
                    </div>
                    <div id="contenedor_constancia">


                    </div>



                </div>


            </div>

        </div>

    </main>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( );
            $('#table_adeudos').DataTable( );
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/constancia_carrera/'+id_carrera ;


            });


            $("#table_enviado").on('click','.enviar',function(){
                var id=$(this).data('id_alumno');
                $.get("/ver_estado_alumno/"+id,function(request){
                    $("#contenedor_constancia").html(request);
                    $("#modal_constancia").modal('show');

                });


            });




        });
    </script>

@endsection