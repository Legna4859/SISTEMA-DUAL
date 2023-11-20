@extends('layouts.app')
@section('content')
    <form action="{{url('canalizacion')}}" method="post">
        {{ csrf_field() }}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" colspan="4" class="text-center">DATOS DEL ESTUDIANTE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td scope="col" colspan="3">CARRERA:
                                                @foreach ($carreras as $dato)
                                                    {{$dato->nombre}}
                                                @endforeach
                                            </td>
                                            <td scope="col">SEMESTRE:
                                                @foreach ($semestre as $dato)
                                                    {{$dato->descripcion}}
                                                @endforeach
                                            </td>
                                            <td scope="col" >FECHA CITA ANTERIOR: <input type="date" class="form-control" id="fecha_canalizacion_anterior" name="fecha_canalizacion_anterior"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row" colspan="3">NOMBRE DEL ESTUDIANTE: {{$alumno->nombre}} {{$alumno->apaterno}} {{$alumno->amaterno}}</td>
                                            <td>GRUPO:
                                                @foreach ($grupo as $dato)
                                                    {{$dato->grupo}}
                                                @endforeach
                                            </td>
                                            <td scope="col" >FECHA CITA: <input type="date" class="form-control" id="fecha_canalizacion" name="fecha_canalizacion"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row" colspan="3">NOMBRE DEL TUTOR:
                                                @foreach ($prof as $dato)
                                                    {{$dato->nombre}}
                                                @endforeach
                                            </td>
                                            <td>HORA: <input type="time" class="form-control" id="hora" name="hora" ></td>
                                            </td>
                                            <td scope="col" >FECHA DE SIGUIENTE CITA: <input type="date" class="form-control" id="fecha_canalizacion_siguiente" name="fecha_canalizacion"></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" colspan="4" class="text-center">OBSERVACIONES</th>
                                            <th scope="col" class="text-center">OBSERVACIONES GENERALES</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row" colspan="3" >Aspectos sociológicos</th>
                                            <th scope="row" colspan="6" rowspan="9" ><textarea type="text" id="observaciones" name="observaciones" class="form-control"></textarea></th>
                                        </tr>
                                        <tr>
                                            <td>Indisciplina:</td>
                                            <td> <input type="checkbox" class="" id="aspectos_sociologicos1" name="aspectos_sociologicos1" value="1"></td>
                                        </tr>
                                        <tr>
                                            <td>Problemas de integración:</td>
                                            <td> <input type="checkbox" class="" id="aspectos_sociologicos2" name="aspectos_sociologicos2" value="1"></td>
                                        </tr>
                                        <tr>
                                            <td>Problemas familiares:</td>
                                            <td> <input type="checkbox" class="" id="aspectos_sociologicos3" name="aspectos_sociologicos3" value="1"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="3" >Aspectos académicos</th>
                                        </tr>
                                        <tr>
                                            <td>Dificultades de concentración:</td>
                                            <td> <input type="checkbox" class="" id="aspectos_academicos1" name="aspectos_academicos1" value="1"></td>
                                        </tr>
                                        <tr>
                                            <td>Falta de motivación académica:</td>
                                            <td> <input type="checkbox" class="" id="aspectos_academicos2" name="aspectos_academicos2" value="1"></td>
                                        </tr>
                                        <tr>
                                            <td>Bajo rendimiento académico:</td>
                                            <td> <input type="checkbox" class="" id="aspectos_academicos3" name="aspectos_academicos3" value="1"></td>
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="3">OTROS (especifique):<br><textarea type="text" id="otros" name="otros" class="form-control"></textarea></th>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td rowspan="">CORREO: <br>@foreach ($prof as $dato)
                                                    {{$dato->correo}}
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="status" name="status" value="0">
                                                    <label class="form-check-label" for="materialGroupExample2">En Proceso</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="status" name="status" value="1">
                                                    <label class="form-check-label" for="materialGroupExample3">Terminado</label>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" colspan="3">Área a canalizar tutorado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select name="id_area" id="id_area" class="custom-select custom-select-md">
                                                    <option value="" selected>Elija área a canalizar</option>
                                                    @foreach ($areas as $dato)
                                                        <option value="{{$dato->id_area}}" >{{$dato->descripcion_area}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div style="display: none">
                                        <input type="number" class="form-control"  id="id_alumno" name="id_alumno" value="{{$alumno->id_alumno}}">
                                        @foreach ($prof as $dato)
                                            <input type="number" class="form-control"  id="id_personal" name="id_personal" value="{{$dato->id_personal}}">
                                        @endforeach

                                    </div>
                                    <div align="center">
                                        <input type="submit" value="Agregar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

<script src="{{asset('js/jquery.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#final').click(function(){
            var con= true;
            var datos = $('#form-cana').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "profesor",
                method: "POST",
                dataType: "json",
                data:datos,
                //window:location = "profesor.canalizacion"
            });
        });
    });
</script>