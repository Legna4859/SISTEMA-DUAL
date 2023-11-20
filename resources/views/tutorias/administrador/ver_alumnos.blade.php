@extends('layouts.app')
@section('title', 'Admin')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Estudiantes</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-bordered table-resposive" id="table_enviado">
                    <thead>
                    <tr>
                        <th>Numero cuenta</th>
                        <th>Nombre completo</th>
                        <th>ver</th>
                        <th>Agregar imagen</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($alumnos as $alumno)

                        <tr>
                            <td>{{$alumno->cuenta}}</td>
                            <td>{{$alumno->nombre}}</td>
                            <td>
                                @if($alumno->foto == 'image/jpeg')
                                    <img src="{{ asset('Fotografias/'.$alumno->cuenta.'.jpeg') }}" width="30px" height="30px" />
                                @elseif($alumno->foto == 'image/png')
                                    <img src="{{ asset('Fotografias/'.$alumno->cuenta.'.png') }}" width="30px" height="30px" />
                                @elseif($alumno->foto == 'image/jpg')
                                    <p>hola</p>
                                    <img src="{{ asset('Fotografias/'.$alumno->cuenta.'.jpg') }}" width="30px" height="30px" />
                                @endif
                            </td>
                            <td>
                                <form class="form" id="form_solicitud_residencia" action="{{url("/computo/modificar_imagen/".$alumno->id_alumno)}}" role="form" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <input type="file" class="form-control" accept="image/jpeg,image/png" name="foto"  id="foto" required>
                                    <button class="form-control" type="submit">Enviar</button>

                                </form>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <br>
    </main>




    <script type="text/javascript">
        $(document).ready(function() {

            $('#table_enviado').DataTable( {

            } );


        });
    </script>

    </script>
@endsection