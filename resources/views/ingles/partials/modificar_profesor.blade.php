@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Modificación Docentes')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Modificar Facilitador de Ingles</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form id="form_modificar_profesores_ingles" action="{{url("/profesores_ingles/modificacion/profesor")}}" class="form" role="form" method="POST">
                {{ csrf_field() }}
                <div clas="row">
                    <div class="col-md-3 col-md-offset-2">
                        <div class="form-group">
                            <label for="nombre_docente">Nombre Completo</label>
                            <input type="text" id="nombre_profesor" class="form-control"  name="nombre_profesor" placeholder="Nombre" style="text-transform:uppercase" value="{{  $datos_profesor->nombre }}" required>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="apellido_paterno">Apellido Paterno</label>
                            <input type="text" id="ap_paterno" class="form-control"  name="ap_paterno" placeholder="Apellido Paterno" style="text-transform:uppercase" value="{{  $datos_profesor->apellido_paterno }}" required>


                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" id="ap_materno" class="form-control"  name="ap_materno" placeholder="Apellido Materno" style="text-transform:uppercase" value="{{  $datos_profesor->apellido_materno}}" required>


                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3 col-md-offset-2">
                        <div class="form-group">
                            <div class="dropdown">
                                <label for="nivel_ingles">Sexo</label>
                                <select name="sexo" id="sexo" class="form-control " required>
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($sexos as $sexo)
                                        @if($sexo->id_sexo==$datos_profesor->id_sexo)
                                            <option value="{{$datos_profesor->id_sexo}}" selected="selected" >{{$sexo->descripcion}}</option>
                                        @else
                                            <option value="{{$sexo->id_sexo}}"> {{$sexo->descripcion}}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <div class="dropdown">
                                <label for="nivel_ingles">Nivel ingles</label>
                                <select name="nivel_ingles" id="nivel_ingles" class="form-control " required>
                                    <option disabled selected>Selecciona nivel de ingles...</option>
                                    @foreach($nivel_ingles as $nivel)
                                        @if($nivel->id_nivel_ingles==$datos_profesor->id_nivel_ingles)
                                            <option value="{{$datos_profesor->id_nivel_ingles}}" selected="selected" >{{$nivel->descripcion}}</option>
                                        @else
                                            <option value="{{$nivel->id_nivel_ingles}}"> {{$nivel->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <div class="dropdown">
                                <label for="titulo">Certificado o Constancia</label>
                                <select name="titulo" id="titulo" class="form-control " required>
                                    <option disabled selected>Selecciona ...</option>
                                    @foreach($titulos as $titulo)
                                        @if($titulo->id_titulo==$datos_profesor->id_tipo_titulo)
                                            <option value="{{$datos_profesor->id_tipo_titulo}}" selected="selected" >{{$titulo->descripcion}}</option>
                                        @else
                                            <option value="{{$titulo->id_titulo}}"> {{$titulo->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-2">
                        <div class="form-group">
                            <label for="fecha_termino">Fecha emision de Constancia o Certificado</label>
                            <input class="form-control datepicker fecha_termino" type="text" id="fecha_termino" name="fecha_termino" data-date-format="yyyy/mm/dd" placeholder="AAAA/MM/DD" value="{{  $datos_profesor->fecha_emision_titulo}}" required>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-5 m">
                        <button  type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>Guardar datos</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready( function() {
            $( '.fecha_termino').datepicker({
                pickTime: false,
                autoclose: true,
                language: 'es',
                startDate: '+0d',
            });
        });
    </script>
@endsection