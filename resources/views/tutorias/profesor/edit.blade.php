@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <form action="{{route('canalizados.update',$plan->id_canalizacion)}}" method="post">
        @csrf
        @method('PUT')
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
                                            <td scope="col" >FECHA CITA ANTERIOR: <input type="date" class="form-control" id="fecha_canalizacion_anterior" name="fecha_canalizacion_anterior" value="{{$plan->fecha_canalizacion_anterior}}"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row" colspan="3">NOMBRE DEL ESTUDIANTE:
                                                @foreach ($alumno as $al)
                                                    {{$al->nombre}} {{$al->apaterno}} {{$al->amaterno}}
                                            @endforeach
                                            </td>
                                            <td>GRUPO:
                                                @foreach ($grupo as $dato)
                                                    {{$dato->grupo}}
                                                @endforeach
                                            </td>
                                            <td scope="col" >FECHA CITA: <input type="date" class="form-control" id="fecha_canalizacion" name="fecha_canalizacion" value="{{$plan->fecha_canalizacion}}"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row" colspan="3">NOMBRE DEL TUTOR:
                                                @foreach ($prof as $dato)
                                                    {{$dato->nombre}}
                                                @endforeach
                                            </td>
                                            <td>HORA: <input type="time" class="form-control" id="hora" name="hora" value="{{$plan->hora}}"></td>
                                            </td>
                                            <td scope="col" >FECHA DE SIGUIENTE CITA: <input type="date" class="form-control" id="fecha_canalizacion_siguiente" name="fecha_canalizacion_siguiente" value="{{$plan->fecha_canalizacion_siguiente}}"></td>
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
                                            <th scope="row" colspan="6" rowspan="9" ><textarea type="text" id="observaciones" name="observaciones" class="form-control">{{$plan->observaciones}}</textarea></th>
                                        </tr>
                                        <tr>
                                            <td>Indisciplina:</td>
                                            @if($plan->aspectos_sociologicos1 !=null)
                                                <td> <input type="checkbox" class="" id="aspectos_sociologicos1" name="aspectos_sociologicos1" value="1" checked></td>
                                            @else
                                                <td> <input type="checkbox" class="" id="aspectos_sociologicos1" name="aspectos_sociologicos1" value="1"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Problemas de integración:</td>
                                            @if($plan->aspectos_sociologicos1=null)
                                                <td> <input type="checkbox" class="" id="aspectos_sociologicos2" name="aspectos_sociologicos2" value="1" checked></td>
                                            @else
                                                <td> <input type="checkbox" class="" id="aspectos_sociologicos2" name="aspectos_sociologicos2" value="1"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Problemas familiares:</td>
                                            @if($plan->aspectos_sociologicos3 !=null)
                                                <td> <input type="checkbox" class="" id="aspectos_sociologicos3" name="aspectos_sociologicos3" value="1" checked></td>
                                            @else
                                                <td> <input type="checkbox" class="" id="aspectos_sociologicos3" name="aspectos_sociologicos3" value="1"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="3" >Aspectos académicos</th>
                                        </tr>
                                        <tr>
                                            <td>Dificultades de concentración:</td>
                                            @if($plan->aspectos_academicos1 !=null)
                                                <td> <input type="checkbox" class="" id="aspectos_academicos1" name="aspectos_academicos1" value="1" checked></td>
                                            @else
                                                <td> <input type="checkbox" class="" id="aspectos_academicos1" name="aspectos_academicos1" value="1"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Falta de motivación académica:</td>
                                            @if($plan->aspectos_academicos2 !=null)
                                                <td> <input type="checkbox" class="" id="aspectos_academicos2" name="aspectos_academicos2" value="1" checked></td>
                                            @else
                                                <td> <input type="checkbox" class="" id="aspectos_academicos2" name="aspectos_academicos2" value="1"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Bajo rendimiento académico:</td>
                                            @if($plan->aspectos_academicos3 !=null)
                                                <td> <input type="checkbox" class="" id="aspectos_academicos3" name="aspectos_academicos3" value="1" checked></td>
                                            @else
                                                <td> <input type="checkbox" class="" id="aspectos_academicos3" name="aspectos_academicos3" value="1"></td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="3">OTROS (especifique):<br><textarea type="text" id="otros" name="otros" class="form-control">{{$plan->otros}}</textarea></th>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" colspan="2">¿EL TUTOR REQUIERE NOTIFICACIÓN PERIÓDICA DE LOS AVANCES DEL CASO?</th>
                                            <th scope="col" >STATUS DE LA CANALIZACIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select name="notificacion" id="notificacion" class="custom-select custom-select-md">
                                                    @if($plan->notificacion !=null)
                                                        @if($plan->notificacion ==1)
                                                            <option value="">Elija Opcion</option>
                                                            <option value="1" selected>Si</option>
                                                            <option value="0">No</option>
                                                        @else
                                                            <option value="">Elija Opcion</option>
                                                            <option value="1">Si</option>
                                                            <option value="0" selected>No</option>
                                                        @endif
                                                    @else
                                                        <option value="" selected>Elija Opcion</option>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    @endif
                                                </select>
                                            </td>
                                            <td rowspan="">CORREO: <br>@foreach ($prof as $dato)
                                                    {{$dato->correo}}
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($plan->status ==0)
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="status" name="status" value="0" checked>
                                                        <label class="form-check-label" for="materialGroupExample2">En Proceso</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="status" name="status" value="1">
                                                        <label class="form-check-label" for="materialGroupExample3">Terminado</label>
                                                    </div>
                                                @else
                                                    @if($plan->status ==1)
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input" id="status" name="status" value="0">
                                                            <label class="form-check-label" for="materialGroupExample2">En Proceso</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input" id="status" name="status" value="1" checked>
                                                            <label class="form-check-label" for="materialGroupExample3">Terminado</label>
                                                        </div>
                                                    @else
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input" id="status" name="status" value="0">
                                                            <label class="form-check-label" for="materialGroupExample2">En Proceso</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input" id="status" name="status" value="1">
                                                            <label class="form-check-label" for="materialGroupExample3">Terminado</label>
                                                        </div>
                                                    @endif
                                                @endif
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
                                                        @if($plan->id_area ==$dato->id_area)
                                                            <option value="{{$dato->id_area}}" selected>{{$dato->descripcion_area}}</option>
                                                        @else
                                                            <option value="{{$dato->id_area}}">{{$dato->descripcion_area}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div style="display: none">
                                        @foreach ($alumno as $al)
                                            <input type="number" class="form-control"  id="id_alumno" name="id_alumno" value="{{$al->id_alumno}}">
                                        @endforeach
                                        @foreach ($prof as $dato)
                                            <input type="number" class="form-control"  id="id_personal" name="id_personal" value="{{$dato->id_personal}}">
                                        @endforeach
                                    </div>
                                    <div align="center">
                                        <input type="submit" value="Editar">
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
