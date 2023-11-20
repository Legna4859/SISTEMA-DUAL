@extends('layouts.app')
@section('title', 'Centro de Computo')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Registrar  correo y contraseña de los estudiantes
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <form class="form"  action="{{url("/centro_computo/registro_datos_estudiante_excel/")}}" role="form" method="POST" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input class="form-control"  id="excel_registro" name="excel_registro" type="file"   required/>
                    <button  type="submit" class="btn btn-primary" >Guardar</button>
                </form>
            </div>
        </div>



    </main>
@endsection